# 📋 Instruções para Testar no XAMPP

## ⚠️ IMPORTANTE: Copiar Arquivos para o XAMPP

### Passo 1: Localizar a Pasta do XAMPP
O XAMPP geralmente está em:
```
C:\xampp\htdocs\
```

### Passo 2: Copiar Toda a Pasta do Projeto
Copie **TODA** a pasta `new` para:
```
C:\xampp\htdocs\new\
```

Certifique-se de que a estrutura fique assim:
```
C:\xampp\htdocs\new\
├── conta/
│   └── checkout/
│       └── pix/
│           ├── payment.html
│           ├── test-payment.php
│           └── test-simulate.php
├── consulta/
│   └── confirmar-test.php
├── teste-funil.php
└── ... (outros arquivos)
```

## 🚀 Como Acessar

### Opção 1: Página Principal de Teste (RECOMENDADO)
```
http://localhost/new/teste-funil.php
```

### Opção 2: Página de Teste na Pasta PIX
```
http://localhost/new/conta/checkout/pix/test-payment.php
```

### Opção 3: Testar Diretamente um Upsell
```
http://localhost/new/conta/checkout/pix/test-simulate.php?service=Payment EMP
```

## ✅ Verificar se Está Funcionando

1. **Inicie o XAMPP** (Apache deve estar rodando)
2. **Abra o navegador** e acesse: `http://localhost/new/teste-funil.php`
3. **Você deve ver** uma página com botões coloridos para testar cada upsell

## 🐛 Se Ainda Der Erro 404

### Verificar:
1. ✅ O Apache está rodando no XAMPP?
2. ✅ Os arquivos foram copiados para `C:\xampp\htdocs\new\`?
3. ✅ A estrutura de pastas está correta?

### Testar se o XAMPP está funcionando:
Acesse: `http://localhost/`
- Se aparecer a página do XAMPP, está funcionando
- Se não aparecer, verifique se o Apache está iniciado

### Verificar Caminho Correto:
1. Abra o Windows Explorer
2. Vá para: `C:\xampp\htdocs\`
3. Verifique se existe a pasta `new`
4. Dentro de `new`, verifique se existe `conta/checkout/pix/test-payment.php`

## 📝 Links de Teste Rápidos

Depois de copiar os arquivos, teste estes links:

```
http://localhost/new/teste-funil.php
http://localhost/new/conta/checkout/pix/test-simulate.php?service=Payment EMP
http://localhost/new/conta/checkout/pix/payment.html?test=1&id=test-123&service=Payment EMP
```

## 🎯 Fluxo de Teste

1. Clique em "🚀 Iniciar: Payment EMP"
2. Aguarde 2 segundos (pagamento será confirmado automaticamente)
3. Você será redirecionado para `iof2.html`
4. De lá, pode continuar testando os outros upsells

