<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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

        $role = auth()->user()->role;
        switch ($role) {
            case 'admin':
                return view('adminLte.dashboard');
                break;
            case 'employee':
                return view('employee_dashboard');
                break;
            case 'supervisor':
                return view('supervisor_dashboard');
                break;
            default:
                echo "Nieznany typ użytkownika";
                return view('home');
        }
        return view('home');
    }
}
