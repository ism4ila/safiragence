<?php
/**
 * Script pour réinitialiser les tentatives de connexion - SAFIR CMS
 */

echo "<h2>🔓 Réinitialisation des tentatives de connexion</h2>";

try {
    // Connexion à la base de données
    require_once '../includes/config.php';
    
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    echo "✅ Connexion BDD OK<br>";
    
    // 1. Supprimer les variables de session liées aux tentatives
    session_start();
    if (isset($_SESSION['login_attempts'])) {
        unset($_SESSION['login_attempts']);
        echo "✅ Tentatives de session supprimées<br>";
    }
    
    if (isset($_SESSION['last_attempt_time'])) {
        unset($_SESSION['last_attempt_time']);
        echo "✅ Temps de dernière tentative réinitialisé<br>";
    }
    
    // 2. Vérifier s'il y a une table pour les tentatives IP
    try {
        $stmt = $pdo->query("SHOW TABLES LIKE 'login_attempts'");
        if ($stmt->rowCount() > 0) {
            // Supprimer toutes les tentatives de connexion
            $pdo->query("DELETE FROM login_attempts");
            echo "✅ Table login_attempts vidée<br>";
        } else {
            echo "ℹ️ Pas de table login_attempts trouvée<br>";
        }
    } catch (Exception $e) {
        echo "ℹ️ Pas de table login_attempts (normal)<br>";
    }
    
    // 3. Vérifier les logs d'activité
    try {
        $stmt = $pdo->query("SHOW TABLES LIKE 'activity_logs'");
        if ($stmt->rowCount() > 0) {
            // Supprimer les logs de tentatives échouées récents
            $pdo->query("DELETE FROM activity_logs WHERE action = 'login_failed' AND created_at > DATE_SUB(NOW(), INTERVAL 1 HOUR)");
            echo "✅ Logs de tentatives récentes supprimés<br>";
        }
    } catch (Exception $e) {
        echo "ℹ️ Pas de table activity_logs (normal)<br>";
    }
    
    // 4. Réinitialiser complètement la session
    session_destroy();
    session_start();
    
    echo "<br><div style='background:#d4edda; padding:15px; border-radius:5px; margin:10px 0;'>";
    echo "✅ <strong>Réinitialisation terminée avec succès !</strong><br>";
    echo "Vous pouvez maintenant essayer de vous reconnecter.";
    echo "</div>";
    
    // 5. Informations de connexion
    echo "<div style='background:#f8f9fa; padding:15px; border-radius:5px; margin:10px 0;'>";
    echo "<h3>Rappel des identifiants :</h3>";
    echo "<strong>Username :</strong> admin<br>";
    echo "<strong>Email :</strong> ismailahamadou5@gmail.com<br>";
    echo "<strong>Mot de passe :</strong> 12345678<br>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "❌ <strong>Erreur :</strong> " . $e->getMessage() . "<br>";
}
?>

<div style="margin:20px 0;">
    <a href="login.php" style="padding:10px 20px; background:#007bff; color:white; text-decoration:none; border-radius:5px;">
        🔑 Aller à la page de connexion
    </a>
    <a href="debug-login.php" style="padding:10px 20px; background:#28a745; color:white; text-decoration:none; border-radius:5px; margin-left:10px;">
        🔍 Tester avec debug
    </a>
    <a href="update-admin.php" style="padding:10px 20px; background:#ffc107; color:black; text-decoration:none; border-radius:5px; margin-left:10px;">
        👤 Mettre à jour l'admin
    </a>
</div>

<div style="margin:20px 0; padding:15px; background:#fff3cd; border-radius:5px;">
    <h4>💡 Si le problème persiste :</h4>
    <ol>
        <li>Redémarrez votre navigateur</li>
        <li>Videz le cache de votre navigateur</li>
        <li>Utilisez la navigation privée/incognito</li>
        <li>Attendez encore quelques minutes</li>
    </ol>
</div>