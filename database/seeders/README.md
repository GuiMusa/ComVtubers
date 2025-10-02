# Guide des Seeders - ComVtubers

## 📚 Commandes disponibles

### 1. Seeding normal (sans nettoyer)
```bash
php artisan db:seed
```
✅ **Utilise** : `updateOrCreate` pour éviter les doublons sur l'utilisateur de test

### 2. Seeding complet (avec nettoyage)
```bash
php artisan db:seed --class=CleanAndSeedSeeder
```
✅ **Avantage** : Nettoie toutes les tables avant de réexécuter les seeders
✅ **Utilisation** : Idéal pour repartir sur une base propre

### 3. Réinitialisation complète (migrations + seeders)
```bash
php artisan migrate:fresh --seed
```
⚠️ **Attention** : Supprime TOUTES les données et recrée les tables

### 4. Test Seeder uniquement
```bash
php artisan db:seed --class=testSeeder
```

---

## 📊 Données créées par défaut

| Modèle         | Nombre | Description                    |
|----------------|--------|--------------------------------|
| User           | 1      | Utilisateur de test            |
| Mention        | 50     | Mentions aléatoires            |
| Carte          | 20     | Cartes VTubers                 |
| Utilisateur    | 50     | Utilisateurs de la plateforme  |
| Article        | 100    | Articles/posts                 |
| Commentaire    | 200    | Commentaires sur articles      |
| Liste          | 30     | Listes de favoris              |
| Catégorie      | 40     | Catégories de contenu          |

---

## 🔧 Résolution de l'erreur "Duplicate entry"

### Problème résolu ✅
L'erreur `Duplicate entry 'test@example.com'` a été corrigée en utilisant :

```php
User::updateOrCreate(
    ['email' => 'test@example.com'],
    [
        'name' => 'Test User',
        'email_verified_at' => now(),
        'password' => bcrypt('password'),
    ]
);
```

**Explication** : 
- Si l'utilisateur existe déjà → mise à jour
- Si l'utilisateur n'existe pas → création

---

## 🚀 Workflow recommandé

### En développement
```bash
# 1. Nettoyer et réexécuter les seeders
php artisan db:seed --class=CleanAndSeedSeeder

# 2. Ou réinitialiser complètement
php artisan migrate:fresh --seed
```

### En production
```bash
# Exécuter uniquement les seeders sans nettoyer
php artisan db:seed
```

---

## 🔑 Identifiants de test

**Email** : `test@example.com`  
**Mot de passe** : `password`

---

## 📝 Ordre d'exécution des seeders

1. **DatabaseSeeder** - Crée l'utilisateur de test
2. **testSeeder** - Crée toutes les données de test dans l'ordre :
   - Mentions (sans dépendances)
   - Cartes (sans dépendances)
   - Utilisateurs
   - Articles
   - Commentaires
   - Listes
   - Catégories

---

## ⚠️ Notes importantes

- Les factories utilisent `fake()->unique()->safeEmail()` pour éviter les doublons d'emails
- Les contraintes de clés étrangères sont gérées automatiquement
- Les seeders peuvent être exécutés plusieurs fois sans erreur

---

## 🐛 Dépannage

### Erreur de contrainte de clé étrangère
```bash
# Vider la base et recommencer
php artisan migrate:fresh --seed
```

### Erreur "Table not found"
```bash
# Exécuter les migrations d'abord
php artisan migrate
php artisan db:seed
```

### Base de données verrouillée (SQLite)
```bash
# Arrêter tous les processus qui utilisent la DB
# Puis relancer
php artisan migrate:fresh --seed
```
