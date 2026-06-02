@echo off
echo ========================================
echo   Instalador Node.js e Vercel CLI
echo ========================================
echo.
echo Este script vai abrir os links para download
echo e guiar voce na instalacao.
echo.
pause

echo.
echo ========================================
echo PASSO 1: Instalar Node.js
echo ========================================
echo.
echo Abrindo pagina de download do Node.js...
start https://nodejs.org/

echo.
echo INSTRUCOES:
echo 1. Na pagina que abriu, clique em "Download Node.js (LTS)"
echo 2. Execute o arquivo .msi baixado
echo 3. Siga o assistente de instalacao
echo 4. IMPORTANTE: Marque "Automatically install the necessary tools"
echo 5. Clique em Next ate finalizar
echo.
echo Apos instalar, pressione qualquer tecla para continuar...
pause

echo.
echo ========================================
echo PASSO 2: Verificar Instalacao
echo ========================================
echo.
echo Abrindo novo PowerShell para verificar...
echo.
start powershell -NoExit -Command "cd 'C:\Downloaded Web Sites\bancred.site'; Write-Host 'Verificando Node.js...' -ForegroundColor Yellow; node --version; Write-Host 'Verificando npm...' -ForegroundColor Yellow; npm --version; Write-Host ''; Write-Host 'Se apareceram numeros de versao, esta instalado!' -ForegroundColor Green; Write-Host ''; Write-Host 'Proximo passo: Instalar Vercel CLI' -ForegroundColor Yellow; Write-Host 'Execute: npm install -g vercel' -ForegroundColor White; Write-Host ''; pause"

echo.
echo ========================================
echo PASSO 3: Instalar Vercel CLI
echo ========================================
echo.
echo No PowerShell que abriu, execute:
echo   npm install -g vercel
echo.
echo Aguarde a instalacao terminar.
echo.
pause

echo.
echo ========================================
echo PASSO 4: Fazer Login e Deploy
echo ========================================
echo.
echo Abrindo PowerShell para login...
echo.
start powershell -NoExit -Command "cd 'C:\Downloaded Web Sites\bancred.site'; Write-Host 'Proximos comandos:' -ForegroundColor Yellow; Write-Host '1. vercel login' -ForegroundColor White; Write-Host '2. vercel (deploy de teste)' -ForegroundColor White; Write-Host '3. vercel --prod (deploy em producao)' -ForegroundColor White; Write-Host ''; Write-Host 'Execute os comandos acima na ordem.' -ForegroundColor Cyan"

echo.
echo Instalacao concluida!
echo.
pause



