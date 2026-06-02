# 🔧 Solução: Erro de Conexão

## ❌ Problema
Você está recebendo: "Erro de conexão. Verifique sua internet e tente novamente."

## 🔍 Possíveis Causas e Soluções

### **1. Arquivo HTML aberto diretamente (file://)**

Se você está abrindo o `cpf.html` diretamente no navegador (duplo clique), isso não funciona porque:
- Navegadores bloqueiam requisições HTTP de arquivos locais
- Você precisa de um servidor web rodando

**✅ Solução:**
1. **Instale um servidor local:**
   - **XAMPP** (Windows): https://www.apachefriends.org/
   - **WAMP** (Windows): https://www.wampserver.com/
   - **MAMP** (Mac): https://www.mamp.info/

2. **Coloque os arquivos na pasta do servidor:**
   - XAMPP: `C:\xampp\htdocs\bancred.site\`
   - WAMP: `C:\wamp64\www\bancred.site\`

3. **Acesse pelo navegador:**
   - `http://localhost/bancred.site/cpf.html`

### **2. Arquivo PHP não encontrado**

**✅ Verifique:**
- O arquivo `consulta/cpf.php` existe?
- Está na pasta correta?
- Permissões estão corretas?

**Estrutura esperada:**
```
bancred.site/
├── consulta/
│   └── cpf.php  ← Deve existir aqui
├── cpf.html
└── ...
```

### **3. Servidor PHP não está rodando**

**✅ Verifique:**
- XAMPP/WAMP está rodando?
- Apache está ativo?
- PHP está habilitado?

**Teste:**
1. Acesse: `http://localhost/bancred.site/consulta/cpf.php`
2. Deve retornar JSON (mesmo que erro, mas deve responder)

### **4. Caminho da URL incorreto**

**✅ Ajuste no código:**

Abra `cpf.html` e encontre a linha:
```javascript
return 'http://localhost/bancred.site/consulta/cpf.php';
```

**Ajuste conforme seu servidor:**
- Se usar XAMPP: `http://localhost/bancred.site/consulta/cpf.php`
- Se usar WAMP: `http://localhost/bancred.site/consulta/cpf.php`
- Se usar outro: ajuste o caminho

### **5. CORS (Cross-Origin Resource Sharing)**

Se estiver em produção, pode ser problema de CORS.

**✅ Verifique no `consulta/cpf.php`:**
```php
header('Access-Control-Allow-Origin: *');
```
Deve estar presente.

## 🧪 Como Testar Passo a Passo

### **Passo 1: Verificar se PHP funciona**

Crie um arquivo `teste.php` na pasta `consulta/`:
```php
<?php
echo json_encode(['teste' => 'PHP funcionando!']);
?>
```

Acesse: `http://localhost/bancred.site/consulta/teste.php`
Deve mostrar: `{"teste":"PHP funcionando!"}`

### **Passo 2: Testar a API diretamente**

No navegador, abra o Console (F12) e execute:
```javascript
fetch('http://localhost/bancred.site/consulta/cpf.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify({cpf: '12345678909'})
})
.then(r => r.json())
.then(console.log)
.catch(console.error);
```

### **Passo 3: Verificar logs**

- Abra o Console do navegador (F12)
- Veja a aba "Console" para erros
- Veja a aba "Network" para requisições

## 🚀 Solução Rápida (Teste Local)

Se você só quer testar rapidamente sem servidor:

1. **Use um servidor Python simples:**
```bash
# Na pasta do projeto
python -m http.server 8000
```

2. **Mas isso NÃO vai executar PHP!**
   - Você precisa de PHP rodando
   - Use XAMPP/WAMP

## 📝 Checklist

- [ ] Servidor web instalado (XAMPP/WAMP)
- [ ] Servidor está rodando
- [ ] Arquivo `consulta/cpf.php` existe
- [ ] Acessando via `http://localhost/...` (não `file://`)
- [ ] PHP está habilitado no servidor
- [ ] Extensão cURL está habilitada no PHP
- [ ] Console do navegador mostra erros específicos

## 💡 Dica

Abra o Console do navegador (F12) e veja:
- Qual URL está sendo chamada
- Qual erro específico está acontecendo
- Isso vai ajudar muito a identificar o problema!

## 🆘 Ainda não funciona?

Me diga:
1. Como você está abrindo o arquivo? (duplo clique? servidor local?)
2. Qual servidor está usando? (XAMPP? WAMP? outro?)
3. O que aparece no Console do navegador (F12)?



