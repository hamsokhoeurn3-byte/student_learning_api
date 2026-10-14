<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SLAS - Login</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Kantumruy+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            min-height: 100dvh;
            background-color: #dcecff;
            background-image: url('{{ asset('bg.png') }}');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            background-attachment: fixed;
            font-family: 'Kantumruy Pro', Inter, Arial, Helvetica, sans-serif;
        }

        .login-wrapper {
            min-height: 100vh;
            min-height: 100dvh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px 16px;
            background: rgba(255, 255, 255, 0.12);
            box-sizing: border-box;
            position: relative;
        }

        .login-lang-switch {
            position: fixed;
            top: 18px;
            right: 20px;
            z-index: 100;
        }

        .login-card {
            width: 100%;
            max-width: 410px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.08);
            padding: 34px 38px 36px;
            box-sizing: border-box;
            margin: auto 0;
        }

        .login-logo {
            display: block;
            width: min(100%, 220px);
            aspect-ratio: 1;
            height: auto;
            margin: 0 auto 14px;
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
            font-size: 13px;
            margin-bottom: 26px;
        }

        .form-label {
            color: #111827;
            font-weight: 600;
            font-size: 13px;
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
            height: 45px;
        }

        .input-icon {
            width: 45px;
            min-width: 45px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #f8fafc;
            border: 1px solid #d1d5db;
            border-right: 0;

            border-radius: 8px 0 0 8px;

            font-size: 17px;
        }

        .custom-input {
            flex: 1;

            height: 45px;

            border: 1px solid #d1d5db;
            border-left: 0;

            border-radius: 0 8px 8px 0;

            padding: 0 13px;

            font-size: 14px;

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
            height: 45px;
        }

        .password-input {
            flex: 1;

            height: 45px;

            border: 1px solid #d1d5db;
            border-left: 0;
            border-right: 0;

            padding: 0 13px;

            font-size: 14px;

            outline: none;
        }

        .password-input:focus {
            border-color: #8b5cf6;

            box-shadow:
                0 0 0 3px rgba(139, 92, 246, 0.12);
        }

        .password-toggle {
            width: 45px;
            min-width: 45px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #ffffff;

            border: 1px solid #d1d5db;
            border-left: 0;

            border-radius: 0 8px 8px 0;

            cursor: pointer;

            font-size: 17px;
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
            justify-content: flex-start;

            margin-top: 14px;
            margin-bottom: 20px;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 8px;

            color: #374151;
            font-size: 12px;
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
            font-size: 12px;
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
            height: 45px;

            border: none;
            border-radius: 8px;

            background: linear-gradient(90deg,
                    #7c3aed,
                    #9333ea);

            color: white;

            font-size: 14px;
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

        /* When screen is narrower or aspect ratio < 16/10: frame temple and push left artwork text off-screen cleanly */
        @media (max-width: 1250px), (max-aspect-ratio: 16/10) {
            body {
                background-position: 85% center;
            }
        }

        @media (max-width: 768px) {
            body {
                background-position: 80% center;
                background-attachment: scroll;
            }

            .login-wrapper {
                padding: 65px 16px 30px;
            }
        }

        @media (max-width: 576px) {
            .login-wrapper {
                padding: 60px 14px 20px;
            }

            .login-card {
                padding: 26px 18px 28px;
                border-radius: 14px;
            }

            .login-logo {
                width: min(100%, 170px);
                margin-bottom: 10px;
            }

            .description {
                font-size: 12px;
                margin-bottom: 20px;
            }

            .login-lang-switch {
                top: 12px;
                right: 14px;
            }
        }
    </style>
</head>

<body>

    <div class="login-lang-switch">
        <x-language-switcher />
    </div>

    <div class="login-wrapper">

        <div class="login-card">

            {{-- Logo --}}
            <div class="text-center">

                <img src="{{ asset('slas-logo.png') }}" alt="SLAS - Siem Reap University" class="login-logo">

                <div class="description">
                    {{ __('Smart Insights for Better Learning') }}
                </div>

            </div>


            {{-- Login Form --}}
            <form method="POST" action="{{ route('login.submit') }}">

                @csrf


                {{-- Login ID --}}
                <div class="mb-4">

                    <label for="login_id" class="form-label">
                        {{ __('Student / Teacher / Admin ID') }}
                    </label>

                    <div class="input-group-custom">

                        {{-- Icon --}}
                        <div class="input-icon">
                            👤
                        </div>

                        {{-- Input --}}
                        <input type="text" id="login_id" name="login_id" class="custom-input"
                            placeholder="{{ __('Enter your ID') }}" value="{{ old('login_id') }}" autocomplete="username" required>

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
                        {{ __('Password') }}
                    </label>

                    <div class="password-group">

                        {{-- Lock Icon --}}
                        <div class="input-icon">
                            🔒
                        </div>

                        {{-- Password --}}
                        <input type="password" id="password" name="password" class="password-input"
                            placeholder="{{ __('Enter your password') }}" autocomplete="current-password" required>

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
                            {{ __('Remember me') }}
                        </span>

                    </label>

                </div>


                {{-- Sign In --}}
                <button type="submit" class="login-button">
                    {{ __('Sign In') }} →
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
