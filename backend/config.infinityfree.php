<?php
/**
 * Configuration pour InfinityFree
 * 
 * INSTRUCTIONS :
 * 1. Remplacez les valeurs ci-dessous par celles d'InfinityFree
 * 2. Renommez ce fichier en "config.php" avant de l'uploader
 * 3. Ou copiez le contenu dans votre config.php existant
 */

// ========================================
// CONFIGURATION BASE DE DONNÉES
// ========================================
// Remplacez par vos valeurs InfinityFree
define('DB_HOST', 'sqlXXX.infinityfree.com');     // Ex: sql123.infinityfree.com
define('DB_NAME', 'epiz_XXXXXXXX_sondage');       // Ex: epiz_12345678_sondage
define('DB_USER', 'epiz_XXXXXXXX');               // Ex: epiz_12345678
define('DB_PASS', 'VOTRE_MOT_DE_PASSE_MYSQL');    // Votre mot de passe MySQL

// ========================================
// MOT DE PASSE ADMIN
// ========================================
// CHANGEZ CE MOT DE PASSE AVANT DE DÉPLOYER !
define('ADMIN_PASSWORD', 'VotreMotDePasseSecurise123!');

// ========================================
// CONFIGURATION CORS
// ========================================
// Après le déploiement Vercel, remplacez * par votre URL Vercel
// Ex: header('Access-Control-Allow-Origin: https://sondage-benin.vercel.app');
header('Access-Control-Allow-Origin: *');  // Temporaire pour les tests
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json; charset=UTF-8');

// Gérer les requêtes OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// ========================================
// CONNEXION À LA BASE DE DONNÉES
// ========================================
/**
 * Connexion à la base de données
 * @return PDO
 */
function getDBConnection() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        return $pdo;
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Erreur de connexion à la base de données'
        ]);
        exit();
    }
}

// ========================================
// FONCTIONS UTILITAIRES
// ========================================
/**
 * Fonction pour valider et nettoyer les données
 * @param string $data
 * @return string
 */
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

// ========================================
// NOTES IMPORTANTES
// ========================================
/*
 * APRÈS AVOIR UPLOADÉ SUR INFINITYFREE :
 * 
 * 1. Testez la connexion : https://votre-site.infinityfreeapp.com/backend/submit.php
 * 2. Vous devriez voir un message JSON (erreur 405 est normale)
 * 3. Si erreur de connexion DB, vérifiez les credentials ci-dessus
 * 
 * APRÈS LE DÉPLOIEMENT VERCEL :
 * 
 * 1. Notez votre URL Vercel (ex: sondage-benin.vercel.app)
 * 2. Modifiez la ligne 28 :
 *    header('Access-Control-Allow-Origin: https://votre-projet.vercel.app');
 * 3. Re-uploadez config.php sur InfinityFree
 * 
 * SÉCURITÉ :
 * 
 * - Changez ADMIN_PASSWORD avant de déployer
 * - Ne partagez jamais vos credentials
 * - Utilisez des mots de passe forts
 */
?>
