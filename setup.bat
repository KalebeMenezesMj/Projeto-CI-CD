@echo off
echo ============================================
echo   Flores e Sonhos - E-commerce Laravel
echo   Script de Configuracao
echo ============================================
echo.

echo [1/5] Verificando PHP...
php --version
if %errorlevel% neq 0 (
    echo ERRO: PHP nao encontrado. Instale o PHP 8.1+ primeiro.
    echo Download: https://www.php.net/downloads.php
    pause
    exit /b 1
)

echo.
echo [2/5] Verificando Composer...
composer --version
if %errorlevel% neq 0 (
    echo ERRO: Composer nao encontrado. Instale o Composer primeiro.
    echo Download: https://getcomposer.org/download/
    pause
    exit /b 1
)

echo.
echo [3/5] Instalando dependencias...
composer install

echo.
echo [4/5] Configurando ambiente...
if not exist .env (
    copy .env.example .env
    echo Arquivo .env criado.
)
php artisan key:generate

echo.
echo [5/5] Configurando banco de dados...
echo.
echo IMPORTANTE: Configure o banco de dados no arquivo .env antes de continuar.
echo.
echo Opcao A - MySQL (padrao):
echo   DB_CONNECTION=mysql
echo   DB_DATABASE=floricultura
echo   DB_USERNAME=root
echo   DB_PASSWORD=sua_senha
echo.
echo Opcao B - SQLite (mais simples):
echo   No .env, altere para: DB_CONNECTION=sqlite
echo   E crie o arquivo: database\database.sqlite
echo.

set /p continuar="Pressione ENTER apos configurar o banco de dados..."

php artisan migrate --seed

echo.
echo [OK] Criando link de storage...
php artisan storage:link

echo.
echo ============================================
echo   INSTALACAO CONCLUIDA!
echo ============================================
echo.
echo Para iniciar o servidor:
echo   php artisan serve
echo.
echo Acesse: http://localhost:8000
echo.
echo Credenciais de acesso:
echo   Admin:   admin@floresesonhos.com.br / admin123
echo   Cliente: cliente@teste.com / cliente123
echo.
echo Painel Admin: http://localhost:8000/admin
echo.
pause
