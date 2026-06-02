# 🔧 Como Resolver Erro 500 (Erro no Servidor)

## 🔍 Passo 1: Verificar os Logs do PHP

O erro 500 significa que há um problema no código PHP. Vamos ver os logs:

### **Localizar os Logs:**

1. **Abra o XAMPP Control Panel**
2. **Clique em "Logs" ao lado de Apache**
3. **Ou abra manualmente:**
   - `C:\xampp\apache\logs\error.log`
   - `C:\xampp\php\logs\php_error_log`

### **O que procurar:**
Procure por mensagens de erro recentes que mencionem:
- `cpf.php`
- `Fatal error`
- `Parse error`
- `Warning`

## 🧪 Passo 2: Testar a API Diretamente

### **Opção 1: Pelo Navegador**
Acesse:
```
http://localhost/bancred.site/consulta/teste-api.php
```

Isso vai mostrar exatamente o que está acontecendo.

### **Opção 2: Pelo Console do Navegador**

1. Abra `cpf.html` no navegador
2. Pressione **F12** para abrir o Console
3. Vá na aba **Network** (Rede)
4. Tente enviar o formulário
5. Clique na requisição para `cpf.php`
6. Veja a resposta completa

## 🔧 Passo 3: Verificações Comuns

### **1. Verificar se cURL está habilitado**

Crie um arquivo `teste-curl.php`:
```php
<?php
if (function_exists('curl_init')) {
    echo "✅ cURL está habilitado";
} else {
    echo "❌ cURL NÃO está habilitado";
}
?>
```

Acesse: `http://localhost/bancred.site/teste-curl.php`

**Se não estiver habilitado:**
1. Abra: `C:\xampp\php\php.ini`
2. Procure: `;extension=curl`
3. Remova o `;` (fica: `extension=curl`)
4. Salve e reinicie Apache

### **2. Verificar permissões**

Certifique-se de que:
- A pasta `consulta/` tem permissão de leitura
- O arquivo `cpf.php` pode ser executado

### **3. Verificar se o arquivo existe**

Acesse diretamente:
```
http://localhost/bancred.site/consulta/cpf.php
```

**Se der 404:** O arquivo não está no lugar certo
**Se der 500:** Há um erro no código (veja os logs)

## 🐛 Passo 4: Modo Debug

Se ainda não funcionar, vamos ativar o modo debug:

1. Abra `consulta/cpf.php`
2. No início do arquivo, adicione:
```php
ini_set('display_errors', 1);
error_reporting(E_ALL);
```

3. Tente novamente
4. Agora os erros vão aparecer na tela

**⚠️ IMPORTANTE:** Remova essas linhas depois de resolver o problema!

## 📋 Checklist de Verificação

- [ ] Apache está rodando no XAMPP
- [ ] Arquivo `consulta/cpf.php` existe
- [ ] cURL está habilitado no PHP
- [ ] Verifiquei os logs do Apache
- [ ] Testei a API diretamente
- [ ] Verifiquei o Console do navegador (F12)

## 💡 Solução Rápida

Se nada funcionar, tente esta versão simplificada:

1. Crie um arquivo `consulta/cpf-simples.php`:
```php
<?php
header('Content-Type: application/json');
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!isset($data['cpf'])) {
    echo json_encode(['success' => false, 'message' => 'CPF não informado']);
    exit;
}

echo json_encode([
    'success' => true,
    'data' => [
        'cpf' => $data['cpf'],
        'nome' => 'Teste',
        'status' => 'aprovado'
    ]
]);
?>
```

2. Teste se esse arquivo funciona
3. Se funcionar, o problema está na função da ReceitaWS
4. Se não funcionar, o problema é mais básico (PHP, servidor, etc.)

## 🆘 Ainda não funciona?

Me envie:
1. O conteúdo dos logs do Apache (últimas 20 linhas)
2. O que aparece quando acessa `teste-api.php`
3. O que aparece no Console do navegador (F12 → Network)



