<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy App - Reset Password</title>
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
        
        .reset-card {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 350px;
        }

        .reset-card h2 {
            text-align: center;
            margin-bottom: 25px;
            margin-top: 0;
            color: #2c3e50;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .reset-card input {
            width: 100%;
            padding: 12px;
            margin-bottom: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .reset-card button {
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

        .reset-card button:hover {
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

        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }

        .login-link a {
            color: #27ae60;
            text-decoration: none;
            font-weight: bold;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .instructions {
            font-size: 14px;
            color: #555;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="reset-card">
        <h2>Reset Password</h2>

        @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
            @endforeach
        </div>
        @endif

        <div class="instructions">
            Enter your email and we'll send you a password reset link.
        </div>

        <form action="{{ route('password.email') }}" method="POST">
            @csrf
           
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
                @error('email')
                <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit">Send Reset Link</button>
        </form>

        <div class="login-link">
            Remember your password? <a href="{{ route('login') }}">Log In</a>
        </div>
    </div>
</body>
</html>