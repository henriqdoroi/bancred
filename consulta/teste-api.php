<?php
/**
 * Arquivo de Teste da API CPF
 * Acesse: http://localhost/bancred.site/consulta/teste-api.php
 */

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Teste API CPF</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 900px; margin: 50px auto; padding: 20px; }
        .ok { color: green; font-weight: bold; }
        .erro { color: red; font-weight: bold; }
        .info { background: #f0f0f0; padding: 15px; margin: 10px 0; border-radius: 5px; }
        pre { background: #f5f5f5; padding: 10px; border-radius: 5px; overflow-x: auto; }
        h1 { color: #333; }
        h2 { color: #666; border-bottom: 2px solid #ddd; padding-bottom: 10px; }
    </style>
</head>
<body>
    <h1>🧪 Teste da API CPF</h1>
    
    <h2>Teste Manual</h2>
    <div class="info">
        <p>Este teste vai chamar a API diretamente e mostrar a resposta:</p>
        
        <?php
        // Simular uma requisição POST
        $cpfTeste = '11144477735'; // CPF válido para teste
        
        echo '<p><strong>Testando com CPF:</strong> ' . $cpfTeste . '</p>';
        
        // Vamos fazer uma requisição HTTP real para testar
        ?>
        
        <h3>Teste via cURL:</h3>
        <?php
        $url = 'http://localhost/bancred.site/consulta/cpf.php';
        $data = json_encode(['cpf' => $cpfTeste]);
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'X-CSRF-TOKEN: teste'
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        echo '<p><strong>Código HTTP:</strong> ' . $httpCode . '</p>';
        
        if ($error) {
            echo '<p class="erro">Erro cURL: ' . htmlspecialchars($error) . '</p>';
        }
        
        echo '<h4>Resposta:</h4>';
        echo '<pre>' . htmlspecialchars($response) . '</pre>';
        
        $json = json_decode($response, true);
        if ($json) {
            echo '<h4>Resposta Decodificada:</h4>';
            echo '<pre>' . print_r($json, true) . '</pre>';
        }
        ?>
    </div>
    
    <h2>Teste JavaScript (Frontend)</h2>
    <div class="info">
        <p>Abra o Console do navegador (F12) e execute:</p>
        <pre>
fetch('http://localhost/bancred.site/consulta/cpf.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': 'teste'
    },
    body: JSON.stringify({cpf: '11144477735'})
})
.then(r => r.json())
.then(console.log)
.catch(console.error);
        </pre>
    </div>
    
    <h2>Verificar Logs do PHP</h2>
    <div class="info">
        <p><strong>Localização dos logs:</strong></p>
        <ul>
            <li>XAMPP: <code>C:\xampp\apache\logs\error.log</code></li>
            <li>Ou: <code>C:\xampp\php\logs\php_error_log</code></li>
        </ul>
        <p>Abra esses arquivos para ver os erros detalhados.</p>
    </div>
</body>
</html>

