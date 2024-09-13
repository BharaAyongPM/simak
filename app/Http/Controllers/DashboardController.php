<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }
    public function form()
    {
        return view('dashboard.form');
    }
    public function kalender()
    {
        return view('dashboard.kalender');
    }
}
