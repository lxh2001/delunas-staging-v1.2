<html>
<head>
    <style>
        body {
            font-family: 'Roboto', 'Helvetica Neue', Helvetica, Arial, 'sans-serif';
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
        }
        .header {
            background-color: #135843;
            text-align: center;
            padding: 15px;
            color: #fff;
        }
        .content {
            background-color: #f8f9fa;
            padding: 15px;
            color: #000;
        }
        .message {
            font-size: 18px;
            color: #000;
        }
        .button-container {
            text-align: center;
        }
        .button {
            background-color: #135843;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            display: inline-block;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h3 style="color: #fff; text-align: center;">Appointment Update Notification</h3>
        </div>
        <div class="content">
            <div class="message">
                <p>Hi,</p>
                <p>We hope this email finds you well. We wanted to inform you that your upcoming appointment with Dr. {{ $appointment->doctor->full_name }} has been updated due to the cancellation of other appointments.</p>
                <p><strong>Updated Appointment Details:</strong></p>
                <p>Date:  {{ \Carbon\Carbon::parse($appointment->date_schedule)->format('F j, Y') }}</p>
                <p> Slot #: {{ $appointment->slot_no }} </p>
                <p>Time Slot: {{ \Carbon\Carbon::parse($appointment->start_time)->format('g:i A') }} to {{ \Carbon\Carbon::parse($appointment->end_time)->format('g:i A') }}</p>
                <p>If you have any questions or concerns regarding this update, please feel free to contact our clinic at admin@delunas.com.</p>
                <p>We appreciate your understanding and cooperation.</p>
                <div class="button-container">
                    <a class="button" href="{{ route('patient.dashboard') }}">View Updated Appointment Details</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
