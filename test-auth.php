<?php
require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

// Créer l'application Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Simuler une requête
$request = Request::capture();
$response = $kernel->handle($request);

echo "<h2>Test d'authentification Laravel</h2>";
echo "<p>Application Laravel chargée</p>";

// Tester la route /safir directement
echo "<p><a href='/safir'>Tester l'accès à /safir</a></p>";

// Afficher les routes disponibles
echo "<h3>Routes disponibles :</h3>";
echo "<ul>";
echo "<li><a href='/login'>Page de connexion</a></li>";
echo "<li><a href='/safir'>Dashboard admin</a></li>";
echo "<li><a href='/'>Accueil</a></li>";
echo "</ul>";

$kernel->terminate($request, $response);
?>