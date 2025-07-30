<?php
// Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // Votre nom d'utilisateur BDD
define('DB_PASS', ''); // Votre mot de passe BDD
define('DB_NAME', 'safir_db'); // Le nom de votre base de données

// DSN (Data Source Name)
$dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;

// Options de PDO
$options = [
    PDO::ATTR_PERSISTENT => true,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

// Activer le rapport d'erreurs pour le développement
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Démarrer la session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>