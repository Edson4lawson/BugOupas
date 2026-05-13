<?php
/**
 * Health check endpoint for Render
 */
require_once 'config.php';

try {
    $pdo = getDBConnection();
    echo json_encode([
        'status' => 'ok',
        'database' => 'connected',
        'message' => 'Backend is running'
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
