
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - URL Shortener</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }

        .card {
            width: 100%;
            max-width: 380px;
            padding: 28px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 20px #00000012;
        }

        input, button {
            width: 100%;
            box-sizing: border-box;
            padding: 12px;
            margin-top: 8px;
            margin-bottom: 16px;
        }

        button {
            background: #2563eb;
            color: white;
            border: 0;
            border-radius: 5px;
            cursor: pointer;
        }

        .error {
            color: #dc2626;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>URL Shortener</h2>
        <p>Sign in to your account</p>

        @if ($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.store') }}">
            @csrf

            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>

            <label for="password">Password</label>
            <input id="password" type="password" name="password" required >

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
