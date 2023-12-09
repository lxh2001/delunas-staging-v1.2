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
        .button {
            background-color: #ffc107;
            color: #000;
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
            <h3 style="color: #ffc107; text-align: center;">Appointment Approval</h3>
        </div>
        <div class="content">
            <div class="message">
                <p>Hi {{ $appointment->bookedUser->full_name }},</p>
                <p>Your appointment with Dr. {{ $appointment->doctor->full_name }} has been  {{ $appointment->status }}.</p>
                <p><strong>Appointment Details:</strong></p>
                <p>Date:  {{ \Carbon\Carbon::parse($appointment->date_schedule)->format('F j, Y') }}</p>
                <p>Slot #: {{ $appointment->slot }}</p>
                <p>Service: {{ $appointment->service }}</p>
                <p>Please make sure to arrive early for your appointment. The dentist is available from {{ \Carbon\Carbon::parse($appointment->start_time)->format('g:i A') }}  to {{ \Carbon\Carbon::parse($appointment->end_time)->format('g:i A') }}.</p>
                <p>Thank you for choosing our services!</p>
            </div>
        </div>
    </div>
</body>
</html>
