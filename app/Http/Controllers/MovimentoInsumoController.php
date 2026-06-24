<?php

namespace App\Http\Controllers;

use App\Models\Agricultor;
use App\Models\Cooperativa;
use App\Models\CooperativaMembro;
use App\Models\Insumo;
use App\Models\MovimentoInsumo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovimentoInsumoController extends Controller
{
    public function index($cooperativaId)
    {
        // 1. Busca os insumos da cooperativa atual
        $insumos = Insumo::where('cooperativa_id', $cooperativaId)->get();

        // 2. Busca as saídas gravadas na base de dados (utilizando 'saída' em minúsculas)
        $saidas = MovimentoInsumo::where('cooperativa_id', $cooperativaId)
            ->where('tipo', 'saída')
            ->with(['insumo', 'agricultor'])
            ->get()
            ->map(function ($mov) {
                return [
                    'id' => $mov->id,
                    'insumo_id' => $mov->insumo_id,
                    'insumo_nome' => $mov->insumo ? $mov->insumo->nome : 'Insumo Eliminado',
                    'agricultor_nome' => $mov->agricultor ? $mov->agricultor->nome_completo : 'Não Associado',
                    'tipo' => $mov->insumo ? $mov->insumo->tipo : 'N/D',
                    'quantidade' => $mov->quantidade,
                    'modalidade' => $mov->modalidade,
                    'estado' => $mov->estado,
                    'data' => $mov->created_at ? $mov->created_at->format('Y-m-d') : '',
                ];
            });

        // 3. Renderiza a view passando os dados iniciais carregados do banco
        return view('insumos', compact('insumos', 'saidas', 'cooperativaId'));
    }

    public function getAgricultores($cooperativaId)
    {
        $membros = CooperativaMembro::where('cooperativa_id', $cooperativaId)
            ->where('activo', true) // Garante que traz apenas membros ativos da cooperativa
            ->with(['agricultor' => function ($query) {
                $query->select('id', 'nome_completo')->orderBy('nome_completo', 'asc');
            }])
            ->get();

        $agricultores = $membros->map(function ($membro) {
            if ($membro->agricultor) {
                return [
                    'id' => $membro->agricultor->id,
                    'nome' => $membro->agricultor->nome_completo,
                ];
            }

            return null;
        })
            ->filter() // Remove qualquer associação órfã caso o agricultor tenha sido apagado
            ->values() // Reseta os índices do array para o JSON ir limpo [0, 1, 2...]
            ->sortBy('nome') // Garante a ordenação alfabética final no select
            ->values();

        return response()->json($agricultores);
    }

    public function getAgricultoresPorCooperativa($cooperativaId)
    {
        // Procura os agricultores associados a esta cooperativa
        $agricultores = Agricultor::where('cooperativa_id', $cooperativaId)->get(['id', 'nome']);

        // Retorna como resposta JSON para o JavaScript ler
        return response()->json($agricultores);
    }

    //  Processa a movimentação de estoque (Entrada/Saída).
    // public function movimentarEstoque(Request $request)
    // {
    //     // 1. Validação dos dados que vieram do JavaScript
    //     $request->validate([
    //         'cooperativa_id' => 'required',
    //         'insumo_id' => 'required|integer',
    //         'agricultor_id' => 'required|integer',
    //         'tipo' => 'required|string', // Ex: 'Saída'
    //         'quantidade' => 'required|numeric|min:0.01',
    //         'modalidade' => 'required|string', // Ex: 'Vendido', 'Oferta', etc.
    //         'estado' => 'required|string', // Ex: 'Pago', 'Pendente', etc.
    //     ]);

    //     // 2. Procurar o insumo para verificar e atualizar o estoque principal
    //     $insumo = Insumo::where('id', $request->insumo_id)
    //         ->where('cooperativa_id', $request->cooperativa_id)
    //         ->first();

    //     if (! $insumo) {
    //         return response()->json(['message' => 'Insumo não encontrado na cooperativa.'], 404);
    //     }

    //     // 3. Se for uma Saída, precisamos de validar se há estoque suficiente na BD
    //     if ($request->tipo === 'Saída' && $insumo->quantidade < $request->quantidade) {
    //         return response()->json([
    //             'message' => "Estoque insuficiente na base de dados. Disponível: {$insumo->quantidade} {$insumo->unidade}",
    //         ], 422);
    //     }

    //     // 4. Executar a operação de forma segura usando Database Transaction
    //     try {
    //         $movimento = DB::transaction(function () use ($request, $insumo) {

    //             // Deduz a quantidade do estoque do insumo (ou soma, caso no futuro uses para Entrada)
    //             if ($request->tipo === 'Saída') {
    //                 $insumo->quantidade -= $request->quantidade;
    //             } else {
    //                 $insumo->quantidade += $request->quantidade;
    //             }
    //             $insumo->save();

    //             // Cria o registo na tabela movimento_insumos usando o fillable do teu Model
    //             return MovimentoInsumo::create([
    //                 'cooperativa_id' => $request->cooperativa_id,
    //                 'insumo_id' => $request->insumo_id,
    //                 'agricultor_id' => $request->agricultor_id,
    //                 'tipo' => $request->tipo,
    //                 'quantidade' => $request->quantidade,
    //                 'modalidade' => $request->modalidade,
    //                 'estado' => $request->estado,
    //             ]);
    //         });

    //         // Retorna o sucesso e o ID do movimento criado para o teu JS mapear se precisar
    //         return response()->json([
    //             'message' => 'Movimentação registrada com sucesso!',
    //             'movimento_id' => $movimento->id,
    //         ], 201);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'message' => 'Erro interno ao salvar a movimentação: '.$e->getMessage(),
    //         ], 500);
    //     }
    // }


    public function movimentarEstoque(Request $request)
    {
        // 1. Validação dos dados que vieram do JavaScript
        $request->validate([
            'cooperativa_id' => 'required',
            'insumo_id' => 'required|integer',
            'agricultor_id' => 'required|integer',
            'tipo' => 'required|string', // Ex: 'Saída' ou 'Entrada'
            'quantidade' => 'required|numeric|min:0.01',
            'modalidade' => 'required|string', // Ex: 'Vendido', 'Oferta', etc.
            'estado' => 'required|string', // Ex: 'Pago', 'Pendente', etc.
        ]);

        // 2. Procurar o insumo para verificar e atualizar o estoque principal
        $insumo = Insumo::where('id', $request->insumo_id)
            ->where('cooperativa_id', $request->cooperativa_id)
            ->first();

        if (! $insumo) {
            return response()->json(['message' => 'Insumo não encontrado na cooperativa.'], 404);
        }

        // 3. Se for uma Saída, precisamos de validar se há estoque suficiente na BD
        if ($request->tipo === 'Saída' && $insumo->quantidade < $request->quantidade) {
            return response()->json([
                'message' => "Estoque insuficiente na base de dados. Disponível: {$insumo->quantidade} {$insumo->unidade}",
            ], 422);
        }

        // 4. Executar a operação de forma segura usando Database Transaction
        try {
            $movimento = DB::transaction(function () use ($request, $insumo) {

                // Guardamos o stock antes da alteração para a auditoria
                $stockAnterior = $insumo->quantidade;

                // Deduz ou soma a quantidade do estoque do insumo
                if ($request->tipo === 'Saída') {
                    $insumo->quantidade -= $request->quantidade;
                } else {
                    $insumo->quantidade += $request->quantidade;
                }
                $insumo->save();

                // Cria o registo na tabela movimento_insumos usando o fillable do teu Model
                $novoMovimento = MovimentoInsumo::create([
                    'cooperativa_id' => $request->cooperativa_id,
                    'insumo_id' => $request->insumo_id,
                    'agricultor_id' => $request->agricultor_id,
                    'tipo' => $request->tipo,
                    'quantidade' => $request->quantidade,
                    'modalidade' => $request->modalidade,
                    'estado' => $request->estado,
                ]);

                // ─── NOVO: SALVAR NO HISTÓRICO DE ESTOQUE ───
                \App\Models\HistoricoEstoque::create([
                    'cooperativa_id' => $request->cooperativa_id,
                    'insumo_id'      => $insumo->id,
                    'agricultor_id'  => $request->agricultor_id,
                    'movimento_id'   => $novoMovimento->id,
                    'tipo_movimento' => $request->tipo, // Dinâmico: 'Saída' ou 'Entrada'
                    'quantidade'     => $request->quantidade,
                    'stock_anterior' => $stockAnterior,
                    'stock_atual'    => $insumo->quantidade,
                    'utilizador'     => auth()->user()->name ?? 'Sistema',
                    'observacao'     => "Movimentação de " . strtolower($request->tipo) . " registada (" . ucfirst($request->modalidade) . ")."
                ]);

                return $novoMovimento;
            });

            // Retorna o sucesso e o ID do movimento criado para o teu JS mapear se precisar
            return response()->json([
                'message' => 'Movimentação registrada com sucesso!',
                'movimento_id' => $movimento->id,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro interno ao salvar a movimentação: '.$e->getMessage(),
            ], 500);
        }
    }



    // Salva o movimento de saída/distribuição de insumos para um agricultor.
    public function storeSaida(Request $request)
    {
        // 1. Validação dos dados de entrada baseados no teu modelo
        $request->validate([
            'cooperativa_id' => 'required',
            'insumo_id' => 'required',
            'agricultor_id' => 'required',
            'tipo' => 'required|string',
            'quantidade' => 'required|numeric|min:0.01',
            'modalidade' => 'required|string',
            'estado' => 'required|string',
        ]);

        // 2. Verifica se o insumo existe e se possui estoque suficiente para a saída
        $insumo = Insumo::where('id', $request->insumo_id)
            ->where('cooperativa_id', $request->cooperativa_id)
            ->first();

        if (! $insumo) {
            return response()->json(['message' => 'Insumo não encontrado no sistema.'], 404);
        }

        if ($insumo->quantidade < $request->quantidade) {
            return response()->json([
                'message' => "Estoque insuficiente. Disponível apenas: {$insumo->quantidade} {$insumo->unidade}",
            ], 422);
        }

        // 3. Executa a operação em lote seguro (Database Transaction)
        return DB::transaction(function () use ($request, $insumo) {

            // Subtrai a quantidade do estoque principal do Insumo
            $insumo->quantidade -= $request->quantidade;
            $insumo->save();

            // Cria o registro na tabela movimento_insumos usando o fillable do teu Model
            $movimento = MovimentoInsumo::create([
                'cooperativa_id' => $request->cooperativa_id,
                'insumo_id' => $request->insumo_id,
                'agricultor_id' => $request->agricultor_id,
                'tipo' => $request->tipo, // 'Saída'
                'quantidade' => $request->quantidade,
                'modalidade' => $request->modalidade,
                'estado' => $request->estado,
            ]);

            return response()->json([
                'message' => 'Distribuição de insumo efetuada com sucesso!',
                'insumo' => $movimento->insumo, // Retorna para atualizações adicionais se necessário
            ], 200);
        });
    }




    /**
     * Retorna o histórico de saídas/distribuições de insumos da cooperativa.
     */
    public function getSaidas($cooperativaId)
    {
        $movimentos = MovimentoInsumo::where('cooperativa_id', $cooperativaId)
            ->where('tipo', 'Saída')
            ->with([
                'insumo:id,nome,tipo',
                'agricultor:id,nome_completo',
            ])
            ->orderBy('id', 'desc')
            ->get();

        $saidas = $movimentos->map(function ($mov) {
            return [
                'id' => $mov->id,
                'insumo_id' => $mov->insumo_id,
                'insumo_nome' => $mov->insumo ? $mov->insumo->nome : 'Insumo Eliminado',
                'agricultor_nome' => $mov->agricultor ? $mov->agricultor->nome_completo : 'Não Associado',
                'tipo' => $mov->insumo ? $mov->insumo->tipo : 'N/D',
                'quantidade' => $mov->quantidade,
                'modalidade' => $mov->modalidade,
                'estado' => $mov->estado,
                'data' => $mov->created_at ? $mov->created_at->format('Y-m-d') : '',
            ];
        }); // <-- Esta chaveta e parêntese fecham o $movimentos->map(...)

        return response()->json($saidas);
    } // <-- Esta chaveta fecha o método getSaidas

/**
     * ATUALIZAR SAÍDA EXISTENTE (PUT)
     * Rota: /cooperativa/{cooperativa}/movimentos/saidas/{id}
     */
    // public function updateSaida(Request $request, $cooperativa, $id)
    // {
    //     try {
    //         // 1. Busca o movimento original
    //         $movimento = MovimentoInsumo::where('cooperativa_id', $cooperativa)->findOrFail($id);

    //         $insumoAntigoId   = $movimento->insumo_id;
    //         $quantidadeAntiga = $movimento->quantidade;

    //         // 2. Atualiza APENAS as colunas reais que existem no teu $fillable
    //         $movimento->insumo_id      = $request->insumo_id;
    //         $movimento->agricultor_id  = $request->agricultor_id;
    //         $movimento->quantidade     = $request->quantidade;
    //         $movimento->modalidade     = $request->modalidade;
    //         $movimento->estado         = $request->estado;

    //         // Removemos qualquer tentativa de ler ou salvar 'data_movimento' 
    //         // para que o Eloquent não gere o erro de coluna inexistente.
    //         $movimento->save();

    //         // 3. RECALCULAR ESTOQUE DOS INSUMOS
    //         if ($insumoAntigoId == $request->insumo_id) {
    //             // Cenário A: O produto é o mesmo, só mudou a quantidade
    //             $insumo = \App\Models\Insumo::find($request->insumo_id);
    //             if ($insumo) {
    //                 $insumo->quantidade = ($insumo->quantidade + $quantidadeAntiga) - $request->quantidade;
    //                 $insumo->save();


                    
    //             }
    //         } else {
    //             // Cenário B: Mudaram o próprio produto no Select
    //             $insumoAntigo = \App\Models\Insumo::find($insumoAntigoId);
    //             if ($insumoAntigo) {
    //                 $insumoAntigo->quantidade += $quantidadeAntiga;
    //                 $insumoAntigo->save();
    //             }

    //             $insumoNovo = \App\Models\Insumo::find($request->insumo_id);
    //             if ($insumoNovo) {
    //                 $insumoNovo->quantidade -= $request->quantidade;
    //                 $insumoNovo->save();
    //             }
    //         }

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Distribuição atualizada e estoque recalculado com sucesso.'
    //         ], 200);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Erro ao atualizar registo: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }


    public function updateSaida(Request $request, $cooperativa, $id)
    {
        try {
            // 1. Busca o movimento original
            $movimento = MovimentoInsumo::where('cooperativa_id', $cooperativa)->findOrFail($id);

            $insumoAntigoId   = $movimento->insumo_id;
            $quantidadeAntiga = $movimento->quantidade;

            // 2. Atualiza APENAS as colunas reais
            $movimento->insumo_id      = $request->insumo_id;
            $movimento->agricultor_id  = $request->agricultor_id;
            $movimento->quantidade     = $request->quantidade;
            $movimento->modalidade     = $request->modalidade;
            $movimento->estado         = $request->estado;

            $movimento->save();

            // 3. RECALCULAR ESTOQUE DOS INSUMOS E GERAR HISTÓRICO
            if ($insumoAntigoId == $request->insumo_id) {
                // Cenário A: O produto é o mesmo, só mudou a quantidade (ou outros dados)
                $insumo = \App\Models\Insumo::find($request->insumo_id);
                if ($insumo) {
                    $stockAnterior = $insumo->quantidade;
                    
                    // Recálculo do estoque: devolve a antiga e retira a nova
                    $insumo->quantidade = ($insumo->quantidade + $quantidadeAntiga) - $request->quantidade;
                    $insumo->save();

                    // ─── HISTÓRICO: MESMO INSUMO ───
                    \App\Models\HistoricoEstoque::create([
                        'cooperativa_id' => $cooperativa,
                        'insumo_id'      => $insumo->id,
                        'agricultor_id'  => $request->agricultor_id,
                        'movimento_id'   => $movimento->id,
                        'tipo_movimento' => 'Atualização',
                        'quantidade'     => $request->quantidade,
                        'stock_anterior' => $stockAnterior,
                        'stock_atual'    => $insumo->quantidade,
                        'utilizador'     => auth()->user()->name ?? 'Sistema',
                        'observacao'     => "Saída atualizada (Quantidade antiga: {$quantidadeAntiga} -> Nova: {$request->quantidade})."
                    ]);
                }
            } else {
                // Cenário B: Mudaram o próprio produto no Select
                
                // Estorno no Insumo Antigo
                $insumoAntigo = \App\Models\Insumo::find($insumoAntigoId);
                if ($insumoAntigo) {
                    $stockAnteriorAntigo = $insumoAntigo->quantidade;
                    $insumoAntigo->quantidade += $quantidadeAntiga;
                    $insumoAntigo->save();

                    // ─── HISTÓRICO: ESTORNO DO INSUMO ANTIGO ───
                    \App\Models\HistoricoEstoque::create([
                        'cooperativa_id' => $cooperativa,
                        'insumo_id'      => $insumoAntigo->id,
                        'agricultor_id'  => $request->agricultor_id,
                        'movimento_id'   => $movimento->id,
                        'tipo_movimento' => 'Entrada', // Entra de volta porque a saída foi cancelada/alterada
                        'quantidade'     => $quantidadeAntiga,
                        'stock_anterior' => $stockAnteriorAntigo,
                        'stock_atual'    => $insumoAntigo->quantidade,
                        'utilizador'     => auth()->user()->name ?? 'Sistema',
                        'observacao'     => "Estorno de quantidade devido a alteração do insumo selecionado na movimentação."
                    ]);
                }

                // Aplicação da Saída no Novo Insumo
                $insumoNovo = \App\Models\Insumo::find($request->insumo_id);
                if ($insumoNovo) {
                    $stockAnteriorNovo = $insumoNovo->quantidade;
                    $insumoNovo->quantidade -= $request->quantidade;
                    $insumoNovo->save();

                    // ─── HISTÓRICO: NOVA SAÍDA DO NOVO INSUMO ───
                    \App\Models\HistoricoEstoque::create([
                        'cooperativa_id' => $cooperativa,
                        'insumo_id'      => $insumoNovo->id,
                        'agricultor_id'  => $request->agricultor_id,
                        'movimento_id'   => $movimento->id,
                        'tipo_movimento' => 'Saída',
                        'quantidade'     => $request->quantidade,
                        'stock_anterior' => $stockAnteriorNovo,
                        'stock_atual'    => $insumoNovo->quantidade,
                        'utilizador'     => auth()->user()->name ?? 'Sistema',
                        'observacao'     => "Nova saída registada após alteração do insumo na movimentação."
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Distribuição atualizada e estoque recalculado com sucesso.'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar registo: ' . $e->getMessage()
            ], 500);
        }
    }


    // REMOVER
    public function destroySaida($cooperativa, $id)
    {
        try {
            // 1. Busca o movimento garantindo que pertence à cooperativa ativa
            $movimento = MovimentoInsumo::where('cooperativa_id', $cooperativa)
                ->findOrFail($id);

            // 2. Localiza o Insumo associado a este movimento
            if ($movimento->insumo_id) {
                // Busca o Model do Insumo
                $insumo = Insumo::find($movimento->insumo_id);

                if ($insumo) {
                    // Como estamos a APAGAR uma SAÍDA, o produto VOLTA para o estoque.
                    // Alterado de 'quantidade_atual' para 'quantidade' que é a coluna real da tua BD!
                    $insumo->quantidade += $movimento->quantidade;

                    $insumo->save();
                }
            }

            // 3. Agora que o estoque foi devolvido e guardado, apagamos o registo de saída
            $movimento->delete();

            return response()->json([
                'success' => true,
                'message' => 'Registo de saída excluído e quantidade devolvida ao estoque.',
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registo de saída não foi encontrado.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro interno na BD ao devolver estoque: '.$e->getMessage(),
            ], 500);
        }
    }
}
