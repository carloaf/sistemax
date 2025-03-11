{{-- resources/views/relatorios/pdf/entrada.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Relatório de Entrada</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Relatório de Entrada de Materiais</h1>
    <p>Período: {{ \Carbon\Carbon::parse($dataInicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($dataFim)->format('d/m/Y') }}</p>
    
    @if($entradas->count() > 0)
    <table>
        <thead>
            <tr>
                <th>NF</th>
                <th>Data</th>
                <th>Fornecedor</th>
                <th>Material</th>
                <th>Quantidade</th>
                <th>Preço Unitário</th>
            </tr>
        </thead>
        <tbody>
            @foreach($entradas as $doc)
                @foreach($doc->items as $item)
                <tr>
                    <td>{{ $doc->document_number }}</td>
                    <td>{{ $doc->issue_date->format('d/m/Y') }}</td>
                    <td>{{ $doc->supplier }}</td>
                    <td>{{ $item->material->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>R$ {{ number_format($item->unit_price, 2, ',', '.') }}</td>
                </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
    @else
    <p>Nenhum registro encontrado no período selecionado</p>
    @endif
</body>
</html>