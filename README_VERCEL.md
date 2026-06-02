# 🚀 Deploy na Vercel - Guia Completo

Este guia explica como fazer o deploy do projeto Bancred na Vercel.

## 📋 Pré-requisitos

1. Conta na [Vercel](https://vercel.com)
2. [Vercel CLI](https://vercel.com/docs/cli) instalado (opcional, mas recomendado)
3. Git instalado

## 🔧 Configuração Inicial

### 1. Instalar Vercel CLI (Opcional)

```bash
npm i -g vercel
```

### 2. Login na Vercel

```bash
vercel login
```

## 📦 Estrutura do Projeto

O projeto foi organizado para funcionar na Vercel:

```
bancred.site/
├── api/                    # Serverless Functions (PHP)
│   └── consulta/
│       ├── cpf.php
│       ├── processar.php
│       └── confirmar.php
├── consulta/               # Arquivos PHP originais (backup)
├── conta/                  # Páginas da área logada
├── public/                 # Assets estáticos (CSS, JS, imagens)
├── vercel.json            # Configuração da Vercel
├── package.json           # Configuração do projeto
└── .vercelignore          # Arquivos ignorados no deploy
```

## 🚀 Deploy

### Opção 1: Via Vercel Dashboard (Recomendado)

1. Acesse [vercel.com](https://vercel.com)
2. Clique em "Add New Project"
3. Conecte seu repositório Git (GitHub, GitLab, Bitbucket)
4. Configure o projeto:
   - **Framework Preset**: Other
   - **Root Directory**: `.` (raiz do projeto)
   - **Build Command**: (deixe vazio)
   - **Output Directory**: (deixe vazio)
5. Clique em "Deploy"

### Opção 2: Via CLI

```bash
# Na raiz do projeto
vercel

# Para produção
vercel --prod
```

## ⚙️ Configurações Importantes

### URLs das APIs

As URLs das APIs foram configuradas para funcionar automaticamente:

- **Local**: `http://localhost/bancred.site/consulta/cpf.php`
- **Produção (Vercel)**: `https://seu-dominio.vercel.app/consulta/cpf`

O sistema detecta automaticamente o ambiente e usa a URL correta.

### Rotas Configuradas

O arquivo `vercel.json` configura as seguintes rotas:

- `/cpf` → `/cpf.html`
- `/pessoa` → `/pessoa.html`
- `/simulacao` → `/simulacao.html`
- `/analise` → `/analise.html`
- `/aprovado` → `/aprovado.html`
- `/endereco` → `/endereco.html`
- `/credenciais` → `/credenciais.html`
- `/configurando-conta` → `/configurando-conta.html`
- `/conta` → `/conta.html`
- `/consulta/cpf` → `/api/consulta/cpf.php`
- `/consulta/processar` → `/api/consulta/processar.php`
- `/consulta/confirmar` → `/api/consulta/confirmar.php`

## 🔐 Variáveis de Ambiente

Se necessário, configure variáveis de ambiente na Vercel:

1. Acesse o projeto na Vercel Dashboard
2. Vá em **Settings** → **Environment Variables**
3. Adicione as variáveis necessárias (se houver)

## 📝 PHP na Vercel

A Vercel suporta PHP através do runtime `@vercel/php`. Os arquivos PHP estão em `api/consulta/` e serão executados como serverless functions.

### Limitações do PHP na Vercel

- Timeout máximo: 10 segundos (Hobby) ou 60 segundos (Pro)
- Memória limitada
- Sem acesso a sistema de arquivos persistente

### Alternativa: API Externa

Se precisar de mais recursos PHP, considere:

1. **Hostinger, HostGator, etc.**: Hospedar apenas os arquivos PHP
2. **Railway, Render**: Serviços que suportam PHP nativamente
3. **AWS Lambda + API Gateway**: Para serverless PHP

## 🧪 Testando o Deploy

Após o deploy, teste as seguintes URLs:

1. **Página inicial**: `https://seu-dominio.vercel.app/`
2. **CPF**: `https://seu-dominio.vercel.app/cpf`
3. **API CPF**: `https://seu-dominio.vercel.app/consulta/cpf`

## 🐛 Troubleshooting

### Erro 404 nas APIs

- Verifique se os arquivos PHP estão em `api/consulta/`
- Verifique se o `vercel.json` está configurado corretamente
- Verifique os logs na Vercel Dashboard

### Erro 500 nas APIs

- Verifique os logs da função serverless
- Verifique se todas as dependências PHP estão disponíveis
- Verifique se as variáveis de ambiente estão configuradas

### Assets não carregam

- Verifique se os caminhos estão corretos (relativos ou absolutos)
- Verifique se os arquivos estão no repositório
- Limpe o cache do navegador

## 📚 Recursos Adicionais

- [Documentação Vercel](https://vercel.com/docs)
- [Vercel PHP Runtime](https://vercel.com/docs/runtimes#official-runtimes/php)
- [Vercel CLI](https://vercel.com/docs/cli)

## 🔄 Atualizações

Para atualizar o projeto:

```bash
# Via CLI
vercel --prod

# Ou faça push para o repositório Git conectado
git push origin main
```

A Vercel fará deploy automático quando detectar mudanças no repositório.

## ✅ Checklist de Deploy

- [ ] Arquivos PHP copiados para `api/consulta/`
- [ ] `vercel.json` configurado
- [ ] `package.json` criado
- [ ] URLs das APIs ajustadas nos HTMLs
- [ ] Testado localmente com `vercel dev`
- [ ] Deploy realizado
- [ ] URLs testadas em produção
- [ ] Variáveis de ambiente configuradas (se necessário)

---

**Nota**: Se você preferir manter os arquivos PHP em um servidor separado, ajuste as URLs nos arquivos HTML para apontar para o servidor PHP externo.



