# 🚀 Deploy na Vercel - Resumo Rápido

## ✅ O que foi feito

1. ✅ Criado `vercel.json` com configuração de rotas e rewrites
2. ✅ Criado `package.json` para Vercel reconhecer o projeto
3. ✅ Criado `.vercelignore` para excluir arquivos desnecessários
4. ✅ Criado `.gitignore` para controle de versão
5. ✅ Ajustadas URLs das APIs nos HTMLs para funcionar na Vercel
6. ✅ Criada pasta `api/consulta/` com arquivos PHP para serverless functions
7. ✅ Criado `README_VERCEL.md` com documentação completa

## 📁 Estrutura Criada

```
bancred.site/
├── api/                    # Serverless Functions (PHP)
│   └── consulta/
│       ├── cpf.php
│       ├── processar.php
│       └── confirmar.php
├── vercel.json            # Configuração da Vercel
├── package.json           # Configuração do projeto
├── .vercelignore          # Arquivos ignorados no deploy
├── .gitignore            # Arquivos ignorados no Git
└── README_VERCEL.md       # Documentação completa
```

## 🚀 Como Fazer Deploy

### Opção 1: Via Dashboard (Mais Fácil)

1. Acesse [vercel.com](https://vercel.com) e faça login
2. Clique em **"Add New Project"**
3. Conecte seu repositório Git (GitHub, GitLab, Bitbucket)
4. Configure:
   - **Framework Preset**: Other
   - **Root Directory**: `.` (raiz)
   - **Build Command**: (deixe vazio)
   - **Output Directory**: (deixe vazio)
5. Clique em **"Deploy"**

### Opção 2: Via CLI

```bash
# Instalar Vercel CLI (se ainda não tiver)
npm i -g vercel

# Login
vercel login

# Deploy
vercel

# Deploy em produção
vercel --prod
```

## 🔧 URLs Configuradas

As URLs foram ajustadas para funcionar automaticamente:

- **Local**: `http://localhost/bancred.site/consulta/cpf.php`
- **Vercel**: `https://seu-dominio.vercel.app/consulta/cpf`

O sistema detecta automaticamente o ambiente!

## 📝 Rotas Disponíveis

- `/` → Página inicial
- `/cpf` → Consulta CPF
- `/pessoa` → Dados pessoais
- `/simulacao` → Simulação de empréstimo
- `/analise` → Análise de crédito
- `/aprovado` → Aprovação
- `/endereco` → Endereço
- `/credenciais` → Credenciais
- `/configurando-conta` → Configurando conta
- `/conta` → Área logada
- `/consulta/cpf` → API CPF
- `/consulta/processar` → API PIX
- `/consulta/confirmar` → API Confirmação PIX

## ⚠️ Importante

### PHP na Vercel

A Vercel suporta PHP através do runtime `@vercel/php`, mas tem limitações:

- ⏱️ Timeout: 10s (Hobby) ou 60s (Pro)
- 💾 Memória limitada
- 📁 Sem sistema de arquivos persistente

### Alternativa: API Externa

Se precisar de mais recursos, considere hospedar os PHP em:
- Hostinger, HostGator (hospedagem PHP tradicional)
- Railway, Render (suportam PHP)
- AWS Lambda + API Gateway

Nesse caso, ajuste as URLs nos HTMLs para apontar para o servidor externo.

## 🧪 Testar Localmente

```bash
# Instalar Vercel CLI
npm i -g vercel

# Rodar localmente
vercel dev
```

Acesse `http://localhost:3000` para testar.

## 📚 Documentação Completa

Veja `README_VERCEL.md` para documentação detalhada.

## ✅ Checklist Antes do Deploy

- [x] Arquivos PHP em `api/consulta/`
- [x] `vercel.json` configurado
- [x] `package.json` criado
- [x] URLs ajustadas nos HTMLs
- [ ] Testado localmente com `vercel dev` (opcional)
- [ ] Deploy realizado
- [ ] URLs testadas em produção

---

**Pronto para deploy!** 🎉



