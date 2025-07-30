<?php
/**
 * Gestion des services - SAFIR CMS
 */

$page_title = 'Gestion des Services';
$breadcrumbs = [
    ['title' => 'Contenu', 'url' => '#'],
    ['title' => 'Services']
];

require_once 'includes/header.php';

// Vérifier les permissions
$auth->requireAuth('manage_services');

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
                $slug = trim($_POST['slug']);
                $title = trim($_POST['title']);
                $description = $_POST['description'];
                $short_description = trim($_POST['short_description']);
                $price = trim($_POST['price']);
                $duration = trim($_POST['duration']);
                $is_featured = isset($_POST['is_featured']) ? 1 : 0;
                $meta_title = trim($_POST['meta_title']);
                $meta_description = trim($_POST['meta_description']);
                
                try {
                    // Vérifier l'unicité du slug
                    $stmt = $pdo->prepare("SELECT COUNT(*) FROM services WHERE slug = ?");
                    $stmt->execute([$slug]);
                    if ($stmt->fetchColumn() > 0) {
                        $error = 'Ce slug existe déjà.';
                        break;
                    }
                    
                    $stmt = $pdo->prepare("
                        INSERT INTO services 
                        (slug, title, description, short_description, price, duration, is_featured, meta_title, meta_description, created_by) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                    ");
                    $stmt->execute([
                        $slug, $title, $description, $short_description, 
                        $price, $duration, $is_featured, $meta_title, $meta_description, 
                        $_SESSION['admin_id']
                    ]);
                    
                    $auth->logActivity($_SESSION['admin_id'], 'service_created', ['title' => $title]);
                    $message = 'Service créé avec succès.';
                } catch (PDOException $e) {
                    $error = 'Erreur lors de la création : ' . $e->getMessage();
                }
                break;
                
            case 'update':
                $id = (int) $_POST['id'];
                $title = trim($_POST['title']);
                $description = $_POST['description'];
                $short_description = trim($_POST['short_description']);
                $price = trim($_POST['price']);
                $duration = trim($_POST['duration']);
                $is_featured = isset($_POST['is_featured']) ? 1 : 0;
                $is_active = isset($_POST['is_active']) ? 1 : 0;
                $meta_title = trim($_POST['meta_title']);
                $meta_description = trim($_POST['meta_description']);
                
                try {
                    $stmt = $pdo->prepare("
                        UPDATE services 
                        SET title = ?, description = ?, short_description = ?, price = ?, duration = ?, 
                            is_featured = ?, is_active = ?, meta_title = ?, meta_description = ?, updated_at = NOW()
                        WHERE id = ?
                    ");
                    $stmt->execute([
                        $title, $description, $short_description, $price, $duration, 
                        $is_featured, $is_active, $meta_title, $meta_description, $id
                    ]);
                    
                    $auth->logActivity($_SESSION['admin_id'], 'service_updated', ['service_id' => $id, 'title' => $title]);
                    $message = 'Service mis à jour avec succès.';
                } catch (PDOException $e) {
                    $error = 'Erreur lors de la mise à jour : ' . $e->getMessage();
                }
                break;
                
            case 'delete':
                $id = (int) $_POST['id'];
                
                try {
                    // Récupérer les infos avant suppression
                    $stmt = $pdo->prepare("SELECT title FROM services WHERE id = ?");
                    $stmt->execute([$id]);
                    $service = $stmt->fetch();
                    
                    $stmt = $pdo->prepare("DELETE FROM services WHERE id = ?");
                    $stmt->execute([$id]);
                    
                    $auth->logActivity($_SESSION['admin_id'], 'service_deleted', ['service_id' => $id, 'title' => $service['title']]);
                    $message = 'Service supprimé avec succès.';
                } catch (PDOException $e) {
                    $error = 'Erreur lors de la suppression : ' . $e->getMessage();
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
            $stmt = $pdo->prepare("SELECT title FROM services WHERE id = ?");
            $stmt->execute([$id]);
            $service = $stmt->fetch();
            
            $stmt = $pdo->prepare("DELETE FROM services WHERE id = ?");
            $stmt->execute([$id]);
            
            $auth->logActivity($_SESSION['admin_id'], 'service_deleted', ['service_id' => $id, 'title' => $service['title']]);
            $message = 'Service supprimé avec succès.';
        } catch (PDOException $e) {
            $error = 'Erreur lors de la suppression : ' . $e->getMessage();
        }
    }
}

// Récupération des services
try {
    $stmt = $pdo->query("
        SELECT s.*, a.username as created_by_name 
        FROM services s 
        LEFT JOIN admins a ON s.created_by = a.id 
        ORDER BY s.sort_order, s.title
    ");
    $services = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = 'Erreur lors du chargement des services : ' . $e->getMessage();
    $services = [];
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

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-concierge-bell mr-2"></i>
                    Services SAFIR
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-primary btn-sm" onclick="createService()">
                        <i class="fas fa-plus mr-1"></i>
                        Nouveau service
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="servicesTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th>Description</th>
                                <th>Prix</th>
                                <th>Durée</th>
                                <th>Statut</th>
                                <th>Créé par</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($services as $service): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if ($service['featured_image']): ?>
                                        <img src="../uploads/services/<?= htmlspecialchars($service['featured_image']) ?>" 
                                             class="img-thumbnail mr-2" style="width: 40px; height: 40px;">
                                        <?php else: ?>
                                        <div class="bg-light text-center mr-2" style="width: 40px; height: 40px; line-height: 40px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                        <?php endif; ?>
                                        <div>
                                            <strong><?= htmlspecialchars($service['title']) ?></strong>
                                            <br>
                                            <small class="text-muted">
                                                <i class="fas fa-link mr-1"></i>
                                                <?= htmlspecialchars($service['slug']) ?>
                                            </small>
                                            <?php if ($service['is_featured']): ?>
                                            <br>
                                            <span class="badge badge-warning">
                                                <i class="fas fa-star mr-1"></i>En vedette
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?= htmlspecialchars(substr($service['short_description'] ?: strip_tags($service['description']), 0, 100)) ?>...
                                </td>
                                <td>
                                    <?= $service['price'] ? htmlspecialchars($service['price']) : '-' ?>
                                </td>
                                <td>
                                    <?= $service['duration'] ? htmlspecialchars($service['duration']) : '-' ?>
                                </td>
                                <td>
                                    <?php if ($service['is_active']): ?>
                                    <span class="badge badge-success">Actif</span>
                                    <?php else: ?>
                                    <span class="badge badge-secondary">Inactif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <small>
                                        <?= htmlspecialchars($service['created_by_name'] ?? 'N/A') ?><br>
                                        <span class="text-muted"><?= date('d/m/Y', strtotime($service['created_at'])) ?></span>
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" 
                                                class="btn btn-info btn-sm" 
                                                onclick="editService(<?= $service['id'] ?>)" 
                                                title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <a href="../service_<?= htmlspecialchars($service['slug']) ?>.php" 
                                           target="_blank" 
                                           class="btn btn-success btn-sm" 
                                           title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="?delete=<?= $service['id'] ?>&token=<?= urlencode($csrf_token) ?>" 
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

<!-- Modal de création/édition -->
<div class="modal fade" id="serviceModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="POST" id="serviceForm">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
                <input type="hidden" name="action" id="formAction" value="create">
                <input type="hidden" name="id" id="serviceId">
                
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">
                        <i class="fas fa-plus mr-2"></i>
                        Nouveau service
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Informations principales -->
                            <div class="form-group">
                                <label for="serviceTitle">Titre du service *</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="serviceTitle" 
                                       name="title" 
                                       required>
                            </div>
                            
                            <div class="form-group">
                                <label for="serviceSlug">Slug (URL) *</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="serviceSlug" 
                                       name="slug" 
                                       pattern="[a-z0-9_-]+"
                                       title="Lettres minuscules, chiffres, tirets et underscores uniquement"
                                       required>
                                <small class="form-text text-muted">
                                    URL du service (ex: hadj, oumra, voyages)
                                </small>
                            </div>
                            
                            <div class="form-group">
                                <label for="serviceShortDescription">Description courte</label>
                                <textarea class="form-control" 
                                          id="serviceShortDescription" 
                                          name="short_description" 
                                          rows="2"
                                          maxlength="500"></textarea>
                                <small class="form-text text-muted">
                                    Description affichée dans les listes (max 500 caractères)
                                </small>
                            </div>
                            
                            <div class="form-group">
                                <label for="serviceDescription">Description complète *</label>
                                <textarea class="form-control" 
                                          id="serviceDescription" 
                                          name="description" 
                                          rows="10" 
                                          required></textarea>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <!-- Paramètres -->
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        <i class="fas fa-cog mr-1"></i>
                                        Paramètres
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="servicePrice">Prix</label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="servicePrice" 
                                               name="price"
                                               placeholder="Ex: À partir de 1 500 000 FCFA">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="serviceDuration">Durée</label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="serviceDuration" 
                                               name="duration"
                                               placeholder="Ex: 15 jours">
                                    </div>
                                    
                                    <div class="form-check">
                                        <input type="checkbox" 
                                               class="form-check-input" 
                                               id="serviceFeatured" 
                                               name="is_featured">
                                        <label class="form-check-label" for="serviceFeatured">
                                            Service en vedette
                                        </label>
                                    </div>
                                    
                                    <div class="form-check" id="activeCheckContainer" style="display: none;">
                                        <input type="checkbox" 
                                               class="form-check-input" 
                                               id="serviceActive" 
                                               name="is_active">
                                        <label class="form-check-label" for="serviceActive">
                                            Service actif
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- SEO -->
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        <i class="fas fa-search mr-1"></i>
                                        Référencement SEO
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="serviceMetaTitle">Titre SEO</label>
                                        <input type="text" 
                                               class="form-control form-control-sm" 
                                               id="serviceMetaTitle" 
                                               name="meta_title"
                                               maxlength="60">
                                        <small class="form-text text-muted">
                                            Max 60 caractères
                                        </small>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="serviceMetaDescription">Description SEO</label>
                                        <textarea class="form-control form-control-sm" 
                                                  id="serviceMetaDescription" 
                                                  name="meta_description" 
                                                  rows="3"
                                                  maxlength="160"></textarea>
                                        <small class="form-text text-muted">
                                            Max 160 caractères
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
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

<script>
// Données des services pour JavaScript
const servicesData = <?= json_encode($services) ?>;

function createService() {
    // Réinitialiser le formulaire
    document.getElementById('serviceForm').reset();
    document.getElementById('formAction').value = 'create';
    document.getElementById('serviceId').value = '';
    document.getElementById('modalTitle').innerHTML = '<i class="fas fa-plus mr-2"></i>Nouveau service';
    document.getElementById('activeCheckContainer').style.display = 'none';
    
    // Ouvrir le modal
    $('#serviceModal').modal('show');
}

function editService(serviceId) {
    const service = servicesData.find(s => s.id == serviceId);
    if (!service) return;
    
    // Remplir le formulaire
    document.getElementById('formAction').value = 'update';
    document.getElementById('serviceId').value = service.id;
    document.getElementById('serviceTitle').value = service.title;
    document.getElementById('serviceSlug').value = service.slug;
    document.getElementById('serviceSlug').readOnly = true; // Empêcher modification du slug
    document.getElementById('serviceShortDescription').value = service.short_description || '';
    document.getElementById('serviceDescription').value = service.description;
    document.getElementById('servicePrice').value = service.price || '';
    document.getElementById('serviceDuration').value = service.duration || '';
    document.getElementById('serviceFeatured').checked = service.is_featured == 1;
    document.getElementById('serviceActive').checked = service.is_active == 1;
    document.getElementById('serviceMetaTitle').value = service.meta_title || '';
    document.getElementById('serviceMetaDescription').value = service.meta_description || '';
    
    // Modifier le titre et afficher l'option active
    document.getElementById('modalTitle').innerHTML = '<i class="fas fa-edit mr-2"></i>Modifier le service';
    document.getElementById('activeCheckContainer').style.display = 'block';
    
    // Ouvrir le modal
    $('#serviceModal').modal('show');
}

$(document).ready(function() {
    // Initialiser DataTable
    $('#servicesTable').DataTable({
        "order": [[ 0, "asc" ]],
        "columnDefs": [
            { "orderable": false, "targets": -1 }
        ]
    });
    
    // Générer automatiquement le slug depuis le titre
    $('#serviceTitle').on('input', function() {
        if (document.getElementById('formAction').value === 'create') {
            const title = $(this).val();
            const slug = title.toLowerCase()
                              .replace(/[àáâãäå]/g, 'a')
                              .replace(/[èéêë]/g, 'e')
                              .replace(/[ìíîï]/g, 'i')
                              .replace(/[òóôõö]/g, 'o')
                              .replace(/[ùúûü]/g, 'u')
                              .replace(/[ç]/g, 'c')
                              .replace(/[^a-z0-9]/g, '_')
                              .replace(/_+/g, '_')
                              .replace(/^_|_$/g, '');
            $('#serviceSlug').val(slug);
        }
    });
    
    // Remettre le slug en lecture seule après création
    $('#serviceModal').on('hidden.bs.modal', function() {
        document.getElementById('serviceSlug').readOnly = false;
    });
    
    // Compteur de caractères pour SEO
    $('#serviceMetaTitle').on('input', function() {
        const length = $(this).val().length;
        const color = length > 60 ? 'text-danger' : 'text-muted';
        $(this).next('.form-text').removeClass('text-muted text-danger').addClass(color);
    });
    
    $('#serviceMetaDescription').on('input', function() {
        const length = $(this).val().length;
        const color = length > 160 ? 'text-danger' : 'text-muted';
        $(this).next('.form-text').removeClass('text-muted text-danger').addClass(color);
    });
});
</script>

<?php
$additional_js = '
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
$(document).ready(function() {
    // Initialiser CKEditor pour la description
    ClassicEditor
        .create(document.querySelector("#serviceDescription"), {
            toolbar: [
                "heading", "|",
                "bold", "italic", "link", "|",
                "bulletedList", "numberedList", "|",
                "outdent", "indent", "|",
                "blockQuote", "insertTable", "|",
                "undo", "redo"
            ],
            language: "fr"
        })
        .catch(error => {
            console.error("Erreur CKEditor:", error);
        });
});
</script>
';

require_once 'includes/footer.php';
?>