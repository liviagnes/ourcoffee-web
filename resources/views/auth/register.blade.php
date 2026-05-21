<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | OurCoffee</title>
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
    <style>
        .alert {
            padding: 10px;
            margin-bottom: 15px;
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
    </style>
</head>
<body>
    <section class="auth-page">
        <div class="auth-container">
            <div class="auth-image">
                <img src="{{ asset('assets/img/sign-in.jpg') }}" alt="Coffee Register">
            </div>
            <div class="auth-box">
                <h2>Create Account ☕</h2>
                <p class="auth-subtitle">Join us and start your coffee journey</p>

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form action="{{ url('/register') }}" method="post">
                    @csrf
                    <input type="text" name="full_name" placeholder="Full Name" required value="{{ old('full_name') }}">
                    <input type="text" name="username" placeholder="Username" required value="{{ old('username') }}">
                    <input type="email" name="email" placeholder="Email Address" required value="{{ old('email') }}">
                    <div style="position: relative;">
                        <input type="password" name="password" id="password" placeholder="Password" required style="width: 100%; padding-right: 40px; margin-bottom: 15px;">
                        <span id="togglePassword" style="position: absolute; right: 15px; top: 25px; transform: translateY(-50%); cursor: pointer; color: #8b5e3c;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </span>
                    </div>
                    <div style="position: relative;">
                        <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required style="width: 100%; padding-right: 40px; margin-bottom: 15px;">
                        <span id="toggleConfirmPassword" style="position: absolute; right: 15px; top: 25px; transform: translateY(-50%); cursor: pointer; color: #8b5e3c;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </span>
                    </div>

                    <div class="remember-row">
                        <label>
                            <input type="checkbox" required>
                            I agree to the <a href="#">Terms & Conditions</a>
                        </label>
                    </div>

                    <button type="submit">Create Account</button>

                    <div class="divider">
                        <span>OR</span>
                    </div>

                    <a href="#" class="btn-google">
                        <img src="{{ asset('assets/img/google.svg') }}" alt="Google" width="20">
                        Continue with Google
                    </a>
                </form>

                <p class="auth-footer">
                    Already have an account?
                    <a href="{{ url('/login') }}">Sign in</a>
                </p>
            </div>
        </div>
    </section>

    <script>
        function setupPasswordToggle(toggleId, inputId) {
            const togglePassword = document.querySelector(toggleId);
            const password = document.querySelector(inputId);

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

        setupPasswordToggle('#togglePassword', '#password');
        setupPasswordToggle('#toggleConfirmPassword', '#confirm_password');
    </script>
</body>
</html>
