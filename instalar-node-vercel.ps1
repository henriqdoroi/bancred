# Script para instalar Node.js e Vercel CLI automaticamente
# Execute como Administrador: PowerShell (como administrador) -> .\instalar-node-vercel.ps1

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  Instalador Node.js e Vercel CLI      " -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Verificar se está rodando como administrador
$isAdmin = ([Security.Principal.WindowsPrincipal] [Security.Principal.WindowsIdentity]::GetCurrent()).IsInRole([Security.Principal.WindowsBuiltInRole]::Administrator)

if (-not $isAdmin) {
    Write-Host "ERRO: Este script precisa ser executado como Administrador!" -ForegroundColor Red
    Write-Host ""
    Write-Host "Como executar:" -ForegroundColor Yellow
    Write-Host "1. Clique com botao direito no PowerShell" -ForegroundColor White
    Write-Host "2. Selecione 'Executar como administrador'" -ForegroundColor White
    Write-Host "3. Navegue ate a pasta: cd 'C:\Downloaded Web Sites\bancred.site'" -ForegroundColor White
    Write-Host "4. Execute: .\instalar-node-vercel.ps1" -ForegroundColor White
    Write-Host ""
    pause
    exit
}

# Verificar se Node.js já está instalado
Write-Host "Verificando Node.js..." -ForegroundColor Yellow
try {
    $nodeVersion = node --version 2>$null
    if ($nodeVersion) {
        Write-Host "OK Node.js ja esta instalado: $nodeVersion" -ForegroundColor Green
        $nodeInstalado = $true
    }
} catch {
    $nodeInstalado = $false
}

# Se Node.js não estiver instalado, baixar e instalar
if (-not $nodeInstalado) {
    Write-Host "Node.js nao encontrado. Baixando instalador..." -ForegroundColor Yellow
    
    # URL do Node.js LTS
    $nodeUrl = "https://nodejs.org/dist/v20.11.0/node-v20.11.0-x64.msi"
    $nodeInstaller = "$env:TEMP\nodejs-installer.msi"
    
    try {
        Write-Host "Baixando Node.js (isso pode levar alguns minutos)..." -ForegroundColor Yellow
        Invoke-WebRequest -Uri $nodeUrl -OutFile $nodeInstaller -UseBasicParsing
        
        Write-Host "Instalando Node.js..." -ForegroundColor Yellow
        Write-Host "Siga as instrucoes na tela do instalador." -ForegroundColor Yellow
        Write-Host ""
        
        # Executar instalador
        Start-Process msiexec.exe -ArgumentList "/i `"$nodeInstaller`" /quiet /norestart" -Wait
        
        Write-Host "Node.js instalado! Reiniciando PowerShell em 5 segundos..." -ForegroundColor Green
        Write-Host "IMPORTANTE: Feche e abra um NOVO PowerShell para continuar!" -ForegroundColor Yellow
        Write-Host ""
        
        # Adicionar Node.js ao PATH (temporário)
        $env:Path += ";C:\Program Files\nodejs\"
        
        Start-Sleep -Seconds 5
        
    } catch {
        Write-Host "ERRO ao baixar/instalar Node.js: $_" -ForegroundColor Red
        Write-Host ""
        Write-Host "Instalacao manual:" -ForegroundColor Yellow
        Write-Host "1. Acesse: https://nodejs.org/" -ForegroundColor White
        Write-Host "2. Baixe a versao LTS" -ForegroundColor White
        Write-Host "3. Execute o instalador" -ForegroundColor White
        Write-Host ""
        pause
        exit
    }
} else {
    Write-Host ""
}

# Verificar npm
Write-Host "Verificando npm..." -ForegroundColor Yellow
try {
    $npmVersion = npm --version 2>$null
    if ($npmVersion) {
        Write-Host "OK npm instalado: $npmVersion" -ForegroundColor Green
    } else {
        Write-Host "ERRO: npm nao encontrado mesmo com Node.js instalado" -ForegroundColor Red
        Write-Host "Reinicie o PowerShell e tente novamente" -ForegroundColor Yellow
        pause
        exit
    }
} catch {
    Write-Host "ERRO: npm nao encontrado" -ForegroundColor Red
    Write-Host "Reinicie o PowerShell e tente novamente" -ForegroundColor Yellow
    pause
    exit
}

Write-Host ""

# Instalar Vercel CLI
Write-Host "Instalando Vercel CLI..." -ForegroundColor Yellow
Write-Host "Isso pode levar alguns minutos..." -ForegroundColor Yellow
Write-Host ""

try {
    npm install -g vercel
    
    Write-Host ""
    Write-Host "Verificando instalacao do Vercel CLI..." -ForegroundColor Yellow
    $vercelVersion = vercel --version 2>$null
    if ($vercelVersion) {
        Write-Host "OK Vercel CLI instalado: $vercelVersion" -ForegroundColor Green
    } else {
        Write-Host "AVISO: Vercel CLI pode nao estar no PATH" -ForegroundColor Yellow
        Write-Host "Tente: npx vercel" -ForegroundColor White
    }
} catch {
    Write-Host "ERRO ao instalar Vercel CLI: $_" -ForegroundColor Red
    Write-Host ""
    Write-Host "Tente instalar manualmente:" -ForegroundColor Yellow
    Write-Host "npm install -g vercel" -ForegroundColor White
}

Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  Instalacao Concluida!                " -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Proximos passos:" -ForegroundColor Yellow
Write-Host "1. Feche este PowerShell" -ForegroundColor White
Write-Host "2. Abra um NOVO PowerShell (nao precisa ser admin)" -ForegroundColor White
Write-Host "3. Navegue ate: cd 'C:\Downloaded Web Sites\bancred.site'" -ForegroundColor White
Write-Host "4. Execute: vercel login" -ForegroundColor White
Write-Host "5. Execute: vercel (para deploy de teste)" -ForegroundColor White
Write-Host ""
pause



