# 🧪 Guia Completo de Teste - Funil de Upsells

## ✅ Correções Aplicadas

Todos os redirecionamentos foram corrigidos para funcionar no **localhost** sem redirecionar para domínios externos.

### O que foi corrigido:

1. ✅ **Redirecionamentos para bancred.shop** → Agora usa caminhos relativos no localhost
2. ✅ **Validação de userData** → Em modo de teste, cria dados fake automaticamente
3. ✅ **Extensões de arquivos** → Corrigido para usar `.htm` e `.html` corretamente
4. ✅ **Caminhos de redirecionamento** → Todos adaptados para localhost

## 🚀 Como Testar Agora

### 1. Copiar Arquivos para XAMPP

Copie toda a pasta `new` para:
```
C:\xampp\htdocs\new\
```

### 2. Iniciar XAMPP

- Abra o XAMPP Control Panel
- Inicie o **Apache**

### 3. Acessar Página de Teste

```
http://localhost/new/teste-funil.php
```

## 📋 Fluxo Completo de Teste

### Teste 1: Payment EMP (Primeiro Pagamento)
```
http://localhost/new/conta/checkout/pix/test-simulate.php?service=Payment EMP
```
**Resultado esperado:**
- Redireciona para `payment.html` (modo teste)
- Após 2 segundos, confirma pagamento automaticamente
- Redireciona para `iof2.htm` (UP1)

### Teste 2: Payment EMP UP1
```
http://localhost/new/conta/checkout/pix/test-simulate.php?service=Payment EMP UP1
```
**Resultado esperado:**
- Redireciona para `payment.html` (modo teste)
- Após 2 segundos, confirma pagamento automaticamente
- Redireciona para `tarifa-cadastro.htm` (UP2)

### Teste 3: Payment EMP UP2
```
http://localhost/new/conta/checkout/pix/test-simulate.php?service=Payment EMP UP2
```
**Resultado esperado:**
- Redireciona para `payment.html` (modo teste)
- Após 2 segundos, confirma pagamento automaticamente
- Redireciona para `aumento-limite.htm` (UP3)

### Teste 4: Payment EMP UP3
```
http://localhost/new/conta/checkout/pix/test-simulate.php?service=Payment EMP UP3
```
**Resultado esperado:**
- Redireciona para `payment.html` (modo teste)
- Após 2 segundos, confirma pagamento automaticamente
- Redireciona para `assinatura.htm` (UP4)

### Teste 5: Payment EMP UP4
```
http://localhost/new/conta/checkout/pix/test-simulate.php?service=Payment EMP UP4
```
**Resultado esperado:**
- Redireciona para `payment.html` (modo teste)
- Após 2 segundos, confirma pagamento automaticamente
- Redireciona para `confirmacao-dados.htm` (UP5)

### Teste 6: Payment EMP UP5
```
http://localhost/new/conta/checkout/pix/test-simulate.php?service=Payment EMP UP5
```
**Resultado esperado:**
- Redireciona para `payment.html` (modo teste)
- Após 2 segundos, confirma pagamento automaticamente
- Redireciona para `iof.html` (UP6 - Final)

## 🎯 Testar Fluxo Completo em Sequência

1. Acesse: `http://localhost/new/teste-funil.php`
2. Clique em cada botão na ordem:
   - 🚀 Iniciar: Payment EMP
   - 📄 UP1: iof2.htm
   - 💰 UP2: tarifa-cadastro.htm
   - 📈 UP3: aumento-limite.htm
   - ✍️ UP4: assinatura.htm
   - ✅ UP5: confirmacao-dados.htm

## ⚠️ Modo de Teste Ativo

Quando você acessa via `localhost`, o sistema:
- ✅ **NÃO redireciona** para bancred.shop
- ✅ **Cria dados fake** automaticamente (userData)
- ✅ **Confirma pagamentos** automaticamente após 2 segundos
- ✅ **Usa caminhos relativos** para todos os redirecionamentos

## 🐛 Solução de Problemas

### Erro 404
- Verifique se copiou os arquivos para `C:\xampp\htdocs\new\`
- Verifique se o Apache está rodando

### Redirecionamento para bancred.shop
- Certifique-se de estar acessando via `http://localhost/`
- Não use `file://` ou outros protocolos

### Dados não aparecem
- Limpe o `sessionStorage` do navegador (F12 → Application → Session Storage → Clear)
- Recarregue a página

## ✅ Checklist de Teste

- [ ] Payment EMP → iof2.htm
- [ ] Payment EMP UP1 → tarifa-cadastro.htm
- [ ] Payment EMP UP2 → aumento-limite.htm
- [ ] Payment EMP UP3 → assinatura.htm
- [ ] Payment EMP UP4 → confirmacao-dados.htm
- [ ] Payment EMP UP5 → iof.html
- [ ] Nenhum redirecionamento para bancred.shop no localhost
- [ ] Dados fake são criados automaticamente
- [ ] Pagamentos são confirmados automaticamente

