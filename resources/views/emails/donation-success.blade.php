<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Your Donation!</title>
    <style>
        body {font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background:#f9f9fb; margin:0; padding:0;}
        .container {max-width:600px; margin:40px auto; background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,.07);}
        .header {background:#6366f1; padding:30px; text-align:center; color:#fff;}
        .header h1 {margin:0; font-size:28px;}
        .body {padding:30px; color:#333;}
        .body p {margin:0 0 16px; line-height:1.6;}
        .highlight {background:#eef2ff; padding:12px; border-radius:8px; margin:16px 0;}
        .footer {background:#f1f5f9; padding:20px; text-align:center; font-size:13px; color:#64748b;}
        .btn {display:inline-block; background:#6366f1; color:#fff; padding:12px 24px; border-radius:6px; text-decoration:none; margin-top:20px;}
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Thank You, {{ $donation->name }}!</h1>
    </div>

    <div class="body">
        <p>We’ve successfully received your generous donation of <strong>₹{{ number_format($donation->amount, 2) }}</strong>.</p>

        <div class="highlight">
            <p><strong>Transaction ID:</strong> {{ $donation->razorpay_payment_id }}</p>
            <p><strong>Order ID:</strong> {{ $donation->razorpay_order_id }}</p>
            <p><strong>Date:</strong> {{ $donation->updated_at->format('d M Y, h:i A') }}</p>
        </div>

        <p>Your contribution means the world to us. It will directly support <em>[Your Cause]</em>. We’ll keep you updated on the impact you’re making.</p>

        <a href="{{ env('NEXT_PUBLIC_FRONTEND_URL') }}" class="btn">Back to Home</a>
    </div>

    <div class="footer">
        <p>© {{ date('Y') }} Suhrit Organization. All rights reserved.</p>
        <p>Need help? <a href="mailto:suhritorganization@gmail.com">support@suhrit.com</a></p>
    </div>
</div>
</body>
</html>