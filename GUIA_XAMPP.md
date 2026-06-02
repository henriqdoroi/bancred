# 🚀 Guia Completo: Configurar XAMPP

## 📋 Passo a Passo

### **1. Instalar e Iniciar XAMPP**

1. ✅ XAMPP já instalado? Ótimo!
2. Abra o **XAMPP Control Panel**
   - Procure "XAMPP Control Panel" no menu Iniciar
   - Ou vá em: `C:\xampp\xampp-control.exe`

3. **Inicie o Apache:**
   - Clique no botão **"Start"** ao lado de "Apache"
   - Deve ficar verde ✅
   - Se der erro de porta, veja a seção "Problemas Comuns" abaixo

### **2. Copiar Arquivos para o XAMPP**

1. **Localize a pasta htdocs do XAMPP:**
   ```
   C:\xampp\htdocs\
   ```

2. **Copie toda a pasta do projeto:**
   - Copie a pasta `bancred.site` inteira
   - Cole dentro de `C:\xampp\htdocs\`
   
   **Resultado final:**
   ```
   C:\xampp\htdocs\bancred.site\
   ├── consulta\
   │   └── cpf.php
   ├── cpf.html
   ├── index.htm
   └── ... (outros arquivos)
   ```

### **3. Ajustar o Código para XAMPP**

O código já está preparado, mas vamos verificar se precisa ajustar a URL.

### **4. Testar**

1. Abra o navegador
2. Acesse:
   ```
   http://localhost/bancred.site/cpf.html
   ```
3. Teste com um CPF válido

## 🔧 Verificações Importantes

### **Verificar se Apache está rodando:**
- XAMPP Control Panel deve mostrar Apache como "Running" (verde)
- Acesse: `http://localhost` - deve mostrar página do XAMPP

### **Verificar se PHP está funcionando:**
- Acesse: `http://localhost/bancred.site/consulta/cpf.php`
- Deve retornar JSON (mesmo que erro, mas deve responder)

### **Verificar estrutura de pastas:**
```
C:\xampp\htdocs\bancred.site\
├── consulta\
│   ├── cpf.php  ← Deve existir!
│   └── cpf-receitaws-exemplo.php
├── cpf.html
├── index.htm
└── ...
```

## ⚠️ Problemas Comuns

### **Erro: "Port 80 already in use"**

**Solução:**
1. No XAMPP Control Panel, clique em "Config" ao lado de Apache
2. Selecione "httpd.conf"
3. Procure por `Listen 80`
4. Mude para `Listen 8080`
5. Salve e reinicie Apache
6. Acesse: `http://localhost:8080/bancred.site/cpf.html`

### **Erro: "Apache won't start"**

**Solução:**
1. Feche programas que usam porta 80 (Skype, IIS, etc.)
2. Execute XAMPP como Administrador
3. Verifique se não há outro servidor web rodando

### **Erro 404: "File not found"**

**Solução:**
1. Verifique se os arquivos estão em `C:\xampp\htdocs\bancred.site\`
2. Verifique se o nome da pasta está correto
3. Verifique permissões da pasta

### **Erro: "cURL não habilitado"**

**Solução:**
1. Abra: `C:\xampp\php\php.ini`
2. Procure por `;extension=curl`
3. Remova o `;` (fica: `extension=curl`)
4. Salve e reinicie Apache

## 🧪 Teste Rápido

### **Teste 1: Verificar Apache**
```
http://localhost
```
Deve mostrar página do XAMPP ✅

### **Teste 2: Verificar PHP**
Crie um arquivo `teste.php` em `C:\xampp\htdocs\bancred.site\`:
```php
<?php
phpinfo();
?>
```
Acesse: `http://localhost/bancred.site/teste.php`
Deve mostrar informações do PHP ✅

### **Teste 3: Testar API**
Acesse: `http://localhost/bancred.site/consulta/cpf.php`
Deve retornar JSON ✅

## 📝 Próximos Passos

1. ✅ XAMPP instalado
2. ✅ Apache rodando
3. ✅ Arquivos copiados
4. ⏭️ Testar o formulário
5. ⏭️ Verificar se ReceitaWS está funcionando

## 💡 Dicas

- **Sempre inicie o Apache antes de testar**
- **Use `http://localhost/...` nunca `file://`**
- **Verifique o Console do navegador (F12) para erros**
- **Mantenha o XAMPP Control Panel aberto**



