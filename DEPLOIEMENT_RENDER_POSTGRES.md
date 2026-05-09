# 🚀 Déploiement sur Render avec PostgreSQL

Ce guide explique comment déployer le backend PHP avec PostgreSQL sur Render.

## ✅ Avantages de PostgreSQL sur Render

- **Base de données managée gratuite** (1 Go, suffisant pour démarrer)
- **Backups automatiques**
- **Pas de configuration complexe** - Render gère tout
- **DATABASE_URL automatique** - pas besoin de configurer les variables individuellement

---

## 📋 Étapes de déploiement

### 1. Pousser le code sur GitHub

```bash
git add .
git commit -m "Configuration Render avec PostgreSQL"
git push origin main
```

### 2. Créer le Blueprint sur Render

1. Allez sur [Render Dashboard](https://dashboard.render.com/)
2. Cliquez sur **"Blueprints"** dans le menu
3. Cliquez sur **"New Blueprint Instance"**
4. Collez l'URL de votre repo GitHub
5. Cliquez sur **"Apply"**

Render va automatiquement :
- Créer la base de données PostgreSQL (`bugoupas-postgres`)
- Déployer le service web PHP
- Connecter la base au service via `DATABASE_URL`

### 3. Configurer le mot de passe admin

Dans le Dashboard Render :
1. Allez dans votre service web `bugoupas-backend`
2. Onglet **"Environment"**
3. Ajoutez/modifiez :
   ```
   ADMIN_PASSWORD_HASH=$2y$12$WMni5c94Bf21j06HAE8mUeLJ0.013z7FUzk8HR3.jxkN7AbvNJmCo
   CORS_ORIGIN=https://votre-frontend.vercel.app
   ```

### 4. Créer la table dans PostgreSQL

Après le déploiement, vous devez créer la table `responses` :

**Option A : via Render Shell**
1. Dashboard → votre base PostgreSQL → **"Shell"**
2. Connectez-vous : `psql $DATABASE_URL`
3. Exécutez le script SQL :
   ```sql
   CREATE TABLE IF NOT EXISTS responses (
       id SERIAL PRIMARY KEY,
       problem TEXT NOT NULL,
       domain VARCHAR(100) NOT NULL,
       frustration INTEGER NOT NULL CHECK (frustration >= 1 AND frustration <= 5),
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );

   CREATE INDEX idx_domain ON responses (domain);
   CREATE INDEX idx_created_at ON responses (created_at);
   ```

**Option B : via le fichier SQL**
Le fichier `database.postgresql.sql` est inclus dans le repo pour référence.

### 5. Configurer le frontend

Mettez à jour votre `.env` frontend avec l'URL du backend Render :

```env
VITE_API_URL=https://bugoupas-backend.onrender.com
```

Puis rebuild et redeploy le frontend :

```bash
npm run build
# Deploy sur Vercel/Netlify
```

---

## 🔧 Variables d'environnement automatiques

Render configure automatiquement ces variables :

| Variable | Source | Description |
|----------|--------|-------------|
| `DATABASE_URL` | Render PostgreSQL | URL complète de connexion |
| `RENDER` | Service | Indique qu'on est sur Render |

**Variables à configurer manuellement :**

| Variable | Requis | Description |
|----------|--------|-------------|
| `ADMIN_PASSWORD_HASH` | ✅ | Hash bcrypt du mot de passe admin |
| `CORS_ORIGIN` | ✅ | URL de votre frontend (ex: https://votre-app.vercel.app) |

---

## 🐛 Dépannage

### Erreur "table responses does not exist"
La table n'a pas été créée. Utilisez la méthode du shell (étape 4) pour la créer manuellement.

### Erreur CORS
Vérifiez que `CORS_ORIGIN` correspond exactement à votre URL frontend (avec https://, sans slash final).

### Le service ne démarre pas
Consultez les logs dans Render Dashboard → votre service → **"Logs"**

---

## 📁 Fichiers PostgreSQL créés

- `backend/config.php` - Détection auto MySQL/PostgreSQL via DATABASE_URL
- `backend/Dockerfile` - Extensions pdo_pgsql installées
- `render.yaml` - Configuration avec service PostgreSQL
- `database.postgresql.sql` - Script SQL pour créer la table
- `backend/.env.postgresql.example` - Template des variables

---

## 🎉 Vérification

Après déploiement, testez :

```
https://bugoupas-backend.onrender.com/submit.php
https://bugoupas-backend.onrender.com/admin.php
```

Le formulaire et l'admin devraient fonctionner avec PostgreSQL !
