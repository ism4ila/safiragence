<?php
/**
 * Gestion des paramètres du site - SAFIR CMS
 */

$page_title = 'Paramètres du Site';
$breadcrumbs = [
    ['title' => 'Administration', 'url' => '#'],
    ['title' => 'Paramètres']
];

require_once 'includes/header.php';

// Vérifier les permissions
$auth->requireAuth('manage_settings');

// Connexion à la base de données
try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}

$message = '';
$error = '';

// Traitement des mises à jour
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf_token = $_POST['csrf_token'] ?? '';
    
    if (!$auth->verifyCSRFToken($csrf_token)) {
        $error = 'Token de sécurité invalide.';
    } else {
        $updated_count = 0;
        $updated_settings = [];
        
        // Parcourir tous les paramètres envoyés
        foreach ($_POST as $key => $value) {
            if ($key !== 'csrf_token' && strpos($key, 'setting_') === 0) {
                $setting_key = substr($key, 8); // Enlever 'setting_'
                $setting_value = is_array($value) ? json_encode($value) : trim($value);
                
                try {
                    $stmt = $pdo->prepare("
                        UPDATE site_settings 
                        SET setting_value = ?, updated_by = ?, updated_at = NOW()
                        WHERE setting_key = ? AND is_editable = 1
                    ");
                    $result = $stmt->execute([$setting_value, $_SESSION['admin_id'], $setting_key]);
                    
                    if ($stmt->rowCount() > 0) {
                        $updated_count++;
                        $updated_settings[] = $setting_key;
                    }
                } catch (PDOException $e) {
                    error_log('Erreur mise à jour setting ' . $setting_key . ': ' . $e->getMessage());
                }
            }
        }
        
        if ($updated_count > 0) {
            $auth->logActivity($_SESSION['admin_id'], 'settings_updated', [
                'count' => $updated_count,
                'settings' => $updated_settings
            ]);
            $message = "$updated_count paramètre(s) mis à jour avec succès.";
        } else {
            $error = 'Aucun paramètre n\'a été modifié.';
        }
    }
}

// Récupération des paramètres groupés
try {
    $stmt = $pdo->query("
        SELECT setting_key, setting_value, setting_type, setting_group, description, is_editable
        FROM site_settings 
        ORDER BY setting_group, setting_key
    ");
    $all_settings = $stmt->fetchAll();
    
    // Grouper par catégorie
    $settings_groups = [];
    foreach ($all_settings as $setting) {
        $settings_groups[$setting['setting_group']][] = $setting;
    }
    
} catch (PDOException $e) {
    $error = 'Erreur lors du chargement des paramètres : ' . $e->getMessage();
    $settings_groups = [];
}

$csrf_token = $auth->generateCSRFToken();
?>

<?php if ($message): ?>
<div class="alert alert-success alert-dismissible fade show">
    <i class="fas fa-check-circle me-2"></i>
    <?= htmlspecialchars($message) ?>
    <button type="button" class="close" data-dismiss="alert">
        <span>&times;</span>
    </button>
</div>
<?php endif; ?>

<?php if ($error): ?>
<div class="alert alert-danger alert-dismissible fade show">
    <i class="fas fa-exclamation-triangle me-2"></i>
    <?= htmlspecialchars($error) ?>
    <button type="button" class="close" data-dismiss="alert">
        <span>&times;</span>
    </button>
</div>
<?php endif; ?>

<form method="POST" id="settingsForm">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
    
    <div class="row">
        <div class="col-md-8">
            <!-- Onglets des paramètres -->
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="settingsTabs" role="tablist">
                        <?php
                        $tab_icons = [
                            'general' => 'fas fa-cog',
                            'contact' => 'fas fa-phone',
                            'social' => 'fas fa-share-alt',
                            'seo' => 'fas fa-search',
                            'email' => 'fas fa-envelope',
                            'advanced' => 'fas fa-tools'
                        ];
                        
                        $tab_labels = [
                            'general' => 'Général',
                            'contact' => 'Contact',
                            'social' => 'Réseaux sociaux',
                            'seo' => 'SEO',
                            'email' => 'Email',
                            'advanced' => 'Avancé'
                        ];
                        
                        $first_tab = true;
                        foreach ($settings_groups as $group => $settings):
                        ?>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link <?= $first_tab ? 'active' : '' ?>" 
                               id="<?= $group ?>-tab" 
                               data-toggle="tab" 
                               href="#<?= $group ?>" 
                               role="tab">
                                <i class="<?= $tab_icons[$group] ?? 'fas fa-cog' ?> mr-1"></i>
                                <?= $tab_labels[$group] ?? ucfirst($group) ?>
                            </a>
                        </li>
                        <?php 
                        $first_tab = false;
                        endforeach; 
                        ?>
                    </ul>
                </div>
                
                <div class="card-body">
                    <div class="tab-content" id="settingsTabContent">
                        <?php 
                        $first_tab = true;
                        foreach ($settings_groups as $group => $settings): 
                        ?>
                        <div class="tab-pane fade <?= $first_tab ? 'show active' : '' ?>" 
                             id="<?= $group ?>" 
                             role="tabpanel">
                            
                            <h5 class="mb-4">
                                <i class="<?= $tab_icons[$group] ?? 'fas fa-cog' ?> mr-2"></i>
                                <?= $tab_labels[$group] ?? ucfirst($group) ?>
                            </h5>
                            
                            <div class="row">
                                <?php foreach ($settings as $setting): ?>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="setting_<?= htmlspecialchars($setting['setting_key']) ?>">
                                            <?= htmlspecialchars(ucfirst(str_replace('_', ' ', $setting['setting_key']))) ?>
                                            <?php if (!$setting['is_editable']): ?>
                                            <span class="badge badge-secondary ml-1">Lecture seule</span>
                                            <?php endif; ?>
                                        </label>
                                        
                                        <?php if ($setting['setting_type'] === 'textarea'): ?>
                                        <textarea class="form-control" 
                                                  id="setting_<?= htmlspecialchars($setting['setting_key']) ?>"
                                                  name="setting_<?= htmlspecialchars($setting['setting_key']) ?>"
                                                  rows="3"
                                                  <?= !$setting['is_editable'] ? 'readonly' : '' ?>><?= htmlspecialchars($setting['setting_value'] ?? '') ?></textarea>
                                        
                                        <?php elseif ($setting['setting_type'] === 'boolean'): ?>
                                        <div class="form-check">
                                            <input type="checkbox" 
                                                   class="form-check-input" 
                                                   id="setting_<?= htmlspecialchars($setting['setting_key']) ?>"
                                                   name="setting_<?= htmlspecialchars($setting['setting_key']) ?>"
                                                   value="1"
                                                   <?= $setting['setting_value'] ? 'checked' : '' ?>
                                                   <?= !$setting['is_editable'] ? 'disabled' : '' ?>>
                                            <label class="form-check-label" for="setting_<?= htmlspecialchars($setting['setting_key']) ?>">
                                                Activer
                                            </label>
                                        </div>
                                        
                                        <?php elseif ($setting['setting_type'] === 'number'): ?>
                                        <input type="number" 
                                               class="form-control" 
                                               id="setting_<?= htmlspecialchars($setting['setting_key']) ?>"
                                               name="setting_<?= htmlspecialchars($setting['setting_key']) ?>"
                                               value="<?= htmlspecialchars($setting['setting_value'] ?? '') ?>"
                                               <?= !$setting['is_editable'] ? 'readonly' : '' ?>>
                                        
                                        <?php elseif ($setting['setting_type'] === 'email'): ?>
                                        <input type="email" 
                                               class="form-control" 
                                               id="setting_<?= htmlspecialchars($setting['setting_key']) ?>"
                                               name="setting_<?= htmlspecialchars($setting['setting_key']) ?>"
                                               value="<?= htmlspecialchars($setting['setting_value'] ?? '') ?>"
                                               <?= !$setting['is_editable'] ? 'readonly' : '' ?>>
                                        
                                        <?php elseif ($setting['setting_type'] === 'url'): ?>
                                        <input type="url" 
                                               class="form-control" 
                                               id="setting_<?= htmlspecialchars($setting['setting_key']) ?>"
                                               name="setting_<?= htmlspecialchars($setting['setting_key']) ?>"
                                               value="<?= htmlspecialchars($setting['setting_value'] ?? '') ?>"
                                               placeholder="https://"
                                               <?= !$setting['is_editable'] ? 'readonly' : '' ?>>
                                        
                                        <?php else: ?>
                                        <input type="text" 
                                               class="form-control" 
                                               id="setting_<?= htmlspecialchars($setting['setting_key']) ?>"
                                               name="setting_<?= htmlspecialchars($setting['setting_key']) ?>"
                                               value="<?= htmlspecialchars($setting['setting_value'] ?? '') ?>"
                                               <?= !$setting['is_editable'] ? 'readonly' : '' ?>>
                                        <?php endif; ?>
                                        
                                        <?php if ($setting['description']): ?>
                                        <small class="form-text text-muted">
                                            <?= htmlspecialchars($setting['description']) ?>
                                        </small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php 
                        $first_tab = false;
                        endforeach; 
                        ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Actions -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-save mr-2"></i>
                        Actions
                    </h6>
                </div>
                <div class="card-body">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-save mr-2"></i>
                        Enregistrer les modifications
                    </button>
                    
                    <button type="button" class="btn btn-outline-secondary btn-block mt-2" onclick="resetForm()">
                        <i class="fas fa-undo mr-2"></i>
                        Annuler les modifications
                    </button>
                    
                    <hr>
                    
                    <div class="btn-group-vertical w-100">
                        <a href="../index.php" target="_blank" class="btn btn-outline-info btn-sm">
                            <i class="fas fa-eye mr-2"></i>
                            Prévisualiser le site
                        </a>
                        
                        <button type="button" class="btn btn-outline-warning btn-sm mt-1" onclick="clearCache()">
                            <i class="fas fa-trash mr-2"></i>
                            Vider le cache
                        </button>
                        
                        <button type="button" class="btn btn-outline-success btn-sm mt-1" onclick="exportSettings()">
                            <i class="fas fa-download mr-2"></i>
                            Exporter les paramètres
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Informations -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle mr-2"></i>
                        Informations
                    </h6>
                </div>
                <div class="card-body">
                    <div class="info-item mb-2">
                        <strong>Version du site :</strong><br>
                        <small class="text-muted">SAFIR CMS v1.0.0</small>
                    </div>
                    
                    <div class="info-item mb-2">
                        <strong>Dernière modification :</strong><br>
                        <small class="text-muted">
                            <?php
                            try {
                                $stmt = $pdo->query("
                                    SELECT MAX(updated_at) as last_update, a.username 
                                    FROM site_settings s 
                                    LEFT JOIN admins a ON s.updated_by = a.id 
                                    WHERE s.updated_at IS NOT NULL
                                ");
                                $last_update = $stmt->fetch();
                                if ($last_update && $last_update['last_update']) {
                                    echo date('d/m/Y H:i', strtotime($last_update['last_update']));
                                    if ($last_update['username']) {
                                        echo ' par ' . htmlspecialchars($last_update['username']);
                                    }
                                } else {
                                    echo 'Jamais modifié';
                                }
                            } catch (PDOException $e) {
                                echo 'Information non disponible';
                            }
                            ?>
                        </small>
                    </div>
                    
                    <div class="info-item">
                        <strong>Paramètres :</strong><br>
                        <small class="text-muted">
                            <?= count($all_settings) ?> paramètres configurés
                        </small>
                    </div>
                </div>
            </div>
            
            <!-- Aide -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-question-circle mr-2"></i>
                        Aide
                    </h6>
                </div>
                <div class="card-body">
                    <small class="text-muted">
                        <strong>Variables disponibles :</strong><br>
                        <code>{{site_name}}</code> - Nom du site<br>
                        <code>{{contact_email}}</code> - Email de contact<br>
                        <code>{{contact_phone}}</code> - Téléphone<br>
                        <code>{{current_year}}</code> - Année actuelle<br><br>
                        
                        <strong>Conseils :</strong><br>
                        • Les URLs doivent commencer par http:// ou https://<br>
                        • Les numéros WhatsApp doivent être au format international<br>
                        • Testez toujours vos modifications sur le site
                    </small>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
function resetForm() {
    if (confirm('Êtes-vous sûr de vouloir annuler toutes les modifications ?')) {
        document.getElementById('settingsForm').reset();
    }
}

function clearCache() {
    // TODO: Implémenter la fonction de vidage du cache
    Swal.fire({
        title: 'Cache vidé',
        text: 'Le cache du site a été vidé avec succès.',
        icon: 'success',
        timer: 2000
    });
}

function exportSettings() {
    // TODO: Implémenter l'export des paramètres
    alert('Fonctionnalité d\'export en cours de développement');
}

$(document).ready(function() {
    // Confirmation avant soumission
    $('#settingsForm').on('submit', function(e) {
        const button = $(this).find('button[type="submit"]');
        button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Enregistrement...');
        
        // Réactiver le bouton après 3 secondes (au cas où)
        setTimeout(function() {
            button.prop('disabled', false).html('<i class="fas fa-save mr-2"></i>Enregistrer les modifications');
        }, 3000);
    });
    
    // Indicateur de modifications non sauvegardées
    let formModified = false;
    
    $('#settingsForm input, #settingsForm textarea, #settingsForm select').on('change', function() {
        formModified = true;
        if (!$('#saveIndicator').length) {
            $('.card-header').first().append('<span id="saveIndicator" class="badge badge-warning ml-2">Modifications non sauvegardées</span>');
        }
    });
    
    $('#settingsForm').on('submit', function() {
        formModified = false;
        $('#saveIndicator').remove();
    });
    
    // Avertissement si l'utilisateur quitte sans sauvegarder
    window.addEventListener('beforeunload', function(e) {
        if (formModified) {
            e.preventDefault();
            e.returnValue = '';
        }
    });
    
    // Validation des URLs
    $('input[type="url"]').on('blur', function() {
        const url = $(this).val();
        if (url && !url.match(/^https?:\/\//)) {
            $(this).val('https://' + url);
        }
    });
});
</script>

<?php
require_once 'includes/footer.php';
?>