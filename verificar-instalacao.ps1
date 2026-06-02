# Script para verificar se tudo esta pronto para deploy na Vercel
# Execute: .\verificar-instalacao.ps1

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  Verificacao de Instalacao - Vercel  " -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

$tudoOk = $true

# Verificar Node.js
Write-Host "1. Verificando Node.js..." -ForegroundColor Yellow
try {
    $nodeVersion = node --version 2>$null
    if ($nodeVersion) {
        Write-Host "   OK Node.js instalado: $nodeVersion" -ForegroundColor Green
    } else {
        throw "Node.js nao encontrado"
    }
} catch {
    Write-Host "   ERRO Node.js NAO esta instalado!" -ForegroundColor Red
    Write-Host "   Baixe em: https://nodejs.org/" -ForegroundColor Yellow
    $tudoOk = $false
}
Write-Host ""

# Verificar npm
Write-Host "2. Verificando npm..." -ForegroundColor Yellow
try {
    $npmVersion = npm --version 2>$null
    if ($npmVersion) {
        Write-Host "   OK npm instalado: $npmVersion" -ForegroundColor Green
    } else {
        throw "npm nao encontrado"
    }
} catch {
    Write-Host "   ERRO npm NAO esta instalado!" -ForegroundColor Red
    Write-Host "   npm vem junto com Node.js" -ForegroundColor Yellow
    $tudoOk = $false
}
Write-Host ""

# Verificar Vercel CLI
Write-Host "3. Verificando Vercel CLI..." -ForegroundColor Yellow
try {
    $vercelVersion = vercel --version 2>$null
    if ($vercelVersion) {
        Write-Host "   OK Vercel CLI instalado: $vercelVersion" -ForegroundColor Green
    } else {
        throw "Vercel CLI nao encontrado"
    }
} catch {
    Write-Host "   ERRO Vercel CLI NAO esta instalado!" -ForegroundColor Red
    Write-Host "   Instale com: npm install -g vercel" -ForegroundColor Yellow
    $tudoOk = $false
}
Write-Host ""

# Verificar arquivos do projeto
Write-Host "4. Verificando arquivos do projeto..." -ForegroundColor Yellow
$arquivosNecessarios = @(
    "vercel.json",
    "package.json",
    "api\consulta\cpf.php",
    "api\consulta\processar.php",
    "api\consulta\confirmar.php"
)

foreach ($arquivo in $arquivosNecessarios) {
    if (Test-Path $arquivo) {
        Write-Host "   OK $arquivo" -ForegroundColor Green
    } else {
        Write-Host "   ERRO $arquivo NAO encontrado!" -ForegroundColor Red
        $tudoOk = $false
    }
}
Write-Host ""

# Resultado final
Write-Host "========================================" -ForegroundColor Cyan
if ($tudoOk) {
    Write-Host "  Tudo pronto para deploy!" -ForegroundColor Green
    Write-Host ""
    Write-Host "Proximos passos:" -ForegroundColor Yellow
    Write-Host "1. vercel login" -ForegroundColor White
    Write-Host "2. vercel (deploy de teste)" -ForegroundColor White
    Write-Host "3. vercel --prod (deploy em producao)" -ForegroundColor White
} else {
    Write-Host "  Alguns itens precisam ser corrigidos" -ForegroundColor Red
    Write-Host ""
    Write-Host "Consulte GUIA_CLI_VERCEL.md para instrucoes detalhadas" -ForegroundColor Yellow
}
Write-Host "========================================" -ForegroundColor Cyan
