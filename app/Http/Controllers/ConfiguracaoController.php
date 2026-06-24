<?php

namespace App\Http\Controllers;

use App\Models\AnoAgricola;
use App\Models\User;
use Illuminate\Http\Request;

class ConfiguracaoController extends Controller
{
    // mark: Configurações
    public function index()
    {
        $query = User::query();

        $users = User::orderBy('name')->get();

        $anos = AnoAgricola::orderBy('data_inicio', 'desc')->get();

        return view(
            'configuracoes.configuracoes',
            compact('users', 'anos')
        );
    }

    public function store(Request $request)
    {
        dd($request->all());
    }
}
