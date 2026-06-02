# 📄 Como Funciona o `iof.html?utm_source=google&utm_medium=cpc`

## 🎯 O que é o `iof.html`?

O `iof.html` é a **página de destino após o pagamento PIX ser confirmado**. Ele faz parte do fluxo de saque e é exibido quando o pagamento é aprovado.

## 🔄 Fluxo Completo:

```
1. checkout.html?utm_source=google&utm_medium=cpc&teste=123
   ↓
   [Salva parâmetros no sessionStorage]
   sessionStorage.setItem('trackingParams', '?utm_source=google&utm_medium=cpc&teste=123')
   ↓
   
2. payment.html?id=123
   [URL limpa - sem parâmetros de tracking para não interferir na API PIX]
   ↓
   [Registra parâmetros para tracking usando History API temporariamente]
   ↓
   [API PIX funciona normalmente]
   ↓
   [Usuário paga o PIX]
   ↓
   [Pagamento confirmado]
   ↓
   
3. iof.html?utm_source=google&utm_medium=cpc&teste=123
   [Parâmetros restaurados do sessionStorage]
```

## 🔧 Como os Parâmetros são Preservados:

### **1. Salvamento (checkout.html):**

Antes de ir para `payment.html`, os parâmetros são salvos:

```javascript
// Salvar parâmetros de tracking no sessionStorage
if (window.location.search) {
    sessionStorage.setItem('trackingParams', window.location.search);
}

// Redirecionar com URL limpa (apenas ?id=)
redirectUrl = "payment.html?id=" + response.data.id;
```

### **2. Registro Temporário (payment.html):**

No `payment.html`, os parâmetros são registrados temporariamente para tracking:

```javascript
function registrarTrackingParams() {
    const savedParams = sessionStorage.getItem('trackingParams');
    // Adiciona temporariamente na URL para scripts de tracking lerem
    // Após 500ms, restaura URL limpa (apenas ?id=)
}
```

### **3. Restauração (payment.html → iof.html):**

Quando o pagamento é confirmado, os parâmetros são restaurados:

```javascript
function getTrackingParams() {
    // Recuperar parâmetros salvos do sessionStorage
    const savedParams = sessionStorage.getItem('trackingParams');
    
    if (savedParams) {
        // Remover parâmetros funcionais (id, transaction_id, etc.)
        const urlParams = new URLSearchParams(savedParams);
        const trackingParams = new URLSearchParams();
        
        const functionalParams = ['id', 'transaction_id', 'txid'];
        
        // Copiar apenas parâmetros de tracking
        for (const [key, value] of urlParams.entries()) {
            if (!functionalParams.includes(key.toLowerCase())) {
                trackingParams.append(key, value);
            }
        }
        
        const queryString = trackingParams.toString();
        return queryString ? '?' + queryString : '';
    }
    return '';
}

// Ao redirecionar após pagamento confirmado:
redirectUrl = "https://bancred.site/conta/saque/iof.html" + getTrackingParams();
// Resultado: iof.html?utm_source=google&utm_medium=cpc&teste=123
```

## 📊 Código Completo no payment.html:

```javascript
// Quando pagamento é confirmado
if (data.success && data.data && data.data.status === 'paid') {
    // Obter tipo de serviço
    const servico = produto.service || "Payment EMP";
    
    // Determinar URL de destino baseado no serviço
    let redirectUrl;
    
    if (servico == 'Payment EMP') {
        redirectUrl = "https://bancred.site/conta/saque/iof.html";
    } else if (servico == 'Payment EMP Upsell 01') {
        redirectUrl = "https://bancred.site/conta/saque/tarifa-cadastro.html";
    }
    // ... outros serviços
    
    // Adicionar parâmetros de tracking restaurados
    redirectUrl = redirectUrl + getTrackingParams();
    
    // Redirecionar
    window.location.href = redirectUrl;
}
```

## ✅ O que acontece na URL `iof.html?utm_source=google&utm_medium=cpc`:

1. **Parâmetros Preservados**: Os parâmetros de tracking (`utm_source`, `utm_medium`, `teste`) são restaurados do `sessionStorage`

2. **Parâmetros Funcionais Removidos**: Parâmetros como `id`, `transaction_id` são removidos (não são mais necessários)

3. **Tracking Funciona**: Scripts de analytics (utmify, Google Analytics, Facebook Pixel) leem os parâmetros da URL

4. **Continuidade do Fluxo**: Os parâmetros continuam sendo preservados nas próximas páginas

## 🔍 Exemplo Prático:

### **⚠️ IMPORTANTE:**
Os parâmetros são **REAIS** e vêm do fluxo anterior do usuário. Os exemplos abaixo são apenas ilustrativos. O sistema preserva **QUALQUER** parâmetro que o usuário trouxer na URL.

### **Cenário 1 - Google Ads:**
- Usuário vem de: `checkout.html?utm_source=google&utm_medium=cpc&utm_campaign=emprestimo&gclid=CjwKCAjw...`
- Paga o PIX em: `payment.html?id=abc123`
- É redirecionado para: `iof.html?utm_source=google&utm_medium=cpc&utm_campaign=emprestimo&gclid=CjwKCAjw...`

### **Cenário 2 - Facebook:**
- Usuário vem de: `checkout.html?utm_source=facebook&utm_medium=social&fbclid=IwAR123456`
- Paga o PIX em: `payment.html?id=abc123`
- É redirecionado para: `iof.html?utm_source=facebook&utm_medium=social&fbclid=IwAR123456`

### **Cenário 3 - Email Marketing:**
- Usuário vem de: `checkout.html?utm_source=email&utm_medium=newsletter&ref=user123`
- Paga o PIX em: `payment.html?id=abc123`
- É redirecionado para: `iof.html?utm_source=email&utm_medium=newsletter&ref=user123`

### **Cenário 4 - Sem Parâmetros:**
- Usuário vem de: `checkout.html` (sem parâmetros)
- Paga o PIX em: `payment.html?id=abc123`
- É redirecionado para: `iof.html` (sem parâmetros)

### **O que acontece (com parâmetros REAIS):**

1. **checkout.html**:
   ```javascript
   // Salva os parâmetros REAIS que estão na URL atual
   // Exemplo real: ?utm_source=facebook&utm_medium=social&gclid=abc123
   sessionStorage.setItem('trackingParams', window.location.search);
   // Redireciona para payment.html?id=abc123
   ```

2. **payment.html**:
   ```javascript
   // URL: payment.html?id=abc123 (limpa)
   // Registra parâmetros REAIS temporariamente para tracking
   // API PIX funciona normalmente
   // Após pagamento confirmado:
   redirectUrl = "iof.html" + getTrackingParams();
   // Resultado: iof.html?utm_source=facebook&utm_medium=social&gclid=abc123
   // (ou qualquer parâmetro real que o usuário trouxer)
   ```

3. **iof.html**:
   ```javascript
   // URL: iof.html?utm_source=facebook&utm_medium=social&gclid=abc123
   // (ou qualquer parâmetro real que o usuário trouxer)
   // Scripts de tracking leem os parâmetros REAIS
   // Parâmetros REAIS continuam sendo preservados nas próximas páginas
   ```

## 🎯 Benefícios:

1. **✅ Tracking Completo**: Parâmetros são rastreados em todas as páginas, incluindo após o pagamento
2. **✅ API PIX Funciona**: URL limpa no payment.html não interfere na geração do código PIX
3. **✅ Continuidade**: Parâmetros são preservados do início ao fim do fluxo
4. **✅ Analytics Preciso**: Você sabe exatamente de onde veio cada conversão

## 🧪 Como Testar:

1. **Acesse com parâmetros:**
   ```
   checkout.html?utm_source=google&utm_medium=cpc&teste=123
   ```

2. **Gere o PIX:**
   - Deve redirecionar para: `payment.html?id=abc123`
   - URL deve estar limpa (sem parâmetros de tracking)

3. **Após pagamento:**
   - Deve redirecionar para: `iof.html?utm_source=google&utm_medium=cpc&teste=123`
   - Parâmetros devem estar presentes

4. **Verifique no Console:**
   ```javascript
   // No payment.html, antes do redirecionamento:
   console.log('Parâmetros salvos:', sessionStorage.getItem('trackingParams'));
   // Deve mostrar: ?utm_source=google&utm_medium=cpc&teste=123
   
   // No iof.html:
   console.log('URL atual:', window.location.href);
   // Deve mostrar: .../iof.html?utm_source=google&utm_medium=cpc&teste=123
   ```

## 📝 Notas Importantes:

- **sessionStorage**: Os parâmetros são salvos no `sessionStorage`, que persiste apenas durante a sessão do navegador
- **Parâmetros Funcionais**: Parâmetros como `id`, `transaction_id` são removidos porque não são necessários após o pagamento
- **Múltiplos Serviços**: Dependendo do tipo de serviço (`Payment EMP`, `Upsell 01`, etc.), o redirecionamento pode ir para páginas diferentes, mas sempre com os parâmetros preservados

## 🔗 Páginas Relacionadas:

- **checkout.html**: Salva parâmetros antes de ir para payment.html
- **payment.html**: Registra parâmetros temporariamente e restaura ao sair
- **iof.html**: Recebe parâmetros restaurados e continua o fluxo
- **Outras páginas de destino**: `tarifa-cadastro.html`, `app-download.html`, etc. também recebem os parâmetros

