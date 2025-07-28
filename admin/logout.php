<?php
/**
 * Déconnexion admin - SAFIR CMS
 */

require_once 'includes/auth.php';

// Effectuer la déconnexion
$auth->logout();

// Redirection avec message
header('Location: login.php?message=logout_success');
exit;
?>