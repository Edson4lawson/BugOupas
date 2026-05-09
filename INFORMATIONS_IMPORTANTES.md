# 📋 Informations Importantes à Noter

## 🔐 Credentials InfinityFree

**Notez ces informations après la création de votre compte :**

### Compte InfinityFree
```
Email : _______________________________
Mot de passe : _______________________________
```

### Site Web
```
Nom du site : _______________________________
URL : https://_______________________________.infinityfreeapp.com
```

### Base de Données MySQL
```
Database Host : sql___.infinityfree.com
Database Name : epiz_________sondage
Database User : epiz__________
Database Password : _______________________________
phpMyAdmin URL : _______________________________
```

### FTP (pour uploader les fichiers)
```
FTP Host : ftpupload.net
FTP Username : epiz__________
FTP Password : _______________________________
FTP Port : 21
```

---

## 🔐 Credentials GitHub

```
Username : _______________________________
Email : _______________________________
Personal Access Token : _______________________________
Repository URL : https://github.com/_______/_______
```

**Créer un Personal Access Token :**
1. Allez sur : https://github.com/settings/tokens
2. Cliquez "Generate new token (classic)"
3. Cochez : `repo` (toutes les cases)
4. Cliquez "Generate token"
5. **COPIEZ LE TOKEN** (vous ne pourrez plus le voir !)

---

## 🌐 URLs de Production

### Frontend (Vercel)
```
URL Vercel : https://_______________________________.vercel.app
URL Admin : https://_______________________________.vercel.app/admin
```

### Backend (InfinityFree)
```
URL Backend : https://_______________________________.infinityfreeapp.com/backend
URL Submit : https://_______________________________.infinityfreeapp.com/backend/submit.php
URL Admin API : https://_______________________________.infinityfreeapp.com/backend/admin.php
```

---

## 🔑 Mots de Passe Admin

**Mot de passe admin du site (dans config.php) :**
```
Mot de passe : _______________________________
```

**⚠️ IMPORTANT** : Changez ce mot de passe dans `backend/config.php` avant de déployer !

---

## 📝 Variables d'Environnement

### Fichier .env (Frontend)
```env
VITE_API_URL=https://_______________________________.infinityfreeapp.com/backend
```

### Variables Vercel
```
VITE_API_URL = https://_______________________________.infinityfreeapp.com/backend
```

---

## 📂 Fichiers Importants

### À Modifier Avant le Déploiement

1. **`backend/config.php`**
   - Ligne 7-10 : Credentials MySQL InfinityFree
   - Ligne 13 : Mot de passe admin
   - Ligne 16 : URL CORS (après déploiement Vercel)

2. **`frontend/.env`**
   - URL du backend InfinityFree

3. **`frontend/index.html`**
   - Lignes 17, 20, 25, 28, 31 : URL Vercel (après déploiement)

4. **`frontend/public/sitemap.xml`**
   - Toutes les URLs : URL Vercel (après déploiement)

5. **`frontend/public/robots.txt`**
   - Ligne 6 : URL Vercel (après déploiement)

---

## 🚀 Ordre des Étapes

### Phase 1 : InfinityFree (Backend)
1. ✅ Créer compte InfinityFree
2. ✅ Créer site web
3. ✅ Créer base de données MySQL
4. ✅ Importer `database.sql` via phpMyAdmin
5. ✅ Modifier `backend/config.php` avec les credentials
6. ✅ Uploader les fichiers backend via FTP ou File Manager
7. ✅ Tester : `https://votresite.infinityfreeapp.com/backend/submit.php`

### Phase 2 : GitHub
1. ✅ Créer fichier `.env` avec l'URL backend
2. ✅ Initialiser Git dans `frontend/`
3. ✅ Créer repository sur GitHub
4. ✅ Pousser le code sur GitHub

### Phase 3 : Vercel (Frontend)
1. ✅ Se connecter sur Vercel avec GitHub
2. ✅ Importer le repository
3. ✅ Configurer Root Directory = `frontend`
4. ✅ Ajouter variable `VITE_API_URL`
5. ✅ Déployer
6. ✅ Noter l'URL Vercel

### Phase 4 : Finalisation
1. ✅ Mettre à jour les URLs dans `index.html`, `sitemap.xml`, `robots.txt`
2. ✅ Mettre à jour CORS dans `backend/config.php` sur InfinityFree
3. ✅ Redéployer (git push)
4. ✅ Tester le site complet

---

## 🧪 Tests à Effectuer

### Test Backend (InfinityFree)
```bash
# Test 1 : Vérifier que le backend répond
curl https://votresite.infinityfreeapp.com/backend/submit.php

# Test 2 : Soumettre un formulaire test
curl -X POST https://votresite.infinityfreeapp.com/backend/submit.php \
  -H "Content-Type: application/json" \
  -d '{"problem":"Test","domain":"Santé","custom_domain":"","frustration":3}'
```

### Test Frontend (Vercel)
1. Ouvrir : `https://votre-projet.vercel.app`
2. Remplir le formulaire
3. Soumettre
4. Vérifier dans phpMyAdmin que les données sont enregistrées
5. Tester la page admin : `https://votre-projet.vercel.app/admin`
6. Se connecter avec le mot de passe admin
7. Vérifier que les données s'affichent

---

## 📊 Outils de Monitoring

### Vercel Dashboard
```
URL : https://vercel.com/dashboard
```
- Voir les déploiements
- Voir les logs
- Gérer les variables d'environnement
- Voir les analytics

### InfinityFree Control Panel
```
URL : https://dash.infinityfree.net
```
- Gérer les fichiers (File Manager)
- Gérer la base de données (phpMyAdmin)
- Voir les statistiques
- Gérer le FTP

### Google Search Console (après déploiement)
```
URL : https://search.google.com/search-console
```
- Soumettre le sitemap
- Voir l'indexation
- Voir les performances SEO

---

## 🆘 Contacts Support

### InfinityFree
- Forum : https://forum.infinityfree.net
- Documentation : https://infinityfree.net/support

### Vercel
- Documentation : https://vercel.com/docs
- Support : https://vercel.com/support
- Discord : https://vercel.com/discord

### GitHub
- Documentation : https://docs.github.com
- Support : https://support.github.com

---

## 📝 Notes Personnelles

```
_____________________________________________________________

_____________________________________________________________

_____________________________________________________________

_____________________________________________________________

_____________________________________________________________

_____________________________________________________________
```

---

## ✅ Checklist Finale

- [ ] Backend uploadé sur InfinityFree
- [ ] Base de données créée et importée
- [ ] Backend testé et fonctionnel
- [ ] Fichier .env créé avec l'URL backend
- [ ] Code poussé sur GitHub
- [ ] Site déployé sur Vercel
- [ ] Variable VITE_API_URL configurée sur Vercel
- [ ] URLs mises à jour dans les fichiers
- [ ] CORS configuré dans config.php
- [ ] Site testé et fonctionnel
- [ ] Formulaire fonctionne
- [ ] Page admin accessible
- [ ] Données enregistrées correctement
- [ ] Sitemap soumis à Google Search Console

---

**Date de déploiement** : ___ / ___ / _____

**Statut** : ⬜ En cours  ⬜ Terminé  ⬜ En production

---

**Imprimez ou sauvegardez ce fichier pour référence future !**
