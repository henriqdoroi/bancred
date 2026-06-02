# 🚀 Instalação Simples - Passo a Passo

## ⚡ Método Mais Fácil

### Opção 1: Usar o arquivo .bat (Mais Simples)

1. **Clique duas vezes no arquivo:** `INSTALAR_AGORA.bat`
2. **Siga as instruções na tela**
3. O script vai abrir os links e guiar você

### Opção 2: Manual (Passo a Passo)

## 📥 Passo 1: Instalar Node.js

1. **Acesse:** https://nodejs.org/
2. **Clique em:** "Download Node.js (LTS)" - botão verde
3. **Execute o arquivo** `.msi` baixado
4. **Siga o assistente:**
   - ✅ Marque "Automatically install the necessary tools"
   - Clique em "Next" até finalizar
5. **Reinicie o PowerShell** (feche e abra novamente)

## ✅ Passo 2: Verificar se Instalou

Abra um **novo PowerShell** e digite:

```powershell
node --version
npm --version
```

**Se aparecerem números**, está instalado! ✅

**Se aparecer erro**, reinicie o PowerShell e tente novamente.

## 📦 Passo 3: Instalar Vercel CLI

No PowerShell, digite:

```powershell
npm install -g vercel
```

Aguarde terminar (pode levar alguns minutos).

## ✅ Passo 4: Verificar Vercel CLI

```powershell
vercel --version
```

**Se aparecer um número**, está instalado! ✅

## 🔐 Passo 5: Fazer Login

```powershell
cd "C:\Downloaded Web Sites\bancred.site"
vercel login
```

Siga as instruções na tela para autenticar.

## 🚀 Passo 6: Fazer Deploy

```powershell
# Deploy de teste primeiro
vercel

# Depois, deploy em produção
vercel --prod
```

## 🎯 Resumo dos Comandos

```powershell
# 1. Verificar Node.js
node --version

# 2. Instalar Vercel CLI
npm install -g vercel

# 3. Ir para a pasta do projeto
cd "C:\Downloaded Web Sites\bancred.site"

# 4. Login
vercel login

# 5. Deploy de teste
vercel

# 6. Deploy em produção
vercel --prod
```

## 🐛 Problemas?

### "node não é reconhecido"
- ✅ Reinicie o PowerShell
- ✅ Verifique se instalou o Node.js
- ✅ Tente reinstalar

### "npm não é reconhecido"
- ✅ npm vem com Node.js
- ✅ Reinicie o PowerShell
- ✅ Reinstale Node.js se necessário

### "vercel não é reconhecido"
- ✅ Execute: `npm install -g vercel`
- ✅ Aguarde terminar
- ✅ Reinicie o PowerShell

---

**Pronto!** Siga esses passos e você conseguirá fazer o deploy! 🎉



