<?php

namespace App\Http\Controllers;

use App\Models\Agricultor;
use App\Models\Cooperativa;
use App\Models\Talhao;
use Illuminate\Http\Request;

class TalhoesController extends Controller
{
    public function index(Request $request)
    {
        // Iniciamos a query base com os relacionamentos
        $query = Talhao::with(['agricultor', 'cooperativa']);

        // 1. Filtro por Designação (ID: searchTalhao)
        if ($request->filled('searchTalhao')) {
            $query->where('designacao', 'like', "%{$request->searchTalhao}%");
        }

        // 2. Filtro por Estado (ID: filterEstado)
        if ($request->filled('filterEstado')) {
            $query->where('estado', $request->filterEstado);
        }

        // 3. Filtro por Agricultor via ID do Select (ID: filterAgricultor)
        if ($request->filled('filterAgricultor')) {
            $query->where('agricultor_id', $request->filterAgricultor);
        }

        // --- CÁLCULO DAS ESTATÍSTICAS FILTRADAS ---
        $statsQuery = clone $query;
        $totalTalhoes = $statsQuery->count();

        $contagemPorEstado = $statsQuery->selectRaw('estado, COUNT(*) as total')
            ->groupBy('estado')
            ->pluck('total', 'estado')
            ->toArray();

        $stats = [
            'total' => $totalTalhoes,
            'em_cultivo' => $contagemPorEstado['Em cultivo'] ?? ($contagemPorEstado['em cultivo'] ?? 0),
            'pousio' => $contagemPorEstado['Pousio'] ?? ($contagemPorEstado['pousio'] ?? 0),
            'colhido' => $contagemPorEstado['Colhido'] ?? ($contagemPorEstado['colhido'] ?? 0),
            'activo' => $contagemPorEstado['activo'] ?? ($contagemPorEstado['Activo'] ?? 0),
        ];

        // --- PAGINAÇÃO ---
        $talhoes = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        // 4. Lista de agricultores para preencher o teu componente <select>
        $agricultores = Agricultor::orderBy('nome_completo', 'asc')->get(['id', 'nome_completo']);

        // Passa todas as variáveis para a tua Blade existente
        return view('talhoes.talhoes', compact('talhoes', 'stats', 'agricultores'));
    }

    // lista todos os talhões de uma cooperativa específica
    public function apiIndex(Request $request, Cooperativa $cooperativa)
    {
        $query = Talhao::with('agricultor')
            ->where('cooperativa_id', $cooperativa->id);
        // filtro por designação
        if ($request->filled('designacao')) {
            $query->where(
                'designacao',
                'like',
                '%'.$request->designacao.'%'
            );
        }
        // filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        return response()->json(
            $query->latest()
                ->paginate(10)
        );
    }

    // mostra os detalhes de um talhão específico de uma cooperativa
    public function show(Cooperativa $cooperativa, $id)
    {
        $talhao = Talhao::with('agricultor')
            ->where('cooperativa_id', $cooperativa->id)
            ->where('id', $id)
            ->firstOrFail();

        return response()->json($talhao);
    }

    public function store(Request $request, Cooperativa $cooperativa)
    {
        $data = $request->validate([
            'designacao' => 'required|string',
            'area' => 'required|numeric',
            'cultura_actual' => 'nullable|string',
            'localizacao' => 'nullable|string',
            'estado' => 'required|string',
            'agricultor_id' => 'required|integer',
        ]);

        $data['cooperativa_id'] = $cooperativa->id;

        $talhao = Talhao::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Talhão criado com sucesso',
            'data' => $talhao,
        ]);
    }

    public function update(Request $request, Cooperativa $cooperativa, $id)
    {
        $talhao = Talhao::where('cooperativa_id', $cooperativa->id)
            ->where('id', $id)
            ->firstOrFail();

        $data = $request->validate([
            'designacao' => 'required|string',
            'area' => 'required|numeric',
            'cultura_actual' => 'nullable|string',
            'localizacao' => 'nullable|string',
            'estado' => 'required|string',
            'agricultor_id' => 'required|integer',
        ]);

        $talhao->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Talhão atualizado com sucesso',
            'data' => $talhao,
        ]);
    }

    public function destroy(Cooperativa $cooperativa, $id)
    {
        $talhao = Talhao::where('cooperativa_id', $cooperativa->id)
            ->where('id', $id)
            ->firstOrFail();

        $talhao->delete();

        return response()->json([
            'success' => true,
            'message' => 'Talhão eliminado com sucesso',
        ]);
    }
}
