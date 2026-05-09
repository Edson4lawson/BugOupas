# ⚡ Commandes Rapides - Déploiement Complet

## 📋 Checklist Avant de Commencer

- [ ] Compte InfinityFree créé
- [ ] Compte GitHub existant ✅
- [ ] Backend uploadé sur InfinityFree
- [ ] Base de données créée sur InfinityFree
- [ ] URL backend notée (ex: `https://votresite.infinityfreeapp.com/backend`)

---

## ÉTAPE 1 : Créer .env

Ouvrez PowerShell dans le dossier `frontend/` et exécutez :

```powershell
# Créer le fichier .env
@"
VITE_API_URL=https://votresite.infinityfreeapp.com/backend
"@ | Out-File -FilePath .env -Encoding UTF8
```

**⚠️ IMPORTANT** : Remplacez `votresite.infinityfreeapp.com` par votre vraie URL InfinityFree !

Ou créez manuellement le fichier `.env` avec :
```
VITE_API_URL=https://votresite.infinityfreeapp.com/backend
```

---

## ÉTAPE 2 : Pousser sur GitHub

### Option A : Script Automatique (Recommandé)

```powershell
# Naviguer vers le dossier frontend
cd c:\Users\pc\Desktop\dev-life\vue\sondage-web\frontend

# Exécuter le script
.\deploy-github.ps1
```

Le script vous guidera étape par étape !

### Option B : Commandes Manuelles

```powershell
# 1. Naviguer vers le dossier frontend
cd c:\Users\pc\Desktop\dev-life\vue\sondage-web\frontend

# 2. Initialiser Git
git init

# 3. Ajouter tous les fichiers
git add .

# 4. Créer le commit
git commit -m "Initial commit - Ready for Vercel"

# 5. Créer un repository sur GitHub
# Allez sur : https://github.com/new
# Nom : sondage-digital-benin
# Cliquez "Create repository"

# 6. Lier au repository (REMPLACEZ VOTRE-USERNAME)
git remote add origin https://github.com/VOTRE-USERNAME/sondage-digital-benin.git

# 7. Renommer la branche
git branch -M main

# 8. Pousser sur GitHub
git push -u origin main
```

**Si demandé, entrez :**
- Username : votre nom d'utilisateur GitHub
- Password : **Personal Access Token** (créez-en un sur https://github.com/settings/tokens)

---

## ÉTAPE 3 : Déployer sur Vercel

### Via le Dashboard (Plus facile)

1. **Allez sur** : https://vercel.com
2. **Connectez-vous** avec GitHub
3. **Cliquez** : "Add New Project"
4. **Sélectionnez** : votre repository `sondage-digital-benin`
5. **Configurez** :
   - Cliquez "Edit" à côté de "Root Directory"
   - Sélectionnez `frontend`
   - Framework : Vite (auto-détecté)
6. **Ajoutez la variable d'environnement** :
   - Cliquez "Environment Variables"
   - Name : `VITE_API_URL`
   - Value : `https://votresite.infinityfreeapp.com/backend`
   - Cliquez "Add"
7. **Cliquez** : "Deploy" 🚀

### Via CLI (Alternatif)

```powershell
# Installer Vercel CLI
npm install -g vercel

# Se connecter
vercel login

# Déployer
cd c:\Users\pc\Desktop\dev-life\vue\sondage-web\frontend
vercel

# Suivre les instructions :
# - Set up and deploy? Y
# - Which scope? [votre compte]
# - Link to existing project? N
# - Project name? sondage-digital-benin
# - Directory? ./
# - Override settings? N

# Ajouter la variable d'environnement
vercel env add VITE_API_URL
# Entrez : https://votresite.infinityfreeapp.com/backend

# Déployer en production
vercel --prod
```

---

## ÉTAPE 4 : Mettre à Jour les URLs

Après le déploiement, notez votre URL Vercel (ex: `sondage-digital-benin.vercel.app`)

### 1. Mettre à jour le frontend

Ouvrez ces fichiers et remplacez `https://votre-domaine.vercel.app/` :

**`frontend/index.html`** (lignes 17, 20, 25, 28, 31)
**`frontend/public/sitemap.xml`**
**`frontend/public/robots.txt`**

### 2. Mettre à jour le backend

Sur InfinityFree, modifiez `backend/config.php` ligne 16 :

```php
// Avant
header('Access-Control-Allow-Origin: *');

// Après (remplacez par votre URL Vercel)
header('Access-Control-Allow-Origin: https://sondage-digital-benin.vercel.app');
```

### 3. Redéployer

```powershell
cd c:\Users\pc\Desktop\dev-life\vue\sondage-web\frontend

git add .
git commit -m "Update URLs with production domains"
git push
```

Vercel redéploiera automatiquement !

---

## ✅ Vérification

Testez votre site :

```powershell
# Ouvrir le site dans le navigateur
start https://votre-projet.vercel.app
```

**Checklist :**
- [ ] Site accessible
- [ ] Formulaire fonctionne
- [ ] Données enregistrées dans la base
- [ ] Page admin accessible (`/admin`)
- [ ] Pas d'erreurs dans la console (F12)

---

## 🆘 Commandes de Dépannage

### Voir les logs Vercel
```powershell
vercel logs
```

### Redéployer manuellement
```powershell
vercel --prod --force
```

### Vérifier les variables d'environnement
```powershell
vercel env ls
```

### Tester le backend
```powershell
curl https://votresite.infinityfreeapp.com/backend/submit.php
```

### Voir le statut Git
```powershell
git status
```

### Voir l'historique des commits
```powershell
git log --oneline
```

---

## 📞 Aide Rapide

**Le formulaire ne fonctionne pas**
→ Vérifiez `VITE_API_URL` dans Vercel Dashboard → Settings → Environment Variables

**Erreur CORS**
→ Vérifiez `backend/config.php` ligne 16 sur InfinityFree

**Build Vercel échoue**
→ Vérifiez que Root Directory = `frontend`

**Git demande un mot de passe**
→ Utilisez un Personal Access Token : https://github.com/settings/tokens

---

## 🎉 C'est Tout !

Votre site est maintenant en ligne ! 🌍

**URLs :**
- Frontend : `https://votre-projet.vercel.app`
- Admin : `https://votre-projet.vercel.app/admin`
- Backend : `https://votresite.infinityfreeapp.com/backend`

---

**Besoin d'aide ?** Consultez `GUIDE_INFINITYFREE.md` pour plus de détails !
