<?php
/**
 * Header AdminLTE pour SAFIR CMS
 */

if (!isset($auth)) {
    require_once 'auth.php';
}

$auth->requireAuth();
$admin = $auth->getAdmin();
$page_title = $page_title ?? 'Dashboard';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($page_title) ?> | SAFIR CMS</title>
    
    <!-- Bootstrap CSS local fallback -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" onerror="this.onerror=null;this.href='../css/bootstrap.min.css';">
    <!-- Font Awesome local fallback -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" onerror="this.onerror=null;this.href='assets/css/fontawesome.min.css';">
    <!-- AdminLTE local fallback -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css" onerror="this.onerror=null;this.href='assets/css/adminlte.min.css';">
    
    <!-- Fallback CSS si CDN ne fonctionne pas -->
    <noscript>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/admin-fallback.css">
    </noscript>
    
    <style>
        .main-sidebar {
            background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
        }
        
        .nav-sidebar .nav-link {
            color: rgba(255,255,255,0.8);
        }
        
        .nav-sidebar .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
            color: #fff;
        }
        
        .nav-sidebar .nav-link.active {
            background-color: #3498db;
            color: #fff;
        }
        
        .navbar-light {
            background: linear-gradient(90deg, #fff 0%, #f8f9fa 100%);
        }
        
        .content-wrapper {
            background: #f4f6f9;
        }
        
        .card {
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
            border: none;
        }
        
        .info-box {
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .info-box:hover {
            transform: translateY(-5px);
        }
        
        .brand-text {
            font-weight: 600;
            color: #fff !important;
        }
        
        .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active {
            background-color: #3498db;
        }
    </style>
    
    <?php if (isset($additional_css)): ?>
        <?= $additional_css ?>
    <?php endif; ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="../index.php" class="nav-link" target="_blank">
                    <i class="fas fa-eye me-1"></i> Voir le site
                </a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-comments"></i>
                    <span class="badge badge-danger navbar-badge" id="messages-count">0</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">Messages de contact</span>
                    <div class="dropdown-divider"></div>
                    <a href="messages.php" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> Voir tous les messages
                    </a>
                </div>
            </li>
            
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge" id="notifications-count">0</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="reservations.php" class="dropdown-item">
                        <i class="fas fa-calendar mr-2"></i> Nouvelles réservations
                    </a>
                </div>
            </li>
            
            <!-- User Account Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-user"></i>
                    <span class="d-none d-md-inline"><?= htmlspecialchars($admin['name']) ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header"><?= htmlspecialchars($admin['name']) ?></span>
                    <div class="dropdown-divider"></div>
                    <a href="profile.php" class="dropdown-item">
                        <i class="fas fa-user mr-2"></i> Mon profil
                    </a>
                    <a href="settings.php" class="dropdown-item">
                        <i class="fas fa-cog mr-2"></i> Paramètres
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="logout.php" class="dropdown-item" onclick="return confirm('Êtes-vous sûr de vouloir vous déconnecter ?')">
                        <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                    </a>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="dashboard.php" class="brand-link">
            <i class="fas fa-plane brand-image img-circle elevation-3" style="opacity: .8; margin-left: 10px; margin-right: 10px; color: #3498db;"></i>
            <span class="brand-text">SAFIR CMS</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <i class="fas fa-user-circle fa-2x text-white" style="opacity: 0.8;"></i>
                </div>
                <div class="info">
                    <a href="profile.php" class="d-block text-white">
                        <?= htmlspecialchars($admin['name']) ?>
                    </a>
                    <small class="text-muted"><?= ucfirst($admin['role']) ?></small>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    
                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <!-- Gestion du contenu -->
                    <li class="nav-item <?= in_array(basename($_SERVER['PHP_SELF']), ['pages.php', 'services.php']) ? 'menu-open' : '' ?>">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                Contenu
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="pages.php" class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'pages.php') ? 'active' : '' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Pages</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="services.php" class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'services.php') ? 'active' : '' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Services</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Encadreurs -->
                    <li class="nav-item">
                        <a href="encadreurs.php" class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'encadreurs.php') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Encadreurs</p>
                        </a>
                    </li>

                    <!-- Réservations -->
                    <li class="nav-item">
                        <a href="reservations.php" class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'reservations.php') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-calendar-check"></i>
                            <p>
                                Réservations
                                <span class="badge badge-info right" id="sidebar-reservations-count">0</span>
                            </p>
                        </a>
                    </li>

                    <!-- Messages -->
                    <li class="nav-item">
                        <a href="messages.php" class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'messages.php') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-envelope"></i>
                            <p>
                                Messages
                                <span class="badge badge-success right" id="sidebar-messages-count">0</span>
                            </p>
                        </a>
                    </li>

                    <!-- Galerie -->
                    <li class="nav-item">
                        <a href="gallery.php" class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'gallery.php') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-images"></i>
                            <p>Galerie</p>
                        </a>
                    </li>

                    <!-- Documents -->
                    <li class="nav-item">
                        <a href="documents.php" class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'documents.php') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-file-pdf"></i>
                            <p>Documents</p>
                        </a>
                    </li>

                    <?php if ($auth->hasPermission('manage_settings')): ?>
                    <!-- Administration -->
                    <li class="nav-header">ADMINISTRATION</li>
                    
                    <li class="nav-item">
                        <a href="settings.php" class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'settings.php') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>Paramètres</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="users.php" class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'users.php') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-user-shield"></i>
                            <p>Utilisateurs</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="logs.php" class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'logs.php') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-history"></i>
                            <p>Logs d'activité</p>
                        </a>
                    </li>
                    <?php endif; ?>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><?= htmlspecialchars($page_title) ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="dashboard.php">Accueil</a></li>
                            <?php if (isset($breadcrumbs) && is_array($breadcrumbs)): ?>
                                <?php foreach ($breadcrumbs as $breadcrumb): ?>
                                    <?php if (isset($breadcrumb['url'])): ?>
                                        <li class="breadcrumb-item"><a href="<?= htmlspecialchars($breadcrumb['url']) ?>"><?= htmlspecialchars($breadcrumb['title']) ?></a></li>
                                    <?php else: ?>
                                        <li class="breadcrumb-item active"><?= htmlspecialchars($breadcrumb['title']) ?></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li class="breadcrumb-item active"><?= htmlspecialchars($page_title) ?></li>
                            <?php endif; ?>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">