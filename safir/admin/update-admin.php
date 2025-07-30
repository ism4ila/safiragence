<?php
/**
 * Script de mise à jour des identifiants admin - SAFIR CMS
 */

echo "<h2>Mise à jour de l'administrateur SAFIR</h2>";

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
    
    // Nouveau mot de passe haché
    $new_password = password_hash('12345678', PASSWORD_DEFAULT);
    
    // Mise à jour de l'admin
    $stmt = $pdo->prepare("
        UPDATE admins SET 
            email = ?,
            password = ?,
            first_name = ?,
            last_name = ?
        WHERE username = 'admin'
    ");
    
    $result = $stmt->execute([
        'ismailahamadou5@gmail.com',
        $new_password,
        'Ismail',
        'HAMADOU'
    ]);
    
    if ($result && $stmt->rowCount() > 0) {
        echo "✅ <strong>Administrateur mis à jour avec succès !</strong><br><br>";
        
        // Vérification
        $stmt = $pdo->prepare("SELECT username, email, first_name, last_name FROM admins WHERE username = 'admin'");
        $stmt->execute();
        $admin = $stmt->fetch();
        
        if ($admin) {
            echo "<div style='background:#d4edda; padding:15px; border-radius:5px; margin:10px 0;'>";
            echo "<h3>Nouveaux identifiants :</h3>";
            echo "<strong>Username :</strong> " . htmlspecialchars($admin['username']) . "<br>";
            echo "<strong>Email :</strong> " . htmlspecialchars($admin['email']) . "<br>";
            echo "<strong>Nom :</strong> " . htmlspecialchars($admin['first_name'] . ' ' . $admin['last_name']) . "<br>";
            echo "<strong>Mot de passe :</strong> 12345678<br>";
            echo "</div>";
        }
        
    } else {
        echo "❌ Aucun administrateur trouvé avec le username 'admin'<br>";
        
        // Créer l'admin s'il n'existe pas
        echo "<br>Création d'un nouvel administrateur...<br>";
        $stmt = $pdo->prepare("
            INSERT INTO admins (username, email, password, role, first_name, last_name, is_active) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        
        $result = $stmt->execute([
            'admin',
            'ismailahamadou5@gmail.com',
            $new_password,
            'super_admin',
            'Ismail',
            'HAMADOU',
            1
        ]);
        
        if ($result) {
            echo "✅ <strong>Nouvel administrateur créé avec succès !</strong><br>";
        } else {
            echo "❌ Erreur lors de la création de l'administrateur<br>";
        }
    }
    
} catch (Exception $e) {
    echo "❌ <strong>Erreur :</strong> " . $e->getMessage() . "<br>";
}
?>

<div style="margin:20px 0; padding:15px; background:#f8f9fa; border-radius:5px;">
    <h3>Tester la connexion :</h3>
    <p>Vous pouvez maintenant vous connecter avec :</p>
    <ul>
        <li><strong>Username :</strong> admin</li>
        <li><strong>Email :</strong> ismailahamadou5@gmail.com</li>
        <li><strong>Mot de passe :</strong> 12345678</li>
    </ul>
</div>

<div style="margin:20px 0;">
    <a href="login.php" style="padding:10px 20px; background:#007bff; color:white; text-decoration:none; border-radius:5px;">
        → Aller à la page de connexion
    </a>
    <a href="debug-login.php" style="padding:10px 20px; background:#28a745; color:white; text-decoration:none; border-radius:5px; margin-left:10px;">
        → Tester avec debug
    </a>
</div>