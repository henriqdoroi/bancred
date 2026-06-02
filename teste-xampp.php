<?php
/**
 * Arquivo de Teste - XAMPP
 * Acesse: http://localhost/bancred.site/teste-xampp.php
 */

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Teste XAMPP - Bancred</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        .ok { color: green; font-weight: bold; }
        .erro { color: red; font-weight: bold; }
        .info { background: #f0f0f0; padding: 15px; margin: 10px 0; border-radius: 5px; }
        h1 { color: #333; }
        h2 { color: #666; border-bottom: 2px solid #ddd; padding-bottom: 10px; }
    </style>
</head>
<body>
    <h1>🧪 Teste de Configuração XAMPP</h1>
    
    <h2>1. Verificação PHP</h2>
    <div class="info">
        <p><strong>Versão PHP:</strong> <?php echo phpversion(); ?></p>
        <p><strong>Servidor:</strong> <?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Desconhecido'; ?></p>
    </div>
    
    <h2>2. Extensões Necessárias</h2>
    <div class="info">
        <?php
        $extensoes = ['curl', 'json', 'mbstring'];
        foreach ($extensoes as $ext) {
            $status = extension_loaded($ext);
            echo '<p>';
            echo $status ? '<span class="ok">✅</span>' : '<span class="erro">❌</span>';
            echo ' <strong>' . $ext . ':</strong> ' . ($status ? 'Habilitado' : 'NÃO HABILITADO');
            echo '</p>';
        }
        ?>
    </div>
    
    <h2>3. Arquivos e Pastas</h2>
    <div class="info">
        <?php
        $arquivos = [
            'consulta/cpf.php' => 'Arquivo da API',
            'cpf.html' => 'Página principal',
            'consulta/' => 'Pasta consulta'
        ];
        
        foreach ($arquivos as $arquivo => $descricao) {
            $existe = file_exists($arquivo) || is_dir($arquivo);
            echo '<p>';
            echo $existe ? '<span class="ok">✅</span>' : '<span class="erro">❌</span>';
            echo ' <strong>' . $arquivo . ':</strong> ' . ($existe ? 'Existe' : 'NÃO ENCONTRADO');
            echo ' <em>(' . $descricao . ')</em>';
            echo '</p>';
        }
        ?>
    </div>
    
    <h2>4. Permissões</h2>
    <div class="info">
        <?php
        $pasta = 'consulta';
        $podeLer = is_readable($pasta);
        $podeEscrever = is_writable($pasta);
        
        echo '<p>';
        echo $podeLer ? '<span class="ok">✅</span>' : '<span class="erro">❌</span>';
        echo ' Pasta consulta: Leitura ' . ($podeLer ? 'OK' : 'ERRO');
        echo '</p>';
        
        echo '<p>';
        echo $podeEscrever ? '<span class="ok">✅</span>' : '<span class="ok">⚠️</span>';
        echo ' Pasta consulta: Escrita ' . ($podeEscrever ? 'OK' : 'Não necessário, mas recomendado');
        echo '</p>';
        ?>
    </div>
    
    <h2>5. Teste de cURL (ReceitaWS)</h2>
    <div class="info">
        <?php
        if (function_exists('curl_init')) {
            echo '<p><span class="ok">✅</span> cURL está disponível</p>';
            
            // Teste de conexão com a ReceitaWS
            // Nota: 404 pode ser normal se o CPF não existir, mas a conexão funciona
            $ch = curl_init('https://www.receitaws.com.br/v1/cpf/11144477735');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
            
            $resultado = @curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $erro = curl_error($ch);
            curl_close($ch);
            
            if ($httpCode == 200) {
                echo '<p><span class="ok">✅</span> Conexão com ReceitaWS: OK (200)</p>';
                echo '<p><em>API está funcionando perfeitamente!</em></p>';
            } else if ($httpCode == 429) {
                echo '<p><span class="ok">✅</span> Conexão com ReceitaWS: OK (limite excedido)</p>';
                echo '<p><em>Código 429: Você excedeu o limite de 3 consultas/minuto, mas a conexão funciona!</em></p>';
            } else if ($httpCode == 404) {
                echo '<p><span class="ok">⚠️</span> Conexão com ReceitaWS: Funcionando</p>';
                echo '<p><em>Código 404: CPF de teste não encontrado, mas a API está acessível.</em></p>';
                echo '<p><em>Isso é NORMAL - a API funciona, só não encontrou esse CPF específico.</em></p>';
            } else if ($httpCode == 0 || $erro) {
                echo '<p><span class="erro">❌</span> Erro de conexão: ' . htmlspecialchars($erro ?: 'Não foi possível conectar') . '</p>';
                echo '<p><em>Verifique sua conexão com a internet</em></p>';
            } else {
                echo '<p><span class="ok">⚠️</span> ReceitaWS respondeu com código: ' . $httpCode . '</p>';
                echo '<p><em>A API está acessível. Código ' . $httpCode . ' pode ser normal dependendo da resposta.</em></p>';
            }
            
            // Teste adicional: verificar se consegue fazer requisição HTTPS
            echo '<hr style="margin: 15px 0; border: none; border-top: 1px solid #ddd;">';
            $ch2 = curl_init('https://www.google.com');
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch2, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch2, CURLOPT_NOBODY, true);
            $testeInternet = @curl_exec($ch2);
            $internetCode = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
            curl_close($ch2);
            
            if ($internetCode == 200 || $internetCode == 301 || $internetCode == 302) {
                echo '<p><span class="ok">✅</span> Conexão com internet: OK</p>';
            } else {
                echo '<p><span class="erro">❌</span> Problema de conexão com internet</p>';
            }
        } else {
            echo '<p><span class="erro">❌</span> cURL NÃO está disponível</p>';
            echo '<p><em>Edite C:\\xampp\\php\\php.ini e remova o ; de extension=curl</em></p>';
        }
        ?>
    </div>
    
    <h2>6. URLs de Teste</h2>
    <div class="info">
        <p><strong>Página Principal:</strong> <a href="cpf.html">cpf.html</a></p>
        <p><strong>API:</strong> <a href="consulta/cpf.php">consulta/cpf.php</a></p>
        <p><strong>Este teste:</strong> teste-xampp.php</p>
    </div>
    
    <h2>✅ Próximos Passos</h2>
    <div class="info">
        <?php
        $tudoOk = extension_loaded('curl') && 
                  extension_loaded('json') && 
                  file_exists('consulta/cpf.php') && 
                  file_exists('cpf.html');
        
        if ($tudoOk) {
            echo '<p class="ok">🎉 Tudo configurado! Você pode testar agora:</p>';
            echo '<p><a href="cpf.html" style="background: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">Testar Formulário CPF</a></p>';
        } else {
            echo '<p class="erro">⚠️ Ainda há alguns problemas a resolver. Veja os itens marcados com ❌ acima.</p>';
        }
        ?>
    </div>
    
    <hr>
    <p><small>Se todos os itens estiverem ✅, você está pronto para usar!</small></p>
</body>
</html>

