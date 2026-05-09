# 📋 Guide d'installation rapide

## ⚡ Installation en 5 minutes

### 1️⃣ Base de données (2 minutes)

**Option A : Via phpMyAdmin**
1. Ouvrez XAMPP/WAMP et démarrez Apache + MySQL
2. Allez sur `http://localhost/phpmyadmin`
3. Cliquez sur "Nouveau" pour créer une base de données
4. Nommez-la `sondage_digital`
5. Cliquez sur "Importer" et sélectionnez `database.sql`
6. Cliquez sur "Exécuter"

**Option B : Via ligne de commande**
```bash
# Ouvrez un terminal et exécutez :
mysql -u root -p
# Entrez votre mot de passe MySQL (vide par défaut sur XAMPP)

# Puis exécutez :
CREATE DATABASE sondage_digital;
USE sondage_digital;
SOURCE C:/Users/pc/Desktop/dev-life/vue/sondage-web/database.sql;
EXIT;
```

### 2️⃣ Backend PHP (1 minute)

1. **Copiez le dossier backend** dans votre serveur web :
   ```
   Copiez : C:/Users/pc/Desktop/dev-life/vue/sondage-web/backend/
   Vers   : C:/xampp/htdocs/sondage-web/backend/
   ```

2. **Vérifiez la configuration** dans `backend/config.php` :
   - Si vous utilisez XAMPP avec les paramètres par défaut, **aucune modification n'est nécessaire**
   - Sinon, modifiez les constantes DB_USER et DB_PASS

3. **Testez le backend** :
   - Ouvrez `http://localhost/sondage-web/backend/submit.php`
   - Vous devriez voir : `{"success":false,"message":"Méthode non autorisée"}`
   - C'est normal ! ✅

### 3️⃣ Frontend Vue.js (2 minutes)

1. **Ouvrez un terminal** dans le dossier frontend :
   ```bash
   cd C:/Users/pc/Desktop/dev-life/vue/sondage-web/frontend
   ```

2. **Installez les dépendances** :
   ```bash
   npm install
   ```
   ⏱️ Cela prend environ 1-2 minutes

3. **Lancez le serveur de développement** :
   ```bash
   npm run dev
   ```

4. **Ouvrez votre navigateur** :
   - Le terminal affichera une URL (généralement `http://localhost:3000`)
   - Cliquez dessus ou ouvrez-la manuellement

### ✅ C'est terminé !

Vous devriez maintenant voir le site fonctionnel avec :
- ✨ Formulaire de soumission animé
- 📊 Page d'administration (mot de passe : `admin123`)
- 🎨 Interface moderne et responsive

---

## 🔧 Vérification de l'installation

### Test du formulaire
1. Allez sur la page d'accueil
2. Remplissez le formulaire
3. Cliquez sur "Envoyer mon idée"
4. Vous devriez voir un message de succès en haut à droite

### Test de l'admin
1. Cliquez sur "Accès administrateur"
2. Entrez le mot de passe : `admin123`
3. Vous devriez voir les statistiques et le tableau des réponses

---

## ❌ Problèmes courants

### "npm n'est pas reconnu..."
➡️ Installez Node.js depuis https://nodejs.org/

### "Erreur de connexion à la base de données"
➡️ Vérifiez que MySQL est démarré dans XAMPP/WAMP

### "CORS error" dans la console
➡️ Vérifiez que le backend est bien accessible à `http://localhost/sondage-web/backend/`

### Le formulaire ne s'envoie pas
➡️ Ouvrez la console du navigateur (F12) et vérifiez les erreurs
➡️ Vérifiez que l'URL dans `Formulaire.vue` correspond à votre configuration

---

## 🎯 Prochaines étapes

1. **Testez toutes les fonctionnalités** :
   - Soumission de formulaire
   - Filtrage et tri dans l'admin
   - Responsive design (testez sur mobile)

2. **Personnalisez le projet** :
   - Changez les couleurs dans `tailwind.config.js`
   - Modifiez le mot de passe admin dans `config.php`
   - Ajoutez votre logo dans `src/assets/`

3. **Préparez pour la production** :
   - Lisez la section "Déploiement" dans README.md
   - Sécurisez le mot de passe admin
   - Configurez CORS pour votre domaine

---

## 📞 Besoin d'aide ?

Consultez le fichier `README.md` pour :
- Documentation complète
- Guide de dépannage détaillé
- Personnalisation avancée
- Déploiement en production

**Bon développement ! 🚀**
