# 🚀 Déploiement sur Render

Ce guide explique comment déployer le backend PHP sur Render.

## ⚠️ Prérequis Important

Render ne propose pas de service MySQL managé. Vous devez donc :

**Option A (Recommandée) :** Utiliser un hébergement MySQL externe gratuit :
- [InfinityFree](https://www.infinityfree.net/) (MySQL gratuit)
- [PlanetScale](https://planetscale.com/) (MySQL serverless)
- [Aiven](https://aiven.io/) (MySQL gratuit)

**Option B :** Modifier le code pour utiliser PostgreSQL (Render propose PostgreSQL gratuit)

## 📋 Étapes de déploiement

### 1. Préparer la base de données externe

Créez une base de données MySQL sur InfinityFree ou autre service :
- Notez l'hôte (hostname)
- Notez le nom de la base
- Notez l'utilisateur et le mot de passe
- Importez le fichier `database.sql`

### 2. Déployer sur Render

#### Option 1 : Via Render Blueprint (Automatique)

1. Poussez votre code sur GitHub
2. Dans Render Dashboard → Blueprints → New Blueprint Instance
3. Collez l'URL de votre repo GitHub
4. Render détectera automatiquement le `render.yaml`
5. Configurez les variables d'environnement :

```
DB_HOST=sqlXXX.epizy.com  (votre hôte MySQL)
DB_NAME=epiz_xxx          (votre base de données)
DB_USER=epiz_xxx          (votre utilisateur)
DB_PASS=votre_mot_de_passe
ADMIN_PASSWORD_HASH=$2y$12$WMni5c94Bf21j06HAE8mUeLJ0.013z7FUzk8HR3.jxkN7AbvNJmCo
CORS_ORIGIN=https://votre-frontend.vercel.app
```

#### Option 2 : Manuel (Web Service Docker)

1. Dashboard Render → New → Web Service
2. Connectez votre repo GitHub
3. Runtime : **Docker**
4. Dockerfile Path : `./backend/Dockerfile`
5. Ajoutez les variables d'environnement ci-dessus
6. Créez le service

### 3. Configurer le frontend

Une fois le backend déployé, mettez à jour votre `.env` frontend :

```env
VITE_API_URL=https://votre-backend.onrender.com
```

Puis rebuild et redeploy le frontend.

### 4. Vérifier le déploiement

Testez les endpoints :
```
https://votre-backend.onrender.com/submit.php
https://votre-backend.onrender.com/admin.php
```

## 🔧 Variables d'environnement Render

| Variable | Description | Requis |
|----------|-------------|--------|
| `DB_HOST` | Hôte de la base de données MySQL | ✅ |
| `DB_NAME` | Nom de la base de données | ✅ |
| `DB_USER` | Utilisateur MySQL | ✅ |
| `DB_PASS` | Mot de passe MySQL | ✅ |
| `ADMIN_PASSWORD_HASH` | Hash bcrypt du mot de passe admin | ✅ |
| `CORS_ORIGIN` | Origine autorisée (votre frontend) | ✅ |

## 🐛 Dépannage

### Erreur de connexion à la base de données
- Vérifiez que l'hôte MySQL est accessible depuis l'extérieur
- Certains hébergements gratuits bloquent les connexions externes

### Erreur CORS
- Vérifiez que `CORS_ORIGIN` correspond exactement à l'URL de votre frontend
- Incluez `https://` et pas de slash à la fin

### Logs
Dans Render Dashboard → votre service → Logs pour voir les erreurs.

## 📁 Fichiers créés pour Render

- `backend/Dockerfile` - Configuration Docker PHP+Apache
- `backend/.dockerignore` - Fichiers exclus du build
- `render.yaml` - Configuration Render Blueprint
- `backend/config.php` - Modifié pour supporter les env vars

---

**Note :** Si vous préférez une solution plus simple, envisagez [Railway](https://railway.app/) ou [AlwaysData](https://www.alwaysdata.com/) qui supportent PHP+MySQL nativement.
