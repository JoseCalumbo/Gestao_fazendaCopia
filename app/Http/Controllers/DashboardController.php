<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Exibe a página principal com a listagem inicial
    public function index()
    {
        return view('dashboard.dashboard');
    }
    
}
