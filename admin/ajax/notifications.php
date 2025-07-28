<?php
/**
 * API pour les notifications en temps réel - SAFIR CMS
 */

require_once '../includes/auth.php';

// Vérifier l'authentification
if (!$auth->isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['error' => 'Non autorisé']);
    exit;
}

try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    $notifications = [];
    
    // Compter les nouveaux messages
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM contact_messages WHERE status = 'new'");
    $notifications['messages'] = (int) $stmt->fetch()['count'];
    
    // Compter les réservations en attente
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM reservations WHERE status = 'pending'");
    $notifications['reservations'] = (int) $stmt->fetch()['count'];
    
    // Autres notifications (à développer)
    $notifications['alerts'] = 0;
    $notifications['updates'] = 0;
    
    header('Content-Type: application/json');
    echo json_encode($notifications);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur serveur']);
}
?>