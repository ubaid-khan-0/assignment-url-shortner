
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Company Invitation</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="containter">
    <h1>Invite an Admin to a New Company</h1>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    @if (session('invitation_url'))
        <p>Share this invitation link with the Admin:</p>
        <input
            type="text"
            readonly
            value="{{ session('invitation_url') }}"
            style="width: 500px; max-width: 95%;"
        >
    @endif

    <form method="POST" action="{{ route('superadmin.invitations.store') }}">
        @csrf

        <div>
            <label for="company_name">Company Name</label>
            <input
                id="company_name"
                name="company_name"
                value="{{ old('company_name') }}"
                required
            >
        </div>

        <div>
            <label for="email">Admin Email</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
            >
        </div>

        <button type="submit">Create Company & Invite Admin</button>
    </form>

    <p><a href="{{ route('dashboard') }}">Back to Dashboard</a></p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
