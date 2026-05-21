<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | OurCoffee</title>
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
    <style>
        .alert {
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 14px;
            font-size: 13px;
            text-align: center;
        }
        .alert-danger {
            background-color: #ffebee;
            color: #c62828;
            border: 1px solid #ef9a9a;
        }
        .alert-success {
            background-color: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #a5d6a7;
        }
    </style>
</head>
<body>
    <section class="auth-page">
        <div class="auth-container">
            <div class="auth-image">
                <img src="{{ asset('assets/img/sign-in.jpg') }}" alt="Forgot Password">
            </div>
            <div class="auth-box">
                <h2>Reset Password 🔒</h2>
                <p class="auth-subtitle">Enter your email and create a new password instantly.</p>

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('password.instant') }}" method="post">
                    @csrf
                    <input type="email" name="email" placeholder="Email Address" required value="{{ old('email') }}" style="margin-bottom: 15px;">
                    
                    <div style="position: relative;">
                        <input type="password" name="new_password" id="new_password" placeholder="New Password" required style="width: 100%; padding-right: 40px; margin-bottom: 15px;">
                        <span id="toggleNewPassword" style="position: absolute; right: 15px; top: 25px; transform: translateY(-50%); cursor: pointer; color: #8b5e3c;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </span>
                    </div>

                    <div style="position: relative;">
                        <input type="password" name="confirm_new_password" id="confirm_new_password" placeholder="Confirm New Password" required style="width: 100%; padding-right: 40px; margin-bottom: 15px;">
                        <span id="toggleConfirmPassword" style="position: absolute; right: 15px; top: 25px; transform: translateY(-50%); cursor: pointer; color: #8b5e3c;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </span>
                    </div>
                    
                    <button type="submit">Update Password</button>
                </form>
                <p class="auth-footer" style="margin-top: 20px;">
                    Remember your password?
                    <a href="{{ url('/login') }}">Sign in</a>
                </p>
            </div>
        </div>
    </section>

    <script>
        function setupPasswordToggle(toggleId, inputId) {
            const togglePassword = document.querySelector(toggleId);
            const password = document.querySelector(inputId);

            if (togglePassword && password) {
                togglePassword.addEventListener('click', function (e) {
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);
                    
                    if (type === 'text') {
                        this.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye-off"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>';
                    } else {
                        this.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>';
                    }
                });
            }
        }

        setupPasswordToggle('#toggleNewPassword', '#new_password');
        setupPasswordToggle('#toggleConfirmPassword', '#confirm_new_password');
    </script>
</body>
</html>
