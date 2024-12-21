<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enter URL for Metadata Extraction</title>
</head>
<body>
    <h1>Enter URL</h1>

    <form action="{{ route('fetch.metadata') }}" method="POST">
        @csrf
        <label for="url">URL:</label>
        <!-- <input type="text" name="url" placeholder="masukkan URL yang ingin  dicari -  contoh :https://example.com" required> -->
        <input type="text" name="url" placeholder="masukkan URL yang ingin dicari - contoh :https://example.com" required="required" required style="width: 50%;">
        
        <button type="submit">Fetch Metadata</button>
    </form>
</body>
</html>
