<html>
<head>
</head>
<body style="font-family: 'Roboto', 'Helvetica Neue', Helvetica, Arial, 'sans-serif';">
    <div class="container" style="max-width: 600px; margin: 0 auto;">
        <div class="header" style="background-color: #135843; text-align: center; padding: 15px; color: #fff;">
            <h3 style="color:#ffc107; text-align:center;">Account Verification</h3>
        </div>
        <div class="content" style="background-color: #f8f9fa; padding: 15px; color:#000;">
            <div class="message" style="font-size: 18px; color: #000;">
                <p>Hi {{ $user->name }}, </p><p>
                </p><p>This is an email from Delunas Dental Clinic because you have registered on our site. Please click on the verification button below: </p>
                @component('mail::button', ['url' =>  $user->redirect_route])
                    Verify your Account
                @endcomponent
                <br>
            </div>
        </div>
    </div>
</body>
</html>
