<?php

namespace App\Http\Controllers;

use App\Models\User;
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
     * @return \Illuminate\Contracts\Support\Renderable
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
        return $this->dashboard(
            'Panel administratora',
            'Zarządzaj użytkownikami, rolami oraz ewidencją czasu pracy w firmie.',
            'fas fa-user-shield',
        );
    }

    public function supervisor(): View
    {
        return $this->dashboard(
            'Panel przełożonego',
            'Rejestruj godziny pracy pracowników i kontroluj bieżącą ewidencję.',
            'fas fa-user-clock',
        );
    }

    public function employee(): View
    {
        return $this->dashboard(
            'Panel pracownika',
            'Przeglądaj własną historię pracy oraz komentarze do wpisów.',
            'fas fa-id-badge',
        );
    }

    private function dashboard(string $title, string $message, string $icon): View
    {
        return view('adminLte.dashboard', [
            'dashboardTitle' => $title,
            'dashboardMessage' => $message,
            'dashboardIcon' => $icon,
            'roleLabel' => match (auth()->guard()->user()->role) {
                User::ROLE_ADMIN => 'Administrator',
                User::ROLE_SUPERVISOR => 'Przełożony',
                default => 'Pracownik',
            },
        ]);
    }
}





