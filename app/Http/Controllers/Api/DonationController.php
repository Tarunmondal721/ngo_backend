<?php

namespace App\Http\Controllers\Api;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Razorpay\Api\Api;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Mail\DonationSuccessMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class DonationController extends Controller
{
    protected $razorpay;

    public function __construct()
    {
        // Initialise Razorpay client once
        $this->razorpay = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
    }

    /** --------------------------------------------------------------
     *  CREATE ORDER – wrapped in DB transaction
     * -------------------------------------------------------------- */
    public function createOrder(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1',
            'name'   => 'required|string|max:255',
            'email'  => 'required|email',
            'phone'  => 'required|numeric|digits_between:10,15',
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()], 422);
        }

        $amountInPaise = $request->amount * 100;

        // ---- DB TRANSACTION -------------------------------------------------
        return DB::transaction(function () use ($request, $amountInPaise) {
            // 1. Create Razorpay order
            $order = $this->razorpay->order->create([
                'amount'   => $amountInPaise,
                'currency' => 'INR',
                'receipt'  => 'donation_' . time(),
            ]);

            // 2. Persist donation row (still "pending")
            $donation = Donation::create([
                'name'              => $request->name,
                'email'             => $request->email,
                'phone'             => $request->phone,
                'amount'            => $request->amount,
                'currency'          => 'INR',
                'receipt'           => $order->receipt,
                'razorpay_order_id' => $order->id,
                'status'            => 'pending',
            ]);

            // 3. Return data for frontend
            return response()->json([
                'order_id' => $order->id,
                'amount'   => $amountInPaise,
                'key'      => env('RAZORPAY_KEY'),
                'donation_id' => $donation->id, 
            ]);
        });
        // --------------------------------------------------------------------
    }

    /** --------------------------------------------------------------
     *  VERIFY PAYMENT – wrapped in DB transaction + email on success
     * -------------------------------------------------------------- */
    public function verifyPayment(Request $request)
    {
        $request->validate([
            'razorpay_order_id'   => 'required|string',
            'razorpay_payment_id' => 'required|string',
            'razorpay_signature'  => 'required|string',
        ]);

        // ---- DB TRANSACTION -------------------------------------------------
        $result = DB::transaction(function () use ($request) {
            // 1. Verify signature using Razorpay helper
            try {
                $this->razorpay->utility->verifyPaymentSignature([
                    'razorpay_order_id'   => $request->razorpay_order_id,
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                    'razorpay_signature'  => $request->razorpay_signature,
                ]);
            } catch (\Razorpay\Api\Errors\SignatureVerificationError $e) {
                // Mark as failed *inside* transaction
                Donation::where('razorpay_order_id', $request->razorpay_order_id)
                        ->update(['status' => 'failed']);

                return ['success' => false, 'message' => 'Invalid signature'];
            }

            // 2. Update donation as paid
            $donation = Donation::where('razorpay_order_id', $request->razorpay_order_id)
                ->firstOrFail();

            $donation->update([
                'status'               => 'paid',
                'razorpay_payment_id'  => $request->razorpay_payment_id,
                'razorpay_signature'   => $request->razorpay_signature,
                'paid_at'              => now(),
            ]);

            // 3. Queue the beautiful e-mail (still inside transaction)
            Mail::to($donation->email)->queue(new DonationSuccessMail($donation));

            return ['success' => true, 'message' => 'Thank you!'];
        });
        // --------------------------------------------------------------------

        // Return appropriate JSON response
        return response()->json($result, $result['success'] ? 200 : 400);
    }
}