<?php
/**
 * Debug page de connexion - SAFIR CMS
 */
echo "<h2>DEBUG - Page de connexion SAFIR</h2>";

// Test 1: Inclusion des fichiers
echo "<h3>1. Test des inclusions :</h3>";
try {
    echo "Config.php : ";
    require_once '../includes/config.php';
    echo "✅ OK<br>";
} catch (Exception $e) {
    echo "❌ ERREUR: " . $e->getMessage() . "<br>";
}

try {
    echo "Auth.php : ";
    require_once 'includes/auth.php';
    echo "✅ OK<br>";
} catch (Exception $e) {
    echo "❌ ERREUR: " . $e->getMessage() . "<br>";
}

// Test 2: Connexion BDD
echo "<h3>2. Test de connexion BDD :</h3>";
try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
        DB_USER,
        DB_PASS
    );
    echo "✅ Connexion BDD OK<br>";
    
    // Vérifier la table admins
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM admins");
    $count = $stmt->fetch()['count'];
    echo "✅ Table admins : $count utilisateur(s)<br>";
    
    // Vérifier l'admin par défaut
    $stmt = $pdo->prepare("SELECT username, email FROM admins WHERE username = 'admin'");
    $stmt->execute();
    $admin = $stmt->fetch();
    if ($admin) {
        echo "✅ Admin par défaut trouvé : " . $admin['username'] . " (" . $admin['email'] . ")<br>";
    } else {
        echo "❌ Admin par défaut non trouvé<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Erreur BDD: " . $e->getMessage() . "<br>";
}

// Test 3: Classe Auth
echo "<h3>3. Test de la classe Auth :</h3>";
try {
    $auth = new Auth();
    echo "✅ Classe Auth instanciée<br>";
    
    // Test CSRF
    $csrf = $auth->generateCSRFToken();
    echo "✅ CSRF Token généré : " . substr($csrf, 0, 20) . "...<br>";
    
    // Test isLoggedIn
    $isLogged = $auth->isLoggedIn();
    echo "✅ isLoggedIn() : " . ($isLogged ? 'true' : 'false') . "<br>";
    
} catch (Exception $e) {
    echo "❌ Erreur Auth: " . $e->getMessage() . "<br>";
}

// Test 4: Login test
if ($_POST) {
    echo "<h3>4. Test de connexion :</h3>";
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    try {
        $result = $auth->login($username, $password);
        if ($result['success']) {
            echo "✅ Login réussi !<br>";
            echo "<a href='dashboard.php'>Aller au dashboard</a><br>";
        } else {
            echo "❌ Login échoué : " . $result['message'] . "<br>";
        }
    } catch (Exception $e) {
        echo "❌ Erreur Login: " . $e->getMessage() . "<br>";
    }
}
?>

<h3>5. Formulaire de test :</h3>
<form method="POST" style="background:#f5f5f5; padding:20px; margin:10px 0;">
    <p><strong>Identifiants par défaut :</strong></p>
    <p>Username: <code>admin</code> ou Email: <code>ismailahamadou5@gmail.com</code><br>Password: <code>12345678</code></p>
    
    <div style="margin:10px 0;">
        <label>Username ou Email:</label><br>
        <input type="text" name="username" value="admin" style="padding:5px; width:300px;">
    </div>
    
    <div style="margin:10px 0;">
        <label>Password:</label><br>
        <input type="password" name="password" value="12345678" style="padding:5px; width:200px;">
    </div>
    
    <button type="submit" style="padding:10px 20px; background:#007bff; color:white; border:none;">
        Tester la connexion
    </button>
</form>

<h3>6. Liens utiles :</h3>
<a href="login.php">← Retour au login normal</a><br>
<a href="test-design.php">Test du design</a><br>
<a href="../index.php">Retour au site</a>