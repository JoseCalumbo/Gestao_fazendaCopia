<?php

namespace App\Http\Controllers;

use App\Models\Agricultor;
use App\Models\Cooperativa;
use App\Models\CooperativaMembro;
use App\Models\HistoricoEstoque;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AgricultoresController extends Controller
{
    // Exibir os detalhes de um Agricultor específico

    public function getHistoricoJson($id)
    {
        try {
            // Puxamos o insumo e o movimento associado para extrair a modalidade
            $historico = HistoricoEstoque::with(['insumo', 'movimento'])
                ->where('agricultor_id', $id)
                ->orderBy('created_at', 'desc')
                ->get();

            $dadosFormatados = $historico->map(function ($item) {
                $movimento = $item->movimento;

                return [
                    'id' => $item->id,
                    'data' => $item->created_at->format('d/m/Y H:i'),
                    'insumo_nome' => $item->insumo ? $item->insumo->nome : 'Insumo Removido',
                    'insumo_tipo' => $item->insumo ? ucfirst($item->insumo->tipo) : 'N/A', // Tipo do Insumo
                    'tipo_movimento' => $item->tipo_movimento,
                    'quantidade' => (float) $item->quantidade,
                    'stock_anterior' => (float) $item->stock_anterior,
                    'stock_atual' => (float) $item->stock_atual,
                    'utilizador' => $item->utilizador ?? 'Sistema',
                    'modalidade' => $movimento ? ucfirst($movimento->modalidade) : 'N/A', // Modalidade
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $dadosFormatados,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao carregar histórico: '.$e->getMessage(),
            ], 500);
        }
    }

    // public function show($id)
    // {
    //     // Busca o agricultor com a árvore de relações ativa carregada
    //     $agricultor = Agricultor::with(['associacoes.cooperativa'])->findOrFail($id);

    //     // Extrai os dados da associação para passar de forma amigável para a view
    //     $vinculoAtivo = $agricultor->associacoes->where('activo', true)->first();
    //     $cooperativaNome = $vinculoAtivo && $vinculoAtivo->cooperativa ? $vinculoAtivo->cooperativa->nome : 'Sem cooperativa';
    //     $cargoCooperativa = $vinculoAtivo ? $vinculoAtivo->cargo : 'Nenhum';

    //     // 2. CALCULAR O TOTAL GERAL RECEBIDO (Apenas saídas para o agricultor)
    //     $totalInsumosRecebidos = HistoricoEstoque::where('agricultor_id', $id)
    //         ->where('tipo_movimento', 'Saída')
    //         ->sum('quantidade');

    //     // ─── NOVA BUSCA: Histórico exclusivo deste Agricultor ───
    //     $historicos = HistoricoEstoque::with(['insumo'])
    //         ->where('agricultor_id', $id)
    //         ->orderBy('created_at', 'desc')
    //         ->take(10) // Traz os 10 movimentos mais recentes dele
    //         ->get();

    //     $stats = [];

    //     // Passa a variável $historicos para a view
    //     return view('agricultores.show', compact('agricultor', 'cooperativaNome', 'cargoCooperativa', 'stats', 'historicos'));
    // }

   
   public function show($id)
{
    // 1. Procura o agricultor e associações (O teu código)
    $agricultor = Agricultor::with(['associacoes.cooperativa'])->findOrFail($id);

    $vinculoAtivo = $agricultor->associacoes->where('activo', true)->first();
    $cooperativaNome = $vinculoAtivo && $vinculoAtivo->cooperativa ? $vinculoAtivo->cooperativa->nome : 'Sem cooperativa';
    $cargoCooperativa = $vinculoAtivo ? $vinculoAtivo->cargo : 'Nenhum';

$totalInsumosRecebidos = \App\Models\HistoricoEstoque::where('agricultor_id', $id)->count();

    // 3. OPCIONAL: Agrupado por tipo de insumo para os teus blocos de estatísticas
    $resumoPorTipo = \App\Models\HistoricoEstoque::join('insumos', 'historico_estoques.insumo_id', '=', 'insumos.id')
        ->where('historico_estoques.agricultor_id', $id)
        ->where('historico_estoques.tipo_movimento', 'Saída')
        ->selectRaw('insumos.tipo, SUM(historico_estoques.quantidade) as total')
        ->groupBy('insumos.tipo')
        ->pluck('total', 'tipo')
        ->toArray();

    $stats = [
        'total_geral'   => $totalInsumosRecebidos,
        'fertilizantes' => $resumoPorTipo['fertilizante'] ?? 0,
        'sementes'      => $resumoPorTipo['semente'] ?? 0,
        'mecanico'      => $resumoPorTipo['mecanico'] ?? 0,
    ];
    
    return view('agricultores.show', compact('agricultor', 'cooperativaNome', 'cargoCooperativa', 'stats'));
}
   
   


    
    public function index(Request $request)
    {
        // 1. Lista de cooperativas para preencher o <select> no Blade
        $cooperativas = Cooperativa::all();

        $query = Agricultor::with(['associacoes.cooperativa']);

        // FILTRO: Pesquisa por Nome, BI (bilhete) ou Nome da Cooperativa
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nome_completo', 'like', "%{$search}%")
                    ->orWhere('bilhete', 'like', "%{$search}%");

                // Pesquisa pelo nome da cooperativa na nova estrutura relacional
                $q->orWhereHas('associacoes.cooperativa', function ($coopQuery) use ($search) {
                    $coopQuery->where('nome', 'like', "%{$search}%")
                        ->where('cooperativa_membros.activo', true); // Apenas na associação ativa
                });
            });
        }

        // FILTRO: Estado do Agricultor
        if ($request->filled('estado')) {
            $query->where('estado', $request->input('estado'));
        }

        // FILTRO: Cooperativa (Filtra agricultores com vínculo ATIVO na cooperativa selecionada)
        if ($request->filled('cooperativa_id')) {
            $cooperativaId = $request->input('cooperativa_id');
            $query->whereHas('associacoes', function ($q) use ($cooperativaId) {
                $q->where('cooperativa_id', $cooperativaId)
                    ->where('activo', true);
            });
        }

        // FILTRO: Cargo na Cooperativa
        if ($request->filled('cargo')) {
            $cargo = $request->input('cargo');
            $query->whereHas('associacoes', function ($q) use ($cargo) {
                $q->where('cargo', $cargo)
                    ->where('activo', true); // Garante que filtra apenas pelo cargo atual/ativo
            });
        }

        // 3. Obter os agricultores filtrados com paginação (mantive o seu valor de 2 para testes)
        $agricultores = $query->latest()->paginate(5)->withQueryString();

        // 4. Contagens para os Cards baseadas na nova tabela pivot
        $totalAgricultores = Agricultor::count();

        // Conta quantos agricultores possuem um vínculo ATIVO na tabela cooperativa_membros
        $associadosCoop = Agricultor::whereHas('associacoes', function ($q) {
            $q->where('activo', true);
        })->count();

        // Conta quantos agricultores possuem o cargo de 'Técnico' no seu vínculo ativo
        $tecnicos = Agricultor::whereHas('associacoes', function ($q) {
            $q->where('cargo', 'Técnico')
                ->where('activo', true);
        })->count();

        // Conta os agricultores ativos no sistema de forma geral
        $activos = Agricultor::where('estado', 'activo')->count();

        // Conta os agricultores ativos no sistema de forma geral
        $pedentes = Agricultor::where('estado', 'Pendente')->count();

        return view('agricultores.agricultores', compact(
            'agricultores',
            'cooperativas',
            'totalAgricultores',
            'associadosCoop',
            'pedentes',
            'activos'
        ));
    }

    public function store(Request $request)
    {
        try {
            // 1. Validação
            $request->validate([
                'nome_completo' => 'required|string|max:255',
                'sexo' => 'required',
                'data_nascimento' => 'required|date',
                'bilhete' => 'required|string|max:20|unique:agricultores,bilhete',
                'telefone_principal' => 'required',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ], [
                'bilhete.unique' => 'Este número de Bilhete de Identidade já está registado no sistema.',
            ]);

            // Inicia a transação de segurança no Banco de Dados
            \DB::beginTransaction();

            // 2. Upload da Foto (se existir)
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('agricultores', 'public');
            }

            // 3. Criar o Agricultor
            $agricultor = Agricultor::create([
                'nome_completo' => $request->nome_completo,
                'sexo' => $request->sexo,
                'data_nascimento' => $request->data_nascimento,
                'bilhete' => $request->bilhete,
                'nif' => $request->nif,
                'estado' => $request->estado,
                'telefone_principal' => $request->telefone_principal,
                'telefone_alternativo' => $request->telefone_alternativo,
                'email' => $request->email,
                'endereco' => $request->endereco,
                'foto' => $fotoPath,
            ]);

            // 4. Vincular à Cooperativa usando o Model correto
            if ($request->filled('cooperativa_id')) {
                CooperativaMembro::create([
                    'agricultor_id' => $agricultor->id,
                    'cooperativa_id' => $request->cooperativa_id,
                    'cargo' => $request->cargo_cooperativa ?? 'Membro',
                    'activo' => true,
                ]);
            }

            // Se tudo deu certo, confirma as gravações no Banco
            \DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Agricultor guardado com sucesso!',
            ]);

        } catch (ValidationException $e) {
            // Se a validação falhar, desfaz as alterações que estavam na fila
            \DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first(),
            ], 422);
        } catch (\Exception $e) {
            // Captura qualquer outro erro inesperado do sistema
            \DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Erro interno ao guardar dados: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * 2. ALTERAÇÃO / EDIÇÃO COMPLETA (PUT /agricultores/{id})
     */
    public function update(Request $request, $id)
    {
        // Usamos um try/catch abrangente e Transactions para total segurança
        try {
            $agricultor = Agricultor::findOrFail($id);

            $request->validate([
                'nome_completo' => 'required|string|max:255',
                'sexo' => 'required',
                'data_nascimento' => 'required|date',
                'bilhete' => 'required|string',
                'telefone_principal' => 'required',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            \DB::beginTransaction();

            // Se foi enviada uma NOVA foto
            if ($request->hasFile('foto')) {
                if ($agricultor->foto) {
                    \Storage::disk('public')->delete($agricultor->foto);
                }
                $agricultor->foto = $request->file('foto')->store('agricultores', 'public');
            }

            // Atualizar todos os dados na tabela 'agricultores'
            $agricultor->update([
                'nome_completo' => $request->nome_completo,
                'sexo' => $request->sexo,
                'data_nascimento' => $request->data_nascimento,
                'bilhete' => $request->bilhete,
                'nif' => $request->nif ?: null,
                'estado' => $request->estado,
                'telefone_principal' => $request->telefone_principal,
                'telefone_alternativo' => $request->telefone_alternativo ?: null,
                'email' => $request->email ?: null,
                'endereco' => $request->endereco ?: null,
                'foto' => $agricultor->foto,
            ]);

            // Gerenciar o vínculo com a Cooperativa (Usando o Modelo CooperativaMembro)
            if ($request->filled('cooperativa_id')) {

                // Busca se ele já possui um registo ativo nesta tabela
                $vinculo = CooperativaMembro::where('agricultor_id', $agricultor->id)
                    ->where('activo', true)
                    ->first();

                if ($vinculo) {
                    // Se já tinha, atualiza os dados da cooperativa e cargo atuais
                    $vinculo->update([
                        'cooperativa_id' => $request->cooperativa_id,
                        'cargo' => $request->cargo_cooperativa ?: 'Membro',
                    ]);
                } else {
                    // Se não tinha associação ativa, cria uma nova ativa
                    CooperativaMembro::create([
                        'agricultor_id' => $agricultor->id,
                        'cooperativa_id' => $request->cooperativa_id,
                        'cargo' => $request->cargo_cooperativa ?: 'Membro',
                        'activo' => true,
                    ]);
                }
            } else {
                // Se o campo cooperativa veio vazio no formulário, desativamos o vínculo atual dele (activo = false)
                CooperativaMembro::where('agricultor_id', $agricultor->id)
                    ->where('activo', true)
                    ->update(['activo' => false]);
            }

            \DB::commit();

            return response()->json(['success' => true, 'message' => 'Agricultor atualizado com sucesso!']);

        } catch (ValidationException $e) {
            \DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first(),
            ], 422);
        } catch (\Exception $e) {
            \DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar dados: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Eliminar Agricultor
     */
    public function destroy($id)
    {
        // Usa uma Transaction para garantir que se algo falhar, nada é apagado por metade
        \DB::beginTransaction();

        try {
            $agricultor = Agricultor::findOrFail($id);

            // 1. Remove os vínculos com a cooperativa na tabela 'cooperativa_membros' primeiro
            CooperativaMembro::where('agricultor_id', $agricultor->id)->delete();

            // 2. Remove a fotografia física do disco
            if ($agricultor->foto) {
                \Storage::disk('public')->delete($agricultor->foto);
            }

            // 3. Elimina o agricultor da base de dados (tabela 'agricultores')
            $agricultor->delete();

            // Se tudo correu bem, confirma as alterações na BD
            \DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Agricultor, foto e vínculos eliminados com sucesso.',
            ]);

        } catch (\Exception $e) {
            // Se der algum erro, desfaz tudo para não corromper os dados
            \DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Erro ao eliminar o agricultor: '.$e->getMessage(),
            ], 500);
        }
    }
}
