<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>OTP Verification</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
    .container { max-width: 500px; margin: auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
    .otp { font-size: 32px; font-weight: bold; text-align: center; letter-spacing: 8px; color: #1d4ed8; margin: 20px 0; }
    .footer { text-align: center; font-size: 12px; color: #666; margin-top: 30px; }
  </style>
</head>
<body>
  <div class="container">
    <h2>Verify Your Email</h2>
    <p>Your OTP for <strong>{{ $eventName }}</strong> is:</p>
    <div class="otp">{{ $otp }}</div>
    <p>This code expires in <strong>2 minutes</strong>.</p>
    <p class="footer">© {{ date('Y') }} Suhrit Organization. All rights reserved.</p>
  </div>
</body>
</html>