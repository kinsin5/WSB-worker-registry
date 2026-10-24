<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function create()
    {
        return view('books.create');
        return back()->withInput();
    }

    public function store(Request $request)
    {
        $title = $request->input('title');
        $data = $request->all();
        $datasub = $request->only(['title', 'category']);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'year' => ['nullable', 'integer', 'between:1450,2100'],
            'category' => ['nullable', 'string'],
            'description' => ['nullable', 'string', 'max:2000'],
            'available' => ['nullable', 'boolean'],
            ]);

        DB::insert(
        'INSERT INTO books (title, category, description, published_year)
        VALUES (?, ?, ?, ?)',
        [$validated['title'], $validated['category'], $validated['description'] ?? null, $validated['year'] ?? null]
        );


        $title = $validated['title'];
        $year = $validated['year'];
        //return back()->withInput();
        return redirect()->route('books.index');

    }

    public function index()
    {
        $books = DB::select('SELECT * FROM books ORDER BY id DESC');
        return view('books.index', ['books' => $books]);
    }

    public function home()
    {
        return view('adminLte.dashhboard');
    }
}
