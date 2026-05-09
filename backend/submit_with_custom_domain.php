<?php
/**
 * API pour soumettre une nouvelle réponse au sondage
 * Gère le champ domain avec option "Autre" et custom_domain
 */

require_once 'config.php';

// Vérifier que la méthode est POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'status' => 'error',
        'message' => 'Méthode non autorisée'
    ]);
    exit();
}

try {
    // Récupérer les données JSON
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    // Validation des données
    if (!isset($data['problem']) || empty(trim($data['problem']))) {
        throw new Exception('Le problème est requis');
    }
    
    if (!isset($data['domain']) || empty(trim($data['domain']))) {
        throw new Exception('Le domaine est requis');
    }
    
    if (!isset($data['frustration']) || !is_numeric($data['frustration'])) {
        throw new Exception('Le niveau de frustration est requis');
    }
    
    $frustration = intval($data['frustration']);
    if ($frustration < 1 || $frustration > 5) {
        throw new Exception('Le niveau de frustration doit être entre 1 et 5');
    }
    
    // Domaines autorisés
    $allowedDomains = ['Santé', 'Éducation', 'Finance', 'Autre'];
    if (!in_array($data['domain'], $allowedDomains)) {
        throw new Exception('Domaine non valide');
    }
    
    // Nettoyer les données
    $problem = sanitize($data['problem']);
    
    // Gérer le domaine personnalisé
    $finalDomain = '';
    if ($data['domain'] === 'Autre') {
        // Si "Autre" est sélectionné, utiliser custom_domain
        if (!isset($data['custom_domain']) || empty(trim($data['custom_domain']))) {
            throw new Exception('Veuillez spécifier un domaine personnalisé');
        }
        $finalDomain = sanitize($data['custom_domain']);
    } else {
        // Sinon, utiliser le domaine sélectionné
        $finalDomain = sanitize($data['domain']);
    }
    
    // Vérifier que le domaine final n'est pas vide
    if (empty($finalDomain)) {
        throw new Exception('Le domaine ne peut pas être vide');
    }
    
    // Vérifier que le problème n'est pas trop court
    if (strlen($problem) < 10) {
        throw new Exception('Le problème doit contenir au moins 10 caractères');
    }
    
    // Insérer dans la base de données avec prepared statement
    $pdo = getDBConnection();
    $stmt = $pdo->prepare("
        INSERT INTO responses (problem, domain, frustration) 
        VALUES (:problem, :domain, :frustration)
    ");
    
    $stmt->execute([
        ':problem' => $problem,
        ':domain' => $finalDomain,
        ':frustration' => $frustration
    ]);
    
    // Récupérer l'ID de la réponse insérée
    $responseId = $pdo->lastInsertId();
    
    // Réponse de succès
    http_response_code(201);
    echo json_encode([
        'status' => 'success',
        'message' => 'Merci pour votre idée !',
        'data' => [
            'id' => $responseId,
            'problem' => $problem,
            'domain' => $finalDomain,
            'frustration' => $frustration
        ]
    ]);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Erreur lors de l\'enregistrement'
    ]);
}
