
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Accept Invitation</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="containter">
    <h1>Accept Your Invitation</h1>

    <p>Company: {{ $invitation->company->name }}</p>
    <p>Invited email: {{ $invitation->email }}</p>
    <p>Assigned role: {{ $invitation->role }}</p>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form
        method="POST"
        action="{{ route('invitations.accept.store', ['token' => $invitation->token]) }}"
    >
        @csrf

        <div>
            <label for="name">Full Name</label>
            <input
                id="name"
                name="name"
                value="{{ old('name') }}"
                required
            >
        </div>

        <div>
            <label for="password">Password</label>
            <input
                id="password"
                type="password"
                name="password"
                minlength="8"
                required
            >
        </div>

        <div>
            <label for="password_confirmation">Confirm Password</label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                minlength="8"
                required
            >
        </div>

        <button type="submit">Accept Invitation & Create Account</button>
    </form>
</body>
</html>
