<?php
/**
 * API para confirmar status de pagamento PIX
 * Endpoint: /consulta/confirmar.php
 * 
 * Verifica status da transação PIX no gateway Duttyfy
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, X-CSRF-TOKEN');

// Configurações de erro (desabilitar em produção)
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Log de erros
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/pix_errors.log');

/**
 * Resposta JSON padronizada
 */
function jsonResponse($success, $message = '', $data = null, $httpCode = 200) {
    http_response_code($httpCode);
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// Verificar método
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Método não permitido', null, 405);
}

// Ler dados do POST
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Se não for JSON, tentar $_POST
if (json_last_error() !== JSON_ERROR_NONE) {
    $data = $_POST;
}

// Validar transactionId
if (!isset($data['transactionId']) || empty($data['transactionId'])) {
    jsonResponse(false, 'Transaction ID não fornecido', null, 400);
}

$transactionId = trim($data['transactionId']);

// URL da API PIX Duttyfy (mesmo endpoint com transactionId como query param)
$apiUrl = "https://www.pagamentos-seguros.app/api-pix/quNQ72CN4hQZdF3_oRWdvK6ImFTVSeCCaUPq22r4V-b2f5qbAQn462h3c9-Cdr-GbXvYvVhwa2Y2D-CWMcBQZg?transactionId=" . urlencode($transactionId);

// Log da requisição
error_log("=== VERIFICAÇÃO STATUS PIX DUTTYFY ===");
error_log("Transaction ID: " . $transactionId);
error_log("URL: " . $apiUrl);

// Fazer requisição GET para verificar status
try {
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);
    
    error_log("HTTP Code: " . $httpCode);
    error_log("Response: " . $response);
    
    if ($response === false || !empty($curlError)) {
        error_log("Erro cURL ao verificar status PIX: " . $curlError);
        jsonResponse(false, 'Erro ao conectar com o gateway de pagamento', null, 500);
    }
    
    // Verificar código HTTP
    if ($httpCode === 404) {
        error_log("Erro 404: Transação não encontrada para ID: " . $transactionId);
        jsonResponse(false, 'Transação não encontrada', null, 404);
    }
    
    if ($httpCode === 401) {
        error_log("Erro 401: Chave API inválida ou expirada ao verificar status");
        jsonResponse(false, 'Chave API inválida ou expirada', null, 401);
    }
    
    $apiResponse = json_decode($response, true);
    
    // Verificar se o JSON foi decodificado corretamente
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log("Erro ao decodificar JSON da API: " . json_last_error_msg());
        error_log("Resposta recebida: " . $response);
        jsonResponse(false, 'Resposta inválida do gateway de pagamento', null, 500);
    }
    
    error_log("Resposta decodificada: " . print_r($apiResponse, true));
    
    // Verificar se houve erro na API
    if (isset($apiResponse['error'])) {
        error_log("Erro da API: " . $apiResponse['error']);
        jsonResponse(false, $apiResponse['error'], null, 400);
    }
    
    // Obter status da transação
    $status = strtolower($apiResponse['status'] ?? 'pending');
    
    error_log("Status da transação: " . $status);
    
    // Mapear status para o formato esperado pelo frontend
    $mappedStatus = 'pending';
    $isPaid = false;
    
    if ($status === 'paid' || $status === 'approved' || $status === 'completed') {
        $mappedStatus = 'paid';
        $isPaid = true;
    } elseif ($status === 'pending' || $status === 'waiting_payment' || $status === 'processing') {
        $mappedStatus = 'pending';
    } elseif ($status === 'refused' || $status === 'refunded' || $status === 'failed' || $status === 'cancelled') {
        $mappedStatus = 'failed';
    }
    
    // Se pagamento confirmado
    if ($isPaid) {
        error_log("✅ Pagamento CONFIRMADO!");
        jsonResponse(true, 'Pagamento confirmado', [
            'status' => 'paid',
            'transactionId' => $transactionId,
            'id' => $apiResponse['transactionId'] ?? $transactionId,
            'paidAt' => $apiResponse['paidAt'] ?? date('Y-m-d H:i:s')
        ], 200);
    }
    
    // Se ainda pendente
    if ($mappedStatus === 'pending') {
        error_log("⏳ Pagamento PENDENTE");
        jsonResponse(false, 'Pagamento pendente', [
            'status' => 'pending',
            'transactionId' => $transactionId,
            'id' => $apiResponse['transactionId'] ?? $transactionId
        ], 200);
    }
    
    // Outros status (falha, cancelado, etc.)
    error_log("❌ Pagamento com status: " . $status);
    jsonResponse(false, 'Status: ' . $status, [
        'status' => $mappedStatus,
        'transactionId' => $transactionId,
        'id' => $apiResponse['transactionId'] ?? $transactionId,
        'original_status' => $status
    ], 200);
    
} catch (Exception $e) {
    error_log("Erro ao verificar status PIX: " . $e->getMessage());
    jsonResponse(false, 'Erro ao verificar status do pagamento', null, 500);
}
