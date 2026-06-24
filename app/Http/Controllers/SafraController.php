<?php

namespace App\Http\Controllers;

use App\Models\Safra;
use App\Models\Cooperativa;
use Illuminate\Http\Request;

class SafraController extends Controller
{
    public function index($cooperativaId)
    {
        $safras = Safra::where('cooperativa_id', $cooperativaId)
            ->orderByDesc('id')
            ->paginate(10);

        return view('safras.index', compact(
            'safras',
            'cooperativaId'
        ));
    }

    public function store(Request $request, $cooperativaId)
    {
        $request->validate([
            'nome' => 'required|max:255',
            'ano' => 'required|integer',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date',
            'estado' => 'required',
        ]);

        Safra::create([
            'cooperativa_id' => $cooperativaId,
            'nome' => $request->nome,
            'ano' => $request->ano,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
            'estado' => $request->estado,
            'descricao' => $request->descricao,
        ]);

        return back()->with('success', 'Safra registada com sucesso.');
    }

    public function update(Request $request, Safra $safra)
    {
        $request->validate([
            'nome' => 'required|max:255',
            'ano' => 'required|integer',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date',
            'estado' => 'required',
        ]);

        $safra->update($request->all());

        return back()->with('success', 'Safra actualizada com sucesso.');
    }

    public function destroy(Safra $safra)
    {
        $safra->delete();

        return back()->with('success', 'Safra removida com sucesso.');
    }

    // ============================================================================================

    public function painel()
    {
        $cooperativas = Cooperativa::whereIn('estado', ['activa', 'activo'])->count();
        $safras = Safra::with('cooperativa')
            ->paginate(10);

        return view('safras.painel', compact('safras'));
    }
}
