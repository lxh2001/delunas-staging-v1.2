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
            <h3 style="color: #fff; text-align: center;">Appointment Rescheduling</h3>
        </div>
        <div class="content">
            <div class="message">
                <p>Hi,</p>
                <p>We hope this email finds you well. Due to {{ $appointment->reason }}, we need to reschedule your upcoming appointment with Dr. {{ $appointment->doctor->full_name }}.</p>
                <p><strong>Current Appointment Details:</strong></p>
                <p>Date:  {{ \Carbon\Carbon::parse($appointment->date_schedule)->format('F j, Y') }}</p>
                <p><strong>Suggested New Appointment Date:</strong></p>
                <p>Date:  {{ \Carbon\Carbon::parse($appointment->suggested_date)->format('F j, Y') }}</p>
                <p>If the suggested date is convenient for you, please click the button below to confirm the rescheduled appointment:</p>
                <div class="button-container">
                    @if($appointment->reschedule_status == 'rescheduled_by_patient')
                        <a class="button" href="{{ route('admin.dashboard') }}">Confirm Rescheduled Appointment</a>
                    @else
                        <a class="button" href="{{ route('patient.dashboard') }}">Confirm Rescheduled Appointment</a>
                    @endif
                </div>
                <p>If you have any conflicts with the suggested date or need further assistance, please contact our clinic at admin@delunas.com.</p>
                <p>We apologize for any inconvenience and appreciate your understanding.</p>
            </div>
        </div>
    </div>
</body>
</html>
