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
            <h3 style="color: #fff; text-align: center;">Appointment Declined</h3>
        </div>
        <div class="content">
            <div class="message">
                <p>Hi,</p>
                <p>We regret to inform you that your request to reschedule the upcoming appointment has been declined.</p>
                <p><strong>Suggested Appointment Details:</strong></p>
                <p>Date:{{ \Carbon\Carbon::parse($appointment->suggested_date)->format('F j, Y') }} </p>
                <p>Doctor: {{ $appointment->doctor->full_name }}</p>
                <p>Service: {{ $appointment->service }}</p>
                {{-- <p><strong>Reason for Decline:</strong></p>
                <p>{{ $appointment->reason }}</p> --}}
                <p>If you have any questions or concerns, please contact us at admin@delunas.com.</p>
                <p>We apologize for any inconvenience and appreciate your understanding.</p>
            </div>
        </div>
    </div>
</body>
</html>
