<?php
/**
 * Gestion des encadreurs - SAFIR CMS
 */

$page_title = 'Gestion des Encadreurs';
$breadcrumbs = [
    ['title' => 'Encadreurs']
];

require_once 'includes/header.php';

// Vérifier les permissions
$auth->requireAuth('manage_encadreurs');

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

// Traitement des actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $csrf_token = $_POST['csrf_token'] ?? '';
    
    if (!$auth->verifyCSRFToken($csrf_token)) {
        $error = 'Token de sécurité invalide.';
    } else {
        switch ($action) {
            case 'create':
                $full_name = trim($_POST['full_name']);
                $phone_1 = trim($_POST['phone_1']);
                $phone_2 = trim($_POST['phone_2']);
                $email = trim($_POST['email']);
                $city_id = (int) $_POST['city_id'];
                $address = trim($_POST['address']);
                $specialties = trim($_POST['specialties']);
                $notes = trim($_POST['notes']);
                
                try {
                    $stmt = $pdo->prepare("
                        INSERT INTO encadreurs 
                        (full_name, phone_1, phone_2, email, city_id, address, specialties, notes, created_by) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
                    ");
                    $stmt->execute([
                        $full_name, $phone_1, $phone_2 ?: null, $email ?: null, 
                        $city_id, $address ?: null, $specialties ?: null, $notes ?: null,
                        $_SESSION['admin_id']
                    ]);
                    
                    $auth->logActivity($_SESSION['admin_id'], 'encadreur_created', ['name' => $full_name]);
                    $message = 'Encadreur créé avec succès.';
                } catch (PDOException $e) {
                    $error = 'Erreur lors de la création : ' . $e->getMessage();
                }
                break;
                
            case 'update':
                $id = (int) $_POST['id'];
                $full_name = trim($_POST['full_name']);
                $phone_1 = trim($_POST['phone_1']);
                $phone_2 = trim($_POST['phone_2']);
                $email = trim($_POST['email']);
                $city_id = (int) $_POST['city_id'];
                $address = trim($_POST['address']);
                $specialties = trim($_POST['specialties']);
                $notes = trim($_POST['notes']);
                $is_active = isset($_POST['is_active']) ? 1 : 0;
                
                try {
                    $stmt = $pdo->prepare("
                        UPDATE encadreurs 
                        SET full_name = ?, phone_1 = ?, phone_2 = ?, email = ?, city_id = ?, 
                            address = ?, specialties = ?, notes = ?, is_active = ?, updated_at = NOW()
                        WHERE id = ?
                    ");
                    $stmt->execute([
                        $full_name, $phone_1, $phone_2 ?: null, $email ?: null, $city_id,
                        $address ?: null, $specialties ?: null, $notes ?: null, $is_active, $id
                    ]);
                    
                    $auth->logActivity($_SESSION['admin_id'], 'encadreur_updated', ['encadreur_id' => $id, 'name' => $full_name]);
                    $message = 'Encadreur mis à jour avec succès.';
                } catch (PDOException $e) {
                    $error = 'Erreur lors de la mise à jour : ' . $e->getMessage();
                }
                break;
                
            case 'delete':
                $id = (int) $_POST['id'];
                
                try {
                    // Récupérer les infos avant suppression
                    $stmt = $pdo->prepare("SELECT full_name FROM encadreurs WHERE id = ?");
                    $stmt->execute([$id]);
                    $encadreur = $stmt->fetch();
                    
                    $stmt = $pdo->prepare("DELETE FROM encadreurs WHERE id = ?");
                    $stmt->execute([$id]);
                    
                    $auth->logActivity($_SESSION['admin_id'], 'encadreur_deleted', ['encadreur_id' => $id, 'name' => $encadreur['full_name']]);
                    $message = 'Encadreur supprimé avec succès.';
                } catch (PDOException $e) {
                    $error = 'Erreur lors de la suppression : ' . $e->getMessage();
                }
                break;
                
            case 'create_city':
                $city_name = trim($_POST['city_name']);
                $region = trim($_POST['region']);
                
                try {
                    $stmt = $pdo->prepare("INSERT INTO cities (name, region) VALUES (?, ?)");
                    $stmt->execute([$city_name, $region ?: null]);
                    
                    $auth->logActivity($_SESSION['admin_id'], 'city_created', ['name' => $city_name]);
                    $message = 'Ville créée avec succès.';
                } catch (PDOException $e) {
                    $error = 'Erreur lors de la création de la ville : ' . $e->getMessage();
                }
                break;
        }
    }
}

// Action GET pour suppression
if (isset($_GET['delete']) && isset($_GET['token'])) {
    if ($auth->verifyCSRFToken($_GET['token'])) {
        $id = (int) $_GET['delete'];
        try {
            $stmt = $pdo->prepare("SELECT full_name FROM encadreurs WHERE id = ?");
            $stmt->execute([$id]);
            $encadreur = $stmt->fetch();
            
            $stmt = $pdo->prepare("DELETE FROM encadreurs WHERE id = ?");
            $stmt->execute([$id]);
            
            $auth->logActivity($_SESSION['admin_id'], 'encadreur_deleted', ['encadreur_id' => $id, 'name' => $encadreur['full_name']]);
            $message = 'Encadreur supprimé avec succès.';
        } catch (PDOException $e) {
            $error = 'Erreur lors de la suppression : ' . $e->getMessage();
        }
    }
}

// Récupération des encadreurs avec leurs villes
try {
    $stmt = $pdo->query("
        SELECT e.*, c.name as city_name, c.region, a.username as created_by_name 
        FROM encadreurs e 
        LEFT JOIN cities c ON e.city_id = c.id 
        LEFT JOIN admins a ON e.created_by = a.id 
        ORDER BY c.name, e.full_name
    ");
    $encadreurs = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = 'Erreur lors du chargement des encadreurs : ' . $e->getMessage();
    $encadreurs = [];
}

// Récupération des villes
try {
    $stmt = $pdo->query("SELECT * FROM cities WHERE is_active = 1 ORDER BY name");
    $cities = $stmt->fetchAll();
} catch (PDOException $e) {
    $cities = [];
}

// Statistiques par ville
try {
    $stmt = $pdo->query("
        SELECT c.name as city, c.region, COUNT(e.id) as total_encadreurs, 
               COUNT(CASE WHEN e.is_active = 1 THEN 1 END) as active_encadreurs
        FROM cities c 
        LEFT JOIN encadreurs e ON c.id = e.city_id 
        WHERE c.is_active = 1
        GROUP BY c.id, c.name, c.region 
        ORDER BY total_encadreurs DESC, c.name
    ");
    $city_stats = $stmt->fetchAll();
} catch (PDOException $e) {
    $city_stats = [];
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

<!-- Statistiques par ville -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-bar mr-2"></i>
                    Répartition par ville
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-success btn-sm" onclick="createCity()">
                        <i class="fas fa-plus mr-1"></i>
                        Nouvelle ville
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php foreach ($city_stats as $stat): ?>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-info">
                                <i class="fas fa-map-marker-alt"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text"><?= htmlspecialchars($stat['city']) ?></span>
                                <span class="info-box-number"><?= $stat['active_encadreurs'] ?>/<?= $stat['total_encadreurs'] ?></span>
                                <div class="progress">
                                    <div class="progress-bar" style="width: <?= $stat['total_encadreurs'] > 0 ? ($stat['active_encadreurs'] / $stat['total_encadreurs'] * 100) : 0 ?>%"></div>
                                </div>
                                <span class="progress-description">
                                    <?php if ($stat['region']): ?>
                                    <small class="text-muted"><?= htmlspecialchars($stat['region']) ?></small>
                                    <?php endif; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Liste des encadreurs -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-users mr-2"></i>
                    Encadreurs SAFIR
                </h3>
                <div class="card-tools">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary btn-sm" onclick="createEncadreur()">
                            <i class="fas fa-plus mr-1"></i>
                            Nouvel encadreur
                        </button>
                        <button type="button" class="btn btn-info btn-sm" onclick="exportEncadreurs()">
                            <i class="fas fa-download mr-1"></i>
                            Export Excel
                        </button>
                        <a href="../encadreurs.php" target="_blank" class="btn btn-success btn-sm">
                            <i class="fas fa-eye mr-1"></i>
                            Voir page publique
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="encadreursTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Encadreur</th>
                                <th>Téléphones</th>
                                <th>Email</th>
                                <th>Ville/Région</th>
                                <th>Spécialités</th>
                                <th>Statut</th>
                                <th>Créé par</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($encadreurs as $encadreur): ?>
                            <tr>
                                <td>
                                    <div>
                                        <strong><?= htmlspecialchars($encadreur['full_name']) ?></strong>
                                        <?php if ($encadreur['address']): ?>
                                        <br>
                                        <small class="text-muted">
                                            <i class="fas fa-map-marker-alt mr-1"></i>
                                            <?= htmlspecialchars($encadreur['address']) ?>
                                        </small>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <a href="tel:<?= htmlspecialchars($encadreur['phone_1']) ?>" class="text-decoration-none">
                                            <i class="fas fa-phone mr-1"></i>
                                            <?= htmlspecialchars($encadreur['phone_1']) ?>
                                        </a>
                                        <?php if ($encadreur['phone_2']): ?>
                                        <br>
                                        <a href="tel:<?= htmlspecialchars($encadreur['phone_2']) ?>" class="text-decoration-none">
                                            <i class="fas fa-phone mr-1"></i>
                                            <?= htmlspecialchars($encadreur['phone_2']) ?>
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <?php if ($encadreur['email']): ?>
                                    <a href="mailto:<?= htmlspecialchars($encadreur['email']) ?>" class="text-decoration-none">
                                        <i class="fas fa-envelope mr-1"></i>
                                        <?= htmlspecialchars($encadreur['email']) ?>
                                    </a>
                                    <?php else: ?>
                                    <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div>
                                        <strong><?= htmlspecialchars($encadreur['city_name'] ?? 'N/A') ?></strong>
                                        <?php if ($encadreur['region']): ?>
                                        <br>
                                        <small class="text-muted"><?= htmlspecialchars($encadreur['region']) ?></small>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <?php if ($encadreur['specialties']): ?>
                                    <span class="badge badge-info"><?= htmlspecialchars($encadreur['specialties']) ?></span>
                                    <?php else: ?>
                                    <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($encadreur['is_active']): ?>
                                    <span class="badge badge-success">Actif</span>
                                    <?php else: ?>
                                    <span class="badge badge-secondary">Inactif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <small>
                                        <?= htmlspecialchars($encadreur['created_by_name'] ?? 'N/A') ?><br>
                                        <span class="text-muted"><?= date('d/m/Y', strtotime($encadreur['created_at'])) ?></span>
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" 
                                                class="btn btn-info btn-sm" 
                                                onclick="editEncadreur(<?= $encadreur['id'] ?>)" 
                                                title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" 
                                                class="btn btn-success btn-sm" 
                                                onclick="viewEncadreur(<?= $encadreur['id'] ?>)" 
                                                title="Détails">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <a href="?delete=<?= $encadreur['id'] ?>&token=<?= urlencode($csrf_token) ?>" 
                                           class="btn btn-danger btn-sm btn-delete" 
                                           title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal d'encadreur -->
<div class="modal fade" id="encadreurModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" id="encadreurForm">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
                <input type="hidden" name="action" id="formAction" value="create">
                <input type="hidden" name="id" id="encadreurId">
                
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">
                        <i class="fas fa-plus mr-2"></i>
                        Nouvel encadreur
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="encadreurName">Nom complet *</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="encadreurName" 
                                       name="full_name" 
                                       required>
                            </div>
                            
                            <div class="form-group">
                                <label for="encadreurPhone1">Téléphone principal *</label>
                                <input type="tel" 
                                       class="form-control" 
                                       id="encadreurPhone1" 
                                       name="phone_1" 
                                       pattern="[0-9+\-\s]+"
                                       required>
                            </div>
                            
                            <div class="form-group">
                                <label for="encadreurPhone2">Téléphone secondaire</label>
                                <input type="tel" 
                                       class="form-control" 
                                       id="encadreurPhone2" 
                                       name="phone_2"
                                       pattern="[0-9+\-\s]+">
                            </div>
                            
                            <div class="form-group">
                                <label for="encadreurEmail">Email</label>
                                <input type="email" 
                                       class="form-control" 
                                       id="encadreurEmail" 
                                       name="email">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="encadreurCity">Ville *</label>
                                <select class="form-control" 
                                        id="encadreurCity" 
                                        name="city_id" 
                                        required>
                                    <option value="">Sélectionner une ville</option>
                                    <?php foreach ($cities as $city): ?>
                                    <option value="<?= $city['id'] ?>">
                                        <?= htmlspecialchars($city['name']) ?>
                                        <?php if ($city['region']): ?>
                                        (<?= htmlspecialchars($city['region']) ?>)
                                        <?php endif; ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="encadreurAddress">Adresse</label>
                                <textarea class="form-control" 
                                          id="encadreurAddress" 
                                          name="address" 
                                          rows="2"></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="encadreurSpecialties">Spécialités</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="encadreurSpecialties" 
                                       name="specialties"
                                       placeholder="Ex: Hadj, Oumra, Voyages">
                            </div>
                            
                            <div class="form-check" id="activeCheckContainer" style="display: none;">
                                <input type="checkbox" 
                                       class="form-check-input" 
                                       id="encadreurActive" 
                                       name="is_active">
                                <label class="form-check-label" for="encadreurActive">
                                    Encadreur actif
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="encadreurNotes">Notes</label>
                        <textarea class="form-control" 
                                  id="encadreurNotes" 
                                  name="notes" 
                                  rows="2"
                                  placeholder="Notes internes..."></textarea>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>
                        Annuler
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i>
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de ville -->
<div class="modal fade" id="cityModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
                <input type="hidden" name="action" value="create_city">
                
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        Nouvelle ville
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <div class="form-group">
                        <label for="cityName">Nom de la ville *</label>
                        <input type="text" 
                               class="form-control" 
                               id="cityName" 
                               name="city_name" 
                               required>
                    </div>
                    
                    <div class="form-group">
                        <label for="cityRegion">Région</label>
                        <input type="text" 
                               class="form-control" 
                               id="cityRegion" 
                               name="region"
                               placeholder="Ex: Centre, Nord, Est...">
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>
                        Annuler
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i>
                        Créer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Données des encadreurs pour JavaScript
const encadreursData = <?= json_encode($encadreurs) ?>;

function createEncadreur() {
    // Réinitialiser le formulaire
    document.getElementById('encadreurForm').reset();
    document.getElementById('formAction').value = 'create';
    document.getElementById('encadreurId').value = '';
    document.getElementById('modalTitle').innerHTML = '<i class="fas fa-plus mr-2"></i>Nouvel encadreur';
    document.getElementById('activeCheckContainer').style.display = 'none';
    
    // Ouvrir le modal
    $('#encadreurModal').modal('show');
}

function editEncadreur(encadreurId) {
    const encadreur = encadreursData.find(e => e.id == encadreurId);
    if (!encadreur) return;
    
    // Remplir le formulaire
    document.getElementById('formAction').value = 'update';
    document.getElementById('encadreurId').value = encadreur.id;
    document.getElementById('encadreurName').value = encadreur.full_name;
    document.getElementById('encadreurPhone1').value = encadreur.phone_1;
    document.getElementById('encadreurPhone2').value = encadreur.phone_2 || '';
    document.getElementById('encadreurEmail').value = encadreur.email || '';
    document.getElementById('encadreurCity').value = encadreur.city_id;
    document.getElementById('encadreurAddress').value = encadreur.address || '';
    document.getElementById('encadreurSpecialties').value = encadreur.specialties || '';
    document.getElementById('encadreurNotes').value = encadreur.notes || '';
    document.getElementById('encadreurActive').checked = encadreur.is_active == 1;
    
    // Modifier le titre et afficher l'option active
    document.getElementById('modalTitle').innerHTML = '<i class="fas fa-edit mr-2"></i>Modifier l\'encadreur';
    document.getElementById('activeCheckContainer').style.display = 'block';
    
    // Ouvrir le modal
    $('#encadreurModal').modal('show');
}

function viewEncadreur(encadreurId) {
    const encadreur = encadreursData.find(e => e.id == encadreurId);
    if (!encadreur) return;
    
    // Construire le contenu
    let content = `
        <div class="row">
            <div class="col-md-6">
                <h6><i class="fas fa-user mr-1"></i> Informations personnelles</h6>
                <p><strong>Nom :</strong> ${encadreur.full_name}</p>
                <p><strong>Téléphone 1 :</strong> <a href="tel:${encadreur.phone_1}">${encadreur.phone_1}</a></p>
                ${encadreur.phone_2 ? `<p><strong>Téléphone 2 :</strong> <a href="tel:${encadreur.phone_2}">${encadreur.phone_2}</a></p>` : ''}
                ${encadreur.email ? `<p><strong>Email :</strong> <a href="mailto:${encadreur.email}">${encadreur.email}</a></p>` : ''}
            </div>
            <div class="col-md-6">
                <h6><i class="fas fa-map-marker-alt mr-1"></i> Localisation</h6>
                <p><strong>Ville :</strong> ${encadreur.city_name || 'N/A'}</p>
                ${encadreur.region ? `<p><strong>Région :</strong> ${encadreur.region}</p>` : ''}
                ${encadreur.address ? `<p><strong>Adresse :</strong> ${encadreur.address}</p>` : ''}
                ${encadreur.specialties ? `<p><strong>Spécialités :</strong> <span class="badge badge-info">${encadreur.specialties}</span></p>` : ''}
            </div>
        </div>
        ${encadreur.notes ? `<h6><i class="fas fa-sticky-note mr-1"></i> Notes</h6><p>${encadreur.notes}</p>` : ''}
    `;
    
    Swal.fire({
        title: encadreur.full_name,
        html: content,
        width: 600,
        showCloseButton: true,
        showConfirmButton: false
    });
}

function createCity() {
    $('#cityModal').modal('show');
}

function exportEncadreurs() {
    // TODO: Implémenter l'export Excel
    alert('Fonctionnalité d\'export en cours de développement');
}

$(document).ready(function() {
    // Initialiser DataTable
    $('#encadreursTable').DataTable({
        "order": [[ 3, "asc" ], [ 0, "asc" ]],
        "columnDefs": [
            { "orderable": false, "targets": -1 }
        ]
    });
});
</script>

<?php
require_once 'includes/footer.php';
?>