<?php
/**
 * Gestion de la galerie - SAFIR CMS
 */

$page_title = 'Gestion de la Galerie';
$breadcrumbs = [
    ['title' => 'Galerie']
];

require_once 'includes/header.php';

// Vérifier les permissions
$auth->requireAuth('manage_gallery');

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

// Créer le dossier uploads si nécessaire
$upload_dir = '../uploads/gallery/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// Traitement des actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $csrf_token = $_POST['csrf_token'] ?? '';
    
    if (!$auth->verifyCSRFToken($csrf_token)) {
        $error = 'Token de sécurité invalide.';
    } else {
        switch ($action) {
            case 'create_album':
                $name = trim($_POST['album_name']);
                $description = trim($_POST['album_description']);
                
                try {
                    $stmt = $pdo->prepare("
                        INSERT INTO gallery_albums (name, description, created_by) 
                        VALUES (?, ?, ?)
                    ");
                    $stmt->execute([$name, $description ?: null, $_SESSION['admin_id']]);
                    
                    $auth->logActivity($_SESSION['admin_id'], 'album_created', ['name' => $name]);
                    $message = 'Album créé avec succès.';
                } catch (PDOException $e) {
                    $error = 'Erreur lors de la création : ' . $e->getMessage();
                }
                break;
                
            case 'update_album':
                $id = (int) $_POST['album_id'];
                $name = trim($_POST['album_name']);
                $description = trim($_POST['album_description']);
                $is_active = isset($_POST['is_active']) ? 1 : 0;
                
                try {
                    $stmt = $pdo->prepare("
                        UPDATE gallery_albums 
                        SET name = ?, description = ?, is_active = ?
                        WHERE id = ?
                    ");
                    $stmt->execute([$name, $description ?: null, $is_active, $id]);
                    
                    $auth->logActivity($_SESSION['admin_id'], 'album_updated', ['album_id' => $id, 'name' => $name]);
                    $message = 'Album mis à jour avec succès.';
                } catch (PDOException $e) {
                    $error = 'Erreur lors de la mise à jour : ' . $e->getMessage();
                }
                break;
                
            case 'upload_images':
                $album_id = (int) $_POST['album_id'];
                
                if (!empty($_FILES['images']['name'][0])) {
                    $uploaded_count = 0;
                    $total_files = count($_FILES['images']['name']);
                    
                    for ($i = 0; $i < $total_files; $i++) {
                        if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                            $original_name = $_FILES['images']['name'][$i];
                            $tmp_name = $_FILES['images']['tmp_name'][$i];
                            $file_size = $_FILES['images']['size'][$i];
                            
                            // Vérifier le type de fichier
                            $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
                            $file_type = mime_content_type($tmp_name);
                            
                            if (!in_array($file_type, $allowed_types)) {
                                continue;
                            }
                            
                            // Générer un nom unique
                            $extension = pathinfo($original_name, PATHINFO_EXTENSION);
                            $filename = uniqid() . '.' . strtolower($extension);
                            $file_path = $upload_dir . $filename;
                            
                            if (move_uploaded_file($tmp_name, $file_path)) {
                                // Obtenir les dimensions
                                $image_info = getimagesize($file_path);
                                $dimensions = $image_info ? $image_info[0] . 'x' . $image_info[1] : null;
                                
                                // Enregistrer en base
                                try {
                                    $stmt = $pdo->prepare("
                                        INSERT INTO gallery_images 
                                        (album_id, filename, original_name, file_size, dimensions, uploaded_by) 
                                        VALUES (?, ?, ?, ?, ?, ?)
                                    ");
                                    $stmt->execute([
                                        $album_id, $filename, $original_name, 
                                        $file_size, $dimensions, $_SESSION['admin_id']
                                    ]);
                                    $uploaded_count++;
                                } catch (PDOException $e) {
                                    // Supprimer le fichier si erreur BDD
                                    unlink($file_path);
                                }
                            }
                        }
                    }
                    
                    if ($uploaded_count > 0) {
                        $auth->logActivity($_SESSION['admin_id'], 'images_uploaded', ['album_id' => $album_id, 'count' => $uploaded_count]);
                        $message = "$uploaded_count image(s) uploadée(s) avec succès.";
                    } else {
                        $error = 'Aucune image n\'a pu être uploadée.';
                    }
                } else {
                    $error = 'Aucune image sélectionnée.';
                }
                break;
                
            case 'delete_image':
                $image_id = (int) $_POST['image_id'];
                
                try {
                    // Récupérer les infos de l'image
                    $stmt = $pdo->prepare("SELECT filename FROM gallery_images WHERE id = ?");
                    $stmt->execute([$image_id]);
                    $image = $stmt->fetch();
                    
                    if ($image) {
                        // Supprimer le fichier
                        $file_path = $upload_dir . $image['filename'];
                        if (file_exists($file_path)) {
                            unlink($file_path);
                        }
                        
                        // Supprimer de la BDD
                        $stmt = $pdo->prepare("DELETE FROM gallery_images WHERE id = ?");
                        $stmt->execute([$image_id]);
                        
                        $auth->logActivity($_SESSION['admin_id'], 'image_deleted', ['image_id' => $image_id]);
                        $message = 'Image supprimée avec succès.';
                    }
                } catch (PDOException $e) {
                    $error = 'Erreur lors de la suppression : ' . $e->getMessage();
                }
                break;
        }
    }
}

// Action GET pour suppression
if (isset($_GET['delete_album']) && isset($_GET['token'])) {
    if ($auth->verifyCSRFToken($_GET['token'])) {
        $album_id = (int) $_GET['delete_album'];
        try {
            // Supprimer toutes les images de l'album
            $stmt = $pdo->prepare("SELECT filename FROM gallery_images WHERE album_id = ?");
            $stmt->execute([$album_id]);
            $images = $stmt->fetchAll();
            
            foreach ($images as $image) {
                $file_path = $upload_dir . $image['filename'];
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
            
            // Supprimer l'album et ses images
            $stmt = $pdo->prepare("DELETE FROM gallery_images WHERE album_id = ?");
            $stmt->execute([$album_id]);
            
            $stmt = $pdo->prepare("DELETE FROM gallery_albums WHERE id = ?");
            $stmt->execute([$album_id]);
            
            $auth->logActivity($_SESSION['admin_id'], 'album_deleted', ['album_id' => $album_id]);
            $message = 'Album et ses images supprimés avec succès.';
        } catch (PDOException $e) {
            $error = 'Erreur lors de la suppression : ' . $e->getMessage();
        }
    }
}

// Récupération des albums avec comptage des images
try {
    $stmt = $pdo->query("
        SELECT a.*, COUNT(i.id) as image_count, a2.username as created_by_name
        FROM gallery_albums a 
        LEFT JOIN gallery_images i ON a.id = i.album_id AND i.is_active = 1
        LEFT JOIN admins a2 ON a.created_by = a2.id
        GROUP BY a.id
        ORDER BY a.sort_order, a.name
    ");
    $albums = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = 'Erreur lors du chargement des albums : ' . $e->getMessage();
    $albums = [];
}

// Récupération des images récentes
try {
    $stmt = $pdo->query("
        SELECT i.*, a.name as album_name 
        FROM gallery_images i 
        LEFT JOIN gallery_albums a ON i.album_id = a.id
        ORDER BY i.created_at DESC 
        LIMIT 12
    ");
    $recent_images = $stmt->fetchAll();
} catch (PDOException $e) {
    $recent_images = [];
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

<!-- Actions rapides -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5 class="mb-0">
                            <i class="fas fa-images mr-2"></i>
                            Galerie Photos SAFIR
                        </h5>
                        <small class="text-muted">
                            Gérez vos albums photos et images pour le site web
                        </small>
                    </div>
                    <div class="col-md-4 text-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary" onclick="createAlbum()">
                                <i class="fas fa-plus mr-1"></i>
                                Nouvel album
                            </button>
                            <a href="../galerie.php" target="_blank" class="btn btn-success">
                                <i class="fas fa-eye mr-1"></i>
                                Voir la galerie
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Albums -->
<div class="row">
    <?php if (!empty($albums)): ?>
        <?php foreach ($albums as $album): ?>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card album-card h-100">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">
                            <?= htmlspecialchars($album['name']) ?>
                            <?php if (!$album['is_active']): ?>
                            <span class="badge badge-secondary ml-1">Inactif</span>
                            <?php endif; ?>
                        </h6>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary" data-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#" onclick="editAlbum(<?= $album['id'] ?>)">
                                    <i class="fas fa-edit mr-1"></i> Modifier
                                </a>
                                <a class="dropdown-item" href="#" onclick="uploadToAlbum(<?= $album['id'] ?>, '<?= htmlspecialchars($album['name']) ?>')">
                                    <i class="fas fa-upload mr-1"></i> Ajouter des images
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" 
                                   href="?delete_album=<?= $album['id'] ?>&token=<?= urlencode($csrf_token) ?>"
                                   onclick="return confirm('Supprimer cet album et toutes ses images ?')">
                                    <i class="fas fa-trash mr-1"></i> Supprimer
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php if ($album['description']): ?>
                    <p class="text-muted small"><?= htmlspecialchars($album['description']) ?></p>
                    <?php endif; ?>
                    
                    <div class="album-stats">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="stat-item">
                                    <i class="fas fa-images text-primary"></i>
                                    <div class="stat-number"><?= $album['image_count'] ?></div>
                                    <div class="stat-label">Images</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-item">
                                    <i class="fas fa-calendar text-info"></i>
                                    <div class="stat-number"><?= date('d/m', strtotime($album['created_at'])) ?></div>
                                    <div class="stat-label">Créé</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="btn-group w-100">
                        <button type="button" class="btn btn-outline-primary btn-sm" 
                                onclick="viewAlbumImages(<?= $album['id'] ?>, '<?= htmlspecialchars($album['name']) ?>')">
                            <i class="fas fa-eye mr-1"></i>
                            Voir les images
                        </button>
                        <button type="button" class="btn btn-outline-success btn-sm" 
                                onclick="uploadToAlbum(<?= $album['id'] ?>, '<?= htmlspecialchars($album['name']) ?>')">
                            <i class="fas fa-upload mr-1"></i>
                            Upload
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-images fa-3x text-muted mb-3"></i>
                    <h4>Aucun album créé</h4>
                    <p class="text-muted">Commencez par créer votre premier album photo.</p>
                    <button type="button" class="btn btn-primary" onclick="createAlbum()">
                        <i class="fas fa-plus mr-1"></i>
                        Créer un album
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Images récentes -->
<?php if (!empty($recent_images)): ?>
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-clock mr-2"></i>
                    Images récentes
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php foreach ($recent_images as $image): ?>
                    <div class="col-md-2 col-sm-3 col-4 mb-3">
                        <div class="recent-image">
                            <img src="../uploads/gallery/<?= htmlspecialchars($image['filename']) ?>" 
                                 alt="<?= htmlspecialchars($image['title'] ?: $image['original_name']) ?>"
                                 class="img-thumbnail"
                                 onclick="viewImageModal('<?= htmlspecialchars($image['filename']) ?>', '<?= htmlspecialchars($image['original_name']) ?>')">
                            <div class="image-overlay">
                                <button class="btn btn-danger btn-sm" 
                                        onclick="deleteImage(<?= $image['id'] ?>, '<?= htmlspecialchars($image['original_name']) ?>')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <small class="text-muted d-block mt-1">
                                <?= htmlspecialchars($image['album_name'] ?: 'Sans album') ?>
                            </small>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Modal d'album -->
<div class="modal fade" id="albumModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="albumForm">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
                <input type="hidden" name="action" id="albumAction" value="create_album">
                <input type="hidden" name="album_id" id="albumId">
                
                <div class="modal-header">
                    <h5 class="modal-title" id="albumModalTitle">
                        <i class="fas fa-plus mr-2"></i>
                        Nouvel album
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <div class="form-group">
                        <label for="albumName">Nom de l'album *</label>
                        <input type="text" 
                               class="form-control" 
                               id="albumName" 
                               name="album_name" 
                               required>
                    </div>
                    
                    <div class="form-group">
                        <label for="albumDescription">Description</label>
                        <textarea class="form-control" 
                                  id="albumDescription" 
                                  name="album_description" 
                                  rows="3"></textarea>
                    </div>
                    
                    <div class="form-check" id="activeCheckContainer" style="display: none;">
                        <input type="checkbox" 
                               class="form-check-input" 
                               id="albumActive" 
                               name="is_active">
                        <label class="form-check-label" for="albumActive">
                            Album actif (visible sur le site)
                        </label>
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

<!-- Modal d'upload -->
<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data" id="uploadForm">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
                <input type="hidden" name="action" value="upload_images">
                <input type="hidden" name="album_id" id="uploadAlbumId">
                
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-upload mr-2"></i>
                        Ajouter des images
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <div class="form-group">
                        <label for="uploadImages">Sélectionner les images *</label>
                        <input type="file" 
                               class="form-control-file" 
                               id="uploadImages" 
                               name="images[]" 
                               multiple 
                               accept="image/*"
                               required>
                        <small class="form-text text-muted">
                            Formats acceptés : JPG, PNG, GIF, WebP. Vous pouvez sélectionner plusieurs images.
                        </small>
                    </div>
                    
                    <div id="imagePreview" class="mt-3"></div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>
                        Annuler
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload mr-1"></i>
                        Uploader
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.album-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.album-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 1.2rem;
    font-weight: bold;
    color: #2c3e50;
}

.stat-label {
    font-size: 0.8rem;
    color: #6c757d;
}

.recent-image {
    position: relative;
    cursor: pointer;
}

.recent-image img {
    width: 100%;
    height: 80px;
    object-fit: cover;
}

.image-overlay {
    position: absolute;
    top: 0;
    right: 0;
    opacity: 0;
    transition: opacity 0.2s ease;
}

.recent-image:hover .image-overlay {
    opacity: 1;
}

#imagePreview img {
    max-width: 100px;
    max-height: 100px;
    object-fit: cover;
    margin: 5px;
    border-radius: 5px;
}
</style>

<script>
// Données des albums pour JavaScript
const albumsData = <?= json_encode($albums) ?>;

function createAlbum() {
    document.getElementById('albumForm').reset();
    document.getElementById('albumAction').value = 'create_album';
    document.getElementById('albumId').value = '';
    document.getElementById('albumModalTitle').innerHTML = '<i class="fas fa-plus mr-2"></i>Nouvel album';
    document.getElementById('activeCheckContainer').style.display = 'none';
    $('#albumModal').modal('show');
}

function editAlbum(albumId) {
    const album = albumsData.find(a => a.id == albumId);
    if (!album) return;
    
    document.getElementById('albumAction').value = 'update_album';
    document.getElementById('albumId').value = album.id;
    document.getElementById('albumName').value = album.name;
    document.getElementById('albumDescription').value = album.description || '';
    document.getElementById('albumActive').checked = album.is_active == 1;
    document.getElementById('albumModalTitle').innerHTML = '<i class="fas fa-edit mr-2"></i>Modifier l\'album';
    document.getElementById('activeCheckContainer').style.display = 'block';
    
    $('#albumModal').modal('show');
}

function uploadToAlbum(albumId, albumName) {
    document.getElementById('uploadForm').reset();
    document.getElementById('uploadAlbumId').value = albumId;
    document.querySelector('#uploadModal .modal-title').innerHTML = 
        '<i class="fas fa-upload mr-2"></i>Ajouter des images à "' + albumName + '"';
    $('#uploadModal').modal('show');
}

function viewAlbumImages(albumId, albumName) {
    // TODO: Implémenter la vue des images de l'album
    window.open('../galerie.php?album=' + albumId, '_blank');
}

function deleteImage(imageId, imageName) {
    if (confirm('Supprimer l\'image "' + imageName + '" ?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.innerHTML = `
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
            <input type="hidden" name="action" value="delete_image">
            <input type="hidden" name="image_id" value="${imageId}">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}

function viewImageModal(filename, originalName) {
    Swal.fire({
        title: originalName,
        imageUrl: '../uploads/gallery/' + filename,
        imageAlt: originalName,
        showCloseButton: true,
        showConfirmButton: false,
        width: 600
    });
}

// Preview des images sélectionnées
document.getElementById('uploadImages').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    
    Array.from(e.target.files).forEach(file => {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.maxWidth = '100px';
                img.style.maxHeight = '100px';
                img.style.objectFit = 'cover';
                img.style.margin = '5px';
                img.style.borderRadius = '5px';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>

<?php
require_once 'includes/footer.php';
?>