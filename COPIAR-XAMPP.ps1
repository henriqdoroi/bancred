# Script PowerShell para copiar arquivos para o XAMPP
# Execute: powershell -ExecutionPolicy Bypass -File COPIAR-XAMPP.ps1

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  Copiando arquivos para o XAMPP" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Verificar se o XAMPP existe
$xamppPath = "C:\xampp\htdocs\new"
$sourcePath = $PSScriptRoot

if (-not (Test-Path "C:\xampp\htdocs\")) {
    Write-Host "ERRO: Pasta do XAMPP nao encontrada!" -ForegroundColor Red
    Write-Host "Verifique se o XAMPP esta instalado em C:\xampp\" -ForegroundColor Yellow
    Read-Host "Pressione Enter para sair"
    exit
}

Write-Host "Origem: $sourcePath" -ForegroundColor Green
Write-Host "Destino: $xamppPath" -ForegroundColor Green
Write-Host ""
Write-Host "Copiando arquivos..." -ForegroundColor Yellow

# Criar pasta de destino se não existir
if (-not (Test-Path $xamppPath)) {
    New-Item -ItemType Directory -Path $xamppPath -Force | Out-Null
}

# Copiar todos os arquivos
try {
    Copy-Item -Path "$sourcePath\*" -Destination $xamppPath -Recurse -Force -Exclude @("node_modules", ".git", "*.bat", "*.ps1")
    
    Write-Host ""
    Write-Host "========================================" -ForegroundColor Green
    Write-Host "  Copia concluida com sucesso!" -ForegroundColor Green
    Write-Host "========================================" -ForegroundColor Green
    Write-Host ""
    Write-Host "Acesse: http://localhost/new/teste-funil.php" -ForegroundColor Cyan
    Write-Host ""
    
} catch {
    Write-Host ""
    Write-Host "ERRO: Falha ao copiar arquivos!" -ForegroundColor Red
    Write-Host $_.Exception.Message -ForegroundColor Red
    Write-Host ""
}

Read-Host "Pressione Enter para sair"

