@echo off
echo ========================================
echo   Copiando arquivos para o XAMPP
echo ========================================
echo.

REM Verificar se o XAMPP existe
if not exist "C:\xampp\htdocs\" (
    echo ERRO: Pasta do XAMPP nao encontrada!
    echo Verifique se o XAMPP esta instalado em C:\xampp\
    pause
    exit /b
)

echo Copiando arquivos...
echo.

REM Copiar toda a pasta new para o XAMPP
xcopy /E /I /Y "%~dp0" "C:\xampp\htdocs\new\"

if %errorlevel% equ 0 (
    echo.
    echo ========================================
    echo   Copia concluida com sucesso!
    echo ========================================
    echo.
    echo Acesse: http://localhost/new/teste-funil.php
    echo.
) else (
    echo.
    echo ERRO: Falha ao copiar arquivos!
    echo.
)

pause
