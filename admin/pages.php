<?php
/**
 * Gestion des pages - SAFIR CMS
 */

$page_title = 'Gestion des Pages';
$breadcrumbs = [
    ['title' => 'Contenu', 'url' => '#'],
    ['title' => 'Pages']
];

require_once 'includes/header.php';

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
            case 'update':
                $id = (int) $_POST['id'];
                $title = trim($_POST['title']);
                $content = $_POST['content'];
                $meta_title = trim($_POST['meta_title']);
                $meta_description = trim($_POST['meta_description']);
                $meta_keywords = trim($_POST['meta_keywords']);
                
                try {
                    $stmt = $pdo->prepare("
                        UPDATE pages 
                        SET title = ?, content = ?, meta_title = ?, meta_description = ?, meta_keywords = ?, updated_at = NOW()
                        WHERE id = ?
                    ");
                    $stmt->execute([$title, $content, $meta_title, $meta_description, $meta_keywords, $id]);
                    
                    $auth->logActivity($_SESSION['admin_id'], 'page_updated', ['page_id' => $id, 'title' => $title]);
                    $message = 'Page mise à jour avec succès.';
                } catch (PDOException $e) {
                    $error = 'Erreur lors de la mise à jour : ' . $e->getMessage();
                }
                break;
        }
    }
}

// Récupération des pages
try {
    $stmt = $pdo->query("SELECT * FROM pages ORDER BY sort_order, title");
    $pages = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = 'Erreur lors du chargement des pages : ' . $e->getMessage();
    $pages = [];
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
                    <i class="fas fa-file-alt mr-2"></i>
                    Pages du site web
                </h3>
                <div class="card-tools">
                    <div class="btn-group">
                        <button type="button" class="btn btn-info btn-sm" onclick="previewSite()">
                            <i class="fas fa-eye mr-1"></i>
                            Prévisualiser le site
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php foreach ($pages as $page): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-file-alt text-primary mr-2"></i>
                                    <?= htmlspecialchars($page['title']) ?>
                                </h5>
                                <small class="text-muted">
                                    <i class="fas fa-link mr-1"></i>
                                    <?= htmlspecialchars($page['slug']) ?>.php
                                </small>
                            </div>
                            <div class="card-body">
                                <p class="text-muted small">
                                    <?= htmlspecialchars(substr(strip_tags($page['content']), 0, 100)) ?>...
                                </p>
                                
                                <?php if ($page['meta_title']): ?>
                                <div class="mb-2">
                                    <small class="text-success">
                                        <i class="fas fa-search mr-1"></i>
                                        SEO configuré
                                    </small>
                                </div>
                                <?php endif; ?>
                                
                                <div class="text-muted small">
                                    <i class="fas fa-clock mr-1"></i>
                                    Modifié le <?= date('d/m/Y H:i', strtotime($page['updated_at'])) ?>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="btn-group w-100">
                                    <button type="button" 
                                            class="btn btn-primary btn-sm" 
                                            onclick="editPage(<?= $page['id'] ?>)">
                                        <i class="fas fa-edit mr-1"></i>
                                        Modifier
                                    </button>
                                    <a href="../<?= htmlspecialchars($page['slug']) ?>.php" 
                                       target="_blank" 
                                       class="btn btn-outline-info btn-sm">
                                        <i class="fas fa-external-link-alt mr-1"></i>
                                        Voir
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal d'édition -->
<div class="modal fade" id="editPageModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="POST" id="editPageForm">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" id="pageId">
                
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-edit mr-2"></i>
                        Modifier la page
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Contenu principal -->
                            <div class="form-group">
                                <label for="pageTitle">Titre de la page</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="pageTitle" 
                                       name="title" 
                                       required>
                            </div>
                            
                            <div class="form-group">
                                <label for="pageContent">Contenu</label>
                                <textarea class="form-control" 
                                          id="pageContent" 
                                          name="content" 
                                          rows="15" 
                                          required></textarea>
                                <small class="form-text text-muted">
                                    Vous pouvez utiliser du HTML pour le formatage.
                                </small>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <!-- Paramètres SEO -->
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        <i class="fas fa-search mr-1"></i>
                                        Référencement SEO
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="metaTitle">Titre SEO</label>
                                        <input type="text" 
                                               class="form-control form-control-sm" 
                                               id="metaTitle" 
                                               name="meta_title"
                                               maxlength="60">
                                        <small class="form-text text-muted">
                                            Max 60 caractères
                                        </small>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="metaDescription">Description SEO</label>
                                        <textarea class="form-control form-control-sm" 
                                                  id="metaDescription" 
                                                  name="meta_description" 
                                                  rows="3"
                                                  maxlength="160"></textarea>
                                        <small class="form-text text-muted">
                                            Max 160 caractères
                                        </small>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="metaKeywords">Mots-clés</label>
                                        <input type="text" 
                                               class="form-control form-control-sm" 
                                               id="metaKeywords" 
                                               name="meta_keywords"
                                               placeholder="mot1, mot2, mot3">
                                        <small class="form-text text-muted">
                                            Séparez par des virgules
                                        </small>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Aide -->
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Aide
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <small class="text-muted">
                                        <strong>Variables disponibles :</strong><br>
                                        <code>{{site_name}}</code> - Nom du site<br>
                                        <code>{{contact_email}}</code> - Email de contact<br>
                                        <code>{{contact_phone}}</code> - Téléphone<br>
                                        <code>{{address}}</code> - Adresse
                                    </small>
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
// Données des pages pour JavaScript
const pagesData = <?= json_encode($pages) ?>;

function editPage(pageId) {
    const page = pagesData.find(p => p.id == pageId);
    if (!page) return;
    
    // Remplir le formulaire
    document.getElementById('pageId').value = page.id;
    document.getElementById('pageTitle').value = page.title;
    document.getElementById('pageContent').value = page.content;
    document.getElementById('metaTitle').value = page.meta_title || '';
    document.getElementById('metaDescription').value = page.meta_description || '';
    document.getElementById('metaKeywords').value = page.meta_keywords || '';
    
    // Ouvrir le modal
    $('#editPageModal').modal('show');
}

function previewSite() {
    window.open('../index.php', '_blank');
}

$(document).ready(function() {
    // Compteur de caractères pour SEO
    $('#metaTitle').on('input', function() {
        const length = $(this).val().length;
        const color = length > 60 ? 'text-danger' : 'text-muted';
        $(this).next('.form-text').removeClass('text-muted text-danger').addClass(color);
    });
    
    $('#metaDescription').on('input', function() {
        const length = $(this).val().length;
        const color = length > 160 ? 'text-danger' : 'text-muted';
        $(this).next('.form-text').removeClass('text-muted text-danger').addClass(color);
    });
    
    // Soumission du formulaire
    $('#editPageForm').on('submit', function(e) {
        const button = $(this).find('button[type="submit"]');
        button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i>Enregistrement...');
    });
});
</script>

<?php
$additional_js = '
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
$(document).ready(function() {
    // Initialiser CKEditor pour le contenu
    ClassicEditor
        .create(document.querySelector("#pageContent"), {
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