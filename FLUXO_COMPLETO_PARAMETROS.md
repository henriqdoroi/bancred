# ✅ Fluxo Completo de Preservação de Parâmetros

## 🎯 Status: **TOTALMENTE FUNCIONAL**

Todos os parâmetros de tracking (UTM, gclid, fbclid, etc.) são preservados em **TODO o funil**, do início ao fim.

## 📋 Fluxo Completo com Preservação de Parâmetros:

### **1. Entrada no Funil:**
```
index.htm?utm_source=google&utm_medium=cpc&gclid=abc123
  ↓ [Parâmetros preservados]
cpf.html?utm_source=google&utm_medium=cpc&gclid=abc123
```

### **2. Validação de CPF:**
```
cpf.html?utm_source=google&utm_medium=cpc&gclid=abc123
  ↓ [Parâmetros preservados após API]
pessoa.html?utm_source=google&utm_medium=cpc&gclid=abc123
```

### **3. Dados Pessoais:**
```
pessoa.html?utm_source=google&utm_medium=cpc&gclid=abc123
  ↓ [Parâmetros preservados]
simulacao.html?utm_source=google&utm_medium=cpc&gclid=abc123
```

### **4. Simulação:**
```
simulacao.html?utm_source=google&utm_medium=cpc&gclid=abc123
  ↓ [Parâmetros preservados]
analise.html?utm_source=google&utm_medium=cpc&gclid=abc123
```

### **5. Análise:**
```
analise.html?utm_source=google&utm_medium=cpc&gclid=abc123
  ↓ [Parâmetros preservados]
aprovado.html?utm_source=google&utm_medium=cpc&gclid=abc123
```

### **6. Aprovação:**
```
aprovado.html?utm_source=google&utm_medium=cpc&gclid=abc123
  ↓ [Parâmetros preservados]
endereco.html?utm_source=google&utm_medium=cpc&gclid=abc123
```

### **7. Endereço:**
```
endereco.html?utm_source=google&utm_medium=cpc&gclid=abc123
  ↓ [Parâmetros preservados]
credenciais.html?utm_source=google&utm_medium=cpc&gclid=abc123
```

### **8. Credenciais:**
```
credenciais.html?utm_source=google&utm_medium=cpc&gclid=abc123
  ↓ [Parâmetros preservados]
configurando-conta.html?utm_source=google&utm_medium=cpc&gclid=abc123
```

### **9. Configuração:**
```
configurando-conta.html?utm_source=google&utm_medium=cpc&gclid=abc123
  ↓ [Parâmetros preservados]
conta.html?utm_source=google&utm_medium=cpc&gclid=abc123
```

### **10. Conta:**
```
conta.html?utm_source=google&utm_medium=cpc&gclid=abc123
  ↓ [Parâmetros preservados]
conta/saque.html?utm_source=google&utm_medium=cpc&gclid=abc123
```

### **11. Saque:**
```
conta/saque.html?utm_source=google&utm_medium=cpc&gclid=abc123
  ↓ [Parâmetros preservados]
conta/saque/confirmar.html?utm_source=google&utm_medium=cpc&gclid=abc123
```

### **12. Confirmação:**
```
conta/saque/confirmar.html?utm_source=google&utm_medium=cpc&gclid=abc123
  ↓ [Parâmetros preservados]
conta/saque/seguro-prestamista.html?utm_source=google&utm_medium=cpc&gclid=abc123
```

### **13. Seguro:**
```
conta/saque/seguro-prestamista.html?utm_source=google&utm_medium=cpc&gclid=abc123
  ↓ [Parâmetros preservados]
conta/saque/finalizar.html?utm_source=google&utm_medium=cpc&gclid=abc123
```

### **14. Finalização:**
```
conta/saque/finalizar.html?utm_source=google&utm_medium=cpc&gclid=abc123
  ↓ [Parâmetros preservados]
conta/checkout.html?utm_source=google&utm_medium=cpc&gclid=abc123
```

### **15. Checkout (Salvamento):**
```
conta/checkout.html?utm_source=google&utm_medium=cpc&gclid=abc123
  ↓ [Salva no sessionStorage]
  sessionStorage.setItem('trackingParams', '?utm_source=google&utm_medium=cpc&gclid=abc123')
  ↓ [URL limpa para não interferir na API PIX]
conta/checkout/pix/payment.html?id=123
```

### **16. Payment (Registro Temporário):**
```
payment.html?id=123
  ↓ [Registra parâmetros temporariamente para tracking]
  [Scripts de tracking leem os parâmetros]
  ↓ [Restaura URL limpa após 500ms]
  [API PIX funciona normalmente]
  ↓ [Pagamento confirmado]
```

### **17. IOF (Restauração):**
```
iof.html?utm_source=google&utm_medium=cpc&gclid=abc123
  ↓ [Parâmetros restaurados do sessionStorage]
  [Página final com confirmação]
```

## ✅ Implementações Realizadas:

### **1. Todas as Páginas do Funil:**
- ✅ `index.htm` → `cpf.html`
- ✅ `cpf.html` → `pessoa.html`
- ✅ `pessoa.html` → `simulacao.html`
- ✅ `simulacao.html` → `analise.html`
- ✅ `analise.html` → `aprovado.html`
- ✅ `aprovado.html` → `endereco.html`
- ✅ `endereco.html` → `credenciais.html`
- ✅ `credenciais.html` → `configurando-conta.html`
- ✅ `configurando-conta.html` → `conta.html`
- ✅ `conta.html` → `conta/saque.html`
- ✅ `conta/saque.html` → `conta/saque/confirmar.html`
- ✅ `conta/saque/confirmar.html` → `conta/saque/seguro-prestamista.html`
- ✅ `conta/saque/seguro-prestamista.html` → `conta/saque/finalizar.html`
- ✅ `conta/saque/finalizar.html` → `conta/checkout.html`
- ✅ `conta/checkout.html` → `conta/checkout/pix/payment.html` (salva no sessionStorage)
- ✅ `conta/checkout/pix/payment.html` → `conta/saque/iof.html` (restaura do sessionStorage)

### **2. Funções Auxiliares:**
- ✅ `getUrl()` - Preserva parâmetros automaticamente
- ✅ `getTrackingParams()` - Restaura parâmetros do sessionStorage
- ✅ `registrarTrackingParams()` - Registra parâmetros temporariamente no payment.html

### **3. Tratamento Especial:**
- ✅ **payment.html**: Parâmetros salvos no sessionStorage antes de entrar
- ✅ **payment.html**: Parâmetros registrados temporariamente para tracking
- ✅ **payment.html**: URL limpa para não interferir na API PIX
- ✅ **iof.html**: Parâmetros restaurados após pagamento

### **4. Botões "Voltar":**
- ✅ Todos os botões "Voltar" preservam os parâmetros
- ✅ Redirecionamentos para `cpf.html` preservam parâmetros
- ✅ Redirecionamentos para `conta.html` preservam parâmetros

## 🔧 Como Funciona:

### **Método 1: Preservação Direta (Maioria das Páginas)**
```javascript
window.location.href = urlDestino + window.location.search;
// ou
window.location.replace(urlDestino + window.location.search);
```

### **Método 2: Função getUrl() (Páginas com getUrl)**
```javascript
function getUrl(path) {
    // ... código de detecção de ambiente ...
    return url + window.location.search; // Preserva automaticamente
}

window.location.href = getUrl("/conta/saque.html");
```

### **Método 3: SessionStorage (payment.html)**
```javascript
// Antes de entrar no payment.html:
sessionStorage.setItem('trackingParams', window.location.search);

// No payment.html (registro temporário):
registrarTrackingParams(); // Adiciona temporariamente na URL

// Ao sair do payment.html:
redirectUrl = urlDestino + getTrackingParams(); // Restaura do sessionStorage
```

## ✅ Resultado Final:

**SIM, está totalmente funcional!**

Os parâmetros são preservados em **TODAS as páginas** do funil, desde o `index.htm` até o `iof.html`, incluindo:

- ✅ Parâmetros UTM (utm_source, utm_medium, utm_campaign, etc.)
- ✅ Parâmetros de tracking (gclid, fbclid, etc.)
- ✅ Qualquer outro parâmetro customizado
- ✅ Preservação em botões "Voltar"
- ✅ Tratamento especial no payment.html (sem conflito com API PIX)
- ✅ Restauração após pagamento no iof.html

## 🧪 Como Testar:

1. Acesse: `index.htm?utm_source=google&utm_medium=cpc&teste=123`
2. Navegue pelo fluxo completo
3. Verifique se os parâmetros estão presentes em cada página
4. Após o pagamento, verifique se os parâmetros estão no `iof.html`

**Todos os parâmetros serão preservados automaticamente!** 🎉

