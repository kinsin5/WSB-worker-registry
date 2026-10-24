<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
</head>
<body>
    <h1>
        Form Page
    </h1>
    <p>
        This is the form page of the website.
    </p>

    <form action= {{ route('books.store')}} method="POST">
        @csrf
        <label for="title">Tytuł:</label>
        <input type="text" id="title" name="title">
        <label for="year">Rok:</label>
        <input type="text" id="year" name="year">
        <button type="submit">Zapisz</button>
    </form>
</body>
</html>