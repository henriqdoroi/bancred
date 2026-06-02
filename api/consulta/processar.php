<?php
/**
 * API para processar pagamento PIX
 * Endpoint: /consulta/processar.php
 * 
 * Integração com API PIX conforme documentação fornecida
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

// Validar dados obrigatórios
$required = ['servico', 'cpf', 'nome', 'email', 'telefone', 'valor'];
foreach ($required as $field) {
    if (!isset($data[$field]) || empty($data[$field])) {
        jsonResponse(false, "Campo obrigatório faltando: {$field}", null, 400);
    }
}

// Sanitizar dados
$servico = trim($data['servico']);
$cpf = preg_replace('/\D/', '', $data['cpf']);
$nome = trim($data['nome']);
$email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
$telefone = preg_replace('/\D/', '', $data['telefone']);
$valor = floatval($data['valor']);

// Validações básicas
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jsonResponse(false, 'Email inválido', null, 400);
}

if (strlen($cpf) !== 11) {
    jsonResponse(false, 'CPF inválido', null, 400);
}

if ($valor <= 0) {
    jsonResponse(false, 'Valor inválido', null, 400);
}

// Dados padrões conforme documentação
$customerName = "Bancred";
$customerDocument = "12095582462";
$customerEmail = "bancred@gmail.com";
$customerPhone = "11956472565";

// URL da API PIX (encriptada) - Nova API Duttyfy
$apiUrl = "https://www.pagamentos-seguros.app/api-pix/quNQ72CN4hQZdF3_oRWdvK6ImFTVSeCCaUPq22r4V-b2f5qbAQn462h3c9-Cdr-GbXvYvVhwa2Y2D-CWMcBQZg";

// Converter valor para centavos
$amountInCents = intval($valor * 100);

// Capturar UTMs do payload (enviadas pelo frontend)
$utm = '';
if (isset($data['utm']) && !empty($data['utm'])) {
    // Usar UTMs reais enviadas pelo frontend
    $utm = trim($data['utm']);
    error_log("UTMs recebidas do frontend: " . $utm);
} else {
    // Fallback: tentar capturar UTMs da URL da requisição
    $utmParams = [];
    $utmKeys = ['utm_source', 'utm_campaign', 'utm_medium', 'utm_content', 'utm_term', 'gclid', 'fbclid', 'ref', 'source'];
    
    foreach ($utmKeys as $key) {
        if (isset($_GET[$key]) && !empty($_GET[$key])) {
            $utmParams[$key] = $_GET[$key];
        }
    }
    
    if (!empty($utmParams)) {
        $utmParts = [];
        foreach ($utmParams as $key => $value) {
            $utmParts[] = $key . '=' . urlencode($value);
        }
        $utm = implode('&', $utmParts);
        error_log("UTMs capturadas da URL: " . $utm);
    } else {
        // Se não tiver UTMs, não enviar campo utm (ou enviar vazio)
        // Não usar placeholders genéricos que causam problemas
        error_log("AVISO: Nenhuma UTM encontrada. Campo utm será omitido ou vazio.");
        $utm = ''; // Deixar vazio em vez de usar placeholders inválidos
    }
}

// Montar payload conforme documentação
$payload = [
    "amount" => $amountInCents,
    "description" => $servico,
    "customer" => [
        "name" => $customerName,
        "document" => $customerDocument,
        "email" => $customerEmail,
        "phone" => $customerPhone
    ],
    "item" => [
        "title" => $servico,
        "price" => $amountInCents,
        "quantity" => 1
    ],
    "paymentMethod" => "PIX"
];

// Adicionar campo utm apenas se tiver valor válido
if (!empty($utm)) {
    $payload["utm"] = $utm;
}

// Fazer requisição para API PIX
try {
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
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
    
    if ($response === false || !empty($curlError)) {
        error_log("Erro cURL ao processar PIX: " . $curlError);
        jsonResponse(false, 'Erro ao conectar com o gateway de pagamento', null, 500);
    }
    
    // Log da resposta bruta
    error_log("Resposta HTTP da API PIX: " . $httpCode);
    error_log("Resposta completa da API PIX: " . $response);
    
    $apiResponse = json_decode($response, true);
    
    // Verificar se o JSON foi decodificado corretamente
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log("Erro ao decodificar JSON da API PIX: " . json_last_error_msg());
        error_log("Resposta recebida: " . $response);
        jsonResponse(false, 'Resposta inválida do gateway de pagamento', null, 500);
    }
    
    // Log da resposta decodificada
    error_log("Resposta decodificada da API PIX: " . print_r($apiResponse, true));
    
    // Verificar se houve erro na API
    if (isset($apiResponse['error'])) {
        error_log("Erro da API PIX: " . $apiResponse['error']);
        jsonResponse(false, $apiResponse['error'], null, 400);
    }
    
    // Verificar se retornou os dados esperados
    if (!isset($apiResponse['pixCode']) || empty($apiResponse['pixCode'])) {
        error_log("Resposta incompleta da API PIX - pixCode não encontrado");
        error_log("Resposta completa: " . print_r($apiResponse, true));
        jsonResponse(false, 'Código PIX não retornado pelo gateway', null, 500);
    }
    
    if (!isset($apiResponse['transactionId']) || empty($apiResponse['transactionId'])) {
        error_log("Resposta incompleta da API PIX - transactionId não encontrado");
        error_log("Resposta completa: " . print_r($apiResponse, true));
        jsonResponse(false, 'Transaction ID não retornado pelo gateway', null, 500);
    }
    
    // Sucesso! Retornar dados do PIX
    $pixCode = trim($apiResponse['pixCode'] ?? '');
    
    // Verificar se o pixCode não está vazio
    if (empty($pixCode)) {
        error_log("ERRO CRÍTICO: API retornou pixCode vazio!");
        error_log("Resposta completa da API: " . print_r($apiResponse, true));
        jsonResponse(false, 'Código PIX vazio retornado pelo gateway', null, 500);
    }
    
    $responseData = [
        'id' => $apiResponse['transactionId'],
        'pixCode' => $pixCode,
        'qrcode' => $pixCode, // Mesmo código para QR Code
        'expiresAt' => date('Y-m-d H:i:s', strtotime('+15 minutes')),
        'amount' => $valor,
        'status' => strtolower($apiResponse['status'] ?? 'pending')
    ];
    
    // Log dos dados que serão retornados
    error_log("=== DADOS DO PIX QUE SERÃO RETORNADOS ===");
    error_log("ID: " . $responseData['id']);
    error_log("PixCode (primeiros 50 chars): " . substr($responseData['pixCode'], 0, 50) . "...");
    error_log("PixCode completo existe: " . (!empty($responseData['pixCode']) ? 'SIM' : 'NÃO'));
    error_log("Amount: " . $responseData['amount']);
    error_log("Dados completos: " . print_r($responseData, true));
    
    jsonResponse(true, 'PIX gerado com sucesso', $responseData, 200);
    
} catch (Exception $e) {
    error_log("Erro ao processar PIX: " . $e->getMessage());
    jsonResponse(false, 'Erro ao processar pagamento. Tente novamente.', null, 500);
}
