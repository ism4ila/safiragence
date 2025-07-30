<?php
/**
 * Index admin - Redirection vers login - SAFIR CMS
 */

// Vérifier si l'utilisateur est connecté
session_start();

if (isset($_SESSION['admin_id']) && isset($_SESSION['admin_username'])) {
    // Déjà connecté, rediriger vers le dashboard
    header('Location: dashboard.php');
    exit;
} else {
    // Non connecté, rediriger vers la page de login
    header('Location: login.php');
    exit;
}
?>