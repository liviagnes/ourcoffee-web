<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | OurCoffee</title>
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
                <img src="{{ asset('assets/img/sign-in.jpg') }}" alt="Coffee Login">
            </div>
            <div class="auth-box">
                <h2>Welcome Back! 👋</h2>
                <p class="auth-subtitle">Please enter your details to sign in.</p>

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

                <form action="{{ url('/login') }}" method="post" autocomplete="off">
                    @csrf
                    <input type="text" name="username_email" placeholder="Email or Username" required value="{{ old('username_email') }}" autocomplete="off">
                    <div style="position: relative;">
                        <input type="password" name="password" id="password" placeholder="Password" required style="width: 100%; padding-right: 40px; margin-bottom: 15px;" autocomplete="off">
                        <span id="togglePassword" style="position: absolute; right: 15px; top: 25px; transform: translateY(-50%); cursor: pointer; color: #8b5e3c;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </span>
                    </div>
                    <div class="remember-row">
                        <label>
                            <input type="checkbox" name="remember">
                            Remember me
                        </label>
                        <a href="{{ route('password.request') }}">Forgot Password?</a>
                    </div>
                    <button type="submit">Sign In</button>
                    <div class="divider">
                        <span>OR</span>
                    </div>
                    <a href="#" class="btn-google">
                        <img src="{{ asset('assets/img/google.svg') }}" alt="Google">
                        Continue with Google
                    </a>
                </form>
                <p class="auth-footer">
                    Don't have an account?
                    <a href="{{ url('/register') }}">Sign up</a>
                </p>
            </div>
        </div>
    </section>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function (e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            if (type === 'text') {
                this.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye-off"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>';
            } else {
                this.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>';
            }
        });
    </script>
</body>
</html>
