<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SLAS - Login</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg,
                    #f3e8ff 0%,
                    #ffffff 50%,
                    #f5f3ff 100%);
            font-family: Arial, Helvetica, sans-serif;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 15px;
        }

        .login-card {
            width: 100%;
            max-width: 500px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
            padding: 50px;
        }

        .login-logo {
            display: block;
            width: min(100%, 300px);
            aspect-ratio: 1;
            height: auto;
            margin: 0 auto 20px;
            object-fit: contain;
            border-radius: 50%;
        }

        .brand-title {
            color: #6d28d9;
            font-size: 44px;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 10px;
        }

        .brand-line {
            width: 38px;
            height: 4px;
            background: #8b5cf6;
            border-radius: 10px;
            margin: 0 auto 12px;
        }

        .subtitle {
            color: #111827;
            font-size: 21px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .description {
            color: #6b7280;
            font-size: 15px;
            margin-bottom: 35px;
        }

        .form-label {
            color: #111827;
            font-weight: 600;
            margin-bottom: 8px;
        }

        /*
        |--------------------------------------------------------------------------
        | Input Group
        |--------------------------------------------------------------------------
        | Icon is OUTSIDE the input area.
        | Therefore icon will never overlap text.
        */

        .input-group-custom {
            display: flex;
            width: 100%;
            height: 56px;
        }

        .input-icon {
            width: 56px;
            min-width: 56px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #f8fafc;
            border: 1px solid #d1d5db;
            border-right: 0;

            border-radius: 8px 0 0 8px;

            font-size: 21px;
        }

        .custom-input {
            flex: 1;

            height: 56px;

            border: 1px solid #d1d5db;
            border-left: 0;

            border-radius: 0 8px 8px 0;

            padding: 0 16px;

            font-size: 16px;

            outline: none;
        }

        .custom-input:focus {
            border-color: #8b5cf6;

            box-shadow:
                0 0 0 3px rgba(139, 92, 246, 0.12);
        }

        /*
        |--------------------------------------------------------------------------
        | Password Input
        |--------------------------------------------------------------------------
        */

        .password-group {
            display: flex;
            width: 100%;
            height: 56px;
        }

        .password-input {
            flex: 1;

            height: 56px;

            border: 1px solid #d1d5db;
            border-left: 0;
            border-right: 0;

            padding: 0 16px;

            font-size: 16px;

            outline: none;
        }

        .password-input:focus {
            border-color: #8b5cf6;

            box-shadow:
                0 0 0 3px rgba(139, 92, 246, 0.12);
        }

        .password-toggle {
            width: 56px;
            min-width: 56px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #ffffff;

            border: 1px solid #d1d5db;
            border-left: 0;

            border-radius: 0 8px 8px 0;

            cursor: pointer;

            font-size: 20px;
        }

        .password-toggle:hover {
            background: #f9fafb;
        }

        /*
        |--------------------------------------------------------------------------
        | Remember / Forgot
        |--------------------------------------------------------------------------
        */

        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;

            margin-top: 18px;
            margin-bottom: 25px;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 8px;

            color: #374151;
            font-size: 14px;
        }

        .remember-label input {
            width: 17px;
            height: 17px;
            cursor: pointer;
        }

        .forgot-link {
            color: #7c3aed;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        /*
        |--------------------------------------------------------------------------
        | Sign In Button
        |--------------------------------------------------------------------------
        */

        .login-button {
            width: 100%;
            height: 56px;

            border: none;
            border-radius: 8px;

            background: linear-gradient(90deg,
                    #7c3aed,
                    #9333ea);

            color: white;

            font-size: 17px;
            font-weight: 600;

            box-shadow:
                0 8px 20px rgba(124, 58, 237, 0.25);

            transition: 0.2s ease;
        }

        .login-button:hover {
            transform: translateY(-1px);

            box-shadow:
                0 10px 25px rgba(124, 58, 237, 0.35);
        }

        /*
        |--------------------------------------------------------------------------
        | Validation Error
        |--------------------------------------------------------------------------
        */

        .error-message {
            color: #dc2626;
            font-size: 13px;
            margin-top: 7px;
        }

        /*
        |--------------------------------------------------------------------------
        | Responsive
        |--------------------------------------------------------------------------
        */

        @media (max-width: 576px) {

            .login-card {
                padding: 30px 22px;
            }

            .brand-title {
                font-size: 38px;
            }

            .subtitle {
                font-size: 18px;
            }

        }
    </style>
</head>

<body>

    <div class="login-wrapper">

        <div class="login-card">

            {{-- Logo --}}
            <div class="text-center">

                <img src="{{ asset('slas-logo.png') }}" alt="SLAS - Siem Reap University" class="login-logo">

                <div class="description">
                    Smart Insights for Better Learning
                </div>

            </div>


            {{-- Login Form --}}
            <form method="POST" action="{{ route('login.submit') }}">

                @csrf


                {{-- Login ID --}}
                <div class="mb-4">

                    <label for="login_id" class="form-label">
                        Student / Teacher / Admin ID
                    </label>

                    <div class="input-group-custom">

                        {{-- Icon --}}
                        <div class="input-icon">
                            👤
                        </div>

                        {{-- Input --}}
                        <input type="text" id="login_id" name="login_id" class="custom-input"
                            placeholder="Enter your ID" value="{{ old('login_id') }}" autocomplete="username" required>

                    </div>

                    @error('login_id')
                        <div class="error-message">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Password --}}
                <div class="mb-3">

                    <label for="password" class="form-label">
                        Password
                    </label>

                    <div class="password-group">

                        {{-- Lock Icon --}}
                        <div class="input-icon">
                            🔒
                        </div>

                        {{-- Password --}}
                        <input type="password" id="password" name="password" class="password-input"
                            placeholder="Enter your password" autocomplete="current-password" required>

                        {{-- Eye Button --}}
                        <button type="button" class="password-toggle" id="togglePassword" aria-label="Show password">
                            👁️
                        </button>

                    </div>

                    @error('password')
                        <div class="error-message">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Remember + Forgot --}}
                <div class="remember-row">

                    <label class="remember-label">

                        <input type="checkbox" name="remember" value="1">

                        <span>
                            Remember me
                        </span>

                    </label>

                    <a href="#" class="forgot-link">
                        Forgot password?
                    </a>

                </div>


                {{-- Sign In --}}
                <button type="submit" class="login-button">
                    Sign In →
                </button>

            </form>


        </div>

    </div>


    {{-- Password Show / Hide --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const password =
                document.getElementById('password');

            const togglePassword =
                document.getElementById('togglePassword');


            togglePassword.addEventListener('click', function() {

                if (password.type === 'password') {

                    password.type = 'text';

                    togglePassword.textContent = '🙈';

                    togglePassword.setAttribute(
                        'aria-label',
                        'Hide password'
                    );

                } else {

                    password.type = 'password';

                    togglePassword.textContent = '👁️';

                    togglePassword.setAttribute(
                        'aria-label',
                        'Show password'
                    );
                }

            });

        });
    </script>

</body>

</html>
