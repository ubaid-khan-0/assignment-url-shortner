
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Short URLs</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="containter">
    <h1>Short URLs</h1>

    <p>Logged in as: {{ auth()->user()->name }}
        ({{ auth()->user()->role }})
    </p>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if (session('created_url'))
        <p>
            New short URL:
            <a href="{{ session('created_url') }}" target="_blank">
                {{ session('created_url') }}
            </a>
        </p>
    @endif

    @if (in_array(auth()->user()->role, ['Admin', 'Member'], true))
        <p><a href="{{ route('short-urls.create') }}">Create Short URL</a></p>
    @endif

    @if ($shortUrls->isEmpty())
        <p>No short URLs found.</p>
    @else
        <table border="1" cellpadding="8">
            <thead>
                <tr>
                    <th>Short URL</th>
                    <th>Original URL</th>
                    <th>Company</th>
                    <th>Created By</th>
                    <th>Clicks</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($shortUrls as $shortUrl)
                    <tr>
                        <td>
                            <a href="{{ route('short-urls.redirect', ['shortCode' => $shortUrl->short_code]) }}"
                               target="_blank">
                                {{ $shortUrl->short_code }}
                            </a>
                        </td>
                        <td>{{ $shortUrl->original_url }}</td>
                        <td>{{ $shortUrl->company->name }}</td>
                        <td>{{ $shortUrl->user->name }}</td>
                        <td>{{ $shortUrl->clicks }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $shortUrls->links() }}
    @endif

    <p><a href="{{ route('dashboard') }}">Back to Dashboard</a></p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
