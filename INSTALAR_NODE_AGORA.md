# ✅ Instalar Node.js - Passo a Passo

## 📥 Você já baixou o Node.js, agora precisa INSTALAR

### Passo 1: Encontrar o arquivo baixado

1. Abra a pasta **Downloads** (ou onde você salvou)
2. Procure por um arquivo chamado: `node-v20.x.x-x64.msi` (ou similar)
3. O nome começa com `node-v` e termina com `.msi`

### Passo 2: Executar o instalador

1. **Clique duas vezes** no arquivo `.msi`
2. Se aparecer "Windows protegeu seu PC", clique em **"Mais informações"** e depois **"Executar mesmo assim"**

### Passo 3: Seguir o assistente

1. Clique em **"Next"** na primeira tela
2. **IMPORTANTE:** Marque a opção **"Automatically install the necessary tools"** ✅
3. Clique em **"Next"**
4. Clique em **"Install"**
5. Aguarde a instalação terminar
6. Clique em **"Finish"**

### Passo 4: Reiniciar o PowerShell

**MUITO IMPORTANTE:**

1. **Feche este PowerShell completamente**
2. Abra um **NOVO PowerShell**
3. Navegue até a pasta:
   ```powershell
   cd "C:\Downloaded Web Sites\bancred.site"
   ```

### Passo 5: Verificar se funcionou

No novo PowerShell, digite:

```powershell
node --version
npm --version
```

**Se aparecerem números de versão**, está instalado! ✅

**Exemplo de resposta esperada:**
```
v20.11.0
10.2.4
```

## 🚀 Próximo Passo: Instalar Vercel CLI

Depois que o Node.js estiver funcionando, execute:

```powershell
npm install -g vercel
```

Aguarde terminar (pode levar alguns minutos).

## ✅ Depois: Fazer Login e Deploy

```powershell
vercel login
vercel --prod
```

---

**Dica:** Se não encontrar o arquivo baixado, baixe novamente em: https://nodejs.org/



