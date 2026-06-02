<?php
/**
 * Simula um pagamento PIX e redireciona para payment.html
 * Depois de 2 segundos, confirma automaticamente o pagamento
 */

header('Content-Type: text/html; charset=UTF-8');

// Verificar se está no localhost
$isLocalhost = in_array($_SERVER['HTTP_HOST'], ['localhost', '127.0.0.1']) || 
               strpos($_SERVER['HTTP_HOST'], 'localhost:') !== false;

if (!$isLocalhost) {
    die('❌ Esta página só funciona no localhost!');
}

$service = isset($_GET['service']) ? $_GET['service'] : 'Payment EMP';
$testId = 'test-' . time() . '-' . rand(1000, 9999);

// Mapear serviços para valores e títulos
$serviceData = [
    'Payment EMP' => ['price' => 21.00, 'title' => 'Imposto IOF', 'subtitle' => 'Tributo sobre operações financeiras'],
    'Payment EMP UP1' => ['price' => 21.00, 'title' => 'Imposto IOF', 'subtitle' => 'Tributo sobre operações financeiras'],
    'Payment EMP UP2' => ['price' => 12.00, 'title' => 'Tarifa de Cadastro', 'subtitle' => 'Custo dos serviços de cadastro'],
    'Payment EMP UP3' => ['price' => 12.00, 'title' => 'Aumento de Limite', 'subtitle' => 'Custo operacional para ampliar seu crédito'],
    'Payment EMP UP4' => ['price' => 12.00, 'title' => 'Assinatura Digital', 'subtitle' => 'Taxa de processamento'],
    'Payment EMP UP5' => ['price' => 12.00, 'title' => 'Confirmação de Dados', 'subtitle' => 'Taxa de validação'],
];

$data = $serviceData[$service] ?? $serviceData['Payment EMP'];

// Criar dados do PIX simulados
$pixData = [
    'id' => $testId,
    'external_id' => $testId,
    'amount' => $data['price'],
    'pixCode' => '00020126360014BR.GOV.BCB.PIX0114+55119999999995204000053039865802BR5909BANCRED LTDA6009SAO PAULO62070503***6304' . strtoupper(substr(md5($testId), 0, 4)),
    'qrcode' => 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode('PIX-TEST-' . $testId),
    'qrcode_base64' => '',
    'expiresAt' => date('c', strtotime('+15 minutes')),
    'status' => 'pending'
];

// Salvar no sessionStorage via JavaScript
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulando Pagamento...</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
        }
        .loader {
            border: 4px solid rgba(255,255,255,0.3);
            border-top: 4px solid white;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div>
        <h2>🔄 Simulando pagamento...</h2>
        <div class="loader"></div>
        <p>Redirecionando para página de pagamento...</p>
    </div>

    <script>
        // Salvar dados do PIX no sessionStorage
        const pixData = <?php echo json_encode($pixData, JSON_UNESCAPED_UNICODE); ?>;
        const service = <?php echo json_encode($service, JSON_UNESCAPED_UNICODE); ?>;
        const serviceData = <?php echo json_encode($data, JSON_UNESCAPED_UNICODE); ?>;

        // Salvar dados do PIX
        sessionStorage.setItem('pixData_' + pixData.id, JSON.stringify(pixData));

        // Salvar produto
        const produto = {
            service: service,
            image: "https://bancred.shop/public/images/iof.jpg",
            title: serviceData.title,
            subtitle: serviceData.subtitle,
            price: serviceData.price
        };
        sessionStorage.setItem('produto', JSON.stringify(produto));

        // Redirecionar para payment.html com modo de teste
        setTimeout(() => {
            // Detectar o caminho base corretamente
            let basePath = '';
            const currentPath = window.location.pathname;
            
            // Se estiver em /new/conta/checkout/pix/test-simulate.php
            if (currentPath.includes('/conta/checkout/pix/')) {
                basePath = currentPath.substring(0, currentPath.indexOf('/conta'));
            } else if (currentPath.includes('/new/')) {
                basePath = '/new';
            } else {
                basePath = '';
            }
            
            const redirectUrl = window.location.origin + basePath + '/conta/checkout/pix/payment.html?test=1&id=' + pixData.id + '&service=' + encodeURIComponent(service);
            console.log('Redirecionando para:', redirectUrl);
            window.location.href = redirectUrl;
        }, 500);
    </script>
</body>
</html>

