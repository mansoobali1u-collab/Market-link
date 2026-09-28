<x-guest-layout>

    <style>
        .market-reset-page {
            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 40px 20px;

            background: #f4f7f5;
        }

        .market-reset-card {
            width: 100%;
            max-width: 440px;

            background: #ffffff;

            border: 1px solid #e3ebe6;
            border-radius: 16px;

            box-shadow: 0 8px 30px rgba(46, 125, 50, 0.08);

            padding: 32px;
        }

        .market-reset-logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;

            margin-bottom: 20px;
        }

        .market-reset-logo-image {
            width: 80px;
            height: 80px;

            object-fit: contain;
        }

        .market-reset-brand {
            margin-top: 8px;

            color: #2e7d32;

            font-size: 22px;
            font-weight: 700;
        }

        .market-reset-title {
            margin: 0;

            color: #2e3e35;

            font-size: 26px;
            font-weight: 700;

            text-align: center;
        }

        .market-reset-subtitle {
            margin: 7px 0 28px;

            color: #819088;

            font-size: 14px;
            line-height: 1.5;

            text-align: center;
        }

        .market-reset-field {
            margin-bottom: 20px;
        }

        .market-reset-label {
            display: block;

            margin-bottom: 7px;

            color: #2e3e35;

            font-size: 14px;
            font-weight: 600;
        }

        .market-reset-input {
            display: block;

            width: 100%;
            min-height: 44px;

            box-sizing: border-box;

            padding: 11px 13px;

            border: 1px solid #cfdcd3;
            border-radius: 8px;

            background: #ffffff;

            color: #2e3e35;

            font-family: Arial, sans-serif;
            font-size: 14px;

            outline: none;
        }

        .market-reset-input:focus {
            border-color: #2e7d32;

            box-shadow:
                0 0 0 3px rgba(46, 125, 50, 0.12);
        }

        .market-reset-input::placeholder {
            color: #9aa69f;
        }

        .market-reset-errors {
            margin-bottom: 20px;

            padding: 12px 14px;

            border: 1px solid #ffcdd2;
            border-radius: 8px;

            background: #ffebee;

            color: #c62828;

            font-size: 13px;
        }

        .market-reset-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;

            margin-top: 8px;
        }

        .market-reset-button {
            min-height: 42px;

            padding: 10px 20px;

            border: none;
            border-radius: 8px;

            background: #2e7d32;

            color: #ffffff;

            font-size: 14px;
            font-weight: 600;

            cursor: pointer;
        }

        .market-reset-button:hover {
            background: #1b5e20;
        }

        .market-reset-footer {
            margin-top: 25px;
            padding-top: 20px;

            border-top: 1px solid #e3ebe6;

            color: #819088;

            font-size: 12px;

            text-align: center;
        }

        .market-reset-back {
            display: block;

            margin-top: 16px;

            color: #64756b;

            font-size: 13px;

            text-align: center;

            text-decoration: none;
        }

        .market-reset-back:hover {
            color: #2e7d32;
        }

        @media (max-width: 500px) {

            .market-reset-page {
                padding: 20px 15px;
            }

            .market-reset-card {
                padding: 24px 20px;
            }

            .market-reset-actions {
                align-items: stretch;
            }

            .market-reset-button {
                width: 100%;
            }
        }

        .market-reset-status {
            margin-bottom: 20px;
            padding: 12px 14px;
            border: 1px solid #c8e6c9;
            border-radius: 8px;
            background: #e8f5e9;
            color: #2e7d32;
            font-size: 13px;
        }
    </style>


    <div class="market-reset-page">

        <div class="market-reset-card">

            {{-- MarketLink Logo --}}
            <div class="market-reset-logo">

                <div class="market-reset-brand">
                    MarketLink
                </div>
            </div>


            {{-- Heading --}}
            <h1 class="market-reset-title">
                Forgot Password?
            </h1>

            <p class="market-reset-subtitle">
                Enter the email you registered with (customer or farmer) and we will
                email you a link to choose a new password.
            </p>


            {{-- Success message after the link is sent --}}
            @session('status')
                <div class="market-reset-status">
                    {{ $value }}
                </div>
            @endsession


            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="market-reset-errors">
                    <ul style="margin: 0; padding-left: 18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            {{-- Send Reset Link Form --}}
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="market-reset-field">
                    <label for="email" class="market-reset-label">
                        Email
                    </label>

                    <input
                        id="email"
                        class="market-reset-input"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Enter your email"
                        required
                        autofocus
                        autocomplete="username"
                    >
                </div>

                <div class="market-reset-actions">
                    <button type="submit" class="market-reset-button">
                        Email Reset Link
                    </button>
                </div>
            </form>


            {{-- Back to Login --}}
            <a href="{{ route('login') }}" class="market-reset-back">
                Back to Login
            </a>


            {{-- Footer --}}
            <div class="market-reset-footer">
                MarketLink &mdash; Connecting Farmers and Customers
            </div>

        </div>

    </div>

</x-guest-layout>