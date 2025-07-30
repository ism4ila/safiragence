<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Meta tags généraux -->
    <meta name="description" content="SAFIR - Agence de voyages et de tourisme spécialisée dans l'organisation du HADJ et OUMRA. Vente de billets d'avion, réservation d'hôtel, location automobiles.">
    <meta name="keywords" content="SAFIR, voyage, tourisme, HADJ, OUMRA, pèlerinage, billets d'avion, hôtel, location voiture">
    <meta name="author" content="SAFIR - Agence de voyages">

    <!-- Open Graph (Facebook, WhatsApp, LinkedIn) -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="SAFIR - Agence de voyages et de tourisme">
    <meta property="og:description" content="L'accomplissement parfait de votre pèlerinage reste notre priorité ! Voyages, tourisme, billetterie et organisation de pèlerinage.">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="SAFIR">
    <meta property="og:image" content="{{ asset('images/safir-logo-social.jpg') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="SAFIR - Agence de voyages et de tourisme">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:locale" content="fr_FR">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="SAFIR - Agence de voyages et de tourisme">
    <meta name="twitter:description" content="L'accomplissement parfait de votre pèlerinage reste notre priorité !">
    <meta name="twitter:image" content="{{ asset('images/safir-logo-social.jpg') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <title>@yield('title', 'SAFIR - Agence de voyages et de tourisme')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('layouts.partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('layouts.partials.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
