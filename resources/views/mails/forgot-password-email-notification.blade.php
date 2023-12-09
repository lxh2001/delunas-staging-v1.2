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
            <h3 style="color: #ffc107; text-align: center;">Password Reset Request</h3>
        </div>
        <div class="content">
            <div class="message">
                <p>Hi {{ $user->full_name }},</p>
                <p>You are receiving this email because we received a password reset request for your account.</p>
                <p>Please click on the button below to reset your password:</p>

                <div class="button-container">
                    <a class="button" href="{{ route('reset_password', ['token' => $user->token, 'email' => $user->email]) }}">Reset Password</a>
                </div>

                <p>If you did not request a password reset, no further action is required.</p>
                <p>Thank you!</p>
            </div>
        </div>
    </div>
</body>
</html>
