# 🔧 Node.js Não Reconhecido - Solução

## ❌ Problema

O Node.js foi instalado, mas o PowerShell não está reconhecendo.

## ✅ Soluções

### Solução 1: Reiniciar o PowerShell (Mais Comum)

**MUITO IMPORTANTE:** Após instalar o Node.js, você **DEVE** fechar e abrir um **NOVO** PowerShell!

1. **Feche este PowerShell completamente** (clique no X ou digite `exit`)
2. **Abra um NOVO PowerShell**
3. Navegue até a pasta:
   ```powershell
   cd "C:\Downloaded Web Sites\bancred.site"
   ```
4. Teste novamente:
   ```powershell
   node --version
   ```

### Solução 2: Verificar se Node.js Foi Instalado

1. Abra o **Explorador de Arquivos**
2. Navegue até: `C:\Program Files\nodejs\`
3. Veja se existe o arquivo `node.exe`

**Se NÃO existir:**
- O Node.js não foi instalado corretamente
- Execute o instalador `.msi` novamente
- Certifique-se de marcar "Automatically install the necessary tools"

**Se EXISTIR:**
- O Node.js está instalado, mas o PATH não foi atualizado
- Use a Solução 3 ou 4

### Solução 3: Adicionar Node.js ao PATH Manualmente

1. Pressione `Windows + R`
2. Digite: `sysdm.cpl` e pressione Enter
3. Vá na aba **"Avançado"**
4. Clique em **"Variáveis de Ambiente"**
5. Em **"Variáveis do sistema"**, encontre **"Path"**
6. Clique em **"Editar"**
7. Clique em **"Novo"**
8. Adicione: `C:\Program Files\nodejs`
9. Clique em **"OK"** em todas as janelas
10. **Feche e abra um NOVO PowerShell**
11. Teste: `node --version`

### Solução 4: Reinstalar Node.js

Se nada funcionar:

1. Baixe o Node.js novamente: https://nodejs.org/
2. Execute o instalador `.msi`
3. **IMPORTANTE:** Marque "Automatically install the necessary tools"
4. Complete a instalação
5. **Reinicie o computador** (para garantir que o PATH seja atualizado)
6. Abra um novo PowerShell e teste: `node --version`

### Solução 5: Usar Caminho Completo (Temporário)

Se precisar usar o Node.js imediatamente:

```powershell
& "C:\Program Files\nodejs\node.exe" --version
& "C:\Program Files\nodejs\npm.cmd" --version
```

Para instalar Vercel CLI:
```powershell
& "C:\Program Files\nodejs\npm.cmd" install -g vercel
```

## 🎯 Teste Rápido

Execute estes comandos em um **NOVO PowerShell**:

```powershell
# Verificar Node.js
node --version

# Verificar npm
npm --version

# Se ambos funcionarem, instalar Vercel CLI
npm install -g vercel
```

## ✅ Quando Funcionar

Depois que `node --version` mostrar um número, você pode:

1. Instalar Vercel CLI:
   ```powershell
   npm install -g vercel
   ```

2. Fazer login:
   ```powershell
   cd "C:\Downloaded Web Sites\bancred.site"
   vercel login
   ```

3. Fazer deploy:
   ```powershell
   vercel --prod
   ```

---

**Dica:** A causa mais comum é não ter reiniciado o PowerShell após a instalação!



