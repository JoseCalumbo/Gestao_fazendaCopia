<?php

namespace App\Http\Controllers;
use App\Models\HistoricoEstoque;
use Illuminate\Http\Request;

class HistoricoEstoqueController extends Controller
{
    /**
     * Retorna o histórico global formatado exatamente para a tabela do Frontend
     */


public function getHistoricoGlobal($cooperativaId)
{
    try {
        // Trazemos os dados filtrando apenas o que pertence à cooperativa E possui um agricultor associado
        $historico = \App\Models\HistoricoEstoque::with(['insumo', 'agricultor', 'movimento'])
            ->where('cooperativa_id', $cooperativaId)
            ->whereNotNull('agricultor_id') // Garante que a coluna agricultor_id não está vazia
            ->where('agricultor_id', '>', 0) // Segurança extra caso uses 0 para não associado
            ->orderBy('created_at', 'desc')
            ->get();

        $dadosFormatados = $historico->map(function ($item) {
            $movimento = $item->movimento;

            // Como filtramos acima, o agricultor irá sempre existir aqui
            $nomeAgricultor = $item->agricultor ? $item->agricultor->nome_completo : 'Não Associado';

            return [
                'id'              => $item->id,
                'data'            => $item->created_at->format('d/m/Y H:i'),
                'insumo_nome'     => $item->insumo ? $item->insumo->nome : 'Insumo Removido',
                'tipo_movimento'  => $item->tipo_movimento,
                'quantidade'      => (float) $item->quantidade,
                'stock_anterior'  => (float) $item->stock_anterior,
                'stock_atual'     => (float) $item->stock_atual,
                'utilizador'      => $item->utilizador ?? 'Sistema',
                
                'agricultor_nome' => $nomeAgricultor,
                'modalidade'      => $movimento ? $movimento->modalidade : 'N/A',
                'estado'          => $movimento ? $movimento->estado : 'Liquidado',
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => $dadosFormatados
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erro ao carregar histórico: ' . $e->getMessage()
        ], 500);
    }
}



// public function exibirHistoricoAdmin()
// {
//     // Puxa o histórico global trazendo todas as cooperativas e agricultores com paginação do Laravel
//     $historicos = \App\Models\HistoricoEstoque::with(['insumo', 'cooperativa', 'agricultor'])
//         ->whereNotNull('agricultor_id') // Filtra para listar os que possuem agricultores vinculados
//         ->orderBy('created_at', 'desc')
//         ->paginate(15); // Paginação nativa igual ao teu código anterior

//     return view('insumos.', compact('historicos'));
// }


public function getHistoricoGlobalCompleto()
{
    try {
        // Trazemos tudo: insumo, agricultor, movimento e também a cooperativa de origem
        $historico = \App\Models\HistoricoEstoque::with(['insumo', 'agricultor', 'movimento', 'cooperativa'])
            ->whereNotNull('agricultor_id') // Garante que há um agricultor associado
            ->where('agricultor_id', '>', 0)
            ->orderBy('created_at', 'desc')
            ->get();

        $dadosFormatados = $historico->map(function ($item) {
            $movimento = $item->movimento;

            return [
                'id'              => $item->id,
                'data'            => $item->created_at->format('d/m/Y H:i'),
                'cooperativa_nome'=> $item->cooperativa ? $item->cooperativa->nome : 'Cooperativa Desconhecida',
                'insumo_nome'     => $item->insumo ? $item->insumo->nome : 'Insumo Removido',
                'tipo_movimento'  => $item->tipo_movimento,
                'quantidade'      => (float) $item->quantidade,
                'stock_anterior'  => (float) $item->stock_anterior,
                'stock_atual'     => (float) $item->stock_atual,
                'utilizador'      => $item->utilizador ?? 'Sistema',
                'agricultor_nome' => $item->agricultor ? $item->agricultor->nome_completo : 'Não Associado',
                'modalidade'      => $movimento ? $movimento->modalidade : 'N/A',
                'estado'          => $movimento ? $movimento->estado : 'Liquidado',
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => $dadosFormatados
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erro ao carregar histórico global: ' . $e->getMessage()
        ], 500);
    }
}



// public function getHistoricoGlobal($cooperativaId)
// {
//     try {
//         // Trazemos o insumo, o agricultor direto do histórico e o movimento
//         $historico = \App\Models\HistoricoEstoque::with(['insumo', 'agricultor', 'movimento'])
//             ->where('cooperativa_id', $cooperativaId)
//             ->orderBy('created_at', 'desc')
//             ->get();

//         $dadosFormatados = $historico->map(function ($item) {
//             $movimento = $item->movimento;

//             // 1. Tenta pegar o nome direto do histórico, senão tenta via movimento
//             $nomeAgricultor = 'Não Associado';
//             if ($item->agricultor) {
//                 $nomeAgricultor = $item->agricultor->nome_completo; // Usa a coluna correta aqui
//             } elseif ($movimento && $movimento->agricultor) {
//                 $nomeAgricultor = $movimento->agricultor->nome_completo;
//             }

//             return [
//                 'id'              => $item->id,
//                 'data'            => $item->created_at->format('d/m/Y H:i'),
//                 'insumo_nome'     => $item->insumo ? $item->insumo->nome : 'Insumo Removido',
//                 'tipo_movimento'  => $item->tipo_movimento,
//                 'quantidade'      => (float) $item->quantidade,
//                 'stock_anterior'  => (float) $item->stock_anterior,
//                 'stock_atual'     => (float) $item->stock_atual,
//                 'utilizador'      => $item->utilizador ?? 'Sistema',
                
//                 // Mapeamento dos novos dados corrigidos
//                 'agricultor_nome' => $nomeAgricultor,
//                 'modalidade'      => $movimento ? $movimento->modalidade : 'N/A',
//                 'estado'          => $movimento ? $movimento->estado : 'Liquidado',
//             ];
//         });

//         return response()->json([
//             'success' => true,
//             'data'    => $dadosFormatados
//         ], 200);

//     } catch (\Exception $e) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Erro ao carregar histórico: ' . $e->getMessage()
//         ], 500);
//     }
// }



}