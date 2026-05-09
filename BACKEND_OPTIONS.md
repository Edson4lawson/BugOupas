# 🔧 Options pour le Backend PHP

Vercel ne supporte pas PHP nativement. Voici vos options pour héberger le backend.

## 🆓 Option 1 : Hébergement PHP Gratuit (Recommandé)

### InfinityFree ⭐ (Meilleur choix)
- **Site** : https://infinityfree.net
- **Avantages** :
  - Totalement gratuit
  - Bande passante illimitée
  - MySQL illimité
  - Support PHP 7.4+
  - Pas de publicité
  - FTP et File Manager
- **Inconvénients** :
  - Nom de domaine : `votresite.infinityfreeapp.com`
  - Limitations sur les requêtes par heure

**Comment faire :**
1. Créez un compte sur InfinityFree
2. Créez un site web
3. Créez une base MySQL via le panneau de contrôle
4. Uploadez les fichiers du dossier `backend/` via FTP ou File Manager
5. Importez `database.sql` via phpMyAdmin
6. Modifiez `config.php` avec vos credentials
7. Testez l'URL : `https://votresite.infinityfreeapp.com/backend/submit.php`

### 000webhost
- **Site** : https://www.000webhost.com
- **Avantages** :
  - Gratuit
  - 300 MB d'espace
  - 3 GB de bande passante
  - MySQL
  - Support PHP 7.4+
- **Inconvénients** :
  - Publicité possible
  - Limitations strictes

### Hostinger Free
- **Site** : https://www.hostinger.fr
- **Note** : Version gratuite limitée, mais très bon service payant à partir de 1.99€/mois

## 💰 Option 2 : Hébergement PHP Payant (Production)

### Hostinger (Recommandé)
- **Prix** : À partir de 1.99€/mois
- **Avantages** :
  - Très rapide
  - Support 24/7
  - SSL gratuit
  - Domaine gratuit (1 an)
  - Backups automatiques

### OVH
- **Prix** : À partir de 2.99€/mois
- **Avantages** :
  - Hébergeur français
  - Très fiable
  - Support en français

### PlanetHoster
- **Prix** : À partir de 6€/mois
- **Avantages** :
  - Hébergeur canadien
  - Excellent support
  - Performances optimales

## 🚀 Option 3 : Migrer vers Serverless (Gratuit)

Convertir le backend PHP en API Serverless Node.js sur Vercel.

### Avantages
- Tout sur Vercel (frontend + backend)
- Totalement gratuit
- Scalable automatiquement
- Pas de serveur à gérer

### Inconvénients
- Nécessite de réécrire le code PHP en JavaScript/Node.js
- Nécessite une base de données compatible (PlanetScale, Supabase, etc.)

### Comment faire

#### 1. Créer les API Routes Vercel

Créez `frontend/api/submit.js` :
```javascript
import { query } from '../lib/db'

export default async function handler(req, res) {
  if (req.method !== 'POST') {
    return res.status(405).json({ message: 'Method not allowed' })
  }

  const { problem, domain, custom_domain, frustration } = req.body

  // Validation
  if (!problem || problem.length < 10) {
    return res.status(400).json({ 
      success: false, 
      message: 'Le problème doit contenir au moins 10 caractères' 
    })
  }

  try {
    await query(
      'INSERT INTO responses (problem, domain, custom_domain, frustration) VALUES (?, ?, ?, ?)',
      [problem, domain, custom_domain, frustration]
    )

    res.status(200).json({ 
      success: true, 
      message: 'Votre réponse a été enregistrée avec succès !' 
    })
  } catch (error) {
    res.status(500).json({ 
      success: false, 
      message: 'Erreur serveur' 
    })
  }
}
```

#### 2. Configurer la base de données

**Option A : PlanetScale (MySQL gratuit)**
- Site : https://planetscale.com
- 5 GB gratuit
- Compatible MySQL

**Option B : Supabase (PostgreSQL gratuit)**
- Site : https://supabase.com
- 500 MB gratuit
- PostgreSQL + API REST

**Option C : Vercel Postgres**
- Intégré à Vercel
- 256 MB gratuit

#### 3. Créer le fichier de connexion DB

Créez `frontend/lib/db.js` :
```javascript
import mysql from 'mysql2/promise'

const pool = mysql.createPool({
  host: process.env.DB_HOST,
  user: process.env.DB_USER,
  password: process.env.DB_PASSWORD,
  database: process.env.DB_NAME,
  waitForConnections: true,
  connectionLimit: 10,
  queueLimit: 0
})

export async function query(sql, params) {
  const [results] = await pool.execute(sql, params)
  return results
}
```

#### 4. Installer les dépendances

```bash
cd frontend
npm install mysql2
```

#### 5. Configurer les variables d'environnement

Dans Vercel Dashboard :
- `DB_HOST` = votre host PlanetScale
- `DB_USER` = votre user
- `DB_PASSWORD` = votre password
- `DB_NAME` = votre database

#### 6. Mettre à jour le frontend

Dans `frontend/src/config/api.js` :
```javascript
const API_URL = '/api' // Utilise les API routes Vercel

export const config = {
  apiUrl: API_URL,
  endpoints: {
    submit: `${API_URL}/submit`,
    admin: `${API_URL}/admin`
  }
}
```

## 🎯 Quelle Option Choisir ?

### Pour Débuter / Tester
→ **Option 1 : InfinityFree** (gratuit, facile)

### Pour Production Sérieuse
→ **Option 2 : Hostinger** (2€/mois, fiable)

### Pour Projet Scalable
→ **Option 3 : Serverless** (gratuit, moderne)

## 📊 Comparaison

| Critère | InfinityFree | Hostinger | Serverless |
|---------|--------------|-----------|------------|
| **Prix** | Gratuit | 1.99€/mois | Gratuit |
| **Facilité** | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐ | ⭐⭐ |
| **Performance** | ⭐⭐⭐ | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ |
| **Scalabilité** | ⭐⭐ | ⭐⭐⭐ | ⭐⭐⭐⭐⭐ |
| **Support** | ⭐⭐ | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐ |

## 🆘 Besoin d'Aide ?

Si vous voulez que je vous aide à :
- Configurer InfinityFree
- Migrer vers Serverless
- Choisir la meilleure option

Dites-moi simplement ce que vous préférez ! 😊

---

**Recommandation** : Commencez avec **InfinityFree** pour tester, puis migrez vers **Hostinger** ou **Serverless** pour la production.
