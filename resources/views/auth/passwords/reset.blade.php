<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy App - Reset Password</title>
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
</head>
<body>
    <div class="password-card">
        <h2>Reset Password</h2>

        @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
            @endforeach
        </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <input type="email" name="email" placeholder="Email" value="{{ $email ?? old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <input type="password" name="password" placeholder="New Password" required>
                <div class="password-requirements">
                    Password must be at least 8 characters long.
                </div>
            </div>

            <div class="form-group">
                <input type="password" name="password_confirmation" placeholder="Confirm New Password" required>
            </div>

            <button type="submit">Reset Password</button>
        </form>

        <div class="login-link">
            <a href="{{ route('login') }}">Back to Login</a>
        </div>
    </div>
</body>
</html>