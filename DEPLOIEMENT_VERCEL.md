# 🚀 Guide de Déploiement sur Vercel

Ce guide vous explique comment déployer votre site **Sondage Digital Bénin** sur Vercel gratuitement.

## 📋 Prérequis

1. **Compte Vercel** : Créez un compte gratuit sur [vercel.com](https://vercel.com)
2. **Compte GitHub** : Votre code doit être sur GitHub (recommandé) ou GitLab/Bitbucket
3. **Backend hébergé** : Le backend PHP doit être hébergé ailleurs (voir options ci-dessous)

## ⚠️ Important : Backend PHP

Vercel ne supporte pas PHP nativement. Vous avez 3 options :

### Option 1 : Hébergement PHP Gratuit (Recommandé pour débuter)
- **InfinityFree** : https://infinityfree.net (gratuit, illimité)
- **000webhost** : https://www.000webhost.com (gratuit)
- **Hostinger Free** : https://www.hostinger.fr (gratuit avec limitations)

### Option 2 : Migrer vers Node.js/Serverless
- Convertir le backend PHP en API Serverless Vercel (Node.js)
- Plus complexe mais entièrement gratuit sur Vercel

### Option 3 : Garder en local (développement uniquement)
- Le frontend sera en ligne mais le backend restera local
- Utile pour tester le déploiement

## 🎯 Étapes de Déploiement

### 1. Préparer le Backend

#### Si vous utilisez un hébergement PHP gratuit :

1. Créez un compte sur InfinityFree ou 000webhost
2. Créez une base de données MySQL
3. Uploadez les fichiers du dossier `backend/` via FTP
4. Importez `database.sql` dans votre base de données
5. Modifiez `backend/config.php` avec vos credentials :
   ```php
   define('DB_HOST', 'votre_host');
   define('DB_NAME', 'votre_db');
   define('DB_USER', 'votre_user');
   define('DB_PASS', 'votre_password');
   ```
6. Notez l'URL de votre backend (ex: `https://votre-site.infinityfreeapp.com/backend`)

### 2. Configurer le Frontend

1. Créez un fichier `.env` dans le dossier `frontend/` :
   ```env
   VITE_API_URL=https://votre-backend.com/backend
   ```

2. Mettez à jour les URLs dans `index.html` :
   - Remplacez `https://votre-domaine.vercel.app/` par votre future URL Vercel
   - Vous pourrez la mettre à jour après le déploiement

### 3. Pousser sur GitHub

1. Initialisez Git (si ce n'est pas déjà fait) :
   ```bash
   cd frontend
   git init
   git add .
   git commit -m "Initial commit"
   ```

2. Créez un repository sur GitHub

3. Poussez votre code :
   ```bash
   git remote add origin https://github.com/votre-username/sondage-web.git
   git branch -M main
   git push -u origin main
   ```

### 4. Déployer sur Vercel

#### Méthode 1 : Via le Dashboard Vercel (Recommandé)

1. Allez sur [vercel.com](https://vercel.com) et connectez-vous
2. Cliquez sur **"Add New Project"**
3. Importez votre repository GitHub
4. Configurez le projet :
   - **Framework Preset** : Vite
   - **Root Directory** : `frontend`
   - **Build Command** : `npm run build`
   - **Output Directory** : `dist`

5. Ajoutez les variables d'environnement :
   - Cliquez sur **"Environment Variables"**
   - Ajoutez : `VITE_API_URL` = `https://votre-backend.com/backend`

6. Cliquez sur **"Deploy"**

#### Méthode 2 : Via Vercel CLI

1. Installez Vercel CLI :
   ```bash
   npm install -g vercel
   ```

2. Connectez-vous :
   ```bash
   vercel login
   ```

3. Déployez :
   ```bash
   cd frontend
   vercel
   ```

4. Suivez les instructions et configurez :
   - Set up and deploy? **Y**
   - Which scope? Sélectionnez votre compte
   - Link to existing project? **N**
   - Project name? `sondage-digital-benin`
   - Directory? `./`
   - Override settings? **N**

5. Ajoutez les variables d'environnement :
   ```bash
   vercel env add VITE_API_URL
   ```
   Entrez : `https://votre-backend.com/backend`

6. Redéployez avec les variables :
   ```bash
   vercel --prod
   ```

### 5. Configuration Post-Déploiement

1. **Mettez à jour les URLs SEO** :
   - Dans `frontend/index.html`, remplacez `https://votre-domaine.vercel.app/` par votre URL Vercel réelle
   - Dans `frontend/public/sitemap.xml`, faites de même
   - Dans `frontend/public/robots.txt`, faites de même

2. **Configurez CORS sur le backend** :
   - Dans `backend/config.php`, ajoutez votre domaine Vercel :
   ```php
   header('Access-Control-Allow-Origin: https://votre-projet.vercel.app');
   ```

3. **Testez votre site** :
   - Visitez votre URL Vercel
   - Testez le formulaire
   - Vérifiez que les données arrivent dans la base de données

## 🎨 Personnalisation du Domaine

### Domaine Vercel Gratuit
Par défaut : `votre-projet.vercel.app`

### Domaine Personnalisé (Optionnel)
1. Achetez un domaine (Namecheap, OVH, etc.)
2. Dans Vercel Dashboard → Settings → Domains
3. Ajoutez votre domaine
4. Configurez les DNS selon les instructions Vercel

## 🔧 Configuration CORS Backend

Ajoutez ces headers dans votre `backend/config.php` :

```php
// CORS Headers
header('Access-Control-Allow-Origin: https://votre-projet.vercel.app');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}
```

## 📊 Optimisation SEO

### Google Search Console
1. Allez sur [search.google.com/search-console](https://search.google.com/search-console)
2. Ajoutez votre propriété (votre URL Vercel)
3. Vérifiez la propriété
4. Soumettez votre sitemap : `https://votre-projet.vercel.app/sitemap.xml`

### Google Analytics (Optionnel)
1. Créez un compte Google Analytics
2. Obtenez votre ID de suivi (ex: G-XXXXXXXXXX)
3. Ajoutez le script dans `frontend/index.html` :
```html
<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-XXXXXXXXXX');
</script>
```

## 🔄 Mises à Jour

Pour mettre à jour votre site :

1. Modifiez votre code localement
2. Committez et poussez sur GitHub :
   ```bash
   git add .
   git commit -m "Description des changements"
   git push
   ```
3. Vercel redéploiera automatiquement !

## 🐛 Dépannage

### Le formulaire ne fonctionne pas
- Vérifiez que `VITE_API_URL` est correctement configuré
- Vérifiez les CORS dans le backend
- Ouvrez la console du navigateur (F12) pour voir les erreurs

### Erreur 404 sur les routes
- Vérifiez que `vercel.json` est présent avec les rewrites

### Le build échoue
- Vérifiez que toutes les dépendances sont dans `package.json`
- Vérifiez les logs de build dans Vercel Dashboard

## 📞 Support

- **Documentation Vercel** : https://vercel.com/docs
- **Discord Vercel** : https://vercel.com/discord
- **Stack Overflow** : Tag `vercel`

## 🎉 Félicitations !

Votre site est maintenant en ligne et accessible au monde entier ! 🌍

N'oubliez pas de :
- ✅ Tester toutes les fonctionnalités
- ✅ Configurer Google Search Console
- ✅ Partager votre site
- ✅ Surveiller les performances dans Vercel Analytics

---

**Bon déploiement ! 🚀**
