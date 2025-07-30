<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">


    <!-- Meta tags généraux -->
    <meta name="description" content="SAFIR - Agence de voyages et de tourisme spécialisée dans l'organisation du HADJ et OUMRA. Vente de billets d'avion, réservation d'hôtel, location automobiles.">
    <meta name="keywords" content="SAFIR, voyage, tourisme, HADJ, OUMRA, pèlerinage, billets d'avion, hôtel, location voiture">
    <meta name="author" content="SAFIR - Agence de voyages">

    <!-- Open Graph (Facebook, WhatsApp, LinkedIn) -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="SAFIR - Agence de voyages et de tourisme">
    <meta property="og:description" content="L'accomplissement parfait de votre pèlerinage reste notre priorité ! Voyages, tourisme, billetterie et organisation de pèlerinage.">
    <meta property="og:url" content="<?php echo 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
    <meta property="og:site_name" content="SAFIR">
    <meta property="og:image" content="<?php echo 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/assets/images/safir-logo-social.jpg'; ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="SAFIR - Agence de voyages et de tourisme">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:locale" content="fr_FR">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="SAFIR - Agence de voyages et de tourisme">
    <meta name="twitter:description" content="L'accomplissement parfait de votre pèlerinage reste notre priorité ! Voyages, tourisme, billetterie et organisation de pèlerinage.">
    <meta name="twitter:image" content="<?php echo 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/assets/images/safir-logo-social.jpg'; ?>">
    <meta name="twitter:image:alt" content="SAFIR - Agence de voyages et de tourisme">

    <!-- WhatsApp -->
    <meta property="og:image:type" content="image/jpeg">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <link rel="apple-touch-icon" href="assets/images/apple-touch-icon.png">

    <!-- Meta tags pour chaque page spécifique -->
    <?php
    // Variables pour personnaliser selon la page
    $page_title = isset($page_title) ? $page_title : "SAFIR - Agence de voyages et de tourisme";
    $page_description = isset($page_description) ? $page_description : "L'accomplissement parfait de votre pèlerinage reste notre priorité ! Voyages, tourisme, billetterie et organisation de pèlerinage.";
    $base_url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'];
    $page_image = isset($page_image) ? $page_image : $base_url . dirname($_SERVER['REQUEST_URI']) . '/assets/images/safir-logo-social.jpg';
    $page_url = isset($page_url) ? $page_url : $base_url . $_SERVER['REQUEST_URI'];
    ?>
    <!-- SEO Meta Tags -->
    <title>SAFIR - Agence de Voyages et de Tourisme | Bertoua, Cameroun</title>
    <meta name="description" content="Agence SAFIR à Bertoua : Spécialiste du HADJ et OUMRA, vente de billets d'avion, voyages d'affaires et tourisme, réservation d'hôtels et location de voitures. L'accomplissement parfait de votre pèlerinage reste notre priorité.">
    <meta name="keywords" content="SAFIR, agence voyage, Bertoua, Cameroun, HADJ, OUMRA, pèlerinage, billets avion, tourisme, voyage affaires, réservation hôtel, location voiture">
    <meta name="author" content="SAFIR - Agence de Voyages et de Tourisme">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Facebook (Dynamic) -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $page_url; ?>">
    <meta property="og:title" content="SAFIR - Agence de Voyages et de Tourisme">
    <meta property="og:description" content="Spécialiste du HADJ et OUMRA à Bertoua. L'accomplissement parfait de votre pèlerinage reste notre priorité.">
    <meta property="og:image" content="<?php echo $page_image; ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:locale" content="fr_FR">
    <meta property="og:site_name" content="SAFIR">
    
    <!-- Force refresh for social media crawlers -->
    <meta property="og:updated_time" content="<?php echo time(); ?>">

    <!-- Twitter (Dynamic) -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?php echo $page_url; ?>">
    <meta name="twitter:title" content="SAFIR - Agence de Voyages et de Tourisme">
    <meta name="twitter:description" content="Spécialiste du HADJ et OUMRA à Bertoua. L'accomplissement parfait de votre pèlerinage reste notre priorité.">
    <meta name="twitter:image" content="<?php echo $page_image; ?>">
    <meta name="twitter:image:alt" content="SAFIR - Agence de voyages et de tourisme">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon-16x16.png">
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <link rel="manifest" href="assets/images/site.webmanifest">

    <!-- Preconnect for faster loading -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Google Fonts - Optimized loading -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">

    <!-- CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">

    <!-- Structured Data (JSON-LD) -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "TravelAgency",
            "name": "SAFIR - Agence de Voyages et de Tourisme",
            "description": "Agence de voyages spécialisée dans l'organisation du HADJ et OUMRA, vente de billets d'avion, voyages d'affaires et tourisme.",
            "url": "https://safir-agence.com",
            "telephone": "+237 222 24 30 84",
            "email": "safir.agence.cameroun@gmail.com",
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "Immeuble SPC, avant carrefour aviation",
                "addressLocality": "Bertoua",
                "addressRegion": "ENIA",
                "addressCountry": "CM"
            },
            "geo": {
                "@type": "GeoCoordinates",
                "latitude": "4.5770",
                "longitude": "13.6790"
            },
            "openingHours": "Mo-Fr 08:00-18:00, Sa 08:00-14:00",
            "priceRange": "$$",
            "serviceArea": {
                "@type": "Country",
                "name": "Cameroun"
            }
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mettre à jour le title
            document.title = "<?php echo $page_title; ?>";

            // Mettre à jour les meta descriptions
            document.querySelector('meta[name="description"]').setAttribute('content', "<?php echo $page_description; ?>");
            document.querySelector('meta[property="og:title"]').setAttribute('content', "<?php echo $page_title; ?>");
            document.querySelector('meta[property="og:description"]').setAttribute('content', "<?php echo $page_description; ?>");
            document.querySelector('meta[property="og:url"]').setAttribute('content', "<?php echo $page_url; ?>");
            document.querySelector('meta[property="og:image"]').setAttribute('content', "<?php echo $page_image; ?>");
            document.querySelector('meta[name="twitter:title"]').setAttribute('content', "<?php echo $page_title; ?>");
            document.querySelector('meta[name="twitter:description"]').setAttribute('content', "<?php echo $page_description; ?>");
            document.querySelector('meta[name="twitter:image"]').setAttribute('content', "<?php echo $page_image; ?>");
        });
    </script>
</head>

<body>
    <!-- Skip to main content (accessibility) -->
    <a class="visually-hidden-focusable" href="#main-content">Aller au contenu principal</a>

    <header role="banner">
        <nav class="navbar navbar-expand-lg navbar-light fixed-top" aria-label="Navigation principale">
            <div class="container">
                <!-- Logo SAFIR amélioré -->
                <a class="navbar-brand" href="index.php" aria-label="SAFIR - Retour à l'accueil">
                    <div class="safir-logo">SAFIR</div>
                    <div class="safir-subtitle">AGENCE DE VOYAGES ET DE TOURISME</div>
                    <div class="safir-subtitle-en">TRAVEL AND TOURISM AGENCY</div>
                </a>

                <!-- Bouton menu mobile -->
                <button class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarNav"
                    aria-controls="navbarNav"
                    aria-expanded="false"
                    aria-label="Basculer la navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Menu de navigation -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto" role="menubar">
                        <li class="nav-item" role="none">
                            <a class="nav-link"
                                href="index.php"
                                role="menuitem"
                                aria-current="page">
                                <i class="bi bi-house-door me-1" aria-hidden="true"></i>
                                Accueil
                            </a>
                        </li>
                        <li class="nav-item dropdown" role="none">
                            <a class="nav-link dropdown-toggle"
                                href="services.php"
                                id="servicesDropdown"
                                role="menuitem"
                                data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-briefcase me-1" aria-hidden="true"></i>
                                Nos Services
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="servicesDropdown">
                                <li><a class="dropdown-item" href="services.php#billets">
                                        <i class="bi bi-airplane me-2"></i>Billets d'Avion
                                    </a></li>
                                <li><a class="dropdown-item" href="services.php#hadj">
                                        <i class="bi bi-moon-stars me-2"></i>HADJ & OUMRA
                                    </a></li>
                                <li><a class="dropdown-item" href="services.php#voyages">
                                        <i class="bi bi-map me-2"></i>Voyages & Séjours
                                    </a></li>
                                <li><a class="dropdown-item" href="services.php#hotels">
                                        <i class="bi bi-building me-2"></i>Réservation Hôtels
                                    </a></li>
                                <li><a class="dropdown-item" href="services.php#location">
                                        <i class="bi bi-car-front me-2"></i>Location Voitures
                                    </a></li>
                            </ul>
                        </li>
                        <li class="nav-item" role="none">
                            <a class="nav-link"
                                href="galerie.php"
                                role="menuitem">
                                <i class="bi bi-images me-1" aria-hidden="true"></i>
                                Galerie
                            </a>
                        </li>
                        <li class="nav-item" role="none">
                            <a class="nav-link"
                                href="about.php"
                                role="menuitem">
                                <i class="bi bi-info-circle me-1" aria-hidden="true"></i>
                                À Propos
                            </a>
                        </li>
                        <li class="nav-item" role="none">
                            <a class="nav-link"
                                href="contact.php"
                                role="menuitem">
                                <i class="bi bi-telephone me-1" aria-hidden="true"></i>
                                Contact
                            </a>
                        </li>

                        <!-- Bouton CTA -->
                        <li class="nav-item ms-2" role="none">
                            <a class="btn btn-primary nav-cta"
                                href="contact.php#devis"
                                role="menuitem">
                                <i class="bi bi-send me-1" aria-hidden="true"></i>
                                Devis Gratuit
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Informations de contact en mobile -->
                <div class="d-lg-none navbar-contact mt-3">
                    <div class="text-center">
                        <a href="tel:+68300.00.80" class="btn btn-outline-primary btn-sm me-2">
                            <i class="bi bi-telephone"></i> +237 222 24 30 84
                        </a>
                        <a href="mailto:safir.agence.cameroun@gmail.com" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-envelope"></i> Email
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Barre d'informations rapides (desktop seulement) -->
        <div class="top-info-bar d-none d-lg-block">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <small class="text-muted">
                            <i class="bi bi-geo-alt me-1"></i>
                            Bertoua, ENIA - Immeuble SPC, avant carrefour aviation
                        </small>
                    </div>
                    <div class="col-md-4 text-end">
                        <small>
                            <a href="tel:+68300.00.80" class="text-decoration-none me-3">
                                <i class="bi bi-telephone me-1"></i>+237 222 24 30 84
                            </a>
                            <a href="mailto:safir.agence.cameroun@gmail.com" class="text-decoration-none">
                                <i class="bi bi-envelope me-1"></i>Email
                            </a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Espaceur pour navbar fixe -->
    <div class="navbar-spacer"></div>

    <main id="main-content" role="main">
        <!-- Le contenu principal de vos pages ira ici -->