<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Unida Tech Limited | Login</title>
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap"
            rel="stylesheet"
        />
        <style>
            body {
                margin: 0;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                background: radial-gradient(circle at 10% 20%, rgba(0, 84, 170, 0.2), transparent 40%),
                    radial-gradient(circle at 80% 0%, rgba(17, 164, 76, 0.2), transparent 45%), #eef3fb;
                font-family: "Space Grotesk", "Segoe UI", sans-serif;
                color: #0b1d32;
                padding: 24px;
            }

            .card {
                width: min(440px, 100%);
                background: #fff;
                border-radius: 28px;
                box-shadow: 0 25px 80px rgba(7, 23, 64, 0.12);
                padding: 40px;
                border: 1px solid rgba(0, 84, 170, 0.08);
            }

            .badge {
                display: inline-flex;
                gap: 10px;
                padding: 8px 16px;
                border-radius: 999px;
                background: rgba(0, 84, 170, 0.08);
                color: #0054aa;
                font-size: 0.8rem;
                letter-spacing: 0.14em;
                text-transform: uppercase;
            }

            h1 {
                margin: 18px 0 4px;
                font-size: 2rem;
            }

            p {
                margin: 0 0 24px;
                color: #4c5667;
            }

            label {
                display: block;
                font-weight: 600;
                margin-bottom: 6px;
            }

            input {
                width: 100%;
                border-radius: 16px;
                border: 1px solid #e1e5ee;
                padding: 14px 16px;
                font-size: 1rem;
                font-family: inherit;
                margin-bottom: 16px;
            }

            input:focus {
                outline: none;
                border-color: #0054aa;
                box-shadow: 0 0 0 3px rgba(0, 84, 170, 0.16);
            }

            button {
                width: 100%;
                border: none;
                border-radius: 16px;
                padding: 14px;
                background: linear-gradient(120deg, #003d7a, #0054aa);
                color: #fff;
                font-weight: 700;
                cursor: pointer;
                font-size: 1rem;
                box-shadow: 0 12px 30px rgba(0, 84, 170, 0.35);
            }

            .logo {
                width: 84px;
                margin-bottom: 16px;
            }

            .quick-fill {
                display: flex;
                gap: 12px;
                margin: 0 0 16px;
                flex-wrap: wrap;
            }

            .quick-fill button {
                width: auto;
                background: rgba(17, 164, 76, 0.12);
                color: #0b8c40;
                box-shadow: none;
                padding: 10px 16px;
                border-radius: 999px;
                font-size: 0.9rem;
            }

            .error {
                background: rgba(255, 87, 87, 0.1);
                color: #c73838;
                border-radius: 14px;
                padding: 10px 14px;
                margin-bottom: 16px;
                font-size: 0.95rem;
            }
        </style>
    </head>
    <body>
        <div class="card">
            <img src="{{ asset('images/unida.jpeg') }}" alt="Unida logo" class="logo" />
            <div class="badge">Smart · Secure · Connected</div>
            <h1>Karibu Unida Tech</h1>
            <p>Ingia kutumia akaunti iliyoruhusiwa ili kuendelea kuandaa invoice.</p>

            @if ($errors->any())
                <div class="error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.attempt') }}">
                @csrf
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus />

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required />

                <div class="quick-fill">
                    <button type="button" data-email="info@unida.tech" data-password="Unida@2025">info@unida.tech</button>
                    <button type="button" data-email="ezekielsalehe00@gmail.com" data-password="ESNyarobi@1234">
                        ezekielsalehe00@gmail.com
                    </button>
                </div>

                <button type="submit">Ingia Kwenye Mfumo</button>
            </form>
        </div>

        <script>
            document.querySelectorAll(".quick-fill button").forEach((btn) => {
                btn.addEventListener("click", () => {
                    document.getElementById("email").value = btn.dataset.email;
                    document.getElementById("password").value = btn.dataset.password;
                });
            });
        </script>
    </body>
</html>

