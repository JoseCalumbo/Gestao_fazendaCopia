<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Cooperativas</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2e7d32;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 0;
            color: #2e7d32;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0 0 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #e0e0e0;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
            color: #2e7d32;
        }
        tr:nth-child(even) {
            background-color: #fafafa;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 9px;
            color: #999;
            border-top: 1px solid #e0e0e0;
            padding-top: 5px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>SISTEMA DE GESTÃO INTEGRADA</h2>
        <p>Relatório Geral de Cooperativas Cadastradas</p>
        <p style="font-size: 9px;">Gerado em: {{ date('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 25%;">Nome da Cooperativa</th>
                <th style="width: 15%;">NIF</th>
                <th style="width: 15%;">Província</th>
                <th style="width: 15%;">Município</th>
                <th style="width: 15%; text-align: center;">Membros Ativos</th>
                <th style="width: 15%;">Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cooperativas as $coop)
                <tr>
                    <td>{{ $coop->nome }}</td>
                    <td>{{ $coop->nif }}</td>
                    <td>{{ $coop->provincia }}</td>
                    <td>{{ $coop->municipio }}</td>
                    <td class="text-center">{{ $coop->membros_activos_count }}</td>
                    <td>{{ ucfirst($coop->estado) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Nenhuma cooperativa encontrada.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Relatório de Cooperativas - Todos os direitos reservados.
    </div>

</body>
</html>