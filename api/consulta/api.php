<?php
// Configurar headers para sempre retornar JSON
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Função para retornar erro em JSON
function returnError($message, $code = 400) {
    http_response_code($code);
    echo json_encode(['error' => $message, 'success' => false]);
    exit;
}

// Função para log de erros
function logError($message) {
    error_log(date('Y-m-d H:i:s') . " - API Error: " . $message . "\n", 3, "api_errors.log");
}

// Responder a requisições OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    echo json_encode(['success' => true]);
    exit;
}

// Verificar se é uma requisição GET ou POST
if (!in_array($_SERVER['REQUEST_METHOD'], ['GET', 'POST'])) {
    returnError('Método não permitido', 405);
}

// Obter CPF da requisição
$cpf = '';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $cpf = $_GET['cpf'] ?? '';
} else {
    // Lê o corpo da requisição para POST (JSON ou form-urlencoded)
    $input = file_get_contents('php://input');
    
    // Tenta decodificar como JSON primeiro (formato esperado pelo frontend)
    $jsonData = json_decode($input, true);
    if ($jsonData !== null && isset($jsonData['cpf'])) {
        $cpf = $jsonData['cpf'];
    } else {
        // Fallback: tenta como form-urlencoded
        $postData = [];
        parse_str($input, $postData);
        if (isset($postData['cpf'])) {
            $cpf = $postData['cpf'];
        } else if (isset($_POST['cpf'])) {
            $cpf = $_POST['cpf'];
        }
    }
}

// Log para debug
error_log("Requisição recebida - INPUT: " . $input);
error_log("POST data: " . print_r($_POST, true));
error_log("CPF recebido: " . $cpf);

// Verifica se o CPF foi enviado
if (empty($cpf)) {
    returnError('CPF é obrigatório');
}

// Remove caracteres não numéricos do CPF
$cpf = preg_replace('/[^0-9]/', '', $cpf);

// Verifica se o CPF tem 11 dígitos
if (strlen($cpf) !== 11) {
    http_response_code(400);
    echo json_encode(['status' => 400, 'message' => 'CPF inválido']);
    exit;
}

// Token da API (você deve fornecer o token correto)
$token = '1835';

// URL da API externa
$apiUrl = "https://searchapi.dnnl.live/consulta?token_api={$token}&cpf={$cpf}";

// Configuração do contexto para a requisição
$context = stream_context_create([
    'http' => [
        'ignore_errors' => true
    ]
]);

// Faz a requisição para a API externa
$response = @file_get_contents($apiUrl, false, $context);

// Log da resposta para debug
if ($response !== false) {
    error_log("Resposta da API externa: " . substr($response, 0, 500) . "...");
} else {
    logError("Falha na requisição para API externa: " . $apiUrl);
}

// Verifica se a requisição foi bem sucedida
if ($response === false) {
    $error = error_get_last();
    logError("Erro na requisição: " . ($error['message'] ?? 'Erro desconhecido'));
    returnError('Erro ao consultar a API externa. Tente novamente em alguns minutos.', 500);
}

// Verifica se a resposta está vazia
if (empty($response)) {
    logError("Resposta vazia da API externa");
    returnError('API externa retornou resposta vazia', 500);
}

// Verifica se a resposta é um JSON válido
$decodedResponse = json_decode($response, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    logError("JSON inválido: " . json_last_error_msg() . " - Resposta: " . substr($response, 0, 200));
    returnError('Resposta inválida da API externa', 500);
}

// Verificar se há dados válidos
if (!isset($decodedResponse) || !is_array($decodedResponse)) {
    logError("Estrutura de dados inválida na resposta");
    returnError('Dados inválidos retornados pela API', 500);
}

// Mapear dados da API externa para o formato esperado pelo frontend
// A API externa pode retornar diferentes estruturas, então vamos normalizar
$dadosFormatados = [
    'cpf' => $cpf,
    'nome' => $decodedResponse['nome'] ?? $decodedResponse['NOME'] ?? $decodedResponse['name'] ?? 'Não informado',
    'nascimento' => $decodedResponse['nascimento'] ?? $decodedResponse['NASCIMENTO'] ?? $decodedResponse['birthdate'] ?? null,
    'situacao' => $decodedResponse['situacao'] ?? $decodedResponse['SITUACAO'] ?? $decodedResponse['status'] ?? 'Regular',
    'status' => 'aprovado', // Status padrão para o fluxo
    'fonte' => 'API Externa',
    'dados_completos' => $decodedResponse // Manter dados completos para referência
];

// Log de sucesso
error_log("API consultada com sucesso para CPF: " . $cpf);

// Retornar no formato esperado pelo frontend
http_response_code(200);
echo json_encode([
    'success' => true,
    'data' => $dadosFormatados
]);
exit;
