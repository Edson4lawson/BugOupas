# 🌍 Sondage Digital Bénin

Site web moderne pour recueillir des idées de problèmes digitaux au Bénin. Construit avec Vue.js 3, Tailwind CSS, et PHP/MySQL.

![Vue.js](https://img.shields.io/badge/Vue.js-3.4-4FC08D?logo=vue.js)
![Tailwind CSS](https://img.shields.io/badge/Tailwind-3.4-38B2AC?logo=tailwind-css)
![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?logo=mysql)

## ✨ Fonctionnalités

### 📝 Formulaire de soumission
- Champ texte libre pour décrire le problème digital
- Dropdown pour sélectionner le domaine (Santé, Éducation, Finance, Autre)
- Échelle de frustration interactive (1-5)
- Validation en temps réel
- Feedback visuel avec animations
- Animations AOS (Animate On Scroll)
- Icônes Iconify

### 🔐 Page d'administration
- Authentification par mot de passe
- Tableau complet des réponses
- Statistiques en temps réel
- Filtrage par domaine
- Tri par date, frustration ou domaine
- Interface responsive et moderne

## 🏗️ Structure du projet

```
sondage-web/
├── frontend/
│   ├── public/
│   ├── src/
│   │   ├── assets/
│   │   ├── components/
│   │   │   ├── Formulaire.vue
│   │   │   ├── Feedback.vue
│   │   │   └── AdminTable.vue
│   │   ├── views/
│   │   │   ├── Home.vue
│   │   │   └── Admin.vue
│   │   ├── router/
│   │   │   └── index.js
│   │   ├── App.vue
│   │   ├── main.js
│   │   └── style.css
│   ├── index.html
│   ├── package.json
│   ├── vite.config.js
│   ├── tailwind.config.js
│   └── postcss.config.js
├── backend/
│   ├── config.php
│   ├── submit.php
│   ├── admin.php
│   └── .htaccess
├── database.sql
└── README.md
```

## 🚀 Installation et Configuration

### Prérequis

- **Node.js** 18+ et npm
- **PHP** 8.0+
- **MySQL** 8.0+
- **Serveur web** (XAMPP, WAMP, MAMP, ou Laragon recommandé)

### Étape 1 : Configuration de la base de données

1. Démarrez votre serveur MySQL (via XAMPP/WAMP/MAMP)

2. Ouvrez phpMyAdmin ou votre client MySQL préféré

3. Importez le fichier `database.sql` :
   ```sql
   mysql -u root -p < database.sql
   ```
   
   Ou via phpMyAdmin :
   - Créez une base de données nommée `sondage_digital`
   - Importez le fichier `database.sql`

4. Vérifiez que la table `responses` a été créée avec succès

### Étape 2 : Configuration du Backend PHP

1. Copiez le dossier `backend/` dans votre répertoire web :
   - **XAMPP** : `C:/xampp/htdocs/sondage-web/backend/`
   - **WAMP** : `C:/wamp64/www/sondage-web/backend/`
   - **MAMP** : `/Applications/MAMP/htdocs/sondage-web/backend/`

2. Modifiez `backend/config.php` si nécessaire :
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'sondage_digital');
   define('DB_USER', 'root');
   define('DB_PASS', ''); // Votre mot de passe MySQL
   define('ADMIN_PASSWORD', 'admin123'); // Changez en production
   ```

3. Assurez-vous que le serveur Apache est démarré

4. Testez l'API :
   - Ouvrez `http://localhost/sondage-web/backend/submit.php` dans votre navigateur
   - Vous devriez voir un message JSON (erreur 405 est normal car c'est une requête GET)

### Étape 3 : Configuration du Frontend Vue.js

1. Ouvrez un terminal dans le dossier `frontend/`

2. Installez les dépendances :
   ```bash
   npm install
   ```

3. Vérifiez l'URL de l'API dans les composants :
   - `src/components/Formulaire.vue` (ligne ~165)
   - `src/views/Admin.vue` (ligne ~120 et ~155)
   
   L'URL par défaut est : `http://localhost/sondage-web/backend/`
   
   **Modifiez si nécessaire** selon votre configuration serveur.

4. Lancez le serveur de développement :
   ```bash
   npm run dev
   ```

5. Ouvrez votre navigateur à l'adresse affichée (généralement `http://localhost:3000`)

## 🎯 Utilisation

### Page d'accueil (Formulaire)

1. Accédez à `http://localhost:3000`
2. Remplissez le formulaire :
   - Décrivez votre problème digital (minimum 10 caractères)
   - Sélectionnez un domaine
   - Choisissez votre niveau de frustration (1-5)
3. Cliquez sur "Envoyer mon idée"
4. Un message de confirmation s'affiche en haut à droite

### Page d'administration

1. Cliquez sur "Accès administrateur" ou allez à `http://localhost:3000/admin`
2. Entrez le mot de passe : `admin123` (par défaut)
3. Consultez les statistiques et le tableau des réponses
4. Utilisez les filtres pour :
   - Filtrer par domaine
   - Trier par date, frustration ou domaine
   - Changer l'ordre (croissant/décroissant)
5. Cliquez sur "Actualiser" pour recharger les données

## 🛠️ Technologies utilisées

### Frontend
- **Vue.js 3** (Composition API) - Framework JavaScript progressif
- **Vue Router 4** - Routage SPA
- **Tailwind CSS 3** - Framework CSS utility-first
- **Axios** - Client HTTP pour les requêtes API
- **AOS** - Bibliothèque d'animations au scroll
- **Iconify** - Icônes modernes et légères
- **SweetAlert2** - Alertes élégantes (intégré via Feedback.vue)
- **Vite** - Build tool ultra-rapide

### Backend
- **PHP 8** - Langage serveur
- **MySQL** - Base de données relationnelle
- **PDO** - Interface d'accès aux bases de données
- **JSON** - Format d'échange de données

## 📦 Scripts disponibles

```bash
# Développement
npm run dev

# Build de production
npm run build

# Prévisualisation du build
npm run preview
```

## 🔒 Sécurité

### Recommandations pour la production

1. **Changez le mot de passe admin** dans `backend/config.php`
2. **Utilisez HTTPS** pour les communications
3. **Configurez CORS** correctement pour votre domaine
4. **Activez les logs d'erreurs** PHP en production
5. **Utilisez des variables d'environnement** pour les credentials
6. **Ajoutez un rate limiting** sur les endpoints
7. **Validez et sanitisez** toutes les entrées utilisateur (déjà implémenté)

### Fichier .env (recommandé pour production)

Créez un fichier `.env` dans `backend/` :
```env
DB_HOST=localhost
DB_NAME=sondage_digital
DB_USER=root
DB_PASS=votre_mot_de_passe
ADMIN_PASSWORD=votre_mot_de_passe_admin_securise
```

## 🎨 Personnalisation

### Couleurs (Tailwind)

Modifiez `frontend/tailwind.config.js` pour changer les couleurs :
```javascript
theme: {
  extend: {
    colors: {
      primary: {
        500: '#0ea5e9', // Votre couleur principale
      },
    },
  },
}
```

### Domaines

Ajoutez ou modifiez les domaines dans :
- `frontend/src/components/Formulaire.vue` (options du select)
- `backend/submit.php` (validation)

### Animations

Personnalisez les animations AOS dans `frontend/src/main.js` :
```javascript
AOS.init({
  duration: 800,    // Durée de l'animation
  easing: 'ease-in-out',
  once: true,       // Animation une seule fois
  offset: 100       // Décalage avant déclenchement
})
```

## 🐛 Dépannage

### Erreur CORS

Si vous rencontrez des erreurs CORS :
1. Vérifiez que `backend/.htaccess` est bien présent
2. Assurez-vous que `mod_headers` est activé dans Apache
3. Vérifiez les headers dans `backend/config.php`

### Erreur de connexion à la base de données

1. Vérifiez que MySQL est démarré
2. Vérifiez les credentials dans `backend/config.php`
3. Vérifiez que la base `sondage_digital` existe

### Le formulaire ne s'envoie pas

1. Ouvrez la console du navigateur (F12)
2. Vérifiez l'URL de l'API dans `Formulaire.vue`
3. Testez l'endpoint directement : `http://localhost/sondage-web/backend/submit.php`

### Les animations ne fonctionnent pas

1. Vérifiez que AOS est bien chargé dans `main.js`
2. Vérifiez la console pour des erreurs JavaScript
3. Essayez de vider le cache du navigateur

## 📱 Responsive Design

Le site est entièrement responsive et optimisé pour :
- 📱 Mobile (320px+)
- 📱 Tablette (768px+)
- 💻 Desktop (1024px+)
- 🖥️ Large Desktop (1280px+)

## 🚀 Déploiement en production

### Frontend (Netlify, Vercel, etc.)

```bash
npm run build
# Le dossier dist/ contient les fichiers à déployer
```

### Backend (Serveur PHP)

1. Uploadez le dossier `backend/` sur votre serveur
2. Importez `database.sql` sur votre base de données
3. Modifiez `config.php` avec vos credentials de production
4. Mettez à jour les URLs dans le frontend

## 📄 Licence

Ce projet est sous licence MIT. Vous êtes libre de l'utiliser, le modifier et le distribuer.

## 👨‍💻 Auteur

Développé avec ❤️ pour améliorer l'écosystème digital au Bénin

## 🤝 Contribution

Les contributions sont les bienvenues ! N'hésitez pas à :
- Signaler des bugs
- Proposer des nouvelles fonctionnalités
- Améliorer la documentation

## 📞 Support

Pour toute question ou problème :
- Ouvrez une issue sur GitHub
- Consultez la documentation
- Vérifiez la section Dépannage

---

**Bon développement ! 🚀**
