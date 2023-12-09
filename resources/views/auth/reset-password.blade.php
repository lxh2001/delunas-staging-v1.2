<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Delunas Dental Clinic Centre</title>

    <!-- Add your CSS links here -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/login.css') }}" />
    <!-- ... (add other stylesheets as needed) ... -->
</head>
<body>
    <main>
        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Reset Password</div>

                        <div class="card-body">
                            <form action="{{ route('submit_reset_password') }}" method="POST">
                                @csrf
                                <input type="hidden" name="email" value="{{ $email }}">
                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="form-group">
                                    <label for="newPassword">New Password</label>
                                    <input type="password" name="password" class="form-control" required />
                                </div>
                                @if ($errors->has('password'))
                                    <span class="error-msg">{{ $errors->first('password') }}</span>
                                @endif
                                <div class="form-group">
                                    <label for="confirmPassword">Confirm Password</label>
                                    <input type="password" name="confirm_password" class="form-control" required />
                                </div>
                                @if ($errors->has('confirm_password'))
                                    <span class="error-msg">{{ $errors->first('confirm_password') }}</span>
                                @endif
                                <br><br>

                                <button type="submit" class="btn btn-primary">Set New Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add your scripts and script links here -->
        <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap/bootstrap.min.js') }}"></script>
        <!-- ... (add other scripts as needed) ... -->
    </main>
</body>
</html>
