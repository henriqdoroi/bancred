# 📁 Como Copiar Arquivos para o XAMPP

## ⚠️ IMPORTANTE

Quando você cria ou modifica arquivos no projeto, você precisa **copiar para o XAMPP**!

## 📋 Estrutura de Pastas

### **Pasta do Projeto (onde você edita):**
```
C:\Downloaded Web Sites\bancred.site\
├── consulta\
│   ├── cpf.php
│   └── teste-api.php
└── cpf.html
```

### **Pasta do XAMPP (onde o servidor lê):**
```
C:\xampp\htdocs\bancred.site\
├── consulta\
│   ├── cpf.php
│   └── teste-api.php
└── cpf.html
```

## 🔄 Como Copiar Arquivos

### **Opção 1: Copiar Manualmente**

1. Abra o Explorador de Arquivos
2. Vá até: `C:\Downloaded Web Sites\bancred.site\`
3. Selecione os arquivos que modificou
4. Copie (Ctrl+C)
5. Vá até: `C:\xampp\htdocs\bancred.site\`
6. Cole (Ctrl+V)

### **Opção 2: Usar PowerShell (Rápido)**

Abra o PowerShell na pasta do projeto e execute:

```powershell
# Copiar arquivo específico
Copy-Item "consulta\teste-api.php" -Destination "C:\xampp\htdocs\bancred.site\consulta\teste-api.php" -Force

# Copiar pasta inteira (atualiza tudo)
Copy-Item "consulta\*" -Destination "C:\xampp\htdocs\bancred.site\consulta\" -Recurse -Force

# Copiar todo o projeto
Copy-Item "*" -Destination "C:\xampp\htdocs\bancred.site\" -Recurse -Force
```

### **Opção 3: Sincronizar Pastas (Recomendado)**

Use um programa como:
- **FreeFileSync** (gratuito)
- **SyncToy** (Microsoft)
- **Robocopy** (já vem no Windows)

Configure para sincronizar:
- **Origem:** `C:\Downloaded Web Sites\bancred.site\`
- **Destino:** `C:\xampp\htdocs\bancred.site\`

## ✅ Checklist

Sempre que modificar arquivos, verifique:

- [ ] Arquivo existe na pasta do projeto?
- [ ] Arquivo foi copiado para `C:\xampp\htdocs\bancred.site\`?
- [ ] Estrutura de pastas está igual?
- [ ] Testei no navegador?

## 💡 Dica

**Solução Definitiva:** Trabalhe diretamente na pasta do XAMPP!

1. Abra o projeto em: `C:\xampp\htdocs\bancred.site\`
2. Edite os arquivos lá diretamente
3. Não precisa copiar nada!

## 🚀 Script Automático (Opcional)

Crie um arquivo `copiar.bat` na pasta do projeto:

```batch
@echo off
echo Copiando arquivos para XAMPP...
xcopy /E /I /Y "consulta" "C:\xampp\htdocs\bancred.site\consulta\"
xcopy /E /I /Y "public" "C:\xampp\htdocs\bancred.site\public\"
copy /Y "*.html" "C:\xampp\htdocs\bancred.site\"
copy /Y "*.htm" "C:\xampp\htdocs\bancred.site\"
echo Pronto!
pause
```

Execute sempre que modificar arquivos!



