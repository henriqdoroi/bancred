<?php
/**
 * API de Consulta de CPF
 * Endpoint: /consulta/cpf
 * Método: POST
 * 
 * ✅ RECEITAWS CONFIGURADA E ATIVA
 * 
 * Esta API consulta CPF usando a ReceitaWS (gratuita)
 * Limitação: Máximo 3 consultas por minuto por IP
 * 
 * Para usar outras APIs, veja as funções comentadas abaixo
 */

// Ativar exibição de erros para debug (remover em produção)
error_reporting(E_ALL);
ini_set('display_errors', 0); // Não mostrar erros na tela, só nos logs
ini_set('log_errors', 1);

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, X-CSRF-TOKEN');

// Tratar requisições OPTIONS (CORS preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Apenas aceita POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
    exit;
}

// Ler dados do corpo da requisição
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Validar CPF recebido
if (!isset($data['cpf']) || empty($data['cpf'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'CPF não informado']);
    exit;
}

$cpf = preg_replace('/\D/', '', $data['cpf']);

// Validar formato do CPF
if (strlen($cpf) !== 11 || !is_numeric($cpf)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'CPF inválido']);
    exit;
}

// Validar dígitos verificadores do CPF
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
// CONFIGURAÇÃO: Integração com API Real
// ============================================
// Você precisa configurar uma das opções abaixo:

// OPÇÃO 1: Usar ReceitaWS (Gratuita, mas limitada)
// ⚠️ LIMITAÇÃO: Máximo de 3 consultas por minuto por IP
function consultarReceitaWS($cpf) {
    $url = "https://www.receitaws.com.br/v1/cpf/" . $cpf;
    
    // Inicializar cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    
    // Executar requisição
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);
    
    // Verificar erros de conexão
    if ($response === false || !empty($curlError)) {
        error_log("Erro ao consultar ReceitaWS: " . $curlError);
        return null;
    }
    
    // Se não conseguiu conectar (httpCode = 0)
    if ($httpCode == 0) {
        error_log("ReceitaWS: Não foi possível conectar (httpCode = 0)");
        return null;
    }
    
    // Decodificar resposta JSON (mesmo se não for 200)
    $data = json_decode($response, true);
    
    // Se não conseguiu decodificar JSON
    if ($data === null && $httpCode != 200) {
        error_log("ReceitaWS: Resposta não é JSON válido. HTTP: " . $httpCode);
        return null;
    }
    
    // Verificar código HTTP e tratar diferentes casos
    if ($httpCode == 200) {
        // Sucesso - verificar se tem dados válidos
        if (isset($data['erro']) || !isset($data['nome'])) {
            error_log("ReceitaWS retornou erro: " . ($data['erro'] ?? 'Dados incompletos'));
            return null;
        }
        
        // Retornar dados formatados
        return [
            'cpf' => $cpf,
            'nome' => $data['nome'] ?? 'Não informado',
            'nascimento' => $data['nascimento'] ?? null,
            'situacao' => $data['situacao'] ?? 'Regular',
            'status' => 'aprovado',
            'ultima_atualizacao' => $data['ultima_atualizacao'] ?? null,
            'fonte' => 'ReceitaWS'
        ];
    } else if ($httpCode == 404) {
        // CPF não encontrado na base da ReceitaWS
        // Isso é normal - nem todos os CPFs estão na base
        error_log("ReceitaWS: CPF não encontrado (404) - CPF: " . $cpf);
        return null;
    } else if ($httpCode == 429) {
        // Limite de requisições excedido (3 por minuto)
        error_log("ReceitaWS: Limite excedido (429) - Aguarde 1 minuto");
        return null;
    } else if ($httpCode > 0) {
        // Outro erro HTTP
        error_log("ReceitaWS retornou código HTTP: " . $httpCode . " - Resposta: " . substr($response, 0, 200));
        return null;
    } else {
        // Erro de conexão (httpCode = 0)
        error_log("ReceitaWS: Erro de conexão (httpCode = 0)");
        return null;
    }
}

// OPÇÃO 2: Usar Serasa API (Paga, mas completa)
function consultarSerasa($cpf) {
    // Configure com suas credenciais da Serasa
    /*
    $apiKey = 'SUA_API_KEY_AQUI';
    $url = "https://api.serasa.com.br/consulta/cpf";
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['cpf' => $cpf]));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true);
    */
    return null;
}

// OPÇÃO 3: Usar sua própria base de dados
function consultarBancoDados($cpf) {
    // Configure sua conexão com banco de dados
    /*
    $host = 'localhost';
    $dbname = 'seu_banco';
    $username = 'seu_usuario';
    $password = 'sua_senha';
    
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE cpf = ?");
        $stmt->execute([$cpf]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($usuario) {
            return [
                'cpf' => $cpf,
                'nome' => $usuario['nome'],
                'email' => $usuario['email'],
                'status' => $usuario['status']
            ];
        }
    } catch (PDOException $e) {
        error_log("Erro ao consultar banco: " . $e->getMessage());
    }
    */
    return null;
}

// ============================================
// EXECUTAR CONSULTA - RECEITAWS ATIVADA
// ============================================

try {
    $resultado = consultarReceitaWS($cpf);
    
    // Se a consulta falhar, vamos tentar uma abordagem alternativa
    if ($resultado === null) {
        // MODO DESENVOLVIMENTO: Retornar dados simulados quando ReceitaWS falhar
        // Isso permite testar o fluxo completo mesmo sem a API funcionar
        // Em produção, você pode remover isso ou manter como fallback
        
        $resultado = [
            'cpf' => $cpf,
            'nome' => 'Dados não disponíveis',
            'nascimento' => null,
            'situacao' => 'Consulta não disponível',
            'status' => 'pendente',
            'fonte' => 'fallback',
            'observacao' => 'ReceitaWS não retornou dados. CPF validado, mas dados não encontrados na base.'
        ];
        
        // Se você quiser retornar erro em vez de dados simulados, descomente abaixo:
        /*
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Não foi possível consultar o CPF no momento. A API pode estar temporariamente indisponível ou você excedeu o limite de consultas (3 por minuto). Tente novamente em alguns instantes.'
        ]);
        exit;
        */
    }
    
    // Retornar resposta de sucesso
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'data' => $resultado
    ]);
    
} catch (Exception $e) {
    // Capturar qualquer erro não tratado
    error_log("Erro na API CPF: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Erro interno do servidor. Verifique os logs do PHP.',
        'debug' => $e->getMessage() // Remover em produção
    ]);
    exit;
}

