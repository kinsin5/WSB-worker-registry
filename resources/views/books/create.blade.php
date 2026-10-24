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

    @if($errors->any())
        <div class="error-alert">
            <p>
                Prosze poprawic nastepujece bledy w formularzu:
            </p>
        </div>  
        <div class="alert alert-danger" id="error-messages">
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    <form action="/books" method="POST">
        @csrf
        <div>
            <label for="title">Tytuł:</label>

            <input type="text" id="title" name="title" value="{{ old('title') }}" >
            @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror


        </div>


        <div>
            <label for="year">Rok:</label>
            <input type="text" id="year" name="year" value="{{ old('year')}}">
            @error('year')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>


        <div>
            <label for="category">Kategoria:</label>
                <select name="category" for="category" id="category">
                    <option> Sci-Fi / Fantasy</option>
                    <option> Literatura piękna</option>
                    <option> Biografie</option>
                    <option> Naukowe</option>
                </select>
            </label>
        </div>

        <div>
            <label for="description">Opis Ksiazki:</label>
            <textarea name="description" id="description" for="description"> </textarea>
        </div>
        
        <div>
            <label for="available">
                <input type="checkbox" id="available" name="available" value="1" checked>
                Dostępna w bibliotece
            </label>
        </div>

        <div>
            <button type="submit">Zapisz</button>
        </div>
    </form>
</body>
</html>