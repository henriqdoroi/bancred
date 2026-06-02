# 🚀 Guia Completo - Deploy na Vercel via CLI

## 📋 Passo 1: Instalar Node.js

A Vercel CLI precisa do Node.js instalado. Siga estes passos:

### 1.1. Baixar Node.js

1. Acesse: https://nodejs.org/
2. Baixe a versão **LTS** (Long Term Support) - recomendada
3. Execute o instalador `.msi` baixado

### 1.2. Instalar Node.js

1. Clique duas vezes no arquivo baixado
2. Siga o assistente de instalação:
   - ✅ Marque "Automatically install the necessary tools"
   - ✅ Clique em "Next" até finalizar
3. **Reinicie o PowerShell/Terminal** após a instalação

### 1.3. Verificar Instalação

Abra um **novo** PowerShell e execute:

```powershell
node --version
npm --version
```

Você deve ver algo como:
```
v20.x.x
10.x.x
```

## 📦 Passo 2: Instalar Vercel CLI

Com o Node.js instalado, instale a Vercel CLI:

```powershell
npm install -g vercel
```

Isso pode levar alguns minutos. Aguarde a conclusão.

### Verificar Instalação

```powershell
vercel --version
```

Você deve ver algo como: `32.x.x`

## 🔐 Passo 3: Login na Vercel

### 3.1. Criar Conta (se não tiver)

1. Acesse: https://vercel.com/signup
2. Crie uma conta (pode usar GitHub, GitLab, Bitbucket ou email)

### 3.2. Fazer Login via CLI

No PowerShell, na pasta do projeto, execute:

```powershell
vercel login
```

Você verá:
- Opção 1: Abrir navegador automaticamente
- Opção 2: Copiar e colar um link

Siga as instruções na tela para autenticar.

## 📁 Passo 4: Preparar o Projeto

Certifique-se de estar na pasta do projeto:

```powershell
cd "C:\Downloaded Web Sites\bancred.site"
```

Verifique se os arquivos estão presentes:
- ✅ `vercel.json`
- ✅ `package.json`
- ✅ `api/consulta/` (com os arquivos PHP)

## 🚀 Passo 5: Fazer Deploy

### 5.1. Deploy de Teste (Preview)

Primeiro, vamos fazer um deploy de teste:

```powershell
vercel
```

O CLI vai fazer algumas perguntas:

1. **Set up and deploy?** → Digite `Y` e pressione Enter
2. **Which scope?** → Selecione sua conta (geralmente só uma opção)
3. **Link to existing project?** → Digite `N` (primeira vez)
4. **What's your project's name?** → Digite `bancred-org` ou pressione Enter
5. **In which directory is your code located?** → Pressione Enter (usa `.` - pasta atual)

Aguarde o deploy terminar. Você verá algo como:

```
✅ Production: https://bancred-org-xxxxx.vercel.app
```

### 5.2. Deploy em Produção

Após testar, faça o deploy em produção:

```powershell
vercel --prod
```

Ou:

```powershell
vercel production
```

## 🧪 Passo 6: Testar o Deploy

Após o deploy, você receberá uma URL. Teste:

1. **Página inicial**: `https://seu-projeto.vercel.app/`
2. **CPF**: `https://seu-projeto.vercel.app/cpf`
3. **API**: `https://seu-projeto.vercel.app/consulta/cpf`

## 🔄 Passo 7: Atualizar o Projeto

Sempre que fizer mudanças, faça deploy novamente:

```powershell
vercel --prod
```

## 📝 Comandos Úteis

### Ver informações do projeto

```powershell
vercel inspect
```

### Listar deployments

```powershell
vercel ls
```

### Ver logs

```powershell
vercel logs
```

### Remover projeto

```powershell
vercel remove
```

### Testar localmente

```powershell
vercel dev
```

Isso inicia um servidor local em `http://localhost:3000`

## 🐛 Solução de Problemas

### Erro: "node não é reconhecido"

- ✅ Instale o Node.js (Passo 1)
- ✅ Reinicie o PowerShell após instalar
- ✅ Verifique se o Node.js está no PATH do sistema

### Erro: "npm não é reconhecido"

- ✅ O npm vem junto com o Node.js
- ✅ Se não funcionar, reinstale o Node.js
- ✅ Reinicie o PowerShell

### Erro: "vercel não é reconhecido"

- ✅ Instale a Vercel CLI: `npm install -g vercel`
- ✅ Verifique se o npm está funcionando: `npm --version`
- ✅ Tente usar: `npx vercel` (sem instalar globalmente)

### Erro no Deploy

- ✅ Verifique se `vercel.json` está correto
- ✅ Verifique se os arquivos PHP estão em `api/consulta/`
- ✅ Veja os logs: `vercel logs`

### Erro 404 nas APIs

- ✅ Verifique se os arquivos estão em `api/consulta/`
- ✅ Verifique o `vercel.json` (rotas configuradas)
- ✅ Teste a URL diretamente: `https://seu-projeto.vercel.app/consulta/cpf`

## 📚 Recursos

- [Documentação Vercel CLI](https://vercel.com/docs/cli)
- [Node.js Download](https://nodejs.org/)
- [Vercel Dashboard](https://vercel.com/dashboard)

## ✅ Checklist

- [ ] Node.js instalado (`node --version` funciona)
- [ ] npm instalado (`npm --version` funciona)
- [ ] Vercel CLI instalado (`vercel --version` funciona)
- [ ] Login feito (`vercel login` concluído)
- [ ] Projeto na pasta correta
- [ ] Arquivos `vercel.json` e `package.json` presentes
- [ ] Pasta `api/consulta/` com arquivos PHP
- [ ] Deploy de teste realizado (`vercel`)
- [ ] Deploy em produção realizado (`vercel --prod`)
- [ ] URLs testadas e funcionando

---

**Dúvidas?** Consulte a documentação ou me avise!



