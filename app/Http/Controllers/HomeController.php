<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('dashboard.index',['home'=>1]);
    }

    public function handleRoot() {
        return redirect()->route('home');
    }
}
