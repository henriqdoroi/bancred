<?php
/**
 * Webhook para receber notificações de pagamento PIX do BlackcatPay
 * Endpoint: /webhook/pix.php
 * 
 * Valida assinatura HMAC SHA256 e processa notificações de status
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, x-signature');

// Configurações de erro (desabilitar em produção)
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Log de erros
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/pix_errors.log');

// Verificar método
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido']);
    exit;
}

// Configurações
$webhookSecret = "sk_JRTtazAeeNeM-G90uX8elpvqqb0pP7LmPczcUMRrIjD5DJ6S"; // BLACKCAT_WEBHOOK_SECRET

// Ler corpo bruto da requisição (importante para validação HMAC)
$rawBody = file_get_contents('php://input');

// Obter assinatura do header
$signature = isset($_SERVER['HTTP_X_SIGNATURE']) ? $_SERVER['HTTP_X_SIGNATURE'] : '';

if (empty($signature)) {
    error_log("ERRO WEBHOOK: Header x-signature não encontrado");
    http_response_code(401);
    echo json_encode(['error' => 'Assinatura não fornecida']);
    exit;
}

// Gerar hash esperado usando HMAC SHA256
$expectedSignature = hash_hmac('sha256', $rawBody, $webhookSecret);

// Comparar assinaturas de forma segura (timing-safe)
if (!hash_equals($expectedSignature, $signature)) {
    error_log("ERRO WEBHOOK: Assinatura inválida");
    error_log("Esperado: " . $expectedSignature);
    error_log("Recebido: " . $signature);
    error_log("Body: " . substr($rawBody, 0, 200));
    http_response_code(401);
    echo json_encode(['error' => 'Assinatura inválida']);
    exit;
}

// Assinatura válida, processar webhook
try {
    // Decodificar JSON do corpo
    $data = json_decode($rawBody, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log("ERRO WEBHOOK: JSON inválido - " . json_last_error_msg());
        http_response_code(400);
        echo json_encode(['error' => 'JSON inválido']);
        exit;
    }
    
    // Log do webhook recebido
    error_log("=== WEBHOOK RECEBIDO ===");
    error_log("Dados: " . print_r($data, true));
    
    // Validar campos obrigatórios
    if (!isset($data['id']) || !isset($data['status'])) {
        error_log("ERRO WEBHOOK: Campos obrigatórios faltando");
        http_response_code(400);
        echo json_encode(['error' => 'Campos obrigatórios faltando']);
        exit;
    }
    
    $transactionId = $data['id'];
    $status = strtolower($data['status']);
    $amount = isset($data['amount']) ? $data['amount'] : null;
    $paymentMethod = isset($data['payment_method']) ? $data['payment_method'] : null;
    
    // Log do status
    error_log("Transaction ID: " . $transactionId);
    error_log("Status: " . $status);
    error_log("Amount: " . $amount);
    error_log("Payment Method: " . $paymentMethod);
    
    // Processar conforme status
    switch ($status) {
        case 'paid':
            // Pagamento confirmado
            error_log("✅ PAGAMENTO CONFIRMADO - Transaction ID: " . $transactionId);
            
            // Extrair dados do PIX se disponível
            $pixData = isset($data['pix']) ? $data['pix'] : null;
            $endToEndId = isset($pixData['end_to_end_id']) ? $pixData['end_to_end_id'] : null;
            $payer = isset($pixData['payer']) ? $pixData['payer'] : null;
            $paidAt = isset($pixData['paid_at']) ? $pixData['paid_at'] : date('Y-m-d H:i:s');
            
            error_log("End to End ID: " . $endToEndId);
            error_log("Payer: " . $payer);
            error_log("Paid At: " . $paidAt);
            
            // TODO: Atualizar no banco de dados
            // updateTransactionPaid($transactionId, [
            //     'status' => 'paid',
            //     'end_to_end_id' => $endToEndId,
            //     'payer' => $payer,
            //     'paid_at' => $paidAt
            // ]);
            
            break;
            
        case 'waiting_payment':
            error_log("⏳ AGUARDANDO PAGAMENTO - Transaction ID: " . $transactionId);
            // TODO: Atualizar status no banco
            // updateTransactionStatus($transactionId, 'waiting_payment');
            break;
            
        case 'refused':
            error_log("❌ PAGAMENTO REJEITADO - Transaction ID: " . $transactionId);
            // TODO: Atualizar status no banco
            // updateTransactionStatus($transactionId, 'refused');
            break;
            
        case 'refunded':
            error_log("↩️ PAGAMENTO ESTORNADO - Transaction ID: " . $transactionId);
            // TODO: Atualizar status no banco
            // updateTransactionStatus($transactionId, 'refunded');
            break;
            
        default:
            error_log("⚠️ STATUS DESCONHECIDO: " . $status . " - Transaction ID: " . $transactionId);
            break;
    }
    
    // Responder com sucesso
    http_response_code(200);
    echo json_encode(['status' => 'ok', 'message' => 'Webhook processado com sucesso']);
    
} catch (Exception $e) {
    error_log("ERRO WEBHOOK: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao processar webhook']);
}


