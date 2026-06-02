<?php
/**
 * Página de teste para simular pagamentos PIX no localhost
 * Acesse: http://localhost/new/conta/checkout/pix/test-payment.php
 */

header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste de Pagamento PIX - Simulador</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        h1 {
            color: #333;
            margin-bottom: 10px;
            font-size: 28px;
        }
        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }
        .test-section {
            margin-bottom: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            border-left: 4px solid #667eea;
        }
        .test-section h2 {
            color: #333;
            font-size: 18px;
            margin-bottom: 15px;
        }
        .test-button {
            display: block;
            width: 100%;
            padding: 15px 20px;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            text-decoration: none;
            text-align: center;
        }
        .test-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .test-button.secondary {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .test-button.success {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        .info-box {
            background: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .info-box p {
            color: #1565c0;
            font-size: 14px;
            line-height: 1.6;
        }
        .warning {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .warning p {
            color: #856404;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 Simulador de Pagamento PIX</h1>
        <p class="subtitle">Teste todos os upsells do funil de empréstimo</p>

        <div class="warning">
            <p><strong>⚠️ Modo Teste:</strong> Esta página funciona apenas no localhost. Use para testar os redirecionamentos do funil.</p>
        </div>

        <div class="info-box">
            <p><strong>ℹ️ Como usar:</strong></p>
            <p>1. Clique em um dos botões abaixo para simular um pagamento</p>
            <p>2. Você será redirecionado para a página de pagamento PIX</p>
            <p>3. O pagamento será automaticamente confirmado após 2 segundos</p>
            <p>4. Você será redirecionado para o próximo upsell do funil</p>
        </div>

        <div class="test-section">
            <h2>🎯 Testar Fluxo Completo do Funil</h2>
            <a href="test-simulate.php?service=Payment EMP" class="test-button">
                🚀 Iniciar: Payment EMP → iof2.html (UP1)
            </a>
            <a href="test-simulate.php?service=Payment EMP UP1" class="test-button secondary">
                📄 UP1: iof2.html → tarifa-cadastro.html (UP2)
            </a>
            <a href="test-simulate.php?service=Payment EMP UP2" class="test-button secondary">
                💰 UP2: tarifa-cadastro.html → aumento-limite.html (UP3)
            </a>
            <a href="test-simulate.php?service=Payment EMP UP3" class="test-button secondary">
                📈 UP3: aumento-limite.html → assinatura.html (UP4)
            </a>
            <a href="test-simulate.php?service=Payment EMP UP4" class="test-button secondary">
                ✍️ UP4: assinatura.html → confirmacao-dados.html (UP5)
            </a>
            <a href="test-simulate.php?service=Payment EMP UP5" class="test-button success">
                ✅ UP5: confirmacao-dados.html → iof.html (UP6 - Final)
            </a>
        </div>

        <div class="test-section">
            <h2>🔧 Testar Página de Pagamento Diretamente</h2>
            <a href="payment.html?test=1&id=test-123&service=Payment EMP" class="test-button">
                Testar Payment EMP
            </a>
            <a href="payment.html?test=1&id=test-456&service=Payment EMP UP1" class="test-button">
                Testar Payment EMP UP1
            </a>
            <a href="payment.html?test=1&id=test-789&service=Payment EMP UP2" class="test-button">
                Testar Payment EMP UP2
            </a>
        </div>
    </div>
</body>
</html>

