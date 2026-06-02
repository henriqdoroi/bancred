<?php
/**
 * Endpoint de teste para simular confirmação de pagamento PIX
 * Funciona apenas no localhost
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET');
header('Access-Control-Allow-Headers: Content-Type');

// Verificar se está no localhost
$isLocalhost = in_array($_SERVER['HTTP_HOST'], ['localhost', '127.0.0.1']) || 
               strpos($_SERVER['HTTP_HOST'], 'localhost:') !== false;

if (!$isLocalhost) {
    http_response_code(403);
    echo json_encode([
        'success' => false,
        'message' => 'Este endpoint só funciona no localhost'
    ]);
    exit;
}

// Ler dados da requisição
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Se não tiver dados JSON, tentar GET
if (!$data && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $transactionId = isset($_GET['transactionId']) ? $_GET['transactionId'] : null;
} else {
    $transactionId = isset($data['transactionId']) ? $data['transactionId'] : null;
}

// Se o ID começar com "test-", simular pagamento confirmado
if ($transactionId && strpos($transactionId, 'test-') === 0) {
    echo json_encode([
        'success' => true,
        'message' => 'Pagamento simulado confirmado (modo teste)',
        'data' => [
            'id' => $transactionId,
            'status' => 'paid',
            'paid_at' => date('Y-m-d H:i:s'),
            'amount' => 21.00
        ]
    ]);
} else {
    // Para IDs reais, retornar como pendente (não simular)
    echo json_encode([
        'success' => true,
        'message' => 'Pagamento ainda pendente',
        'data' => [
            'id' => $transactionId,
            'status' => 'pending'
        ]
    ]);
}

