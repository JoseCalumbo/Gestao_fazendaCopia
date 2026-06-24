<?php

namespace App\Http\Controllers;

use App\Models\Agricultor;
use App\Models\Cooperativa;
use App\Models\CooperativaMembro;
use App\Models\Talhao;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CooperativaController extends Controller
{
    public function index(Request $request)
    {
        // 1. Contagens de apoio e estatísticas para os cartões (Fixas)
        $totalPendentes = Cooperativa::whereIn('estado', ['pendente', 'Pendente', 'PENDENTE'])->count();
        $totalInactivas = Cooperativa::whereIn('estado', ['inactiva', 'Inactivo', 'INACTIVA'])->count();
        $totalMembrosInativos = CooperativaMembro::where('activo', false)->count();

        $totalCooperativasActivas = Cooperativa::whereIn('estado', ['activa', 'activo'])->count();
        $totalCooperativas = Cooperativa::count();
        $totalGeralAssociados = CooperativaMembro::distinct('agricultor_id')->count('agricultor_id');

        // Agricultores sem cooperativa ativos ou pendentes
        $agricultoresLivres = Agricultor::whereIn('estado', ['activo', 'pendente'])
            ->whereDoesntHave('associacoes', function ($query) {
                $query->where('activo', true);
            })->orderBy('nome_completo', 'asc')->get();

        // ==========================================
        // 2. CONSTRUÇÃO DA QUERY COM OS FILTROS
        // ==========================================
        $query = Cooperativa::query();

        // Adiciona a contagem de membros ativos
        $query->withCount(['membros as membros_activos_count' => function ($q) {
            $q->where('activo', 1);
        }]);

        // Filtro por Nome
        if ($request->filled('nome')) {
            $query->where('nome', 'LIKE', '%'.$request->input('nome').'%');
        }

        // Filtro por Estado
        if ($request->filled('estado')) {
            $estado = $request->input('estado');
            if ($estado === 'activa') {
                $query->whereIn('estado', ['activa', 'Activo', 'ACTIVO', 'activo']);
            } elseif ($estado === 'pendente') {
                $query->whereIn('estado', ['pendente', 'Pendente']);
            } elseif ($estado === 'inactiva') {
                $query->whereIn('estado', ['inactiva', 'Inactivo']);
            } else {
                $query->where('estado', $estado);
            }
        }

        // Filtro por Província
        if ($request->filled('provincia')) {
            $query->where('provincia', $request->input('provincia'));
        }

        // Ordena por nome (ou por criados recentemente se preferires) e pagina mantendo os filtros na URL
        $cooperativas = $query->orderBy('nome', 'asc')
            ->paginate(5) // Podes mudar para 3 ou 10 registros por página
            ->appends($request->all());

        // Retorna tudo certinho para o Blade
        return view('cooperativas.cooperativas', compact(
            'cooperativas',
            'totalInactivas',
            'totalPendentes',
            'totalCooperativas',
            'totalGeralAssociados',
            'agricultoresLivres'
        ));
    }

    // pega os dados da cooperativa
    public function edit($id)
    {
        // Aqui filtramos para trazer apenas membros onde activo = 1
        $cooperativa = Cooperativa::with(['membros' => function ($query) {
            $query->where('activo', 1); // Garante que só vem membros ativos
        }, 'membros.agricultor'])->find($id);

        if (! $cooperativa) {
            return response()->json([
                'success' => false,
                'message' => 'Cooperativa não encontrada.',
            ], 404);
        }

        $dataFundacao = $cooperativa->data_fundacao
            ? $cooperativa->data_fundacao->format('Y-m-d')
            : '';

        return response()->json([
            'success' => true,
            'cooperativa' => [
                'id' => $cooperativa->id,
                'nome' => $cooperativa->nome,
                'nif' => $cooperativa->nif,
                'data_fundacao' => $dataFundacao,
                'numero_socios' => $cooperativa->numero_socios,
                'estado' => $cooperativa->estado,
                'descricao' => $cooperativa->descricao,
                'provincia' => $cooperativa->provincia,
                'municipio' => $cooperativa->municipio,
                'comuna' => $cooperativa->comuna,
                'endereco' => $cooperativa->endereco,
                'telefone' => $cooperativa->telefone,
                'email' => $cooperativa->email,
                'website' => $cooperativa->website,
                'area_total_cultivada' => $cooperativa->area_total_cultivada,
                'principal_cultura' => $cooperativa->principal_cultura,
                'numero_talhoes' => $cooperativa->numero_talhoes,
                'producao_estimada' => $cooperativa->producao_estimada,
                'foto' => $cooperativa->foto,

                'membros' => $cooperativa->membros->map(function ($membro) {
                    return [
                        'id' => $membro->agricultor_id,
                        // 'id' => $membro->id,
                        'agricultor_id' => $membro->agricultor_id,
                        'nome' => $membro->agricultor?->nome_completo,
                        'bilhete' => $membro->agricultor?->bilhete,
                        'tel' => $membro->agricultor?->telefone_principal,
                        'cargo' => $membro->cargo,
                        'data_inicio' => $membro->data_inicio,
                        'data_fim' => $membro->data_fim,
                    ];
                })->values(),
            ],
        ]);
    }

    // salva a cooperativa
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'nif' => 'required|string|max:50|unique:cooperativas,nif',
            'provincia' => 'required|string|max:255',
            'municipio' => 'required|string|max:255',
            'estado' => 'required|in:activa,inactiva,Activo,Inactivo,ACTIVO,INACTIVA,activo',
            'foto' => 'nullable|image|max:2048',
            'agricultores' => 'nullable|array',
            'cargos' => 'nullable|array',
        ]);

        try {
            DB::beginTransaction();

            // Upload da foto se existir
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('cooperativas', 'public');
            }

            // Preparar dados básicos
            $dados = $request->except(['foto', 'agricultores', 'cargos']);
            $dados['foto'] = $fotoPath;

            $cooperativa = Cooperativa::create($dados);

            // Vincular agricultores iniciais
            if ($request->filled('agricultores') && is_array($request->input('agricultores'))) {
                $agricultoresIds = $request->input('agricultores');
                $cargos = $request->input('cargos', []);

                foreach ($agricultoresIds as $index => $agricultorId) {
                    $cargoDefinido = isset($cargos[$index]) ? $cargos[$index] : 'agricultor';

                    CooperativaMembro::create([
                        'cooperativa_id' => $cooperativa->id,
                        'agricultor_id' => $agricultorId,
                        'cargo' => $cargoDefinido,
                        'activo' => 1,
                    ]);
                }
            }
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Cooperativa registada com sucesso!',
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            if ($fotoPath) {
                Storage::disk('public')->delete($fotoPath);
            }

            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // alterar
    public function update(Request $request, $id)
    {
        $cooperativa = Cooperativa::find($id);

        if (! $cooperativa) {
            return response()->json([
                'success' => false,
                'message' => 'Cooperativa não encontrada.',
            ], 404);
        }

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'nif' => 'required|string|max:50|unique:cooperativas,nif,'.$id,
            'data_fundacao' => 'nullable|date',
            'descricao' => 'nullable|string',
            'telefone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|string|max:255',
            'provincia' => 'required|string|max:255',
            'municipio' => 'required|string|max:255',
            'comuna' => 'nullable|string|max:255',
            'endereco' => 'nullable|string|max:255',
            'numero_socios' => 'nullable|integer|min:0',
            'principal_cultura' => 'nullable|string|max:255',
            'numero_talhoes' => 'nullable|integer|min:0',
            'producao_estimada' => 'nullable|numeric|min:0',
            'area_total_cultivada' => 'nullable|numeric|min:0',
            'safra' => 'nullable|string|max:100',
            'inicio_safra' => 'nullable|date',
            'fim_previsto_safra' => 'nullable|date',
            'estado' => 'required|in:activa,inactiva,Activo,Inactivo,pendente,Pendente,activo',
            'foto' => 'nullable|image|max:2048',
            'agricultores' => 'nullable|array',
            'cargos' => 'nullable|array',
        ]);

        try {
            DB::beginTransaction();

            // Preparar dados limpos isolados para evitar erros de sintaxe no update
            $dados = $request->except(['agricultores', 'cargos', 'foto']);

            // Gerir substituição de fotos
            if ($request->hasFile('foto')) {
                if ($cooperativa->foto) {
                    Storage::disk('public')->delete($cooperativa->foto);
                }
                $dados['foto'] = $request->file('foto')->store('cooperativas', 'public');
            }

            // Atualização dos dados da cooperativa
            $cooperativa->update($dados);

            // 1. Desativa sempre todos os atuais (histórico preservado)
            CooperativaMembro::where('cooperativa_id', $cooperativa->id)
                ->update(['activo' => 0]);

            // 2. Captura os arrays enviados pelo formulário
            $agricultoresIds = $request->input('agricultores', []);
            $cargos = $request->input('cargos', []);

            // 3. Se houver elementos no array, processa e reativa/cria os registros
            if (! empty($agricultoresIds) && is_array($agricultoresIds)) {
                foreach ($agricultoresIds as $index => $agricultorId) {
                    $cargoDefinido = isset($cargos[$index]) ? $cargos[$index] : 'Nenhum';

                    // Se o agricultor já existiu nesta cooperativa, reativa-se. Senão, cria-se.
                    $membroExistente = CooperativaMembro::where('cooperativa_id', $cooperativa->id)
                        ->where('agricultor_id', $agricultorId)
                        ->first();

                    if ($membroExistente) {
                        $membroExistente->update([
                            'cargo' => $cargoDefinido,
                            'activo' => 1,
                        ]);
                    } else {
                        CooperativaMembro::create([
                            'cooperativa_id' => $cooperativa->id,
                            'agricultor_id' => $agricultorId,
                            'cargo' => $cargoDefinido,
                            'activo' => 1,
                        ]);
                    }
                }
            }
            // -----------------------------------------------------

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Cooperativa actualizada com sucesso.',
                'cooperativa' => $cooperativa->refresh(),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // Remove a cooperativa, as suas relações e limpa o ficheiro de imagem.
    public function destroy($id)
    {
        $cooperativa = Cooperativa::find($id);

        if (! $cooperativa) {
            return response()->json([
                'success' => false,
                'message' => 'Cooperativa não encontrada.',
            ], 404);
        }

        try {
            DB::beginTransaction();

            // Guardamos o caminho da foto antes de eliminar o registo
            $fotoPath = $cooperativa->foto;

            // o Laravel/MySQL vai limpar as relações de membros automaticamente aqui.
            $cooperativa->delete();

            // Se a remoção no banco correu bem, eliminamos o ficheiro físico do Storage
            if ($fotoPath) {
                Storage::disk('public')->delete($fotoPath);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Cooperativa e as suas associações foram eliminadas com sucesso.',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Erro ao eliminar a cooperativa: '.$e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        // $cooperativa = Cooperativa::with('agricultores')->findOrFail($id);
        $cooperativa = Cooperativa::find($id);
        $totalTalhoes = Talhao::where('cooperativa_id', $cooperativa->id)->count();

        // Dados agregados
        // $totalColheitas = Colheita::whereIn('agricultor_id', $cooperativa->agricultores->pluck('id'))->count();
        // $totalInsumos = Insumo::whereIn('agricultor_id', $cooperativa->agricultores->pluck('id'))->count();
        // ... etc

        return view('cooperativas.cooperativa_show', compact(
            'cooperativa',
            'totalTalhoes',
            // 'agricultores',
            // 'colheitas',
            // 'insumos',
            // 'produtos',
            // 'talhoes',
            // 'receitas',
            // 'contasReceber',
            // 'contasPagar',
            // 'totalColheitas',
            // 'totalInsumos',
            // 'totalProdutos',
            // 'totalTalhoes',
            // 'totalReceitas',
            // 'totalContasReceber',
            // 'totalContasPagar'
        ));
    }

    // Busca os agricultores associados a uma cooperativa específica
    public function agricultoresAssociados(Cooperativa $cooperativa)
    {
        $agricultores = $cooperativa->agricultores()
            ->select(
                'agricultores.id',
                'agricultores.nome_completo',
                'agricultores.telefone_principal',
                'agricultores.estado'
            )
            ->orderBy('nome_completo')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $agricultores,
        ]);
    }

    // Busca os agricultores que não estão associados a uma cooperativa específica
    public function agricultoresDisponiveis($cooperativa)
    {
        // IDs dos agricultores já associados a esta cooperativa
        $associadosIds = CooperativaMembro::where('cooperativa_id', $cooperativa)
            ->pluck('agricultor_id');

        // Buscar agricultores que NÃO estão associados
        $agricultores = Agricultor::whereNotIn('id', $associadosIds)
            ->orderBy('nome_completo')
            ->get()
            ->map(function ($a) {
                return [
                    'id' => $a->id,
                    'nome_completo' => $a->nome_completo,
                    'telefone' => $a->telefone_principal,
                    'bi' => $a->bilhete,
                    'estado' => $a->estado,
                    'foto_url' => $a->foto_url,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $agricultores,
        ]);
    }

    // Busca os agricultores SEM cooperativa (não associados a nenhuma cooperativa)
    public function agricultoresSemCooperativa($cooperativa)
{
    // TODOS os agricultores que estão em qualquer cooperativa
    $idsAssociados = CooperativaMembro::pluck('agricultor_id')
        ->unique();

    // Apenas os que NÃO estão em nenhuma cooperativa
    $agricultores = Agricultor::whereNotIn('id', $idsAssociados)
        ->orderBy('nome_completo')
        ->get()
        ->map(function ($a) {
            return [
                'id' => $a->id,
                'nome_completo' => $a->nome_completo,
                'telefone' => $a->telefone_principal,
                'bi' => $a->bilhete,
                'estado' => $a->estado,
                'foto_url' => $a->foto_url,
            ];
        });

    return response()->json([
        'success' => true,
        'data' => $agricultores
    ]);
}

    // Busca os agricultores associados a uma cooperativa específica que estão activos
    public function agricultoresActivos(Cooperativa $cooperativa)
    {
        $agricultores = $cooperativa->agricultores()
            ->wherePivot('activo', true)
            ->select(
                'agricultores.id',
                'agricultores.nome_completo',
                'agricultores.telefone_principal',
                'agricultores.estado'
            )
            ->orderBy('agricultores.nome_completo')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $agricultores,
        ]);
    }

    public function estatisticas(Cooperativa $cooperativa)
    {
        $totalTalhoes = $cooperativa->talhoes()->count();

        $totalArea = $cooperativa->talhoes()->sum('area');

        $totalAgricultores = $cooperativa->membrosAtivos()->count();

        return response()->json([
            'success' => true,
            'data' => [
                'total_talhoes' => $totalTalhoes,
                'total_agricultores' => $totalAgricultores,
                'area_total' => number_format($totalArea, 2),
            ],
        ]);
    }

    public function exportarPdf(Request $request)
    {
        // 1. Construção da Query com os mesmos filtros dinâmicos
        $query = Cooperativa::query();

        $query->withCount(['membros as membros_activos_count' => function ($q) {
            $q->where('activo', 1);
        }]);

        if ($request->filled('nome')) {
            $query->where('nome', 'LIKE', '%'.$request->input('nome').'%');
        }

        if ($request->filled('estado')) {
            $estado = $request->input('estado');
            if ($estado === 'activa') {
                $query->whereIn('estado', ['activa', 'Activo', 'ACTIVO', 'activo']);
            } elseif ($estado === 'pendente') {
                $query->whereIn('estado', ['pendente', 'Pendente', 'PENDENTE']);
            } elseif ($estado === 'inactiva') {
                $query->whereIn('estado', ['inactiva', 'Inactivo', 'INACTIVA']);
            } else {
                $query->where('estado', $estado);
            }
        }

        if ($request->filled('provincia')) {
            $query->where('provincia', $request->input('provincia'));
        }

        // Trazemos TODOS os registos filtrados (sem paginação para o relatório)
        $cooperativas = $query->orderBy('nome', 'asc')->get();

        // 2. Carregar a View do PDF e passar os dados
        $pdf = Pdf::loadView('cooperativas.pdf', compact('cooperativas'));

        // (Opcional) Configurar folha A4 em modo Paisagem se a tabela for muito larga
        $pdf->setPaper('a4', 'landscape');

        // 3. Fazer o download automático do ficheiro
        return $pdf->download('relatorio-cooperativas.pdf');
    }
}
