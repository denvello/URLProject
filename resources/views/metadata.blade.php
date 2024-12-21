<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $metadata['title'] ?? 'No Title Found' }}</title>
</head>
<body>
    <h1>Metadata Information</h1>

    <div>
        <h2>Title: {{ $metadata['title'] ?? 'Title not available' }}</h2>
        <p>Description: {{ $metadata['description'] ?? 'Description not available' }}</p>

        @if(isset($metadata['image']))
            <img src="{{ $metadata['image'] }}" alt="Image" style="max-width: 500px; height: auto;">
        @else
            <p>Image not available</p>
        @endif
    </div>
</body>
</html>
