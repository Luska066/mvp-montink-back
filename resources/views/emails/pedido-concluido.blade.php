<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pedido Concluído</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .email-header {
            background-color: #4f46e5;
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .email-body {
            padding: 30px;
        }
        .email-body h2 {
            color: #4f46e5;
            margin-top: 0;
        }
        .order-details {
            background: #f9fafb;
            padding: 20px;
            border-radius: 6px;
            margin-top: 20px;
        }
        .order-details p {
            margin: 5px 0;
        }
        .email-footer {
            text-align: center;
            padding: 20px;
            font-size: 14px;
            color: #777;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4f46e5;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 20px;
        }
        .btn:hover {
            background-color: #3730a3;
        }
    </style>
</head>
<body>
<div class="email-container">
    <div class="email-header">
        <h1>Pedido Confirmado 🎉</h1>
    </div>
    <div class="email-body">
        <h2>Olá {{ $pedido->email ?? 'Cliente' }},</h2>
        <p>Seu pedido :<strong>#{{  $pedido->uuid ?? \Illuminate\Support\Str::uuid() }}</strong> foi concluído com sucesso!</p>

        <div class="order-details">
            <p><strong>Informações do Pedido:</strong></p>
            <p><strong>Data:</strong> {{  \Carbon\Carbon::parse($pedido->created_at)->format('d/m/Y') ?? now()->format('d/m/Y') }}</p>
            <p><strong>Valor Total:</strong> R$ {{ number_format($pedido->total ?? 0, 2, ',', '.') }}</p>
            <p><strong>Frete:</strong> R$ {{ number_format($pedido->frete ?? 0, 2, ',', '.') }}</p>
            <p><strong>Desconto:</strong> R$ {{ number_format($pedido->desconto ?? 0, 2, ',', '.') }}</p>
            <p><strong>Status:</strong> {{$pedido->status}}</p>
        </div>

        <div class="order-details">
            <p><strong>Suas Informações:</strong></p>
            <p><strong>Email:</strong> {{  $pedido->email ?? now()->format('d/m/Y') }}</p>
            <p><strong>Cep:</strong> R$ {{ $pedido->cep ?? 'Sem cep'  }}</p>
            <p><strong>Estado:</strong> R$ {{ $pedido->estado ?? 'Sem estado'}}</p>
            <p><strong>Cidade:</strong> R$ {{ $pedido->cep ?? 'Sem cidade'}}</p>
            <p><strong>Rua:</strong> {{$pedido->rua ?? "rua"}}</p>
            <p><strong>Numero:</strong> {{$pedido->numero ?? 'Sem numero'}}</p>
            <p><strong>Complemento:</strong> {{$pedido->complemento ?? 'Sem complemento'}}</p>
        </div>

    </div>
    <div class="email-footer">
        Obrigado por comprar com a gente!<br>
        &copy; {{ date('Y') }} {{ config('app.name') }}. Todos os direitos reservados.
    </div>
</div>
</body>
</html>
