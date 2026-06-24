<?php

namespace App\Http\Controllers;

use App\Models\AnoAgricola;
use Illuminate\Http\Request;

class AnoAgricolaController extends Controller
{
    public function index()
    {
        $anos = AnoAgricola::orderBy('data_inicio', 'desc')
            ->paginate(10);

        return view(
            'configuracoes',
            compact('anos')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|max:100',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after:data_inicio',
            'estado' => 'required',
        ]);

        // apenas um em produção
        if ($request->estado == 'em_producao') {

            AnoAgricola::where(
                'estado',
                'em_producao'
            )->update([
                'estado' => 'finalizado',
            ]);
        }

        $ano = AnoAgricola::create([
            'nome' => $request->nome,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
            'estado' => $request->estado,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Ano agrícola criado com sucesso.',
            'data' => $ano,
        ]);
    }

    public function show($id)
    {
        $ano = AnoAgricola::findOrFail($id);

        return response()->json($ano);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|max:100',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after:data_inicio',
            'estado' => 'required',
        ]);

        $ano = AnoAgricola::findOrFail($id);

        if ($request->estado == 'em_producao') {

            AnoAgricola::where(
                'id',
                '!=',
                $id
            )
                ->where(
                    'estado',
                    'em_producao'
                )
                ->update([
                    'estado' => 'finalizado',
                ]);
        }

        $ano->update([
            'nome' => $request->nome,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
            'estado' => $request->estado,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Ano agrícola actualizado.',
            'data' => $ano 
        ]);
    }

    public function destroy($id)
    {
    $ano = AnoAgricola::findOrFail($id);

    $ano->delete();

    return response()->json([
        'success' => true,
        'message' => 'Ano agrícola removido.',
         'data' => $ano // ← ADICIONA ISTO
    ]);
    }
}
