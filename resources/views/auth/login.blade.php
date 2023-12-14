<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Delunas Dental Clinic Centre</title>

    <!-- Linksf or Bootstrap Local -->
    <link rel="icon" type="image/png" href="{{ asset('icons/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.min.css') }} " />
    <link rel="stylesheet" href="{{ asset('css/login.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/media-queries.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/main.css' )}}" />
    {{-- <link rel="stylesheet" href="{{ asset('/css/global.css' )}}" /> --}}
    <!-- Links for Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;700&family=Plus+Jakarta+Sans:wght@300;400;500;700&family=Poppins:wght@300;400;500;600;700&display=swap"
      rel="stylesheet"
    />
  </head>
  <body>
    <main>
      <div class="login-wrapper">
        <div class="login-l">
          <div class="overlay"></div>
        </div>
        <div class="login-r">
            <div class="d-flex flex-column align-items-center">
              <img src="{{ asset('images/delunas-logo2.png') }}" />
              <p class="caption">Log in your details to continue to your account.</p>
            </div>

            @if (session('success_message'))
              <div class="alert alert-success">{{{   session('success_message')   }}}</div>
            @endif

            @if (session('error_message'))
              <div class="alert alert-danger">{{{   session('error_message')   }}}</div>
            @endif

            @if (session('token_error'))
              <div class="alert alert-danger">{{{   session('token_error')   }}}</div>
            @endif

          <form action="{{ route('auth.login') }}" method="POST">
            @csrf
            <div class="form-group">
              <label>Email</label>
              <input type="email" name="email" class="form-control" placeholder="" />
            </div>
            <div class="form-group mt-2">
              <label>Password</label>
              <input type="password" name="password" class="form-control" placeholder="" />
            </div>
            {{-- <button
            class="forgot-psw"
            type="button"
            data-toggle="modal"
            data-target="#viewDoctorAppointmentLogs"
            >
                Forgot Password?
            </button> --}}
            <a href="#" id="forgotPasswordBtn" class="forgot-psw">Forgot Password?</a>

            <button type="submit" class="btn submit-login">Log In</button>
            <div class="sign-up-wrapper">
              <p>
                Don't have an account?
                <a href="#" id="signupLink">Sign up for free</a>
              </p>
            </div>
          </form>
        </div>

        <div class="signup-section">
          <h3 class="text-left">Create Account</h3>
          {{-- <form id="formAcc"> --}}
          <form id="formAcc" action="{{ route('auth.register', ['is_index' => request('is_index'), 'services' => request('services') ] ) }}" method="POST">
            @csrf
            <div class="row">
              <div class="col-12 col-md-5">
                <div class="form-group">
                  <label>First Name</label>
                  <input name="firstname" type="text" class="form-control" placeholder="" required value="{{ old('firstname') }}"/>
                </div>
                @if ($errors->has('firstname'))
                  <span class="error-msg">{{ $errors->first('firstname') }}</span>
                @endif
              </div>

              <div class="col-12 col-md-2">
                <div class="form-group">
                  <label>M.I</label>
                  <input name="middlename" type="text" class="form-control" placeholder="" value="{{ old('middlename') }}"/>
                </div>
              </div>

              <div class="col-12 col-md-5">
                <div class="form-group">
                  <label>Last Name</label>
                  <input name="lastname" type="text" class="form-control" placeholder="" required value="{{ old('lastname') }}"/>
                </div>
                @if ($errors->has('lastname'))
                    <span class="error-msg">{{ $errors->first('lastname') }}</span>
                @endif
              </div>
            </div>

            <div class="row mt-2">
              <div class="col-12">
                <div class="form-group">
                    <label>Contact Number</label>
                    <input type="text" name="contact_number" class="form-control" placeholder="" />
                </div>
                @if ($errors->has('contact_number'))
                    <span class="error-msg">{{ $errors->first('contact_number') }}</span>
                @endif
              </div>
            </div>

            <div class="row mt-2">
              <div class="col-12">
                <div class="form-group">
                  <label>Email</label>
                  <input name="email" type="email" class="form-control" placeholder="" required value="{{ old('email') }}"/>
                </div>
                @if ($errors->has('email'))
                    <span class="error-msg">{{ $errors->first('email') }}</span>
                @endif
              </div>
            </div>

            <div class="row mt-2">
                <div class="col-12">
                  <div class="form-group">
                    <label>Birthdate:</label>
                    <input name="birthdate" type="date" class="form-control" placeholder="" required value="{{ old('birthdate') }}"/>
                  </div>
                  @if ($errors->has('birthdate'))
                      <span class="error-msg">{{ $errors->first('birthdate') }}</span>
                  @endif
                </div>
              </div>


            <div class="row mt-2">
              <div class="col-12">
                <div class="form-group">
                  <label>Password</label>
                  <input name="password" type="password" class="form-control" placeholder="" required />
                </div>
                @if ($errors->has('password'))
                    <span class="error-msg">{{ $errors->first('password') }}</span>
                @endif
              </div>
            </div>

            <div class="row mt-2">
              <div class="col-12">
                <div class="form-group">
                  <label>Confirm Password</label>
                  <input name="confirm_password" type="password" class="form-control" placeholder="" required/>
                </div>
                @if ($errors->has('confirm_password'))
                    <span class="error-msg">{{ $errors->first('confirm_password') }}</span>
                @endif
              </div>
            </div>

            {{-- <div class="form-check">
              <input class="form-check-input" type="checkbox" id="termsConditions" />
              <label class="form-check-label">I agree to the<a href="#">Terms & Conditions</a></label>
            </div> --}}
            <br><br>
            {{-- <div id="recaptcha-container"></div> --}}
            {{-- <button type="button" onclick="sendOTP();" class="btn submit-signup" id="createAccountButton"> --}}
            <button type="submit" class="btn submit-signup" id="createAccountButton">
              Create Account
            </button>
          </form>
          <p class="back-to-login-p">Already have an account? <a href="#" id="loginLink">Login.</a></p>
        </div>
      </div>
    </main>

<!-- Modal for Resending Email Verification Link -->
<div class="modal fade appointment-info-modal" id="resendEmailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <form action="{{ route('forgot_password') }}" method="POST">
        @csrf
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title text-center">Forgot password</h5>
            <button type="button" class="btn close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <div class="d-flex align-items-center gap-1" id="userEmail">
                <label>Email:</label>
                <input type="email" required name="forgot_email" class="form-control" />
            </div>
            @if ($errors->has('forgot_email'))
                <span class="error-msg">{{ $errors->first('forgot_email') }}</span>
            @endif
            </div>
            <div class="modal-footer">
            <button style="background-color: #135843; color: white;" type="submit" class="btn submit-login w-100" id="resendEmailBtn">Submit</button>
            </div>
        </div>
        </div>
    </form>
  </div>

  <!-- Modal for SMS OTP -->
<div class="modal fade appointment-info-modal" id="smsOTPModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <form>
        @csrf
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title text-center">Click "Send OTP" to generate OTP</h5>
            {{-- <button type="button" class="btn close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span>
            </button> --}}
            </div>
            <div class="modal-body">
                <div class="d-flex align-items-center gap-1" id="generateOTP">
                    @if (session('contact_number'))
                        <div class="alert alert-danger" id="error-otp" style="display: none;"></div>
                        <br><br>
                        <div class="alert alert-success" id="successAuth" style="display: none;"></div>
                        <input type="hidden" id="user_id" value="{{ session('user_id') }}">
                        <input type="hidden" required id="otp_number" name="otp_number" value="{{ session('contact_number') }}" class="form-control" />
                        <br><br>
                    @endif

                    <div style='margin-top: 30px;' id="recaptcha-container"></div>
                </div>

                <div class="d-flex align-items-center gap-1" id="verifyOTP">
                    <div class="alert alert-danger" id="error" style="display: none;"></div>
                    <br><br>
                    <label for="verify_code">Enter Verification Code:</label>
                    <input type="text" required id="verify_code" name="verification_code" class="form-control" />
                </div>
            </div>
            <div class="modal-footer">
                <button style="background-color: #135843; color: white;" type="button" onclick="sendOTP()" id="generateOTPBtn" class="btn submit-login w-100">SEND OTP</button>
                <button style="background-color: #135843; color: white;" type="button" onclick="verify()" id="verifyOTPBtn" class="btn submit-login w-100">VERIFY OTP</button>
            </div>
        </div>
        </div>
    </form>
  </div>
<!-- Modal for Success Message -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center">Success!</h5>
                <button type="button" class="btn close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Password reset instructions have been sent to your email.</p>
            </div>
        </div>
    </div>
</div>
    @if($errors->has('firstname') || $errors->has('lastname') || $errors->has('contact_number') || $errors->has('email') || $errors->has('confirm_password') || $errors->has('passowrd') )
        <script>
            window.addEventListener('load', function () {
                const loginLink = document.getElementById("loginLink");
                const loginWrapper = document.querySelector(".login-r");
                loginWrapper.style.display = "none";
                signupSection.style.display = "flex";
            }, false)

        </script>
    @endif

    <!-- Loading Overlay -->
    <div id="loading-overlay">
        <div class="loader"></div>
    </div>

    <!-- Scripts  -->
    <script src="{{ asset('js/loading-overlay.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
    <script
    src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"
  ></script>

  <!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
  <script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>

  <script>

    var firebaseConfig = {
    apiKey: "AIzaSyCw54jAFQAVHcQbGSnvwnjRC-EpiL1MoXk",
    authDomain: "delunas.firebaseapp.com",
    projectId: "delunas",
    storageBucket: "delunas.appspot.com",
    messagingSenderId: "944035581283",
    appId: "1:944035581283:web:2f612d509be5dce4259756"
    };

    // const firebaseConfig = {
    //     apiKey: "AIzaSyC0N8j6aOLYO4qjGQQ_6fZlXtZbYZ4i5ag",
    //     authDomain: "delunas-aabf4.firebaseapp.com",
    //     projectId: "delunas-aabf4",
    //     storageBucket: "delunas-aabf4.appspot.com",
    //     messagingSenderId: "1075844086825",
    //     appId: "1:1075844086825:web:65adf198d2cedd7317b038"
    // };

    firebase.initializeApp(firebaseConfig);

</script>
<script type="text/javascript">
    window.onload = function () {
        render();
        $('#verifyOTP').attr('style', 'display: none !important');
        $("#verifyOTPBtn").hide();
    };
    function render() {
        window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
        recaptchaVerifier.render();
    }
    function sendOTP() {
        var number = $("#otp_number").val();
        $("#generateOTPBtn").prop("disabled", true);
        firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function (confirmationResult) {
            window.confirmationResult = confirmationResult;
            coderesult = confirmationResult;
            $("#successAuth").text("Message sent");
            $("#successAuth").show();
            $("#generateOTP").hide();
            $("#generateOTPBtn").hide();
            $('#recaptcha-container').attr('style', 'display: none !important');
            $('#verifyOTP').attr('style', '');
            $("#verifyOTPBtn").show();
        }).catch(function (error) {
            $("#generateOTPBtn").prop("disabled", false);
            $("#error-otp").text(error.message);
            $("#error-otp").show();
        });
    }
    function verify() {
        var code = $("#verify_code").val();
        var userId = $('#user_id').val();
        $("#verifyOTPBtn").prop("disabled", true);
        coderesult.confirm(code).then(function (result) {

            $.ajax({
                type: "POST",
                url: '/phone-auth',
                data: JSON.stringify({userId: userId}),
                dataType: "json",
                contentType: "application/json",
                mimeType: "application/json",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            }).done(function (response) {
                window.location.href = "/patient/dashboard";
            });

        }).catch(function (error) {
            $("#error").text(error.message);
            $("#error").show();
            $("#verifyOTPBtn").prop("disabled", false);
        });
    }
</script>

  @if (session('success_sms'))
    <script>
        $(document).ready(function() {
           $('#smsOTPModal').modal('show');
        });
    </script>
 @endif

@if($errors->has('forgot_email'))
 <script>
     $(document).ready(function() {
         $('#resendEmailModal').modal('show');
     });
 </script>
@endif

@if (session('forgot_email_success'))
<script>
    $(document).ready(function() {
        $('#successModal').modal('show');
    });
</script>
@endif

  <script>
        $(document).ready(function() {
            $("#formAcc").submit(function() {
                // Disable the submit button on form submission
                $("#createAccountButton").prop("disabled", true);
            });

            $(document).on('click', '#forgotPasswordBtn', function() {
                $('#resendEmailModal').modal('show');
            });
        });

    </script>

    <!-- Scripts Local -->
    <script src="{{ asset('js/login.js') }}"></script>
    <script src="{{ asset('js/bootstrap/bootstrap.min.js') }}"></script>
  </body>
</html>
