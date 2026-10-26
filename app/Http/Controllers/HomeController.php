<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index(User $user)
    {
        return match (auth()->guard()->user()->role) {
            User::ROLE_ADMIN => redirect()->route('dashboard.admin'),
            User::ROLE_SUPERVISOR => redirect()->route('dashboard.supervisor'),
            User::ROLE_EMPLOYEE => redirect()->route('dashboard.employee'),
            default => abort(403, 'Nieprawidłowa rola użytkownika.'),
        };
    }

    public function admin(): View
    {

        $users = User::query()
            ->select('id', 'name', 'email', 'role', 'created_at')
            ->latest()
            ->paginate(10);

        return $this->dashboard(
            'Panel administratora',
            'Zarządzaj użytkownikami, rolami oraz ewidencją czasu pracy w firmie.',
            'fas fa-user-shield',
            $this->getUserCount(),
            $users
        );
    }

    public function supervisor(): View
    {
        return $this->dashboard(
            'Panel przełożonego',
            'Rejestruj godziny pracy pracowników i kontroluj bieżącą ewidencję.',
            'fas fa-user-clock',
            $this->getUserCount()
        );
    }

    public function employee(): View
    {
        return $this->dashboard(
            'Panel pracownika',
            'Przeglądaj własną historię pracy oraz komentarze do wpisów.',
            'fas fa-id-badge',
            $this->getUserCount()
        );
    }

    private function dashboard(string $title, string $message, string $icon,
        ?int $usercount = null, $users = null): View
    {
        return view('adminLte.dashboard', [
            'dashboardTitle' => $title,
            'dashboardMessage' => $message,
            'dashboardIcon' => $icon,
            'userCount' => $usercount ?? $this->getUserCount(),
            'users' => $users,
            'roleLabel' => match (auth()->guard()->user()->role) {
                User::ROLE_ADMIN => 'Administrator',
                User::ROLE_SUPERVISOR => 'Przełożony',
                default => 'Pracownik',
            },
        ]);
    }

    public function getUserCount(): int
    {
        return User::count();
    }

    public function return1(): int
    {
        return 1;
    }
}
