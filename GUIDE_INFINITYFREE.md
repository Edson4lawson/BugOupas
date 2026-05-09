# 🚀 Guide Complet InfinityFree + Vercel

## 📋 Ce que nous allons faire

1. ✅ Configurer InfinityFree pour le backend PHP
2. ✅ Créer la base de données MySQL
3. ✅ Uploader les fichiers backend
4. ✅ Tester le backend
5. ✅ Pousser sur GitHub
6. ✅ Déployer sur Vercel

---

## PARTIE 1 : Configuration InfinityFree

### Étape 1 : Créer un Site Web

1. **Connectez-vous** sur https://infinityfree.net
2. Cliquez sur **"Create Account"** (Créer un compte)
3. Remplissez les informations :
   - **Username** : Choisissez un nom (ex: `sondagebenin`)
   - **Password** : Créez un mot de passe fort
   - **Domain** : Choisissez une option :
     - **Subdomain** : `sondage-benin.infinityfreeapp.com` (gratuit)
     - Ou utilisez votre propre domaine si vous en avez un

4. Cliquez sur **"Create Account"**
5. Attendez 2-5 minutes que le compte soit activé

### Étape 2 : Créer la Base de Données MySQL

1. Dans le **Control Panel**, allez dans **"MySQL Databases"**
2. Cliquez sur **"Create Database"**
3. Notez ces informations (TRÈS IMPORTANT) :
   ```
   Database Name: epiz_XXXXXXXX_sondage
   Database User: epiz_XXXXXXXX
   Database Password: [votre mot de passe]
   Database Host: sqlXXX.infinityfree.com
   ```
4. **Copiez ces informations** dans un fichier texte temporaire

### Étape 3 : Importer la Base de Données

1. Dans le Control Panel, cliquez sur **"phpMyAdmin"**
2. Connectez-vous avec vos credentials MySQL
3. Sélectionnez votre base de données (ex: `epiz_XXXXXXXX_sondage`)
4. Cliquez sur l'onglet **"Import"**
5. Cliquez sur **"Choose File"** et sélectionnez :
   ```
   c:\Users\pc\Desktop\dev-life\vue\sondage-web\database.sql
   ```
6. Cliquez sur **"Go"** en bas de la page
7. Vérifiez que la table `responses` a été créée

### Étape 4 : Préparer les Fichiers Backend

Avant d'uploader, nous devons modifier `config.php` :

1. Ouvrez `c:\Users\pc\Desktop\dev-life\vue\sondage-web\backend\config.php`
2. Remplacez les valeurs par celles d'InfinityFree :
   ```php
   <?php
   // Configuration de la base de données
   define('DB_HOST', 'sqlXXX.infinityfree.com'); // Remplacez par votre host
   define('DB_NAME', 'epiz_XXXXXXXX_sondage');   // Remplacez par votre DB name
   define('DB_USER', 'epiz_XXXXXXXX');           // Remplacez par votre user
   define('DB_PASS', 'votre_mot_de_passe');      // Remplacez par votre password
   
   // Mot de passe admin (CHANGEZ-LE !)
   define('ADMIN_PASSWORD', 'VotreMotDePasseSecurise123!');
   
   // CORS - Sera mis à jour après le déploiement Vercel
   header('Access-Control-Allow-Origin: *'); // Temporaire pour les tests
   header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
   header('Access-Control-Allow-Headers: Content-Type, Authorization');
   header('Access-Control-Allow-Credentials: true');
   header('Content-Type: application/json; charset=UTF-8');
   
   // Handle preflight requests
   if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
       http_response_code(200);
       exit();
   }
   
   // Connexion à la base de données
   try {
       $pdo = new PDO(
           "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
           DB_USER,
           DB_PASS,
           [
               PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
               PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
               PDO::ATTR_EMULATE_PREPARES => false
           ]
       );
   } catch (PDOException $e) {
       http_response_code(500);
       echo json_encode([
           'success' => false,
           'message' => 'Erreur de connexion à la base de données'
       ]);
       exit();
   }
   ?>
   ```

3. **Sauvegardez** le fichier

### Étape 5 : Uploader les Fichiers Backend

**Option A : Via File Manager (Plus facile)**

1. Dans le Control Panel InfinityFree, cliquez sur **"Online File Manager"**
2. Naviguez vers le dossier **`htdocs`**
3. Créez un nouveau dossier : **`backend`**
4. Entrez dans le dossier `backend`
5. Uploadez tous les fichiers du dossier local `backend/` :
   - `config.php` (modifié)
   - `submit.php`
   - `admin.php`
   - `.htaccess`
6. Attendez que tous les fichiers soient uploadés

**Option B : Via FTP (Plus rapide pour plusieurs fichiers)**

1. Téléchargez **FileZilla** : https://filezilla-project.org/
2. Dans le Control Panel InfinityFree, allez dans **"FTP Details"**
3. Notez :
   ```
   FTP Hostname: ftpupload.net
   FTP Username: epiz_XXXXXXXX
   FTP Password: [votre mot de passe FTP]
   FTP Port: 21
   ```
4. Ouvrez FileZilla et connectez-vous
5. Côté distant, naviguez vers `/htdocs/`
6. Créez le dossier `backend`
7. Uploadez tous les fichiers du dossier local `backend/`

### Étape 6 : Tester le Backend

1. Ouvrez votre navigateur
2. Testez l'URL : `https://votre-site.infinityfreeapp.com/backend/submit.php`
3. Vous devriez voir un message JSON (erreur 405 est normal, c'est une requête GET)
4. Si vous voyez une erreur de connexion DB, vérifiez `config.php`

**Test complet avec Postman ou curl :**
```bash
curl -X POST https://votre-site.infinityfreeapp.com/backend/submit.php \
  -H "Content-Type: application/json" \
  -d '{"problem":"Test problème","domain":"Santé","custom_domain":"","frustration":3}'
```

Si ça fonctionne, vous verrez :
```json
{"success":true,"message":"Votre réponse a été enregistrée avec succès !"}
```

---

## PARTIE 2 : Préparation GitHub

### Étape 7 : Créer le fichier .env

1. Dans le dossier `frontend/`, créez un fichier `.env` :
   ```env
   VITE_API_URL=https://votre-site.infinityfreeapp.com/backend
   ```
   
2. **Remplacez** `votre-site.infinityfreeapp.com` par votre vraie URL InfinityFree

### Étape 8 : Initialiser Git et Pousser sur GitHub

Ouvrez PowerShell dans le dossier `frontend/` :

```powershell
# 1. Naviguer vers le dossier frontend
cd c:\Users\pc\Desktop\dev-life\vue\sondage-web\frontend

# 2. Initialiser Git (si pas déjà fait)
git init

# 3. Ajouter tous les fichiers
git add .

# 4. Créer le premier commit
git commit -m "Initial commit - Ready for Vercel deployment"

# 5. Créer un nouveau repository sur GitHub
# Allez sur https://github.com/new
# Nom: sondage-digital-benin (ou autre)
# Description: Site de sondage digital pour le Bénin
# Public ou Private: à votre choix
# NE COCHEZ PAS "Initialize with README"
# Cliquez "Create repository"

# 6. Lier votre dépôt local à GitHub
# Remplacez VOTRE-USERNAME par votre nom d'utilisateur GitHub
git remote add origin https://github.com/VOTRE-USERNAME/sondage-digital-benin.git

# 7. Renommer la branche en main (si nécessaire)
git branch -M main

# 8. Pousser le code sur GitHub
git push -u origin main
```

**Si Git demande vos identifiants :**
- Username : votre nom d'utilisateur GitHub
- Password : utilisez un **Personal Access Token** (pas votre mot de passe)
  - Créez-en un sur : https://github.com/settings/tokens
  - Permissions : `repo` (cochez toutes les cases sous repo)

---

## PARTIE 3 : Déploiement Vercel

### Étape 9 : Déployer sur Vercel

1. **Allez sur** https://vercel.com
2. **Connectez-vous** avec votre compte GitHub
3. Cliquez sur **"Add New Project"**
4. Sélectionnez votre repository **`sondage-digital-benin`**
5. Configurez le projet :
   
   **Framework Preset** : Vite (détecté automatiquement)
   
   **Root Directory** : `frontend` ⚠️ IMPORTANT
   - Cliquez sur "Edit" à côté de Root Directory
   - Sélectionnez le dossier `frontend`
   
   **Build Command** : `npm run build` (déjà rempli)
   
   **Output Directory** : `dist` (déjà rempli)

6. **Variables d'environnement** :
   - Cliquez sur **"Environment Variables"**
   - Ajoutez :
     - **Name** : `VITE_API_URL`
     - **Value** : `https://votre-site.infinityfreeapp.com/backend`
   - Cliquez sur "Add"

7. Cliquez sur **"Deploy"** 🚀

8. Attendez 2-3 minutes que le build se termine

9. **Notez votre URL Vercel** (ex: `sondage-digital-benin.vercel.app`)

### Étape 10 : Mettre à Jour les URLs

Maintenant que vous avez votre URL Vercel, mettez à jour :

**1. Dans `frontend/index.html` :**
Remplacez toutes les occurrences de `https://votre-domaine.vercel.app/` par votre vraie URL

**2. Dans `frontend/public/sitemap.xml` :**
Remplacez `https://votre-domaine.vercel.app/` par votre vraie URL

**3. Dans `frontend/public/robots.txt` :**
Remplacez `https://votre-domaine.vercel.app/` par votre vraie URL

**4. Dans `backend/config.php` sur InfinityFree :**
Remplacez :
```php
header('Access-Control-Allow-Origin: *');
```
Par :
```php
header('Access-Control-Allow-Origin: https://votre-projet.vercel.app');
```

### Étape 11 : Redéployer

```powershell
# Dans le dossier frontend
git add .
git commit -m "Update URLs with production domains"
git push
```

Vercel redéploiera automatiquement en 1-2 minutes !

---

## ✅ Vérification Finale

### Testez votre site :

1. **Ouvrez** `https://votre-projet.vercel.app`
2. **Remplissez** le formulaire
3. **Soumettez** une réponse
4. **Vérifiez** dans phpMyAdmin InfinityFree que les données sont enregistrées
5. **Testez** la page admin : `https://votre-projet.vercel.app/admin`
6. **Connectez-vous** avec le mot de passe défini dans `config.php`

### Checklist :

- [ ] Site accessible sur Vercel
- [ ] Formulaire fonctionne
- [ ] Données enregistrées dans la base InfinityFree
- [ ] Page admin accessible
- [ ] Pas d'erreurs CORS
- [ ] Design responsive sur mobile

---

## 🎉 Félicitations !

Votre site est maintenant **100% en ligne** et accessible au monde entier ! 🌍

**URLs importantes :**
- **Frontend** : `https://votre-projet.vercel.app`
- **Backend** : `https://votre-site.infinityfreeapp.com/backend`
- **Admin** : `https://votre-projet.vercel.app/admin`

---

## 📊 Prochaines Étapes (Optionnel)

### Google Search Console
1. Allez sur https://search.google.com/search-console
2. Ajoutez votre propriété Vercel
3. Soumettez le sitemap : `https://votre-projet.vercel.app/sitemap.xml`

### Domaine Personnalisé
Si vous voulez un domaine personnalisé (ex: `sondage-benin.com`) :
1. Achetez un domaine (Namecheap, OVH, etc.)
2. Dans Vercel : Settings → Domains → Add
3. Suivez les instructions DNS

### Analytics
- **Vercel Analytics** : Settings → Analytics (gratuit)
- **Google Analytics** : Ajoutez le code dans `index.html`

---

## 🆘 Problèmes Courants

**Erreur "Database connection failed"**
→ Vérifiez les credentials dans `backend/config.php`

**Erreur CORS**
→ Vérifiez que l'URL Vercel est dans `config.php`

**Formulaire ne s'envoie pas**
→ Ouvrez la console (F12) et vérifiez l'URL de l'API

**Build Vercel échoue**
→ Vérifiez que Root Directory = `frontend`

---

**Besoin d'aide ?** Demandez-moi ! 😊
