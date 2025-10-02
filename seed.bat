@echo off
REM Script de gestion des seeders pour ComVtubers
REM Windows Batch Script

echo.
echo ================================
echo  ComVtubers - Gestion Seeders
echo ================================
echo.
echo Choisissez une option:
echo.
echo [1] Executer les seeders normalement
echo [2] Nettoyer et executer les seeders (recommande)
echo [3] Reset complet (migrations + seeders)
echo [4] Executer uniquement testSeeder
echo [5] Quitter
echo.

set /p choice="Votre choix (1-5): "

if "%choice%"=="1" (
    echo.
    echo Execution des seeders...
    php artisan db:seed
    goto end
)

if "%choice%"=="2" (
    echo.
    echo Nettoyage et execution des seeders...
    php artisan db:seed --class=CleanAndSeedSeeder
    goto end
)

if "%choice%"=="3" (
    echo.
    echo ATTENTION: Cette action va supprimer TOUTES les donnees!
    set /p confirm="Etes-vous sur? (oui/non): "
    if /i "%confirm%"=="oui" (
        echo.
        echo Reset complet en cours...
        php artisan migrate:fresh --seed
    ) else (
        echo Operation annulee.
    )
    goto end
)

if "%choice%"=="4" (
    echo.
    echo Execution de testSeeder uniquement...
    php artisan db:seed --class=testSeeder
    goto end
)

if "%choice%"=="5" (
    echo Au revoir!
    goto end
)

echo Choix invalide!

:end
echo.
echo Termine!
pause
