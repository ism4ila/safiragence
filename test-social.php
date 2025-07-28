<?php
// Test pour vérifier les meta tags Open Graph
$base_url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'];
$current_url = $base_url . $_SERVER['REQUEST_URI'];
$image_url = $base_url . dirname($_SERVER['REQUEST_URI']) . '/assets/images/safir-logo-social.jpg';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Open Graph - SAFIR</title>
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $current_url; ?>">
    <meta property="og:title" content="SAFIR - Agence de Voyages et de Tourisme">
    <meta property="og:description" content="Spécialiste du HADJ et OUMRA à Bertoua. L'accomplissement parfait de votre pèlerinage reste notre priorité.">
    <meta property="og:image" content="<?php echo $image_url; ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:locale" content="fr_FR">
    <meta property="og:site_name" content="SAFIR">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?php echo $current_url; ?>">
    <meta name="twitter:title" content="SAFIR - Agence de Voyages et de Tourisme">
    <meta name="twitter:description" content="Spécialiste du HADJ et OUMRA à Bertoua. L'accomplissement parfait de votre pèlerinage reste notre priorité.">
    <meta name="twitter:image" content="<?php echo $image_url; ?>">
    <meta name="twitter:image:alt" content="SAFIR - Agence de voyages et de tourisme">
</head>
<body>
    <h1>Test Open Graph - SAFIR</h1>
    <p>Cette page teste les meta tags Open Graph pour le partage social.</p>
    
    <h2>Informations générées :</h2>
    <ul>
        <li><strong>URL actuelle :</strong> <?php echo $current_url; ?></li>
        <li><strong>Image :</strong> <?php echo $image_url; ?></li>
        <li><strong>Titre :</strong> SAFIR - Agence de Voyages et de Tourisme</li>
        <li><strong>Description :</strong> Spécialiste du HADJ et OUMRA à Bertoua. L'accomplissement parfait de votre pèlerinage reste notre priorité.</li>
    </ul>
    
    <h2>Vérification de l'image :</h2>
    <img src="<?php echo $image_url; ?>" alt="Logo SAFIR" style="max-width: 400px;">
    
    <h2>Outils de test :</h2>
    <ul>
        <li><a href="https://developers.facebook.com/tools/debug/?q=<?php echo urlencode($current_url); ?>" target="_blank">Facebook Open Graph Debugger</a></li>
        <li><a href="https://cards-dev.twitter.com/validator?url=<?php echo urlencode($current_url); ?>" target="_blank">Twitter Card Validator</a></li>
        <li><a href="https://www.linkedin.com/post-inspector/inspect/<?php echo urlencode($current_url); ?>" target="_blank">LinkedIn Post Inspector</a></li>
    </ul>
    
    <p><a href="index.php">Retour à l'accueil</a></p>
</body>
</html>