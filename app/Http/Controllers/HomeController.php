<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct()
    {
        // you want authenticated users only? fine.
        $this->middleware('auth');
    }

    /**
     * Main dashboard/home page.
     */
    public function index(): View
    {
        // This is where you put whatever overview your app needs
        // Example: counts, recent items, whatever you plan to show.
        // For now, return the damn view properly.
        return view('home', [
            'user' => auth()->user(),
        ]);
    }
}
