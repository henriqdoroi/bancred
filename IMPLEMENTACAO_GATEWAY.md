# Guia de Implementação do Gateway PIX

## 📋 Estrutura Criada

### ✅ Arquivos PHP Criados:

1. **`consulta/processar.php`**
   - Endpoint para criar transação PIX
   - Recebe: servico, cpf, nome, email, telefone, valor
   - Retorna: {success, data: {id, qrcode, pixCode, expiresAt, amount, status}}

2. **`consulta/confirmar.php`**
   - Endpoint para verificar status do pagamento
   - Recebe: {transactionId}
   - Retorna: {success, data: {status, transactionId, paidAt}}

3. **`config/gateway_config.php.example`**
   - Template para configurações do gateway
   - **AÇÃO NECESSÁRIA:** Copiar para `gateway_config.php` e preencher com suas credenciais

### ✅ Arquivos Frontend Atualizados:

1. **`conta/checkout.html`**
   - ✅ URLs dinâmicas (funciona local e produção)
   - ✅ Tratamento de erros melhorado
   - ✅ Validações de dados
   - ✅ Logs para debug

2. **`conta/checkout/pix/pix-dinamico.html`**
   - ✅ Nova página PIX dinâmica (substitui a estática)
   - ✅ Carrega dados via API
   - ✅ Gera QR Code dinamicamente
   - ✅ Timer de expiração funcional
   - ✅ Polling de status corrigido
   - ✅ Redirecionamentos dinâmicos

## 🔧 Próximos Passos (Após Receber Documentação)

### 1. **Configurar Credenciais**

```bash
# Copiar template de configuração
cp config/gateway_config.php.example config/gateway_config.php

# Editar e preencher com suas credenciais
# NUNCA commitar gateway_config.php no Git
```

### 2. **Implementar Classe do Gateway**

Criar arquivo: `consulta/GatewayPix.php`

```php
<?php
class GatewayPix {
    private $config;
    
    public function __construct($config) {
        $this->config = $config;
    }
    
    public function createTransaction($data) {
        // Implementar conforme documentação do gateway
        // Retornar: ['id', 'qrcode', 'pixCode', 'expiresAt']
    }
    
    public function checkTransactionStatus($transactionId) {
        // Implementar conforme documentação do gateway
        // Retornar: 'paid', 'pending', 'expired', 'cancelled'
    }
}
```

### 3. **Atualizar `processar.php`**

Substituir a seção marcada com `TODO`:

```php
// Carregar configurações
require_once __DIR__ . '/../config/gateway_config.php';
$gatewayConfig = require __DIR__ . '/../config/gateway_config.php';

// Carregar classe do gateway
require_once __DIR__ . '/GatewayPix.php';

// Criar transação
$gateway = new GatewayPix($gatewayConfig);
$transaction = $gateway->createTransaction([
    'amount' => $valor,
    'payer' => [
        'name' => $nome,
        'document' => $cpf,
        'email' => $email,
        'phone' => $telefone
    ],
    'description' => $servico
]);

$response = [
    'id' => $transaction['id'],
    'qrcode' => $transaction['qrcode'],
    'pixCode' => $transaction['pixCode'],
    'expiresAt' => $transaction['expiresAt'],
    'amount' => $valor,
    'status' => 'pending'
];
```

### 4. **Atualizar `confirmar.php`**

Substituir a seção marcada com `TODO`:

```php
// Carregar configurações e classe
require_once __DIR__ . '/../config/gateway_config.php';
require_once __DIR__ . '/GatewayPix.php';

$gatewayConfig = require __DIR__ . '/../config/gateway_config.php';
$gateway = new GatewayPix($gatewayConfig);

// Verificar status
$status = $gateway->checkTransactionStatus($transactionId);
```

### 5. **Atualizar Redirecionamento no Checkout**

O checkout já está configurado para redirecionar para:
- Local: `/conta/checkout/pix/{id}.html`
- Produção: `/conta/checkout/pix/{id}`

**Opção 1:** Usar a página dinâmica `pix-dinamico.html` e renomear para `index.html`
**Opção 2:** Criar sistema de rotas PHP para servir a página dinâmica

### 6. **Salvar Dados no sessionStorage**

No `checkout.html`, após receber resposta da API:

```javascript
success: function (response) {
    if(response.success && response.data){
        // Salvar dados do PIX no sessionStorage
        sessionStorage.setItem('pixData_' + response.data.id, JSON.stringify(response.data));
        
        // Redirecionar
        window.location.href = redirectUrl;
    }
}
```

## 📝 Checklist de Implementação

- [ ] Receber documentação do gateway
- [ ] Receber credenciais (Client ID, Secret, API Key, etc.)
- [ ] Criar `config/gateway_config.php` com credenciais
- [ ] Implementar classe `GatewayPix.php`
- [ ] Atualizar `processar.php` com integração real
- [ ] Atualizar `confirmar.php` com verificação real
- [ ] Testar criação de transação PIX
- [ ] Testar verificação de status
- [ ] Testar fluxo completo (checkout → PIX → confirmação)
- [ ] Copiar arquivos para XAMPP
- [ ] Testar em ambiente local
- [ ] Remover código mockado

## 🔒 Segurança

- ✅ `.gitignore` configurado para não commitar `gateway_config.php`
- ✅ Validação de dados de entrada
- ✅ Sanitização de inputs
- ✅ Tratamento de erros
- ✅ Logs de erro (sem expor informações sensíveis)

## 📞 Quando Receber a Documentação

Envie:
1. Documentação da API do gateway
2. Credenciais (Client ID, Secret, etc.)
3. Exemplos de requisições/respostas
4. URLs de sandbox e produção

E eu implemento tudo! 🚀



