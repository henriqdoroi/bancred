# 📋 Guia: Copiar Arquivos BlackcatPay para XAMPP

## 📁 Arquivos Modificados/Criados

Os seguintes arquivos foram atualizados para integração com BlackcatPay:

1. **`consulta/processar.php`** - API para criar transação PIX
2. **`consulta/confirmar.php`** - API para verificar status do pagamento
3. **`webhook/pix.php`** - Webhook para receber notificações (NOVO)

## 🚀 Como Copiar

### **Opção 1: Script PowerShell (Recomendado)**

1. Abra o PowerShell na pasta do projeto
2. Execute:
   ```powershell
   .\copiar-para-xampp.ps1
   ```

### **Opção 2: Script Batch (Windows)**

1. Clique duas vezes em: `copiar-para-xampp.bat`
2. Ou execute no CMD:
   ```cmd
   copiar-para-xampp.bat
   ```

### **Opção 3: Copiar Manualmente**

Copie os seguintes arquivos para `C:\xampp\htdocs\bancred.site\`:

```
consulta/
  ├── processar.php    ← Copiar
  └── confirmar.php   ← Copiar

webhook/
  └── pix.php         ← Copiar (criar pasta se não existir)
```

## 📍 Estrutura no XAMPP

Após copiar, a estrutura deve ficar assim:

```
C:\xampp\htdocs\bancred.site\
├── consulta\
│   ├── processar.php    ✅ (Atualizado - BlackcatPay)
│   ├── confirmar.php   ✅ (Atualizado - BlackcatPay)
│   └── ...
├── webhook\
│   └── pix.php         ✅ (Novo - Webhook BlackcatPay)
└── logs\
    └── pix_errors.log  (será criado automaticamente)
```

## ✅ Verificação

Após copiar, verifique:

1. ✅ `C:\xampp\htdocs\bancred.site\consulta\processar.php` existe
2. ✅ `C:\xampp\htdocs\bancred.site\consulta\confirmar.php` existe
3. ✅ `C:\xampp\htdocs\bancred.site\webhook\pix.php` existe
4. ✅ Pasta `logs` existe (será criada automaticamente)

## 🧪 Testar

1. Inicie o XAMPP (Apache)
2. Acesse: `http://localhost/bancred.site/conta/checkout.html`
3. Tente gerar um PIX
4. Verifique os logs em: `C:\xampp\htdocs\bancred.site\logs\pix_errors.log`

## ⚙️ Configuração

Os arquivos já estão configurados com:
- **API Key**: `sk_JRTtazAeeNeM-G90uX8elpvqqb0pP7LmPczcUMRrIjD5DJ6S`
- **URL API**: `https://api.blackcatpagamentos.com/v1/transactions`
- **Webhook Secret**: `sk_JRTtazAeeNeM-G90uX8elpvqqb0pP7LmPczcUMRrIjD5DJ6S`

## 🔧 Ajustar Caminho do XAMPP

Se seu XAMPP estiver em outro local, edite os scripts:

**PowerShell** (`copiar-para-xampp.ps1`):
```powershell
$xamppPath = "SEU_CAMINHO_AQUI\htdocs\bancred.site"
```

**Batch** (`copiar-para-xampp.bat`):
```batch
set XAMPP_PATH=SEU_CAMINHO_AQUI\htdocs\bancred.site
```

## 📝 Notas

- Os scripts criam as pastas automaticamente se não existirem
- Arquivos existentes serão sobrescritos
- Logs de erro serão salvos em `logs/pix_errors.log`


