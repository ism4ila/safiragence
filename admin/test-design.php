<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test Design Admin SAFIR</title>
    
    <!-- Test Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Test Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- CSS de fallback local -->
    <link rel="stylesheet" href="assets/css/admin-fallback.css">
    
    <style>
        .test-card {
            border: 2px solid #28a745;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            background: white;
        }
        .status-ok { color: #28a745; }
        .status-error { color: #dc3545; }
    </style>
</head>
<body class="hold-transition sidebar-mini">

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="test-card">
                <h2><i class="fas fa-check-circle status-ok"></i> Test du Design Admin SAFIR</h2>
                <p>Si vous voyez cette page avec du style, les CSS fonctionnent !</p>
                
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h4><i class="fas fa-cog"></i> Test Bootstrap</h4>
                            </div>
                            <div class="card-body">
                                <p>Cette carte utilise Bootstrap. Si elle est stylée, Bootstrap fonctionne.</p>
                                <button class="btn btn-success"><i class="fas fa-thumbs-up"></i> Bouton Test</button>
                                <button class="btn btn-warning"><i class="fas fa-exclamation-triangle"></i> Attention</button>
                                <button class="btn btn-danger"><i class="fas fa-times"></i> Erreur</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <h4><i class="fas fa-icons"></i> Test Font Awesome</h4>
                            </div>
                            <div class="card-body">
                                <p>Test des icônes Font Awesome :</p>
                                <p>
                                    <i class="fas fa-home fa-2x text-primary"></i>
                                    <i class="fas fa-user fa-2x text-success"></i>
                                    <i class="fas fa-cog fa-2x text-warning"></i>
                                    <i class="fas fa-chart-bar fa-2x text-info"></i>
                                    <i class="fas fa-envelope fa-2x text-danger"></i>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-info mt-4">
                    <i class="fas fa-info-circle"></i>
                    <strong>Instructions :</strong>
                    <ol>
                        <li>Si cette page s'affiche correctement avec des couleurs et icônes : <span class="status-ok">✓ CSS OK</span></li>
                        <li>Si cette page est sans style (texte noir sur blanc) : <span class="status-error">✗ Problème CDN</span></li>
                        <li>Vérifiez votre connexion internet</li>
                        <li>Essayez de rafraîchir la page (F5)</li>
                    </ol>
                </div>
                
                <div class="mt-4">
                    <a href="login.php" class="btn btn-primary btn-lg">
                        <i class="fas fa-arrow-left"></i> Retour au Login
                    </a>
                    <a href="dashboard.php" class="btn btn-success btn-lg">
                        <i class="fas fa-tachometer-alt"></i> Aller au Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Test JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('✓ JavaScript fonctionne');
    
    // Test de détection des CSS
    const testElement = document.createElement('div');
    testElement.className = 'btn btn-primary d-none';
    document.body.appendChild(testElement);
    
    const styles = window.getComputedStyle(testElement);
    const hasBootstrap = styles.display === 'none' && styles.backgroundColor !== 'rgba(0, 0, 0, 0)';
    
    document.body.removeChild(testElement);
    
    if (hasBootstrap) {
        console.log('✓ Bootstrap CSS détecté');
    } else {
        console.warn('⚠ Bootstrap CSS non détecté - utilisation du fallback');
    }
});
</script>

</body>
</html>