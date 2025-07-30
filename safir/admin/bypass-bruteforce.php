<?php
/**
 * Script pour bypasser temporairement la protection anti-brute force - SAFIR CMS
 */

echo "<h2>🔓 Bypass Protection Anti-Brute Force</h2>";

// Démarrer la session
session_start();

echo "<h3>1. État actuel :</h3>";

$ip = $_SERVER['REMOTE_ADDR'];
echo "Votre IP : <strong>$ip</strong><br>";

if (isset($_SESSION['login_attempts'][$ip])) {
    echo "Tentatives actuelles : <strong>" . $_SESSION['login_attempts'][$ip] . "</strong><br>";
} else {
    echo "Tentatives actuelles : <strong>0</strong><br>";
}

if (isset($_SESSION['last_attempt'][$ip])) {
    $last_attempt = $_SESSION['last_attempt'][$ip];
    $time_diff = time() - $last_attempt;
    echo "Dernière tentative : <strong>" . date('H:i:s', $last_attempt) . "</strong> (il y a " . $time_diff . " secondes)<br>";
} else {
    echo "Dernière tentative : <strong>Aucune</strong><br>";
}

echo "<h3>2. Réinitialisation :</h3>";

// Supprimer toutes les données de tentatives
if (isset($_SESSION['login_attempts'])) {
    unset($_SESSION['login_attempts']);
    echo "✅ Toutes les tentatives supprimées<br>";
}

if (isset($_SESSION['last_attempt'])) {
    unset($_SESSION['last_attempt']);
    echo "✅ Tous les temps d'attente supprimés<br>";
}

// Nettoyer d'autres variables liées
$session_keys_to_clean = ['failed_logins', 'brute_force_ip', 'login_blocked_until'];
foreach ($session_keys_to_clean as $key) {
    if (isset($_SESSION[$key])) {
        unset($_SESSION[$key]);
        echo "✅ Variable $key supprimée<br>";
    }
}

echo "<h3>3. Test de connexion direct :</h3>";

if ($_POST && isset($_POST['test_login'])) {
    try {
        require_once '../includes/config.php';
        
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        // Connexion directe à la base sans passer par la classe Auth
        $pdo = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
            DB_USER,
            DB_PASS,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        
        $stmt = $pdo->prepare(
            "SELECT id, username, email, password, role, first_name, last_name, is_active 
             FROM admins WHERE (username = ? OR email = ?) AND is_active = 1"
        );
        $stmt->execute([$username, $username]);
        $admin = $stmt->fetch();
        
        if ($admin) {
            echo "✅ Utilisateur trouvé : " . $admin['username'] . " (" . $admin['email'] . ")<br>";
            
            if (password_verify($password, $admin['password'])) {
                echo "✅ <strong style='color:green;'>Mot de passe correct !</strong><br>";
                
                // Créer une session admin manuelle
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_username'] = $admin['username'];
                $_SESSION['admin_email'] = $admin['email'];
                $_SESSION['admin_role'] = $admin['role'];
                $_SESSION['admin_name'] = $admin['first_name'] . ' ' . $admin['last_name'];
                
                echo "✅ Session admin créée manuellement<br>";
                echo "<br><a href='dashboard.php' style='padding:10px 20px; background:#28a745; color:white; text-decoration:none; border-radius:5px;'>→ Aller au Dashboard</a>";
                
            } else {
                echo "❌ <strong style='color:red;'>Mot de passe incorrect</strong><br>";
                echo "Hash en BDD : <code style='font-size:10px;'>" . substr($admin['password'], 0, 30) . "...</code><br>";
                
                // Test du hash
                $test_hash = password_hash($password, PASSWORD_DEFAULT);
                echo "Hash du mot de passe saisi : <code style='font-size:10px;'>" . substr($test_hash, 0, 30) . "...</code><br>";
            }
        } else {
            echo "❌ <strong style='color:red;'>Utilisateur non trouvé</strong><br>";
        }
        
    } catch (Exception $e) {
        echo "❌ Erreur : " . $e->getMessage() . "<br>";
    }
}
?>

<div style="background:#f8f9fa; padding:15px; border-radius:5px; margin:20px 0;">
    <h3>🔑 Test de connexion directe (bypass complet) :</h3>
    <form method="POST">
        <input type="hidden" name="test_login" value="1">
        
        <div style="margin:10px 0;">
            <label><strong>Username ou Email :</strong></label><br>
            <input type="text" name="username" value="admin" style="padding:8px; width:300px; border:1px solid #ccc;">
        </div>
        
        <div style="margin:10px 0;">
            <label><strong>Mot de passe :</strong></label><br>
            <input type="password" name="password" value="12345678" style="padding:8px; width:200px; border:1px solid #ccc;">
        </div>
        
        <button type="submit" style="padding:10px 20px; background:#007bff; color:white; border:none; border-radius:5px;">
            🚀 Test Direct (sans anti-brute force)
        </button>
    </form>
</div>

<div style="margin:20px 0;">
    <a href="login.php" style="padding:10px 20px; background:#007bff; color:white; text-decoration:none; border-radius:5px;">
        🔑 Retour au login normal
    </a>
    <a href="reset-attempts.php" style="padding:10px 20px; background:#dc3545; color:white; text-decoration:none; border-radius:5px; margin-left:10px;">
        🔄 Reset complet
    </a>
</div>

<div style="background:#fff3cd; padding:15px; border-radius:5px; margin:20px 0;">
    <h4>💡 Identifiants à utiliser :</h4>
    <strong>Username :</strong> admin<br>
    <strong>Email :</strong> ismailahamadou5@gmail.com<br>
    <strong>Mot de passe :</strong> 12345678
</div>