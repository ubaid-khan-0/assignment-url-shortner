
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Short URL</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="containter">
    <h1>Create Short URL</h1>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('short-urls.store') }}">
        @csrf

        <div>
            <label for="original_url">Original URL</label>
            <input
                id="original_url"
                type="url"
                name="original_url"
                value="{{ old('original_url') }}"
                placeholder="https://example.com/page"
                required
                style="width: 400px; max-width: 95%;"
            >
        </div>

        <button type="submit">Create Short URL</button>
    </form>

    <p><a href="{{ route('short-urls.index') }}">Back to Short URLs</a></p>
</body>
</html>
