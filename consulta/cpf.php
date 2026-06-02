<?php
/**
 * API de Consulta de CPF
 * Endpoint: /consulta/cpf.php
 * Método: POST
 * 
 * ✅ INTEGRADO COM API EXTERNA (searchapi.dnnl.live)
 * 
 * Esta API consulta CPF usando a API externa fornecida
 * Token: 1835
 */

// Configurar headers para sempre retornar JSON
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, X-CSRF-TOKEN");

// Função para retornar erro em JSON
function returnError($message, $code = 400) {
    http_response_code($code);
    echo json_encode(['success' => false, 'message' => $message]);
    exit;
}

// Função para log de erros
function logError($message) {
    error_log(date('Y-m-d H:i:s') . " - API CPF Error: " . $message . "\n", 3, "api_errors.log");
}

// Responder a requisições OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
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
error_log("Requisição CPF recebida - CPF: " . substr($cpf, 0, 3) . "***");

// Verifica se o CPF foi enviado
if (empty($cpf)) {
    returnError('CPF é obrigatório');
}

// Remove caracteres não numéricos do CPF
$cpf = preg_replace('/[^0-9]/', '', $cpf);

// Validar formato do CPF
if (strlen($cpf) !== 11 || !is_numeric($cpf)) {
    returnError('CPF inválido');
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
    returnError('CPF inválido');
}

// Token da API externa
$token = '1835';

// URL da API externa
$apiUrl = "https://searchapi.dnnl.live/consulta?token_api={$token}&cpf={$cpf}";

// Configuração do contexto para a requisição (usando cURL para melhor controle)
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

// Faz a requisição para a API externa
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

// Log da resposta para debug
if ($response !== false) {
    error_log("Resposta da API externa recebida - HTTP: " . $httpCode);
} else {
    logError("Falha na requisição para API externa: " . ($curlError ?: 'Erro desconhecido'));
}

// Verifica se a requisição foi bem sucedida
if ($response === false || !empty($curlError)) {
    logError("Erro na requisição cURL: " . ($curlError ?: 'Erro desconhecido'));
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

// Log da resposta completa para debug
error_log("=== RESPOSTA COMPLETA DA API EXTERNA ===");
error_log("Resposta completa (primeiros 2000 chars): " . substr($response, 0, 2000));
error_log("Estrutura decodificada completa: " . print_r($decodedResponse, true));
error_log("Chaves disponíveis no array raiz: " . implode(', ', array_keys($decodedResponse)));

// Verificar se há dados válidos
if (!isset($decodedResponse) || !is_array($decodedResponse)) {
    logError("Estrutura de dados inválida na resposta");
    returnError('Dados inválidos retornados pela API', 500);
}

// A API pode retornar dados em diferentes estruturas:
// 1. Diretamente no array raiz
// 2. Dentro de um campo "data" ou "resultado" ou "dados"
// 3. Dentro de um array de resultados

$dadosApi = $decodedResponse;
if (isset($decodedResponse['data']) && is_array($decodedResponse['data'])) {
    $dadosApi = $decodedResponse['data'];
    error_log("Usando estrutura: decodedResponse['data']");
} elseif (isset($decodedResponse['resultado']) && is_array($decodedResponse['resultado'])) {
    $dadosApi = $decodedResponse['resultado'];
    error_log("Usando estrutura: decodedResponse['resultado']");
} elseif (isset($decodedResponse['dados']) && is_array($decodedResponse['dados'])) {
    $dadosApi = $decodedResponse['dados'];
    error_log("Usando estrutura: decodedResponse['dados']");
} elseif (isset($decodedResponse[0]) && is_array($decodedResponse[0])) {
    // Se for um array de resultados, pegar o primeiro
    $dadosApi = $decodedResponse[0];
    error_log("Usando estrutura: decodedResponse[0] (primeiro item do array)");
} else {
    error_log("Usando estrutura: decodedResponse (raiz)");
}

error_log("Chaves disponíveis em dadosApi: " . implode(', ', array_keys($dadosApi)));
error_log("Conteúdo de dadosApi (primeiros 2000 chars): " . substr(print_r($dadosApi, true), 0, 2000));

// Buscar recursivamente por campos que possam conter gênero ou mãe
error_log("=== BUSCA RECURSIVA DE CAMPOS ===");
foreach ($dadosApi as $key => $value) {
    if (is_string($key)) {
        $keyLower = strtolower($key);
        if (stripos($keyLower, 'sexo') !== false || stripos($keyLower, 'genero') !== false || stripos($keyLower, 'gender') !== false) {
            error_log("Campo relacionado a sexo/gênero encontrado: $key = " . (is_string($value) ? $value : '[' . gettype($value) . ']'));
        }
        if (stripos($keyLower, 'mae') !== false || stripos($keyLower, 'mother') !== false || stripos($keyLower, 'filiacao') !== false) {
            error_log("Campo relacionado a mãe encontrado: $key = " . (is_string($value) ? $value : '[' . gettype($value) . ']'));
        }
    }
}

// Mapear dados da API externa para o formato esperado pelo frontend
// A API externa pode retornar diferentes estruturas, então vamos normalizar
// IMPORTANTE: Retornar em ambos os formatos (maiúsculo e minúsculo) para compatibilidade total

// Extrair valores da API externa (tentando diferentes formatos e variações)
// IMPORTANTE: Tentar TODOS os campos possíveis antes de usar valor padrão
$nomeApi = null;
$camposNome = ['nome', 'NOME', 'name', 'Nome', 'NOME_COMPLETO', 'nome_completo', 
               'full_name', 'FullName', 'FULL_NAME', 'nomeCompleto', 'NomeCompleto',
               'pessoa', 'PESSOA', 'pessoa_nome', 'PESSOA_NOME', 'cliente', 'CLIENTE',
               'nome_pessoa', 'NOME_PESSOA', 'nome_cliente', 'NOME_CLIENTE'];

foreach ($camposNome as $campo) {
    if (isset($dadosApi[$campo]) && !empty($dadosApi[$campo]) && $dadosApi[$campo] !== 'Dados não disponíveis') {
        $nomeApi = $dadosApi[$campo];
        break;
    }
}

// Se ainda não encontrou, tentar recursivamente em sub-arrays
if ($nomeApi === null) {
    foreach ($dadosApi as $key => $value) {
        if (is_array($value)) {
            foreach ($camposNome as $campo) {
                if (isset($value[$campo]) && !empty($value[$campo]) && $value[$campo] !== 'Dados não disponíveis') {
                    $nomeApi = $value[$campo];
                    break 2;
                }
            }
        }
    }
}

// Se ainda não encontrou, usar valor padrão
if ($nomeApi === null || empty($nomeApi) || $nomeApi === 'Dados não disponíveis') {
    $nomeApi = 'Dados não disponíveis';
}

// Buscar nascimento em vários formatos
$nascimentoApi = null;
$camposNascimento = ['nascimento', 'NASCIMENTO', 'birthdate', 'data_nascimento', 'DATA_NASCIMENTO',
                     'dt_nascimento', 'DT_NASCIMENTO', 'dataNascimento', 'data_nasc', 'DATA_NASC',
                     'nasc', 'NASC', 'dt_nasc', 'DT_NASC', 'birth_date', 'BIRTH_DATE'];

foreach ($camposNascimento as $campo) {
    if (isset($dadosApi[$campo]) && !empty($dadosApi[$campo])) {
        $nascimentoApi = $dadosApi[$campo];
        break;
    }
}

// Se ainda não encontrou, tentar recursivamente
if ($nascimentoApi === null) {
    foreach ($dadosApi as $key => $value) {
        if (is_array($value)) {
            foreach ($camposNascimento as $campo) {
                if (isset($value[$campo]) && !empty($value[$campo])) {
                    $nascimentoApi = $value[$campo];
                    break 2;
                }
            }
        }
    }
}

$situacaoApi = $dadosApi['situacao'] ?? $dadosApi['SITUACAO'] ?? $dadosApi['status'] ?? 
               $dadosApi['Status'] ?? $dadosApi['STATUS'] ?? 'Regular';

// Buscar sexo em vários formatos
$sexoApi = null;
$camposSexo = ['sexo', 'SEXO', 'genero', 'GENERO', 'gender', 'Gender', 'GENDER', 'sex', 'SEX',
               'sexo_cpf', 'SEXO_CPF', 'genero_cpf', 'GENERO_CPF', 'tipo_sexo', 'TIPO_SEXO',
               'sexo_pessoa', 'SEXO_PESSOA', 'genero_pessoa', 'GENERO_PESSOA'];

foreach ($camposSexo as $campo) {
    if (isset($dadosApi[$campo]) && !empty($dadosApi[$campo])) {
        $sexoApi = $dadosApi[$campo];
        error_log("Sexo encontrado no campo: $campo = $sexoApi");
        break;
    }
}

// Se ainda não encontrou, tentar recursivamente em sub-arrays
if ($sexoApi === null) {
    foreach ($dadosApi as $key => $value) {
        if (is_array($value)) {
            foreach ($camposSexo as $campo) {
                if (isset($value[$campo]) && !empty($value[$campo])) {
                    $sexoApi = $value[$campo];
                    error_log("Sexo encontrado recursivamente em [$key][$campo] = $sexoApi");
                    break 2;
                }
            }
        }
    }
}

// Se ainda não encontrou, tentar buscar por valores comuns (M, F, Masculino, Feminino)
if ($sexoApi === null) {
    foreach ($dadosApi as $key => $value) {
        if (is_string($value) && preg_match('/^(M|F|MASCULINO|FEMININO|Masculino|Feminino)$/i', $value)) {
            $sexoApi = $value;
            error_log("Sexo encontrado por padrão no campo: $key = $sexoApi");
            break;
        }
    }
}

// Buscar nome da mãe em vários formatos
$maeApi = null;
$camposMae = ['nome_mae', 'NOME_MAE', 'mae', 'MAE', 'mother_name', 'MotherName', 
              'MOTHER_NAME', 'nomeMae', 'NomeMae', 'nome_mae_completo', 'NOME_MAE_COMPLETO',
              'mae_nome', 'MAE_NOME', 'nome_da_mae', 'NOME_DA_MAE', 'mae_nome_completo',
              'MAE_NOME_COMPLETO', 'nome_mae_cpf', 'NOME_MAE_CPF', 'mae_cpf', 'MAE_CPF',
              'filiação_materna', 'FILIACAO_MATERNA', 'filiacao_materna', 'FILIAÇÃO_MATERNA'];

foreach ($camposMae as $campo) {
    if (isset($dadosApi[$campo]) && !empty($dadosApi[$campo])) {
        $maeApi = $dadosApi[$campo];
        error_log("Nome da mãe encontrado no campo: $campo = $maeApi");
        break;
    }
}

// Se ainda não encontrou, tentar recursivamente em sub-arrays
if ($maeApi === null) {
    foreach ($dadosApi as $key => $value) {
        if (is_array($value)) {
            foreach ($camposMae as $campo) {
                if (isset($value[$campo]) && !empty($value[$campo])) {
                    $maeApi = $value[$campo];
                    error_log("Nome da mãe encontrado recursivamente em [$key][$campo] = $maeApi");
                    break 2;
                }
            }
        }
    }
}

// Se ainda não encontrou, tentar buscar por chaves que contenham "mae" ou "mother"
if ($maeApi === null) {
    foreach ($dadosApi as $key => $value) {
        if (is_string($key) && (stripos($key, 'mae') !== false || stripos($key, 'mother') !== false)) {
            if (!empty($value) && is_string($value)) {
                $maeApi = $value;
                error_log("Nome da mãe encontrado por padrão no campo: $key = $maeApi");
                break;
            }
        }
    }
}

// Normalizar dados em ambos os formatos para máxima compatibilidade com o funil
$dadosFormatados = [
    // Formato minúsculo (padrão da nova API)
    'cpf' => $cpf,
    'nome' => $nomeApi,
    'nascimento' => $nascimentoApi ?? 'Não informado',
    'nasc' => $nascimentoApi ?? 'Não informado', // Formato alternativo usado no funil
    'situacao' => $situacaoApi,
    'sexo' => $sexoApi ?? 'Não informado',
    'genero' => $sexoApi ?? 'Não informado',
    'nome_mae' => $maeApi ?? 'Não informado',
    'mae' => $maeApi ?? 'Não informado',
    
    // Formato maiúsculo (usado em várias partes do funil)
    'CPF' => $cpf,
    'NOME' => $nomeApi,
    'NASC' => $nascimentoApi ?? 'Não informado',
    'NASCIMENTO' => $nascimentoApi ?? 'Não informado',
    'SITUACAO' => $situacaoApi,
    'SEXO' => $sexoApi ?? 'Não informado',
    'NOME_MAE' => $maeApi ?? 'Não informado',
    
    // Campos adicionais para o fluxo
    'status' => 'aprovado', // Status padrão para o fluxo
    'fonte' => 'API Externa',
    'dados_completos' => $decodedResponse // Manter dados completos para referência
];

// Log dos dados formatados para debug
error_log("=== DADOS FORMATADOS PARA RETORNO ===");
error_log("Nome encontrado: " . ($nomeApi ?? 'NULL'));
error_log("Nascimento encontrado: " . ($nascimentoApi ?? 'NULL'));
error_log("Sexo encontrado: " . ($sexoApi ?? 'NULL'));
error_log("Mãe encontrada: " . ($maeApi ?? 'NULL'));
error_log("Dados formatados completos: " . print_r($dadosFormatados, true));

// Log de sucesso
error_log("API consultada com sucesso para CPF: " . substr($cpf, 0, 3) . "***");

// Retornar no formato esperado pelo frontend
http_response_code(200);
echo json_encode([
    'success' => true,
    'data' => $dadosFormatados
]);
exit;
