# 🧪 Como Testar a Preservação de Parâmetros de Query String

## ✅ O que foi implementado:

Todos os redirecionamentos no fluxo completo agora preservam os parâmetros de query string (`window.location.search`), incluindo:
- Parâmetros UTM (utm_source, utm_medium, utm_campaign, etc.)
- Parâmetros de tracking (gclid, fbclid, etc.)
- Qualquer outro parâmetro customizado

## 🚀 Como Testar:

### **Teste Completo do Fluxo:**

1. **Abra o navegador e acesse a página inicial com parâmetros:**
   ```
   http://localhost/index.htm?utm_source=google&utm_medium=cpc&utm_campaign=teste&gclid=abc123
   ```
   ou em produção:
   ```
   https://bancred.site/index.htm?utm_source=google&utm_medium=cpc&utm_campaign=teste&gclid=abc123
   ```

2. **Verifique se os parâmetros aparecem na URL:**
   - Abra o Console do navegador (F12)
   - Digite: `window.location.search`
   - Deve mostrar: `?utm_source=google&utm_medium=cpc&utm_campaign=teste&gclid=abc123`

3. **Clique no botão "Começar Simulação" ou "Simular Grátis"**

4. **Verifique cada página do fluxo:**
   
   Após cada redirecionamento, verifique se os parâmetros ainda estão na URL:
   
   - ✅ **cpf.html** - Deve ter os parâmetros
   - ✅ **pessoa.html** - Deve ter os parâmetros
   - ✅ **simulacao.html** - Deve ter os parâmetros
   - ✅ **analise.html** - Deve ter os parâmetros
   - ✅ **aprovado.html** - Deve ter os parâmetros
   - ✅ **endereco.html** - Deve ter os parâmetros
   - ✅ **credenciais.html** - Deve ter os parâmetros
   - ✅ **configurando-conta.html** - Deve ter os parâmetros
   - ✅ **conta.html** - Deve ter os parâmetros
   - ✅ **conta/saque.html** - Deve ter os parâmetros
   - ✅ **conta/saque/confirmar.html** - Deve ter os parâmetros
   - ✅ **conta/saque/seguro-prestamista.html** - Deve ter os parâmetros
   - ✅ **conta/saque/finalizar.html** - Deve ter os parâmetros
   - ✅ **conta/checkout.html** - Deve ter os parâmetros
   - ✅ **conta/checkout/pix/payment.html** - Deve ter os parâmetros

### **Teste Rápido no Console:**

Você pode testar diretamente no console do navegador:

```javascript
// 1. Defina parâmetros de teste
const params = '?utm_source=google&utm_medium=cpc&utm_campaign=teste&gclid=abc123';

// 2. Navegue para a primeira página com os parâmetros
window.location.href = 'http://localhost/index.htm' + params;

// 3. Em cada página, verifique se os parâmetros estão preservados
console.log('Parâmetros atuais:', window.location.search);
```

### **Teste Automatizado (Script):**

Crie um arquivo `teste-parametros.html` e abra no navegador:

```html
<!DOCTYPE html>
<html>
<head>
    <title>Teste de Parâmetros</title>
</head>
<body>
    <h1>Teste de Preservação de Parâmetros</h1>
    <button onclick="testarFluxo()">Iniciar Teste</button>
    <div id="resultado"></div>
    
    <script>
        function testarFluxo() {
            const params = '?utm_source=google&utm_medium=cpc&utm_campaign=teste&gclid=abc123';
            const baseUrl = window.location.origin;
            
            // Lista de páginas para testar
            const paginas = [
                '/index.htm',
                '/cpf.html',
                '/pessoa.html',
                '/simulacao.html',
                '/analise.html',
                '/aprovado.html',
                '/endereco.html',
                '/credenciais.html',
                '/configurando-conta.html',
                '/conta.html',
                '/conta/saque.html',
                '/conta/checkout.html'
            ];
            
            let resultados = '<h2>Resultados do Teste:</h2><ul>';
            
            paginas.forEach((pagina, index) => {
                const urlCompleta = baseUrl + pagina + params;
                resultados += `<li>${pagina}: <a href="${urlCompleta}" target="_blank">Testar</a></li>`;
            });
            
            resultados += '</ul>';
            document.getElementById('resultado').innerHTML = resultados;
        }
    </script>
</body>
</html>
```

## 🔍 Verificações Manuais:

### **1. Verificar no Console do Navegador:**

Em cada página, abra o Console (F12) e execute:

```javascript
// Verificar parâmetros atuais
console.log('Parâmetros:', window.location.search);

// Verificar URL completa
console.log('URL completa:', window.location.href);

// Verificar se contém os parâmetros esperados
const temUtmSource = window.location.search.includes('utm_source=google');
console.log('Tem utm_source?', temUtmSource);
```

### **2. Verificar no Network Tab:**

1. Abra o DevTools (F12)
2. Vá para a aba "Network"
3. Navegue pelo fluxo
4. Verifique cada requisição de redirecionamento
5. Os parâmetros devem estar presentes na URL de destino

### **3. Verificar com Extensões de Tracking:**

Se você usa Google Analytics, Facebook Pixel, ou outras ferramentas de tracking:

1. Instale a extensão "Google Tag Assistant" ou similar
2. Navegue pelo fluxo
3. Verifique se os parâmetros UTM estão sendo capturados corretamente

## ✅ Checklist de Teste:

- [ ] Parâmetros preservados de `index.htm` → `cpf.html`
- [ ] Parâmetros preservados de `cpf.html` → `pessoa.html`
- [ ] Parâmetros preservados de `pessoa.html` → `simulacao.html`
- [ ] Parâmetros preservados de `simulacao.html` → `analise.html`
- [ ] Parâmetros preservados de `analise.html` → `aprovado.html`
- [ ] Parâmetros preservados de `aprovado.html` → `endereco.html`
- [ ] Parâmetros preservados de `endereco.html` → `credenciais.html`
- [ ] Parâmetros preservados de `credenciais.html` → `configurando-conta.html`
- [ ] Parâmetros preservados de `configurando-conta.html` → `conta.html`
- [ ] Parâmetros preservados de `conta.html` → `conta/saque.html`
- [ ] Parâmetros preservados de `conta/saque/confirmar.html` → `seguro-prestamista.html`
- [ ] Parâmetros preservados de `seguro-prestamista.html` → `finalizar.html`
- [ ] Parâmetros preservados de `finalizar.html` → `checkout.html`
- [ ] Parâmetros preservados de `checkout.html` → `payment.html`
- [ ] Parâmetros preservados em redirecionamentos de `payment.html` para páginas finais

## 🐛 Troubleshooting:

### **Problema: Parâmetros desaparecem em alguma página**

**Solução:**
1. Abra o Console do navegador (F12)
2. Vá para a página onde os parâmetros desaparecem
3. Verifique se há erros no console
4. Procure por redirecionamentos que não incluem `window.location.search`

### **Problema: Parâmetros duplicados**

**Solução:**
- Isso pode acontecer se a função `getUrl()` já adiciona os parâmetros e você também adiciona manualmente
- Verifique se não há duplicação: `getUrl("/path") + window.location.search` quando `getUrl` já adiciona

### **Problema: Parâmetros não aparecem no tracking**

**Solução:**
1. Verifique se os scripts de tracking (utmify, Google Analytics) estão carregados
2. Verifique se os parâmetros estão no formato correto (começam com `?`)
3. Teste com parâmetros simples primeiro: `?teste=123`

## 📝 Exemplos de URLs para Teste:

```
# Teste básico
http://localhost/index.htm?teste=123

# Teste com UTM completo
http://localhost/index.htm?utm_source=google&utm_medium=cpc&utm_campaign=emprestimo&utm_term=credito&utm_content=banner

# Teste com tracking IDs
http://localhost/index.htm?gclid=abc123&fbclid=xyz789

# Teste combinado
http://localhost/index.htm?utm_source=facebook&utm_medium=social&fbclid=test123&campaign_id=456
```

## 💡 Dica:

Para facilitar o teste, você pode criar um bookmark no navegador com JavaScript:

```javascript
javascript:(function(){
    const params = '?utm_source=google&utm_medium=cpc&utm_campaign=teste';
    window.location.href = window.location.origin + '/index.htm' + params;
})();
```

Salve como bookmark e clique sempre que quiser testar com os parâmetros!

## ✅ Resultado Esperado:

Após completar o teste, todos os parâmetros devem estar presentes na URL final, permitindo que:
- ✅ Google Analytics rastreie a origem da campanha
- ✅ Facebook Pixel identifique a fonte do tráfego
- ✅ Outras ferramentas de tracking funcionem corretamente
- ✅ Você possa analisar de onde vieram os usuários

