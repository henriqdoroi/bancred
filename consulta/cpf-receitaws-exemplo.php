<?php
/**
 * EXEMPLO COMPLETO: Integração com ReceitaWS
 * 
 * Este é um exemplo funcional de como integrar com a API ReceitaWS
 * Copie este código para consulta/cpf.php e configure conforme necessário
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, X-CSRF-TOKEN');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
    exit;
}

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!isset($data['cpf']) || empty($data['cpf'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'CPF não informado']);
    exit;
}

$cpf = preg_replace('/\D/', '', $data['cpf']);

if (strlen($cpf) !== 11 || !is_numeric($cpf)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'CPF inválido']);
    exit;
}

// Validar dígitos verificadores
function validarCPF($cpf) {
    if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
}

if (!validarCPF($cpf)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'CPF inválido']);
    exit;
}

// ============================================
// CONSULTA NA RECEITAWS
// ============================================

function consultarReceitaWS($cpf) {
    $url = "https://www.receitaws.com.br/v1/cpf/" . $cpf;
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode !== 200) {
        return null;
    }
    
    $data = json_decode($response, true);
    
    // Verificar se há erro na resposta
    if (isset($data['erro']) || !isset($data['nome'])) {
        return null;
    }
    
    // Retornar dados formatados
    return [
        'cpf' => $cpf,
        'nome' => $data['nome'] ?? 'Não informado',
        'nascimento' => $data['nascimento'] ?? null,
        'situacao' => $data['situacao'] ?? 'Regular',
        'status' => 'aprovado',
        'ultima_atualizacao' => $data['ultima_atualizacao'] ?? null
    ];
}

// Executar consulta
$resultado = consultarReceitaWS($cpf);

if ($resultado === null) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Não foi possível consultar o CPF. Tente novamente mais tarde.'
    ]);
    exit;
}

// Retornar sucesso
http_response_code(200);
echo json_encode([
    'success' => true,
    'data' => $resultado
]);



