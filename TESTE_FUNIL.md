# 🧪 Guia de Teste do Funil de Upsells

## 📋 Como Testar no XAMPP

### 1. Copiar Arquivos para o XAMPP

Copie toda a pasta do projeto para:
```
C:\xampp\htdocs\new\
```

### 2. Acessar a Página de Teste

Abra no navegador:
```
http://localhost/new/conta/checkout/pix/test-payment.php
```

### 3. Testar Cada Upsell Individualmente

Na página de teste, você verá botões para testar cada etapa do funil:

#### 🚀 Fluxo Completo:
1. **Payment EMP** → Redireciona para `iof2.html` (UP1)
2. **Payment EMP UP1** → Redireciona para `tarifa-cadastro.html` (UP2)
3. **Payment EMP UP2** → Redireciona para `aumento-limite.html` (UP3)
4. **Payment EMP UP3** → Redireciona para `assinatura.html` (UP4)
5. **Payment EMP UP4** → Redireciona para `confirmacao-dados.html` (UP5)
6. **Payment EMP UP5** → Redireciona para `iof.html` (UP6 - Final)

### 4. Links Diretos para Teste

Você também pode testar diretamente acessando:

#### Testar Payment EMP (Primeiro Pagamento):
```
http://localhost/new/conta/checkout/pix/test-simulate.php?service=Payment EMP
```

#### Testar Payment EMP UP1:
```
http://localhost/new/conta/checkout/pix/test-simulate.php?service=Payment EMP UP1
```

#### Testar Payment EMP UP2:
```
http://localhost/new/conta/checkout/pix/test-simulate.php?service=Payment EMP UP2
```

#### Testar Payment EMP UP3:
```
http://localhost/new/conta/checkout/pix/test-simulate.php?service=Payment EMP UP3
```

#### Testar Payment EMP UP4:
```
http://localhost/new/conta/checkout/pix/test-simulate.php?service=Payment EMP UP4
```

#### Testar Payment EMP UP5:
```
http://localhost/new/conta/checkout/pix/test-simulate.php?service=Payment EMP UP5
```

### 5. Testar Página de Pagamento Diretamente

Para testar a página de pagamento com um serviço específico:

```
http://localhost/new/conta/checkout/pix/payment.html?test=1&id=test-123&service=Payment EMP
```

Substitua `Payment EMP` por:
- `Payment EMP UP1`
- `Payment EMP UP2`
- `Payment EMP UP3`
- `Payment EMP UP4`
- `Payment EMP UP5`

## 🔄 Como Funciona o Modo de Teste

1. **Simulação Automática**: Quando você acessa `payment.html` com `?test=1`, o sistema detecta que está em modo de teste
2. **Confirmação Automática**: Após 2 segundos, o pagamento é automaticamente confirmado
3. **Redirecionamento**: O sistema redireciona automaticamente para o próximo upsell baseado no serviço

## ✅ Checklist de Teste

- [ ] Payment EMP → iof2.html
- [ ] Payment EMP UP1 → tarifa-cadastro.html
- [ ] Payment EMP UP2 → aumento-limite.html
- [ ] Payment EMP UP3 → assinatura.html
- [ ] Payment EMP UP4 → confirmacao-dados.html
- [ ] Payment EMP UP5 → iof.html

## 🐛 Solução de Problemas

### Erro: "Esta página só funciona no localhost"
- Certifique-se de estar acessando via `http://localhost/` e não via `file://`

### Redirecionamento não funciona
- Verifique se o caminho está correto no `payment.html`
- Verifique o console do navegador (F12) para ver mensagens de erro

### Dados não aparecem
- Limpe o `sessionStorage` do navegador
- Recarregue a página

## 📝 Notas Importantes

- ⚠️ O modo de teste **SÓ FUNCIONA NO LOCALHOST**
- ⚠️ Não use em produção - é apenas para desenvolvimento
- ✅ Todos os dados são simulados e não fazem requisições reais à API PIX

