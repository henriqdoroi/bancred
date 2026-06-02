# 📥 Instruções de Instalação - Node.js e Vercel CLI

## ⚠️ Importante

Eu não posso instalar software diretamente no seu PC, mas criei um script que facilita muito o processo!

## 🚀 Método Automatizado (Recomendado)

### Passo 1: Executar o Script de Instalação

1. **Abra o PowerShell como Administrador:**
   - Pressione `Windows + X`
   - Clique em "Windows PowerShell (Admin)" ou "Terminal (Admin)"
   - Ou procure "PowerShell" no menu Iniciar, clique com botão direito e selecione "Executar como administrador"

2. **Navegue até a pasta do projeto:**
   ```powershell
   cd "C:\Downloaded Web Sites\bancred.site"
   ```

3. **Execute o script de instalação:**
   ```powershell
   .\instalar-node-vercel.ps1
   ```

4. **Siga as instruções na tela:**
   - O script vai baixar e instalar o Node.js automaticamente
   - Depois vai instalar a Vercel CLI
   - Aguarde a conclusão

5. **IMPORTANTE:** Após a instalação, feche o PowerShell e abra um novo (não precisa ser admin)

### Passo 2: Verificar Instalação

Abra um **novo PowerShell** (normal, não precisa ser admin) e execute:

```powershell
node --version
npm --version
vercel --version
```

Se aparecerem números de versão, está tudo instalado! ✅

## 📋 Método Manual (Se o Script Não Funcionar)

### 1. Instalar Node.js Manualmente

1. Acesse: **https://nodejs.org/**
2. Clique em **"Download Node.js (LTS)"** - a versão recomendada
3. Execute o arquivo `.msi` baixado
4. Siga o assistente de instalação:
   - ✅ Marque "Automatically install the necessary tools"
   - Clique em "Next" até finalizar
5. **Reinicie o PowerShell** após a instalação

### 2. Verificar Node.js

Abra um novo PowerShell e execute:

```powershell
node --version
npm --version
```

Deve aparecer algo como:
```
v20.x.x
10.x.x
```

### 3. Instalar Vercel CLI

No PowerShell, execute:

```powershell
npm install -g vercel
```

Aguarde a instalação terminar (pode levar alguns minutos).

### 4. Verificar Vercel CLI

```powershell
vercel --version
```

Deve aparecer algo como: `32.x.x`

## 🔐 Próximo Passo: Login na Vercel

Após instalar tudo, faça login:

```powershell
cd "C:\Downloaded Web Sites\bancred.site"
vercel login
```

Siga as instruções na tela para autenticar.

## 🚀 Depois do Login: Fazer Deploy

```powershell
# Deploy de teste
vercel

# Deploy em produção
vercel --prod
```

## 🐛 Problemas Comuns

### "node não é reconhecido"

- ✅ Reinicie o PowerShell após instalar Node.js
- ✅ Verifique se o Node.js foi instalado: `C:\Program Files\nodejs\`
- ✅ Se não funcionar, reinstale o Node.js

### "npm não é reconhecido"

- ✅ O npm vem junto com Node.js
- ✅ Se não funcionar, reinstale o Node.js
- ✅ Reinicie o PowerShell

### "vercel não é reconhecido"

- ✅ Instale: `npm install -g vercel`
- ✅ Verifique se o npm está funcionando: `npm --version`
- ✅ Tente usar: `npx vercel` (sem instalar globalmente)

### Script não executa

- ✅ Certifique-se de estar executando como Administrador
- ✅ Verifique a política de execução:
  ```powershell
  Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
  ```

## ✅ Checklist

- [ ] PowerShell aberto como Administrador
- [ ] Script `instalar-node-vercel.ps1` executado
- [ ] Node.js instalado (`node --version` funciona)
- [ ] npm instalado (`npm --version` funciona)
- [ ] Vercel CLI instalado (`vercel --version` funciona)
- [ ] Novo PowerShell aberto (não precisa ser admin)
- [ ] Login feito (`vercel login`)
- [ ] Pronto para deploy!

---

**Dúvidas?** Execute o script e me avise se encontrar algum problema!



