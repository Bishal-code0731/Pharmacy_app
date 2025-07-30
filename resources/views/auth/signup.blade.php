<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy App - Sign Up</title>
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
        
        .signup-card {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 350px;
        }

        .signup-card h2 {
            text-align: center;
            margin-bottom: 25px;
            margin-top: 0;
            color: #2c3e50;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .signup-card input {
            width: 100%;
            padding: 12px;
            margin-bottom: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .signup-card button {
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

        .signup-card button:hover {
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
            margin-top: 15px;
            font-size: 14px;
        }

        .login-link a {
            color: #3498db;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="signup-card">
        <h2>Create Your Account</h2>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('signup') }}" method="POST">
            @csrf

            <div class="form-group">
                <input type="text" name="full_name" placeholder="Full Name" value="{{ old('full_name') }}" required>
                @error('full_name')
                <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                @error('email')
                <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <input type="tel" name="phone" placeholder="Phone Number" value="{{ old('phone') }}" 
                       pattern="[0-9]{10}" title="10-digit phone number (no dashes or spaces)" required>
                @error('phone')
                <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
                @error('password')
                <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
            </div>

            <button type="submit">Sign Up</button>
        </form>

        <div class="login-link">
            Already have an account? <a href="{{ route('login') }}">Log in</a>
        </div>
    </div>
</body>
</html>