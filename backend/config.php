<?php
/**
 * Configuration de la base de données
 * Supporte MySQL et PostgreSQL automatiquement
 * Compatible avec Render, Railway, Heroku, etc.
 */

// Détection automatique du type de base de données
$dbType = 'mysql'; // Par défaut MySQL

// Vérifier si DATABASE_URL est présente (format standard Render/Railway/Heroku)
$databaseUrl = getenv('DATABASE_URL');

if ($databaseUrl) {
    // Parser DATABASE_URL (ex: postgres://user:pass@host:port/dbname ou mysql://...)
    $parsed = parse_url($databaseUrl);
    if ($parsed) {
        $dbType = strpos($parsed['scheme'], 'postgres') !== false ? 'postgresql' : 'mysql';
        $dbHost = $parsed['host'] ?? 'localhost';
        $dbPort = $parsed['port'] ?? ($dbType === 'postgresql' ? 5432 : 3306);
        $dbName = isset($parsed['path']) ? ltrim($parsed['path'], '/') : 'BugOuPas';
        $dbUser = $parsed['user'] ?? 'root';
        $dbPass = $parsed['pass'] ?? '';
    }
} else {
    // Variables d'environnement individuelles
    $dbType = getenv('DB_TYPE') ?: 'mysql';
    $dbHost = getenv('DB_HOST') ?: 'localhost';
    $dbPort = getenv('DB_PORT') ?: ($dbType === 'postgresql' ? 5432 : 3306);
    $dbName = getenv('DB_NAME') ?: 'BugOuPas';
    $dbUser = getenv('DB_USER') ?: 'root';
    $dbPass = getenv('DB_PASS') ?: '';
}

// Mot de passe admin : admin123
$adminPasswordHash = getenv('ADMIN_PASSWORD_HASH') ?: '$2y$12$TO0aLoTfQtCK.iMoAUS2LO.qzAW9YyWqPfJ2D9r2KYfx8yUbu2v3y';

// Configuration des constantes
define('DB_TYPE', $dbType);
define('DB_HOST', $dbHost);
define('DB_PORT', $dbPort);
define('DB_NAME', $dbName);
define('DB_USER', $dbUser);
define('DB_PASS', $dbPass);
define('ADMIN_PASSWORD_HASH', $adminPasswordHash);

// Configuration CORS
// En production, spécifiez l'origine exacte de votre frontend
$corsOrigin = getenv('CORS_ORIGIN') ?: '*';
header("Access-Control-Allow-Origin: {$corsOrigin}");
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=utf-8');

// Gérer les requêtes OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

/**
 * Connexion à la base de données
 * Supporte MySQL et PostgreSQL automatiquement
 * @return PDO
 */
function getDBConnection() {
    static $pdo = null;
    if ($pdo !== null) return $pdo;

    try {
        if (DB_TYPE === 'postgresql') {
            // Connexion PostgreSQL
            $dsn = "pgsql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME;
        } else {
            // Connexion MySQL (par défaut)
            $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        }
        
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        
        // Initialisation automatique de la table si elle n'existe pas
        initDatabase($pdo);
        
        return $pdo;
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Erreur de connexion à la base de données: ' . $e->getMessage()
        ]);
        exit();
    }
}

/**
 * Initialise la base de données (création des tables)
 * @param PDO $pdo
 */
function initDatabase($pdo) {
    $dbType = DB_TYPE;
    
    if ($dbType === 'postgresql') {
        $sql = "
            CREATE TABLE IF NOT EXISTS responses (
                id SERIAL PRIMARY KEY,
                problem TEXT NOT NULL,
                domain VARCHAR(100) NOT NULL,
                frustration INTEGER NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );
            CREATE INDEX IF NOT EXISTS idx_domain ON responses (domain);
        ";
    } else {
        $sql = "
            CREATE TABLE IF NOT EXISTS responses (
                id INT AUTO_INCREMENT PRIMARY KEY,
                problem TEXT NOT NULL,
                domain VARCHAR(100) NOT NULL,
                frustration INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            CREATE INDEX idx_domain ON responses (domain);
        ";
        // Pour MySQL, CREATE INDEX IF NOT EXISTS n'est pas supporté avant 8.0.x
        // On enveloppe dans un try-catch au cas où
    }
    
    try {
        $pdo->exec($sql);
    } catch (Exception $e) {
        // On ignore si l'index existe déjà
    }
}

/**
 * Fonction pour valider et nettoyer les données
 * @param string $data
 * @return string
 */
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}
