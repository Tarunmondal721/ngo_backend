{{-- resources/views/emails/registration_success_stylish.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>🎉 Registration Confirmed!</title>
  <style>
    /* Base Styles */
    body {
      margin: 0;
      padding: 0;
      background: linear-gradient(135deg, #f0f4ff 0%, #e0eafc 100%);
      font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, Roboto, Arial, sans-serif;
      line-height: 1.6;
      color: #1f2937;
    }

    .container {
      max-width: 640px;
      margin: 20px auto;
      background: #ffffff;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 20px 40px rgba(59, 130, 246, 0.12), 0 8px 16px rgba(0, 0, 0, 0.05);
      border: 1px solid rgba(59, 130, 246, 0.1);
    }

    /* Animated Gradient Header */
    .header {
      background: linear-gradient(-45deg, #1e40af, #3b82f6, #60a5fa, #93c5fd);
      background-size: 400% 400%;
      animation: gradientShift 8s ease infinite;
      color: white;
      padding: 40px 30px;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .header::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 20" preserveAspectRatio="none"><path d="M0,10 Q25,0 50,10 T100,10 L100,20 L0,20 Z" fill="rgba(255,255,255,0.1)"/></svg>') bottom no-repeat;
      background-size: 100% 20px;
    }

    .header h1 {
      margin: 0;
      font-size: 32px;
      font-weight: 800;
      letter-spacing: -0.5px;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .header p {
      margin: 10px 0 0;
      font-size: 16px;
      opacity: 0.95;
      font-weight: 500;
    }

    /* Body */
    .body {
      padding: 36px 32px;
      background: #ffffff;
    }

    .greeting {
      font-size: 18px;
      margin-bottom: 8px;
    }

    .message {
      font-size: 16px;
      color: #4b5563;
      margin-bottom: 24px;
    }

    /* Glassmorphic Card */
    .card {
      background: rgba(249, 250, 252, 0.85);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(59, 130, 246, 0.15);
      border-radius: 16px;
      padding: 24px;
      margin: 20px 0;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
    }

    .card h3 {
      margin: 0 0 16px;
      font-size: 18px;
      color: #1e40af;
      font-weight: 700;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    /* Details Table */
    .details table {
      width: 100%;
      border-collapse: collapse;
    }

    .details td {
      padding: 10px 0;
      vertical-align: top;
    }

    .details .label {
      font-weight: 600;
      color: #374151;
      width: 130px;
      font-size: 15px;
    }

    .details .value {
      color: #1f2937;
      font-weight: 500;
    }

    /* Ticket Highlight */
    .ticket-highlight {
      background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
      padding: 20px;
      border-radius: 14px;
      text-align: center;
      margin: 24px 0;
      border: 1px dashed #93c5fd;
      position: relative;
      overflow: hidden;
    }

    .ticket-highlight::before {
      content: '🎫';
      font-size: 48px;
      position: absolute;
      top: -10px;
      right: -10px;
      opacity: 0.1;
      transform: rotate(15deg);
    }

    .ticket-id {
      font-size: 28px;
      font-weight: 900;
      letter-spacing: 6px;
      color: #1d4ed8;
      margin: 8px 0;
      font-family: 'Courier New', monospace;
      text-shadow: 0 1px 2px rgba(29, 78, 216, 0.1);
    }

    /* CTA Button */
    .btn {
      display: inline-block;
      background: linear-gradient(135deg, #1d4ed8, #2563eb);
      color: white;
      padding: 14px 32px;
      border-radius: 12px;
      text-decoration: none;
      font-weight: 600;
      font-size: 16px;
      margin: 20px 0;
      box-shadow: 0 6px 16px rgba(29, 78, 216, 0.25);
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }

    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(29, 78, 216, 0.3);
    }

    /* Footer */
    .footer {
      background: #0f172a;
      color: #94a3b8;
      padding: 28px 32px;
      text-align: center;
      font-size: 13px;
      line-height: 1.5;
    }

    .footer a {
      color: #60a5fa;
      text-decoration: none;
    }

    .footer .contact {
      margin-top: 12px;
      font-weight: 500;
    }

    /* Animations */
    @keyframes gradientShift {
      0% {
        background-position: 0% 50%;
      }

      50% {
        background-position: 100% 50%;
      }

      100% {
        background-position: 0% 50%;
      }
    }

    /* Responsive */
    @media (max-width: 600px) {
      .container {
        margin: 10px;
        border-radius: 16px;
      }

      .header {
        padding: 30px 20px;
      }

      .header h1 {
        font-size: 26px;
      }

      .body {
        padding: 28px 20px;
      }

      .card {
        padding: 20px;
      }

      .ticket-id {
        font-size: 24px;
        letter-spacing: 4px;
      }
    }
  </style>
</head>

<body>
  <div class="container">

    <!-- Animated Gradient Header -->
    <div class="header">
      <h1>Registration Confirmed! 🎉</h1>
      <p>We can’t wait to welcome you to the event</p>
    </div>

    <!-- Body Content -->
    <div class="body">
      <p class="greeting">Hi <strong>{{ $registration->name }}</strong>,</p>
      <p class="message">Your spot for <strong>{{ $event->title }}</strong> is officially reserved! Here are your event details:</p>

      <!-- Event Details Card -->
      <div class="card">
        <h3>📅 Event Details</h3>
        <div class="details">
          <table>
            <tr>
              <td class="label">Event</td>
              <td class="value">{{ $event->title }}</td>
            </tr>
            <tr>
              <td class="label">Date</td>
              <td class="value">{{ \Carbon\Carbon::parse($event->date)->format('l, F j, Y') }}</td>
            </tr>
            <tr>
              <td class="label">Time</td>
              <td class="value">{{ $event->time }}</td>
            </tr>
            <tr>
              <td class="label">Venue</td>
              <td class="value">{{ $event->location }}</td>
            </tr>
            <tr>
              <td class="label">Price</td>
              <td class="value"><strong style="color:#1d4ed8;">{{ $event->price }}</strong></td>
            </tr>
          </table>
        </div>
      </div>

      <!-- Ticket ID Highlight -->
      <div class="ticket-highlight">
        <p style="margin:0; font-size:14px; color:#1d4ed8; font-weight:600;">YOUR TICKET ID</p>
        <div class="ticket-id">#{{ $registration->event_ticket_no }}</div>
        <p style="margin:8px 0 0; font-size:13px; color:#4b5563;">Keep this safe — show it at the entrance!</p>
      </div>

      <p style="color:#4b5563; font-size:15px;">Confirmation sent to: <strong>{{ $registration->email }}</strong></p>

      <a href="{{ env('NEXT_PUBLIC_FRONTEND_URL') . 'events/' }}"
        style="display:inline-block;
          background: linear-gradient(90deg, #1d4ed8, #3b82f6);
          color: #fff;
          font-weight: 600;
          padding: 12px 28px;
          border-radius: 8px;
          text-decoration: none;
          font-size: 16px;
          box-shadow: 0 4px 10px rgba(0,0,0,0.1);
          transition: all 0.3s ease;">
        View Event Details
      </a>




      <p style="margin-top:28px; color:#1f2937;">See you soon! 🚀</p>
    </div>

    <!-- Footer -->
    <div class="footer">
      <p style="margin:0; color:#e2e8f0;">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
      <p class="contact">
        Need help? Reply to this email or call <a href="tel:+918653681154" style="color:#93c5fd;">+91 865-368-1154</a>
      </p>
    </div>
  </div>

  <!-- Outlook Button Fix (VML) -->
  <!--[if mso]>
  <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word"
               href="{{ url('/events/' . $event->slug) }}" style="height:48px;v-text-anchor:middle;width:220px;"
               arcsize="12%" stroke="f" fillcolor="#1d4ed8">
    <w:anchorlock/>
    <center style="color:#ffffff;font-family:sans-serif;font-size:16px;font-weight:600;">View Event Details</center>
  </v:roundrect>
  <![endif]-->
</body>

</html>