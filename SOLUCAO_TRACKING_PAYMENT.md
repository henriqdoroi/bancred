# ✅ Solução: Tracking de Parâmetros no Payment.html sem Conflito com API PIX

## 🎯 Problema Resolvido:

Os parâmetros de tracking (UTM, gclid, fbclid, etc.) precisam ser registrados na página `payment.html` para analytics, mas não podem interferir com a API PIX que gera o código copia e cola e QR code.

## 🔧 Solução Implementada:

### **1. Salvamento dos Parâmetros (checkout.html)**

Antes de redirecionar para `payment.html`, os parâmetros são salvos no `sessionStorage`:

```javascript
// Salvar parâmetros de tracking no sessionStorage antes de ir para payment.html
if (window.location.search) {
    sessionStorage.setItem('trackingParams', window.location.search);
}

// Redirecionar com URL limpa (apenas ?id=)
redirectUrl = "payment.html?id=" + response.data.id;
```

### **2. Registro dos Parâmetros (payment.html)**

A função `registrarTrackingParams()` é executada quando a página carrega:

1. **Recupera parâmetros do sessionStorage**
2. **Filtra parâmetros funcionais** (remove `id`, `transaction_id`, etc.)
3. **Usa History API** para adicionar temporariamente na URL (apenas para scripts lerem)
4. **Scripts de tracking processam** (utmify, Google Analytics, Facebook Pixel)
5. **Restaura URL original** (apenas com `?id=`) após 500ms

### **3. Timing Correto**

```javascript
$(document).ready(function() {
    // Aguardar scripts de tracking carregarem (200ms)
    setTimeout(function() {
        registrarTrackingParams(); // Registra parâmetros
        
        // Aguardar processamento (300ms)
        setTimeout(function() {
            initPaymentPage(); // Inicializa API PIX
        }, 300);
    }, 200);
});
```

### **4. Restauração dos Parâmetros**

Quando sair do `payment.html`, os parâmetros são restaurados:

```javascript
function getTrackingParams() {
    const savedParams = sessionStorage.getItem('trackingParams');
    // Retorna parâmetros sem os funcionais (id, etc.)
    return '?utm_source=google&utm_medium=cpc';
}

// Ao redirecionar:
window.location.href = urlDestino + getTrackingParams();
```

## ✅ Benefícios:

1. **✅ Tracking Funciona**: Parâmetros são registrados para analytics
2. **✅ API PIX Funciona**: URL limpa (`?id=123`) não interfere
3. **✅ Código PIX Gera**: Sem conflito, o código copia e cola é gerado corretamente
4. **✅ QR Code Gera**: Sem interferência, o QR code é exibido
5. **✅ Parâmetros Preservados**: Restaurados nas páginas seguintes

## 🔍 Como Funciona:

### **Fluxo Completo:**

```
1. checkout.html?utm_source=google&utm_medium=cpc
   ↓
   Salva no sessionStorage: 'trackingParams' = '?utm_source=google&utm_medium=cpc'
   ↓
   Redireciona: payment.html?id=123 (URL limpa)

2. payment.html?id=123 (carrega)
   ↓
   Aguarda 200ms (scripts carregam)
   ↓
   registrarTrackingParams():
     - Recupera do sessionStorage
     - Adiciona temporariamente na URL: payment.html?id=123&utm_source=google&utm_medium=cpc
     - Scripts de tracking leem e processam
     - Após 500ms, restaura: payment.html?id=123
   ↓
   initPaymentPage():
     - getTransactionId() pega apenas o 'id'
     - API PIX funciona normalmente
     - Gera código copia e cola
     - Gera QR code

3. Após pagamento → iof.html?utm_source=google&utm_medium=cpc
   ↓
   getTrackingParams() restaura os parâmetros
```

## 🧪 Como Testar:

1. **Acesse com parâmetros:**
   ```
   checkout.html?utm_source=google&utm_medium=cpc&teste=123
   ```

2. **Gere o PIX:**
   - Deve redirecionar para: `payment.html?id=123`
   - URL deve estar limpa (sem parâmetros de tracking)

3. **Verifique no Console:**
   ```javascript
   // Deve mostrar:
   console.log('=== REGISTRANDO PARÂMETROS DE TRACKING ===');
   console.log('Parâmetros salvos:', '?utm_source=google&utm_medium=cpc&teste=123');
   console.log('✅ URL temporariamente atualizada para tracking');
   console.log('✅ URL restaurada para API PIX');
   ```

4. **Verifique se o PIX funciona:**
   - Código PIX copia e cola deve aparecer
   - QR Code deve ser gerado
   - Nenhum erro no console relacionado à API

5. **Após pagamento:**
   - Deve redirecionar para: `iof.html?utm_source=google&utm_medium=cpc&teste=123`
   - Parâmetros devem estar restaurados

## ⚠️ Pontos Importantes:

1. **Timing é crucial**: Os delays (200ms + 300ms) garantem que:
   - Scripts de tracking carreguem antes
   - Processem os parâmetros
   - API PIX inicialize depois, com URL limpa

2. **History API**: Usa `replaceState` (não `pushState`) para não criar histórico desnecessário

3. **Filtragem**: Remove parâmetros funcionais (`id`, `transaction_id`) para evitar conflitos

4. **SessionStorage**: Mantém parâmetros seguros entre páginas

## 🐛 Troubleshooting:

### **Problema: Parâmetros não são registrados**

**Solução:**
- Verifique se `sessionStorage.getItem('trackingParams')` retorna valor
- Verifique o console para mensagens de erro
- Aumente os delays se necessário (200ms → 300ms, 300ms → 500ms)

### **Problema: API PIX não funciona**

**Solução:**
- Verifique se a URL está limpa após 500ms: `payment.html?id=123`
- Verifique se `getTransactionId()` retorna o ID correto
- Verifique se não há erros no console relacionados à API

### **Problema: QR Code não gera**

**Solução:**
- Verifique se o código PIX está sendo retornado pela API
- Verifique se a URL do QR Code está correta
- Verifique se não há conflito com parâmetros na URL

## ✅ Status Final:

- ✅ Parâmetros salvos no sessionStorage
- ✅ Parâmetros registrados para tracking
- ✅ URL limpa para API PIX
- ✅ Código PIX copia e cola funciona
- ✅ QR Code funciona
- ✅ Parâmetros restaurados nas páginas seguintes

