{{-- resources/views/documentos/pdf/entrada.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Entrada de Materiais - {{ $document->document_number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .logo { max-width: 150px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f5f5f5; }
        .total { margin-top: 20px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/logo.png') }}" class="logo">
        <h1>Entrada de Materiais</h1>
        <p>Número do Documento: {{ $document->document_number }}</p>
        <p>Data: {{ $document->issue_date->format('d/m/Y') }}</p>
        <p>Fornecedor: {{ $document->supplier }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Material</th>
                <th>Quantidade</th>
                <th>Preço Unitário</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($document->items as $item)
            <tr>
                <td>{{ $item->material->name }}</td>
                <td>{{ number_format($item->quantity, 2, ',', '.') }} {{ $item->material->unit }}</td>
                <td>R$ {{ number_format($item->unit_price, 2, ',', '.') }}</td>
                <td>R$ {{ number_format($item->quantity * $item->unit_price, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        Total de Itens: {{ $document->items->count() }}<br>
        Valor Total: R$ {{ number_format($document->items->sum(function($item) {
            return $item->quantity * $item->unit_price;
        }), 2, ',', '.') }}
    </div>
</body>
</html>