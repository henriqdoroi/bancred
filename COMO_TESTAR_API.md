# 🧪 Como Testar a API PIX

## Método 1: Script de Teste Visual (Recomendado)

1. **Acesse no navegador:**
   ```
   http://localhost/new/consulta/testar-api-pix.php
   ```
   ou
   ```
   http://localhost/bancred.site/consulta/testar-api-pix.php
   ```

2. **O script irá:**
   - Mostrar a configuração da API
   - Exibir o payload que será enviado
   - Fazer a requisição para BlackcatPagamentos
   - Mostrar o status HTTP (200 = sucesso)
   - Exibir a resposta completa da API
   - Verificar se o código PIX foi retornado

## Método 2: Via Console do Navegador

1. Abra o Console do navegador (F12)
2. Cole e execute:

```javascript
fetch('http://localhost/new/consulta/processar.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({
        valor: 1.00,
        servico: "Payment EMP"
    })
})
.then(response => {
    console.log('Status HTTP:', response.status);
    return response.json();
})
.then(data => {
    console.log('Resposta:', data);
    if (data.success) {
        console.log('✅ SUCESSO! API retornou 200');
        console.log('Transaction ID:', data.data.id);
        console.log('PIX Code:', data.data.pixCode);
    } else {
        console.error('❌ ERRO:', data.message);
    }
})
.catch(error => {
    console.error('Erro na requisição:', error);
});
```

## Método 3: Via cURL (Terminal/PowerShell)

No PowerShell, execute:

```powershell
$body = @{
    valor = 1.00
    servico = "Payment EMP"
} | ConvertTo-Json

Invoke-RestMethod -Uri "http://localhost/new/consulta/processar.php" `
    -Method POST `
    -ContentType "application/json" `
    -Body $body
```

## Método 4: Verificar Logs do XAMPP

1. Abra o arquivo de log:
   ```
   C:\xampp\htdocs\bancred.site\logs\pix_errors.log
   ```

2. Procure por:
   - `=== RESPOSTA DA API BLACKCATPAGAMENTOS ===`
   - `HTTP Code: 200` (ou outro código)
   - `=== SUCESSO - DADOS RETORNADOS ===`

## O que verificar:

✅ **Status 200 ou 201** = API funcionando corretamente
❌ **Status 400** = Erro de validação (verificar payload)
❌ **Status 401** = Erro de autenticação (verificar chaves)
❌ **Status 500** = Erro no servidor do gateway

## Teste Rápido

Acesse: `http://localhost/new/consulta/testar-api-pix.php`

O script fará tudo automaticamente e mostrará o resultado!


