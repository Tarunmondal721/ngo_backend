<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactResource;
use App\Mail\OtpMail;
use App\Mail\RegistrationSuccessMail;
use App\Models\Contact;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('contacts', 'email')->where('type', 'general'),
            ],
            'phone'   => 'required|string|max:20',
            'subject'  => 'required|string|max:255',
            'message' => 'required|string',
        ]);
        if ($validated->fails()) {
            return response()->json([
                'errors' => $validated->errors(),
            ], 422);
        }
        $data = $validated->validated();
        $contact = Contact::create($data);
        return new ContactResource($contact);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // public function eventRegister(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name'  => 'required|string|max:255',
    //        'email' => [
    //         'required',
    //         'email',
    //         Rule::unique('contacts', 'email')->where('type', 'event'),
    //     ],
    //         'phone' => 'required|string|max:20',
    //         'address' => 'required|string|max:255',
    //         'event_id' => 'required|integer',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'errors' => $validator->errors(),
    //         ], 422);
    //     }

    //     $data = $validator->validated();
    //     $contact = Contact::create($data);

    //     return new ContactResource($contact);
    // }

    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'email' => 'required|email',
            'event_name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $otp = rand(100000, 999999);
        $email = $request->email;
        $eventName = $request->event_name ?? 'Event Registration';

        // Store OTP (5 min)
        Cache::put("otp_email_{$email}", $otp, now()->addMinutes(5));

        // Send Email
        Mail::to($email)->send(new OtpMail($otp, $eventName));

        return response()->json(['message' => 'OTP sent to email']);
    }


    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('contacts', 'email')->where('type', 'event'),
            ],
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'event_id' => 'required|integer|exists:events,id',
            'otp'   => 'required|string|max:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }
        $email = $request->email;
        $storedOtp = Cache::get("otp_email_{$email}");

        if (!$storedOtp || $storedOtp != $request->otp) {
            return response()->json([
                'message' => 'Invalid or expired OTP'
            ], 400);
        }

        // Save to DB
       $registration = Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'type' => 'event',
            'event_id' => $request->event_id,
        ]);

        $data['event_ticket_no'] = 'TKT' . str_pad($registration->id, 6, '0', STR_PAD_LEFT);
        $registration->update($data);

        // Clear OTP
        Cache::forget("otp_email_{$email}");

        // Fetch Event
        $event = Event::findOrFail($request->event_id);

        // Send Beautiful Confirmation Email
        Mail::to($email)->send(new RegistrationSuccessMail($registration, $event));

        return response()->json([
            'message' => 'Registered successfully! Confirmation email sent.'
        ]);
    }
}
