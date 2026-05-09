<?php
/**
 * API pour récupérer toutes les réponses (accès admin)
 */

require_once 'config.php';

// Vérifier que la méthode est POST ou GET
if (!in_array($_SERVER['REQUEST_METHOD'], ['GET', 'POST'])) {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Méthode non autorisée'
    ]);
    exit();
}

try {
    // Récupérer le mot de passe
    $password = '';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        $password = $data['password'] ?? '';
    } else {
        $password = $_GET['password'] ?? '';
    }
    
    // Vérifier le mot de passe admin avec le hash
    if (!password_verify($password, ADMIN_PASSWORD_HASH)) {
        http_response_code(401);
        echo json_encode([
            'success' => false,
            'message' => 'Mot de passe incorrect'
        ]);
        exit();
    }
    
    // Récupérer les paramètres de tri et filtrage
    $sortBy = $_GET['sortBy'] ?? 'created_at';
    $sortOrder = $_GET['sortOrder'] ?? 'DESC';
    $filterDomain = $_GET['domain'] ?? '';
    
    // Colonnes autorisées pour le tri
    $allowedSortColumns = ['id', 'domain', 'frustration', 'created_at'];
    if (!in_array($sortBy, $allowedSortColumns)) {
        $sortBy = 'created_at';
    }
    
    // Ordre de tri autorisé
    $sortOrder = strtoupper($sortOrder);
    if (!in_array($sortOrder, ['ASC', 'DESC'])) {
        $sortOrder = 'DESC';
    }
    
    // Construire la requête SQL
    $pdo = getDBConnection();
    $sql = "SELECT id, problem, domain, frustration, created_at FROM responses";
    $params = [];
    
    // Ajouter le filtre par domaine si spécifié
    if (!empty($filterDomain)) {
        $sql .= " WHERE domain = :domain";
        $params[':domain'] = $filterDomain;
    }
    
    // Ajouter le tri
    $sql .= " ORDER BY $sortBy $sortOrder";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $responses = $stmt->fetchAll();
    
    // Statistiques
    $statsStmt = $pdo->query("
        SELECT 
            COUNT(*) as total,
            AVG(frustration) as avg_frustration,
            domain,
            COUNT(*) as count
        FROM responses
        GROUP BY domain
    ");
    $stats = $statsStmt->fetchAll();
    
    // Réponse de succès
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'data' => $responses,
        'stats' => [
            'total' => count($responses),
            'by_domain' => $stats
        ]
    ]);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Erreur lors de la récupération des données'
    ]);
}
