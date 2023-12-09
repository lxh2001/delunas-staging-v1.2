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
            background-color: #dc3545;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h3 style="color: #fff; text-align: center;">Appointment Cancellation</h3>
        </div>
        <div class="content">
            <div class="message">
                <p>Hi!,</p>
                <p>We regret to inform you that the upcoming appointment has been canceled.</p>
                <p><strong>Details:</strong></p>
                <p>Date: {{ \Carbon\Carbon::parse($appointment->date_schedule)->format('F j, Y') }}</p>
                <p>Doctor: {{ $appointment->doctor->full_name }}</p>
                <p>Service: {{ $appointment->service }}</p>
                <p>Reason for Cancellation: {{ $appointment->reason }}</p>
                <p>We understand that plans can change, and we appreciate your understanding.</p>
                <p>If you have any questions or would like to reschedule, please contact us at admin@delunas.com.</p>
                <p>Thank you for your understanding.</p>
            </div>
        </div>
    </div>
</body>
</html>
