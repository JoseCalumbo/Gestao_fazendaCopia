<?php

namespace App\Http\Controllers;

use App\Models\Agricultor;
use App\Models\CooperativaMembro;
use Illuminate\Http\Request;

class CooperativaMembroController extends Controller
{
    public function index(Request $request)
    {
        $query = Agricultor::query();

        if ($request->filled('nome')) {
            $query->where('nome_completo', 'like', '%'.$request->nome.'%');
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $agricultores = $query
            ->withCount('talhoes')
            ->paginate(10);

        return response()->json($agricultores);
    }

    // Listar todos os membros da cooperativa
    public function indexJson($cooperativaId)
    {
        $membros = CooperativaMembro::with(['agricultor'])
            ->where('cooperativa_id', $cooperativaId)
            ->get()
            ->map(function ($membro) {
                return [
                    'id' => $membro->id,
                    'agricultor_id' => $membro->agricultor_id,
                    'nome' => $membro->agricultor ? $membro->agricultor->nome_completo : 'Removido',
                    'telefone' => $membro->agricultor ? $membro->agricultor->telefone_principal : 'N/A',
                    'cargo' => $membro->cargo ?? 'Membro',
                    'activo' => $membro->activo,
                ];
            });

        // Procurar também agricultores que NÃO pertencem a esta cooperativa para preencher o select de associação
        $agricultoresDisponiveis = Agricultor::whereNotIn('id', function ($query) use ($cooperativaId) {
            $query->select('agricultor_id')
                ->from('cooperativa_membros')
                ->where('cooperativa_id', $cooperativaId)
                ->where('activo', true);
        })->get(['id', 'nome_completo']);

        return response()->json([
            'success' => true,
            'membros' => $membros,
            'disponiveis' => $agricultoresDisponiveis,
        ]);
    }

    public function membrosJson(Request $request, $cooperativa)
    {
        $query = CooperativaMembro::with('agricultor')
            ->where('cooperativa_id', $cooperativa);

        // filtro por nome
        if ($request->filled('nome')) {
            $query->whereHas('agricultor', function ($q) use ($request) {
                $q->where(
                    'nome_completo',
                    'like',
                    '%'.$request->nome.'%'
                );
            });
        }

        // filtro por estado
        if ($request->filled('estado')) {

            if ($request->estado === 'Activo') {
                $query->where('activo', true);
            }

            if ($request->estado === 'Inactivo') {
                $query->where('activo', false);
            }
        }

        $membros = $query
            ->latest()
            ->paginate(5)
            ->through(function ($membro) {

                return [
                    'id' => $membro->id,
                    'agricultor_id' => $membro->agricultor_id,
                    'nome' => $membro->agricultor->nome_completo ?? '',
                    'contacto' => $membro->agricultor->telefone_principal ?? '',
                    'bi' => $membro->agricultor->bilhete ?? '',
                    // 'foto_url' => $membro->agricultor && $membro->agricultor->foto
                    //  ? asset('storage/agricultores/'.basename($membro->agricultor->foto))
                    //  : asset('public/uploads/user-default.png'),
                    'foto_url' => $membro->agricultor?->foto_url,
                    'cargo' => $membro->cargo ?? 'Nenhum',
                    'estado' => $membro->activo
                        ? 'Activo'
                        : 'Inactivo',

                    'created_at' => $membro->created_at,

                    'talhoes_count' => $membro->agricultor
                        ? $membro->agricultor->talhoes()->count()
                        : 0,
                ];
            });

        return response()->json($membros);
    }

    // Associar um novo membro
    public function store(Request $request, $cooperativaId)
    {
        $request->validate([
            'agricultor_id' => 'required|exists:agricultores,id',
            'cargo' => 'required|string|max:100',
        ]);

        // Verificar se o vínculo já existe (mesmo que inativo)
        $membroExistente = CooperativaMembro::where('cooperativa_id', $cooperativaId)
            ->where('agricultor_id', $request->agricultor_id)
            ->first();

        if ($membroExistente) {
            if ($membroExistente->activo) {
                return response()->json(['success' => false, 'message' => 'Este agricultor já é um membro ativo desta cooperativa.'], 422);
            }
            // Se existia inativo, reativa e atualiza o cargo
            $membroExistente->update([
                'cargo' => $request->cargo,
                'activo' => true,
            ]);

            return response()->json(['success' => true, 'message' => 'Membro reativado com sucesso!']);
        }

        // Criar novo vínculo
        CooperativaMembro::create([
            'cooperativa_id' => $cooperativaId,
            'agricultor_id' => $request->agricultor_id,
            'cargo' => $request->cargo,
            'activo' => true,
        ]);

        return response()->json(['success' => true, 'message' => 'Membro associado com sucesso!']);
    }

    // Alternar Estado (Ativar/Desativar)
    public function toggleStatus($cooperativaId, $id)
    {
        $membro = CooperativaMembro::where('cooperativa_id', $cooperativaId)->findOrFail($id);
        $membro->activo = ! $membro->activo;
        $membro->save();

        return response()->json(['success' => true, 'message' => 'Estado do membro alterado com sucesso!']);
    }

    // Remover Vínculo Permanentemente
    public function destroy($cooperativaId, $id)
    {
        $membro = CooperativaMembro::where('cooperativa_id', $cooperativaId)->findOrFail($id);
        $membro->delete();

        return response()->json(['success' => true, 'message' => 'Vínculo removido com sucesso!']);
    }
}
