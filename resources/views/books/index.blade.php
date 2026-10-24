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
        Lista książek
    </h1>
    <p>
        This is the form received page of the website.
    </p>

    @foreach ($books as $book)
        <p>{{ $book->title }} — {{ $book->published_year }}</p>
    @endforeach
    @if (count($books) === 0)
  
    
    endif

</body>
</html>