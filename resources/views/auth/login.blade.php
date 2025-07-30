<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy App - Login</title>
    <style>
        body {
            font-family: "Times New Roman", sans-serif;
            background-image: url('/images/logo.png');
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            background-color: #e0fdfb;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding-right: 50px;
        }
        
        .login-card {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 350px;
        }

        .login-card h2 {
            text-align: center;
            margin-bottom: 25px;
            margin-top: 0;
            color: #2c3e50;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .login-card input {
            width: 100%;
            padding: 12px;
            margin-bottom: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .login-card button {
            width: 100%;
            padding: 12px;
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }

        .login-card button:hover {
            background-color: #219150;
        }

        .error-message {
            color: #e74c3c;
            font-size: 14px;
            margin-top: -5px;
            margin-bottom: 10px;
        }

        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 14px;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .remember-me input {
            width: auto;
            margin-right: 8px;
        }

        .forgot-password {
            text-align: right;
            margin-top: -10px;
            margin-bottom: 15px;
        }

        .forgot-password a {
            color: #3498db;
            text-decoration: none;
            font-size: 13px;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .signup-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }

        .signup-link a {
            color: #27ae60;
            text-decoration: none;
            font-weight: bold;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="login-card">
        <h2>Welcome</h2>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
            @endforeach
        </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
           
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                @error('email')
                <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
                @error('password')
                <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="remember-me">
                <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember">Remember me</label>
            </div>

            <div class="forgot-password">
                <a href="{{ route('password.request') }}">Forgot Password?</a>
            </div>

            <button type="submit">Log In</button>
        </form>

        <div class="signup-link">
            Don't have an account? <a href="{{ route('signup') }}">Sign Up</a>
        </div>
    </div>
</body>
</html>