<?php
// Test simple pour vérifier l'authentification
session_start();
echo "<h2>Test de connexion Laravel</h2>";

// Simuler l'authentification
$_SESSION['user_authenticated'] = true;
$_SESSION['user_id'] = 1;

echo "<p>Session démarrée</p>";
echo "<p>User authenticated: " . (isset($_SESSION['user_authenticated']) ? 'Oui' : 'Non') . "</p>";

// Test de redirection
echo "<p>Redirection test:</p>";
echo "<a href='/safir' target='_blank'>Lien vers /safir</a><br>";
echo "<a href='http://127.0.0.1:8000/safir' target='_blank'>Lien complet vers dashboard</a>";

// Test redirect JavaScript
echo "<script>
setTimeout(function() {
    console.log('Test de redirection dans 3 secondes...');
    // window.location.href = 'http://127.0.0.1:8000/safir';
}, 3000);
</script>";
?>