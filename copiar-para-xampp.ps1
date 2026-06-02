# Script para copiar arquivos modificados para XAMPP
# Execute este script na pasta raiz do projeto

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  Copiando arquivos para XAMPP" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Caminho do projeto atual
$projetoPath = $PSScriptRoot
if ([string]::IsNullOrEmpty($projetoPath)) {
    $projetoPath = Get-Location
}

# Caminho do XAMPP (ajuste se necessário)
$xamppPath = "C:\xampp\htdocs\bancred.site"

# Verificar se a pasta do XAMPP existe
if (-not (Test-Path $xamppPath)) {
    Write-Host "ERRO: Pasta do XAMPP não encontrada!" -ForegroundColor Red
    Write-Host "Caminho esperado: $xamppPath" -ForegroundColor Yellow
    Write-Host ""
    Write-Host "Por favor, ajuste o caminho no script ou crie a pasta." -ForegroundColor Yellow
    pause
    exit
}

Write-Host "Pasta do projeto: $projetoPath" -ForegroundColor Green
Write-Host "Pasta do XAMPP: $xamppPath" -ForegroundColor Green
Write-Host ""

# Arquivos e pastas para copiar
$arquivosParaCopiar = @(
    @{
        Origem = "consulta\processar.php"
        Destino = "consulta\processar.php"
        Descricao = "API Processar PIX (BlackcatPay)"
    },
    @{
        Origem = "consulta\confirmar.php"
        Destino = "consulta\confirmar.php"
        Descricao = "API Confirmar Status PIX"
    },
    @{
        Origem = "webhook\pix.php"
        Destino = "webhook\pix.php"
        Descricao = "Webhook PIX (BlackcatPay)"
    }
)

# Criar pastas necessárias no XAMPP
Write-Host "Criando pastas necessárias..." -ForegroundColor Yellow
$pastas = @("consulta", "webhook", "logs")
foreach ($pasta in $pastas) {
    $pastaCompleta = Join-Path $xamppPath $pasta
    if (-not (Test-Path $pastaCompleta)) {
        New-Item -ItemType Directory -Path $pastaCompleta -Force | Out-Null
        Write-Host "  ✓ Pasta criada: $pasta" -ForegroundColor Green
    }
}
Write-Host ""

# Copiar arquivos
Write-Host "Copiando arquivos..." -ForegroundColor Yellow
$sucesso = 0
$erros = 0

foreach ($arquivo in $arquivosParaCopiar) {
    $origemCompleta = Join-Path $projetoPath $arquivo.Origem
    $destinoCompleta = Join-Path $xamppPath $arquivo.Destino
    
    if (Test-Path $origemCompleta) {
        try {
            # Criar pasta de destino se não existir
            $pastaDestino = Split-Path $destinoCompleta -Parent
            if (-not (Test-Path $pastaDestino)) {
                New-Item -ItemType Directory -Path $pastaDestino -Force | Out-Null
            }
            
            Copy-Item -Path $origemCompleta -Destination $destinoCompleta -Force
            Write-Host "  ✓ $($arquivo.Descricao)" -ForegroundColor Green
            Write-Host "    $($arquivo.Origem) -> $($arquivo.Destino)" -ForegroundColor Gray
            $sucesso++
        }
        catch {
            Write-Host "  ✗ ERRO ao copiar $($arquivo.Descricao)" -ForegroundColor Red
            Write-Host "    $($_.Exception.Message)" -ForegroundColor Red
            $erros++
        }
    }
    else {
        Write-Host "  ⚠ Arquivo não encontrado: $($arquivo.Origem)" -ForegroundColor Yellow
        $erros++
    }
}

Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  Resumo" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  Sucesso: $sucesso" -ForegroundColor Green
Write-Host "  Erros: $erros" -ForegroundColor $(if ($erros -gt 0) { "Red" } else { "Green" })
Write-Host ""

if ($erros -eq 0) {
    Write-Host "✓ Todos os arquivos foram copiados com sucesso!" -ForegroundColor Green
    Write-Host ""
    Write-Host "Agora você pode testar no XAMPP:" -ForegroundColor Yellow
    Write-Host "  http://localhost/bancred.site/conta/checkout.html" -ForegroundColor Cyan
}
else {
    Write-Host "⚠ Alguns arquivos não foram copiados. Verifique os erros acima." -ForegroundColor Yellow
}

Write-Host ""
pause


