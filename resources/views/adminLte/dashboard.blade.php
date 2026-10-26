<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $dashboardTitle }} | Rejestr pracowników XYZ</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button" aria-label="Pokaż menu">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('home') }}" class="nav-link">Panel główny</a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item d-flex align-items-center mr-2">
                <span class="nav-link">{{ auth()->user()->name }}</span>
            </li>
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-link nav-link">Wyloguj się</button>
                </form>
            </li>
        </ul>
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="{{ route('home') }}" class="brand-link">
            <i class="fas fa-users-cog brand-image img-circle elevation-3 text-center pt-2"></i>
            <span class="brand-text font-weight-light">Rejestr pracowników</span>
        </a>

        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image"><i class="fas fa-user-circle fa-2x text-muted"></i></div>
                <div class="info">
                    <span class="d-block text-white">{{ auth()->user()->name }}</span>
                    <small class="text-muted">{{ $roleLabel }}</small>
                </div>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link active">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <main class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"><h1 class="m-0">{{ $dashboardTitle }}</h1></div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Panel główny</a></li>
                            <li class="breadcrumb-item active">{{ $roleLabel }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="alert alert-info">
                    <i class="{{ $dashboardIcon }} mr-2"></i>{{ $dashboardMessage }}
                </div>

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $userCount }}</h3>
                                <p>Liczba użytkowników</p>
                            </div>
                            <div class="icon"><i class="fas fa-users"></i></div>
                        </div>
                    </div>
                </div>

                @if ($users !== null)
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-users mr-2"></i>Użytkownicy</h3>
                            <div class="card-tools">Łącznie: {{ $users->total() }}</div>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Nazwa</th>
                                            <th>E-mail</th>
                                            <th>Rola</th>
                                            <th>Data utworzenia</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($users as $user)
                                            <tr>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td><span class="badge badge-secondary">{{ $user->role }}</span></td>
                                                <td>{{ $user->created_at?->format('d.m.Y H:i') ?? '—' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-4">Brak użytkowników.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @if ($users->hasPages())
                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <span class="text-muted">
                                    Wyświetlono {{ $users->firstItem() }}–{{ $users->lastItem() }} z {{ $users->total() }}
                                </span>
                                <div class="btn-group">
                                    @if ($users->onFirstPage())
                                        <span class="btn btn-outline-secondary disabled">Poprzednia</span>
                                    @else
                                        <a class="btn btn-outline-secondary" href="{{ $users->previousPageUrl() }}">Poprzednia</a>
                                    @endif

                                    @if ($users->hasMorePages())
                                        <a class="btn btn-outline-secondary" href="{{ $users->nextPageUrl() }}">Następna</a>
                                    @else
                                        <span class="btn btn-outline-secondary disabled">Następna</span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            @if (auth()->user()->hasRole(\App\Models\User::ROLE_ADMIN))
                <div class="card">
                    <div class="card-header"><h3 class="card-title">Dodaj użytkownika</h3></div>
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Nazwa użytkownika</label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input class="form-control @error('email') is-invalid @enderror" type="email" id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label for="password">Hasło</label>
                                <input class="form-control @error('password') is-invalid @enderror" type="password" id="password" name="password" required>
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group mb-0">
                                <label for="password_confirmation">Powtórz hasło</label>
                                <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>
                        <div class="card-footer"><button type="submit" class="btn btn-primary">Utwórz użytkownika</button></div>
                    </form>
                </div>
            @endif
        </section>
    </main>

    <footer class="main-footer"><span>Rejestr pracowników</span></footer>
</div>

<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
</body>
</html>
