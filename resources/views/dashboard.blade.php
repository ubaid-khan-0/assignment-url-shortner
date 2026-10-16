
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - URL Shortener</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="containter">
    <h1>URL Shortener Dashboard</h1>

    <p>
        Welcome, {{ auth()->user()->name }}!
    </p>

    <p>
        Your role: {{ auth()->user()->role }}
    </p>
    @if (auth()->user()->role === 'SuperAdmin')
    <p>
        <a href="{{ route('superadmin.invitations.create') }}">
            Create Company & Invite Admin
        </a>
    </p>
    @elseif (auth()->user()->role === 'Admin')
        <p>
            <a href="{{ route('admin.invitations.create') }}">
                Invite Company User
            </a>
        </p>
    @endif
    @if (in_array(auth()->user()->role, ['SuperAdmin', 'Admin', 'Member'], true))
    <p>
        <a href="{{ route('short-urls.index') }}">View Short URLs</a>
    </p>
@endif

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
