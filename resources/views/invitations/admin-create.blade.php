
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invite Company User</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="containter">
    <h1>Invite a User to Your Company</h1>

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
        <p>Share this invitation link:</p>
        <input
            type="text"
            readonly
            value="{{ session('invitation_url') }}"
            style="width: 500px; max-width: 95%;"
        >
    @endif

    <form method="POST" action="{{ route('admin.invitations.store') }}">
        @csrf

        <div>
            <label for="email">User Email</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
            >
        </div>

        <div>
            <label for="role">Role</label>
            <select id="role" name="role" required>
                <option value="Member">Member</option>
                <option value="Admin">Admin</option>
            </select>
        </div>

        <button type="submit">Generate Invitation</button>
    </form>

    <p><a href="{{ route('dashboard') }}">Back to Dashboard</a></p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
