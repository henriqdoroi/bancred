# ⚡ Comandos Rápidos - Vercel CLI

## 🚀 Instalação (Uma vez só)

```powershell
# 1. Instalar Vercel CLI globalmente
npm install -g vercel

# 2. Verificar instalação
vercel --version
```

## 🔐 Login (Uma vez só)

```powershell
vercel login
```

## 📦 Deploy

```powershell
# Deploy de teste (preview)
vercel

# Deploy em produção
vercel --prod
```

## 🧪 Testar Localmente

```powershell
vercel dev
```

Acesse: `http://localhost:3000`

## 📋 Comandos Úteis

```powershell
# Ver informações do projeto
vercel inspect

# Listar deployments
vercel ls

# Ver logs
vercel logs

# Remover projeto
vercel remove
```

## 🔄 Workflow Completo

```powershell
# 1. Ir para a pasta do projeto
cd "C:\Downloaded Web Sites\bancred.site"

# 2. Fazer deploy de teste
vercel

# 3. Testar a URL fornecida

# 4. Se tudo OK, fazer deploy em produção
vercel --prod
```

---

**Nota**: Se algum comando não funcionar, consulte `GUIA_CLI_VERCEL.md` para instruções detalhadas.



