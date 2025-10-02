#!/bin/bash

# Script de gestion des seeders pour ComVtubers
# Bash Script pour Linux/Mac

echo ""
echo "================================"
echo " ComVtubers - Gestion Seeders"
echo "================================"
echo ""
echo "Choisissez une option:"
echo ""
echo "[1] Exécuter les seeders normalement"
echo "[2] Nettoyer et exécuter les seeders (recommandé)"
echo "[3] Reset complet (migrations + seeders)"
echo "[4] Exécuter uniquement testSeeder"
echo "[5] Quitter"
echo ""

read -p "Votre choix (1-5): " choice

case $choice in
    1)
        echo ""
        echo "Exécution des seeders..."
        php artisan db:seed
        ;;
    2)
        echo ""
        echo "Nettoyage et exécution des seeders..."
        php artisan db:seed --class=CleanAndSeedSeeder
        ;;
    3)
        echo ""
        echo "⚠️  ATTENTION: Cette action va supprimer TOUTES les données!"
        read -p "Êtes-vous sûr? (oui/non): " confirm
        if [ "$confirm" = "oui" ]; then
            echo ""
            echo "Reset complet en cours..."
            php artisan migrate:fresh --seed
        else
            echo "Opération annulée."
        fi
        ;;
    4)
        echo ""
        echo "Exécution de testSeeder uniquement..."
        php artisan db:seed --class=testSeeder
        ;;
    5)
        echo "Au revoir!"
        exit 0
        ;;
    *)
        echo "Choix invalide!"
        exit 1
        ;;
esac

echo ""
echo "✅ Terminé!"
