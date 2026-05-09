# 🚀 Guide Rapide - Déploiement Vercel

## ⚡ En 5 Minutes

### 1️⃣ Préparer le Backend (IMPORTANT)

Vercel ne supporte pas PHP. Choisissez une option :

**Option A : Hébergement Gratuit (Recommandé)**
1. Créez un compte sur [InfinityFree](https://infinityfree.net) ou [000webhost](https://www.000webhost.com)
2. Uploadez le dossier `backend/` via FTP
3. Créez une base MySQL et importez `database.sql`
4. Notez votre URL backend (ex: `https://votresite.infinityfreeapp.com/backend`)

**Option B : Tester sans Backend**
- Le site sera en ligne mais le formulaire ne fonctionnera pas
- Utile pour voir le design

### 2️⃣ Configurer le Frontend

Créez `.env` dans `frontend/` :
```env
VITE_API_URL=https://votre-backend.com/backend
```

### 3️⃣ Pousser sur GitHub

```bash
cd frontend
git init
git add .
git commit -m "Initial commit"
git remote add origin https://github.com/votre-username/sondage-web.git
git push -u origin main
```

### 4️⃣ Déployer sur Vercel

1. Allez sur [vercel.com](https://vercel.com)
2. Cliquez **"Add New Project"**
3. Importez votre repo GitHub
4. Configurez :
   - **Root Directory** : `frontend`
   - **Framework** : Vite
   - **Build Command** : `npm run build`
   - **Output Directory** : `dist`
5. Ajoutez la variable d'environnement :
   - `VITE_API_URL` = `https://votre-backend.com/backend`
6. Cliquez **"Deploy"** ✨

### 5️⃣ Après le Déploiement

1. Notez votre URL Vercel (ex: `sondage-benin.vercel.app`)
2. Mettez à jour les URLs dans :
   - `frontend/index.html` (remplacez `votre-domaine.vercel.app`)
   - `frontend/public/sitemap.xml`
   - `frontend/public/robots.txt`
3. Committez et poussez les changements
4. Vercel redéploiera automatiquement

### 6️⃣ Configurer CORS Backend

Dans `backend/config.php`, ajoutez :
```php
header('Access-Control-Allow-Origin: https://votre-projet.vercel.app');
```

## ✅ Vérification

- [ ] Site accessible sur l'URL Vercel
- [ ] Formulaire fonctionne
- [ ] Données enregistrées dans la base
- [ ] Page admin accessible

## 🆘 Problèmes Courants

**Le formulaire ne fonctionne pas**
→ Vérifiez `VITE_API_URL` dans Vercel Dashboard → Settings → Environment Variables

**Erreur CORS**
→ Ajoutez votre domaine Vercel dans `backend/config.php`

**Build échoue**
→ Vérifiez que `Root Directory` est bien `frontend`

## 📚 Guides Complets

- [DEPLOIEMENT_VERCEL.md](./DEPLOIEMENT_VERCEL.md) - Guide détaillé
- [SEO_CHECKLIST.md](./SEO_CHECKLIST.md) - Optimisation SEO

## 🎉 C'est tout !

Votre site est maintenant en ligne ! 🌍

**URL** : https://votre-projet.vercel.app

---

**Besoin d'aide ?** Consultez [DEPLOIEMENT_VERCEL.md](./DEPLOIEMENT_VERCEL.md)
