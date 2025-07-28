<?php
/**
 * Script pour diagnostiquer et corriger les identifiants admin - SAFIR CMS
 */

echo "<h2>🔧 Diagnostic et Correction des Identifiants Admin</h2>";

try {
    // Connexion à la base de données
    require_once '../includes/config.php';
    
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    echo "✅ Connexion BDD OK<br><br>";
    
    // 1. Vérifier les admins existants
    echo "<h3>1. État actuel des administrateurs :</h3>";
    $stmt = $pdo->query("SELECT id, username, email, first_name, last_name, is_active FROM admins");
    $admins = $stmt->fetchAll();
    
    if (empty($admins)) {
        echo "❌ <strong>Aucun administrateur trouvé !</strong><br>";
    } else {
        echo "<table border='1' style='border-collapse:collapse; margin:10px 0;'>";
        echo "<tr style='background:#f8f9fa;'><th>ID</th><th>Username</th><th>Email</th><th>Nom</th><th>Actif</th></tr>";
        foreach ($admins as $admin) {
            $style = $admin['is_active'] ? '' : 'style="background:#ffe6e6;"';
            echo "<tr $style>";
            echo "<td>" . $admin['id'] . "</td>";
            echo "<td>" . htmlspecialchars($admin['username']) . "</td>";
            echo "<td>" . htmlspecialchars($admin['email']) . "</td>";
            echo "<td>" . htmlspecialchars($admin['first_name'] . ' ' . $admin['last_name']) . "</td>";
            echo "<td>" . ($admin['is_active'] ? '✅' : '❌') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    // 2. Actions de correction
    echo "<h3>2. Actions de correction :</h3>";
    
    if ($_POST) {
        $action = $_POST['action'] ?? '';
        
        if ($action === 'delete_all') {
            $pdo->query("DELETE FROM admins");
            echo "✅ Tous les administrateurs supprimés<br>";
        }
        
        if ($action === 'create_new' || $action === 'delete_all') {
            // Créer le nouvel admin avec les bons identifiants
            $new_password = password_hash('12345678', PASSWORD_DEFAULT);
            
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
                echo "<div style='background:#d4edda; padding:15px; border-radius:5px; margin:10px 0;'>";
                echo "<strong>Identifiants créés :</strong><br>";
                echo "Username: admin<br>";
                echo "Email: ismailahamadou5@gmail.com<br>";
                echo "Mot de passe: 12345678<br>";
                echo "Hash généré: <code style='font-size:10px;'>" . substr($new_password, 0, 50) . "...</code>";
                echo "</div>";
                
                // Test immédiat du mot de passe
                echo "<h4>🧪 Test du hash créé :</h4>";
                if (password_verify('12345678', $new_password)) {
                    echo "✅ <strong style='color:green;'>Hash valide - Le mot de passe '12345678' fonctionne</strong><br>";
                } else {
                    echo "❌ <strong style='color:red;'>Problème avec le hash généré</strong><br>";
                }
                
            } else {
                echo "❌ Erreur lors de la création de l'administrateur<br>";
            }
        }
        
        if ($action === 'test_login') {
            $test_username = $_POST['test_username'] ?? '';
            $test_password = $_POST['test_password'] ?? '';
            
            echo "<h4>🧪 Test de connexion :</h4>";
            
            $stmt = $pdo->prepare(
                "SELECT id, username, email, password, first_name, last_name 
                 FROM admins WHERE (username = ? OR email = ?) AND is_active = 1"
            );
            $stmt->execute([$test_username, $test_username]);
            $admin = $stmt->fetch();
            
            if ($admin) {
                echo "✅ Utilisateur trouvé : " . $admin['username'] . " (" . $admin['email'] . ")<br>";
                echo "Hash stocké : <code style='font-size:10px;'>" . substr($admin['password'], 0, 50) . "...</code><br>";
                
                if (password_verify($test_password, $admin['password'])) {
                    echo "✅ <strong style='color:green; font-size:18px;'>MOT DE PASSE CORRECT ! 🎉</strong><br>";
                    
                    // Créer une session admin
                    session_start();
                    $_SESSION['admin_id'] = $admin['id'];
                    $_SESSION['admin_username'] = $admin['username'];
                    $_SESSION['admin_email'] = $admin['email'];
                    $_SESSION['admin_role'] = 'super_admin';
                    $_SESSION['admin_name'] = $admin['first_name'] . ' ' . $admin['last_name'];
                    
                    echo "✅ Session admin créée<br>";
                    echo "<br><a href='dashboard.php' style='padding:15px 30px; background:#28a745; color:white; text-decoration:none; border-radius:5px; font-size:16px;'>🚀 ALLER AU DASHBOARD</a>";
                    
                } else {
                    echo "❌ <strong style='color:red;'>Mot de passe incorrect</strong><br>";
                    
                    // Debug du hash
                    $debug_hash = password_hash($test_password, PASSWORD_DEFAULT);
                    echo "Hash du mot de passe testé : <code style='font-size:10px;'>" . substr($debug_hash, 0, 50) . "...</code><br>";
                }
            } else {
                echo "❌ Aucun utilisateur trouvé avec : " . htmlspecialchars($test_username) . "<br>";
            }
        }
        
        // Refresh de la page pour voir les changements
        if ($action === 'delete_all' || $action === 'create_new') {
            echo "<script>setTimeout(function(){ location.reload(); }, 2000);</script>";
        }
    }
    
} catch (Exception $e) {
    echo "❌ <strong>Erreur :</strong> " . $e->getMessage() . "<br>";
}
?>

<div style="margin:20px 0; padding:20px; background:#f8f9fa; border-radius:5px;">
    <h3>🔧 Actions disponibles :</h3>
    
    <form method="POST" style="margin:10px 0;">
        <input type="hidden" name="action" value="create_new">
        <button type="submit" style="padding:10px 20px; background:#007bff; color:white; border:none; border-radius:5px;">
            ➕ Créer un nouvel admin (garde les existants)
        </button>
    </form>
    
    <form method="POST" style="margin:10px 0;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer tous les admins ?');">
        <input type="hidden" name="action" value="delete_all">
        <button type="submit" style="padding:10px 20px; background:#dc3545; color:white; border:none; border-radius:5px;">
            🗑️ Supprimer tous et recréer
        </button>
    </form>
</div>

<div style="margin:20px 0; padding:20px; background:#e7f3ff; border-radius:5px;">
    <h3>🧪 Test de connexion en direct :</h3>
    <form method="POST">
        <input type="hidden" name="action" value="test_login">
        
        <div style="margin:10px 0;">
            <label><strong>Username ou Email :</strong></label><br>
            <input type="text" name="test_username" value="admin" style="padding:8px; width:300px; border:1px solid #ccc;">
        </div>
        
        <div style="margin:10px 0;">
            <label><strong>Mot de passe :</strong></label><br>
            <input type="password" name="test_password" value="12345678" style="padding:8px; width:200px; border:1px solid #ccc;">
        </div>
        
        <button type="submit" style="padding:10px 20px; background:#28a745; color:white; border:none; border-radius:5px;">
            🔍 Tester ces identifiants
        </button>
    </form>
</div>

<div style="margin:20px 0;">
    <a href="login.php" style="padding:10px 20px; background:#6c757d; color:white; text-decoration:none; border-radius:5px;">
        ← Retour au login
    </a>
</div>