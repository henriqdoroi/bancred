<?php
/**
 * Script de teste para verificar se a API PIX está retornando 200
 * Acesse: http://localhost/new/consulta/testar-api-pix.php
 */

header('Content-Type: text/html; charset=utf-8');

echo "<!DOCTYPE html>
<html>
<head>
    <title>Teste API PIX - BlackcatPagamentos</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #333; }
        .test-section { margin: 20px 0; padding: 15px; background: #f9f9f9; border-left: 4px solid #4CAF50; }
        .error { border-left-color: #f44336; background: #ffebee; }
        .success { border-left-color: #4CAF50; background: #e8f5e9; }
        .info { border-left-color: #2196F3; background: #e3f2fd; }
        pre { background: #263238; color: #aed581; padding: 15px; border-radius: 4px; overflow-x: auto; }
        .status { display: inline-block; padding: 5px 10px; border-radius: 4px; font-weight: bold; }
        .status-200 { background: #4CAF50; color: white; }
        .status-error { background: #f44336; color: white; }
        button { background: #2196F3; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-size: 16px; }
        button:hover { background: #1976D2; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🧪 Teste API PIX - BlackcatPagamentos</h1>";

// Configurações
$apiUrl = "https://api.blackcatpagamentos.com/v1/transactions";
$publicKey = "pk_jkAfOdmjxZjavwow647hjIEu7-MFsAyOXPMp0E0XgAUz3NJU";
$secretKey = "sk_JRTtazAeeNeM-G90uX8elpvqqb0pP7LmPczcUMRrIjD5DJ6S";

// Dados padrões
$customerName = "Bancred";
$customerDocument = "12095582462";
$customerEmail = "bancred@gmail.com";
$customerPhone = "11956472565";

// Valor de teste (R$ 1,00 = 100 centavos)
$valorTeste = 1.00;
$amountInCents = 100;

echo "<div class='test-section info'>
    <h2>📋 Configuração do Teste</h2>
    <p><strong>URL:</strong> $apiUrl</p>
    <p><strong>Valor de teste:</strong> R$ " . number_format($valorTeste, 2, ',', '.') . " ($amountInCents centavos)</p>
    <p><strong>Customer:</strong> $customerName | $customerDocument | $customerEmail | $customerPhone</p>
</div>";

// Montar payload (com campo items obrigatório)
$payload = [
    "amount" => $amountInCents,
    "paymentMethod" => "pix",
    "customer" => [
        "name" => $customerName,
        "document" => [
            "type" => "cpf",
            "number" => $customerDocument
        ],
        "email" => $customerEmail,
        "phone" => $customerPhone
    ],
    "items" => [
        [
            "title" => "Pagamento PIX",
            "quantity" => 1,
            "tangible" => false,
            "unitPrice" => $amountInCents
        ]
    ]
];

echo "<div class='test-section info'>
    <h2>📤 Payload que será enviado</h2>
    <pre>" . json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "</pre>
</div>";

// Criar autenticação Basic
$authString = base64_encode($publicKey . ':' . $secretKey);
$authHeader = 'Basic ' . $authString;

echo "<div class='test-section info'>
    <h2>🔐 Autenticação</h2>
    <p><strong>Método:</strong> Basic Access Authentication</p>
    <p><strong>Header:</strong> Authorization: Basic " . substr($authString, 0, 30) . "...</p>
</div>";

// Fazer requisição
echo "<div class='test-section'>
    <h2>🚀 Enviando Requisição...</h2>";

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: ' . $authHeader
]);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
$curlErrno = curl_errno($ch);
curl_close($ch);

// Exibir resultado
if ($response === false || !empty($curlError)) {
    echo "<div class='test-section error'>
        <h2>❌ Erro de Conexão</h2>
        <p><strong>Erro cURL:</strong> $curlError</p>
        <p><strong>Código:</strong> $curlErrno</p>
        <p><strong>HTTP Code:</strong> $httpCode</p>
    </div>";
} else {
    $statusClass = ($httpCode == 200 || $httpCode == 201) ? 'success' : 'error';
    $statusBadge = ($httpCode == 200 || $httpCode == 201) ? 'status-200' : 'status-error';
    
    echo "<div class='test-section $statusClass'>
        <h2>📥 Resposta da API</h2>
        <p><strong>Status HTTP:</strong> <span class='status $statusBadge'>$httpCode</span></p>";
    
    if ($httpCode == 200 || $httpCode == 201) {
        echo "<p style='color: #4CAF50; font-weight: bold;'>✅ SUCESSO! A API retornou $httpCode</p>";
    } else {
        echo "<p style='color: #f44336; font-weight: bold;'>❌ ERRO! A API retornou $httpCode</p>";
    }
    
    echo "<h3>Resposta Completa:</h3>
        <pre>" . htmlspecialchars($response) . "</pre>";
    
    // Tentar decodificar JSON
    $jsonResponse = json_decode($response, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        echo "<h3>Resposta Decodificada (JSON):</h3>
            <pre>" . htmlspecialchars(json_encode($jsonResponse, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) . "</pre>";
        
        // Verificar se tem dados PIX
        if (isset($jsonResponse['data']['pix']['qrcode'])) {
            $qrcode = $jsonResponse['data']['pix']['qrcode'];
            echo "<div class='test-section success'>
                <h3>✅ Código PIX Encontrado!</h3>
                <p><strong>QR Code (primeiros 50 chars):</strong> " . substr($qrcode, 0, 50) . "...</p>
                <p><strong>Tamanho total:</strong> " . strlen($qrcode) . " caracteres</p>
            </div>";
        }
        
        if (isset($jsonResponse['data']['id'])) {
            echo "<div class='test-section success'>
                <h3>✅ Transaction ID Encontrado!</h3>
                <p><strong>ID:</strong> " . $jsonResponse['data']['id'] . "</p>
            </div>";
        }
    } else {
        echo "<p style='color: #f44336;'>⚠️ Resposta não é um JSON válido</p>";
        echo "<p><strong>Erro JSON:</strong> " . json_last_error_msg() . "</p>";
    }
    
    echo "</div>";
}

echo "<div class='test-section'>
    <h2>🔄 Testar Novamente</h2>
    <button onclick='location.reload()'>🔄 Executar Teste Novamente</button>
</div>";

echo "</div></body></html>";
?>

