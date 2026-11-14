<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel Administratora | Edycja Pracownika | {{$user["name"]}}</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    @if (auth()->user()->hasRole(\App\Models\User::ROLE_ADMIN))
                <div class="card">
                    <div class="card-header"><h3 class="card-title">Edytuj użytkownika</h3></div>
                    <form action="{{ route('users.update', $user) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Nazwa użytkownika</label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ old('name', $user->name)}}" required autofocus>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input class="form-control @error('email') is-invalid @enderror" type="email" id="email" name="email" placeholder="{{$user['email']}}"value="{{ old('email', $user->email) }}" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label for="password">Hasło</label>
                                <input class="form-control @error('password') is-invalid @enderror" type="password" id="password" name="password" placeholder="****" value="{{ old('email', $user->password) }}"required>
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group mb-0">
                                <label for="password_confirmation">Powtórz hasło</label>
                                <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" placeholder="****" value="{{ old('email', $user->password) }}"required>
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <input class="form-control @error('role') is-invalid @enderror" type="role" id="role" name="role" value="{{ old('role', $user->role) }}" required>
                                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            </div>
                        </div>
                        <div class="card-footer"><button type="submit" class="btn btn-primary">Edytuj użytkownika</button></div>
                    </form>
                </div>
            @endif
    
</div>

<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
</body>
<footer class="main-footer"><span>Edycja pracownika</span></footer>
</html>
