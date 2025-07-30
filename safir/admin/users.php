<?php
/**
 * Gestion des utilisateurs admin - SAFIR CMS
 */

$page_title = 'Gestion des Utilisateurs';
$breadcrumbs = [
    ['title' => 'Administration', 'url' => '#'],
    ['title' => 'Utilisateurs']
];

require_once 'includes/header.php';

// Vérifier les permissions (seuls super_admin peuvent gérer les utilisateurs)
$auth->requireAuth();
if ($_SESSION['admin_role'] !== 'super_admin') {
    header('Location: dashboard.php?error=access_denied');
    exit;
}

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
                $username = trim($_POST['username']);
                $email = trim($_POST['email']);
                $password = $_POST['password'];
                $role = $_POST['role'];
                $first_name = trim($_POST['first_name']);
                $last_name = trim($_POST['last_name']);
                
                // Validation
                if (strlen($password) < 6) {
                    $error = 'Le mot de passe doit contenir au moins 6 caractères.';
                    break;
                }
                
                try {
                    // Vérifier l'unicité
                    $stmt = $pdo->prepare("SELECT COUNT(*) FROM admins WHERE username = ? OR email = ?");
                    $stmt->execute([$username, $email]);
                    if ($stmt->fetchColumn() > 0) {
                        $error = 'Ce nom d\'utilisateur ou cet email existe déjà.';
                        break;
                    }
                    
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    
                    $stmt = $pdo->prepare("
                        INSERT INTO admins 
                        (username, email, password, role, first_name, last_name) 
                        VALUES (?, ?, ?, ?, ?, ?)
                    ");
                    $stmt->execute([$username, $email, $hashed_password, $role, $first_name, $last_name]);
                    
                    $auth->logActivity($_SESSION['admin_id'], 'user_created', [
                        'username' => $username, 
                        'role' => $role
                    ]);
                    $message = 'Utilisateur créé avec succès.';
                } catch (PDOException $e) {
                    $error = 'Erreur lors de la création : ' . $e->getMessage();
                }
                break;
                
            case 'update':
                $id = (int) $_POST['id'];
                $username = trim($_POST['username']);
                $email = trim($_POST['email']);
                $role = $_POST['role'];
                $first_name = trim($_POST['first_name']);
                $last_name = trim($_POST['last_name']);
                $is_active = isset($_POST['is_active']) ? 1 : 0;
                
                // Ne pas permettre la modification de son propre compte pour éviter l'auto-verrouillage
                if ($id == $_SESSION['admin_id']) {
                    $is_active = 1; // Forcer actif pour son propre compte
                }
                
                try {
                    // Vérifier l'unicité (exclure l'utilisateur actuel)
                    $stmt = $pdo->prepare("
                        SELECT COUNT(*) FROM admins 
                        WHERE (username = ? OR email = ?) AND id != ?
                    ");
                    $stmt->execute([$username, $email, $id]);
                    if ($stmt->fetchColumn() > 0) {
                        $error = 'Ce nom d\'utilisateur ou cet email existe déjà.';
                        break;
                    }
                    
                    $stmt = $pdo->prepare("
                        UPDATE admins 
                        SET username = ?, email = ?, role = ?, first_name = ?, last_name = ?, is_active = ?
                        WHERE id = ?
                    ");
                    $stmt->execute([$username, $email, $role, $first_name, $last_name, $is_active, $id]);
                    
                    $auth->logActivity($_SESSION['admin_id'], 'user_updated', [
                        'user_id' => $id,
                        'username' => $username
                    ]);
                    $message = 'Utilisateur mis à jour avec succès.';
                } catch (PDOException $e) {
                    $error = 'Erreur lors de la mise à jour : ' . $e->getMessage();
                }
                break;
                
            case 'change_password':
                $id = (int) $_POST['id'];
                $new_password = $_POST['new_password'];
                
                if (strlen($new_password) < 6) {
                    $error = 'Le mot de passe doit contenir au moins 6 caractères.';
                    break;
                }
                
                try {
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    
                    $stmt = $pdo->prepare("UPDATE admins SET password = ? WHERE id = ?");
                    $stmt->execute([$hashed_password, $id]);
                    
                    $auth->logActivity($_SESSION['admin_id'], 'user_password_changed', ['user_id' => $id]);
                    $message = 'Mot de passe modifié avec succès.';
                } catch (PDOException $e) {
                    $error = 'Erreur lors de la modification du mot de passe : ' . $e->getMessage();
                }
                break;
                
            case 'delete':
                $id = (int) $_POST['id'];
                
                // Ne pas permettre de supprimer son propre compte
                if ($id == $_SESSION['admin_id']) {
                    $error = 'Vous ne pouvez pas supprimer votre propre compte.';
                    break;
                }
                
                try {
                    // Récupérer les infos avant suppression
                    $stmt = $pdo->prepare("SELECT username FROM admins WHERE id = ?");
                    $stmt->execute([$id]);
                    $user = $stmt->fetch();
                    
                    $stmt = $pdo->prepare("DELETE FROM admins WHERE id = ?");
                    $stmt->execute([$id]);
                    
                    $auth->logActivity($_SESSION['admin_id'], 'user_deleted', [
                        'user_id' => $id,
                        'username' => $user['username']
                    ]);
                    $message = 'Utilisateur supprimé avec succès.';
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
        
        if ($id == $_SESSION['admin_id']) {
            $error = 'Vous ne pouvez pas supprimer votre propre compte.';
        } else {
            try {
                $stmt = $pdo->prepare("SELECT username FROM admins WHERE id = ?");
                $stmt->execute([$id]);
                $user = $stmt->fetch();
                
                $stmt = $pdo->prepare("DELETE FROM admins WHERE id = ?");
                $stmt->execute([$id]);
                
                $auth->logActivity($_SESSION['admin_id'], 'user_deleted', [
                    'user_id' => $id,
                    'username' => $user['username']
                ]);
                $message = 'Utilisateur supprimé avec succès.';
            } catch (PDOException $e) {
                $error = 'Erreur lors de la suppression : ' . $e->getMessage();
            }
        }
    }
}

// Récupération des utilisateurs
try {
    $stmt = $pdo->query("
        SELECT a.*, 
               COUNT(DISTINCT al.id) as activity_count,
               MAX(al.created_at) as last_activity
        FROM admins a 
        LEFT JOIN activity_logs al ON a.id = al.admin_id
        GROUP BY a.id
        ORDER BY a.created_at DESC
    ");
    $users = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = 'Erreur lors du chargement des utilisateurs : ' . $e->getMessage();
    $users = [];
}

// Statistiques
try {
    $stmt = $pdo->query("
        SELECT 
            COUNT(*) as total_users,
            COUNT(CASE WHEN is_active = 1 THEN 1 END) as active_users,
            COUNT(CASE WHEN role = 'super_admin' THEN 1 END) as super_admins,
            COUNT(CASE WHEN role = 'admin' THEN 1 END) as admins,
            COUNT(CASE WHEN role = 'editor' THEN 1 END) as editors,
            COUNT(CASE WHEN last_login >= DATE_SUB(NOW(), INTERVAL 30 DAY) THEN 1 END) as recent_logins
        FROM admins
    ");
    $stats = $stmt->fetch();
} catch (PDOException $e) {
    $stats = [
        'total_users' => 0,
        'active_users' => 0,
        'super_admins' => 0,
        'admins' => 0,
        'editors' => 0,
        'recent_logins' => 0
    ];
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

<!-- Statistiques -->
<div class="row mb-4">
    <div class="col-lg-3 col-6">
        <div class="info-box">
            <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total utilisateurs</span>
                <span class="info-box-number"><?= $stats['total_users'] ?></span>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="info-box">
            <span class="info-box-icon bg-success"><i class="fas fa-user-check"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Utilisateurs actifs</span>
                <span class="info-box-number"><?= $stats['active_users'] ?></span>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="info-box">
            <span class="info-box-icon bg-warning"><i class="fas fa-crown"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Super Admins</span>
                <span class="info-box-number"><?= $stats['super_admins'] ?></span>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="info-box">
            <span class="info-box-icon bg-danger"><i class="fas fa-clock"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Connexions récentes</span>
                <span class="info-box-number"><?= $stats['recent_logins'] ?></span>
            </div>
        </div>
    </div>
</div>

<!-- Liste des utilisateurs -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user-shield mr-2"></i>
                    Utilisateurs Administrateurs
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-primary btn-sm" onclick="createUser()">
                        <i class="fas fa-plus mr-1"></i>
                        Nouvel utilisateur
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="usersTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Utilisateur</th>
                                <th>Email</th>
                                <th>Rôle</th>
                                <th>Statut</th>
                                <th>Dernière connexion</th>
                                <th>Activité</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                            <tr <?= $user['id'] == $_SESSION['admin_id'] ? 'class="table-info"' : '' ?>>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar mr-2">
                                            <?php if (!empty($user['avatar'])): ?>
                                            <img src="../uploads/avatars/<?= htmlspecialchars($user['avatar']) ?>" 
                                                 alt="<?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?>"
                                                 class="img-circle elevation-2" 
                                                 style="width: 40px; height: 40px;">
                                            <?php else: ?>
                                            <div class="img-circle elevation-2 bg-primary text-white d-flex align-items-center justify-content-center" 
                                                 style="width: 40px; height: 40px; font-size: 1.2rem;">
                                                <?= strtoupper(substr($user['first_name'], 0, 1) . substr($user['last_name'], 0, 1)) ?>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <strong><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></strong>
                                            <?= $user['id'] == $_SESSION['admin_id'] ? '<span class="badge badge-info ml-1">Vous</span>' : '' ?>
                                            <br>
                                            <small class="text-muted">@<?= htmlspecialchars($user['username']) ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td>
                                    <?php
                                    $role_badges = [
                                        'super_admin' => 'badge-danger',
                                        'admin' => 'badge-warning',
                                        'editor' => 'badge-info'
                                    ];
                                    $role_labels = [
                                        'super_admin' => 'Super Admin',
                                        'admin' => 'Administrateur',
                                        'editor' => 'Éditeur'
                                    ];
                                    ?>
                                    <span class="badge <?= $role_badges[$user['role']] ?? 'badge-secondary' ?>">
                                        <i class="fas fa-<?= $user['role'] === 'super_admin' ? 'crown' : ($user['role'] === 'admin' ? 'user-shield' : 'user-edit') ?> mr-1"></i>
                                        <?= $role_labels[$user['role']] ?? $user['role'] ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($user['is_active']): ?>
                                    <span class="badge badge-success">
                                        <i class="fas fa-check mr-1"></i>Actif
                                    </span>
                                    <?php else: ?>
                                    <span class="badge badge-secondary">
                                        <i class="fas fa-times mr-1"></i>Inactif
                                    </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($user['last_login']): ?>
                                    <span title="<?= date('d/m/Y H:i:s', strtotime($user['last_login'])) ?>">
                                        <?= date('d/m/Y H:i', strtotime($user['last_login'])) ?>
                                    </span>
                                    <?php else: ?>
                                    <span class="text-muted">Jamais connecté</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge badge-light">
                                        <?= number_format($user['activity_count']) ?> action<?= $user['activity_count'] > 1 ? 's' : '' ?>
                                    </span>
                                    <?php if ($user['last_activity']): ?>
                                    <br>
                                    <small class="text-muted">
                                        Dernière: <?= date('d/m/Y', strtotime($user['last_activity'])) ?>
                                    </small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" 
                                                class="btn btn-info btn-sm" 
                                                onclick="editUser(<?= $user['id'] ?>)" 
                                                title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" 
                                                class="btn btn-warning btn-sm" 
                                                onclick="changePassword(<?= $user['id'] ?>, '<?= htmlspecialchars($user['username']) ?>')" 
                                                title="Changer le mot de passe">
                                            <i class="fas fa-key"></i>
                                        </button>
                                        <button type="button" 
                                                class="btn btn-success btn-sm" 
                                                onclick="viewActivity(<?= $user['id'] ?>, '<?= htmlspecialchars($user['username']) ?>')" 
                                                title="Voir l'activité">
                                            <i class="fas fa-history"></i>
                                        </button>
                                        <?php if ($user['id'] != $_SESSION['admin_id']): ?>
                                        <a href="?delete=<?= $user['id'] ?>&token=<?= urlencode($csrf_token) ?>" 
                                           class="btn btn-danger btn-sm btn-delete" 
                                           title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <?php endif; ?>
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

<!-- Modal d'utilisateur -->
<div class="modal fade" id="userModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" id="userForm">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
                <input type="hidden" name="action" id="formAction" value="create">
                <input type="hidden" name="id" id="userId">
                
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">
                        <i class="fas fa-plus mr-2"></i>
                        Nouvel utilisateur
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="userFirstName">Prénom *</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="userFirstName" 
                                       name="first_name" 
                                       required>
                            </div>
                            
                            <div class="form-group">
                                <label for="userLastName">Nom *</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="userLastName" 
                                       name="last_name" 
                                       required>
                            </div>
                            
                            <div class="form-group">
                                <label for="userUsername">Nom d'utilisateur *</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="userUsername" 
                                       name="username" 
                                       pattern="[a-zA-Z0-9_]+"
                                       title="Lettres, chiffres et underscores uniquement"
                                       required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="userEmail">Email *</label>
                                <input type="email" 
                                       class="form-control" 
                                       id="userEmail" 
                                       name="email" 
                                       required>
                            </div>
                            
                            <div class="form-group">
                                <label for="userRole">Rôle *</label>
                                <select class="form-control" 
                                        id="userRole" 
                                        name="role" 
                                        required>
                                    <option value="editor">Éditeur</option>
                                    <option value="admin">Administrateur</option>
                                    <option value="super_admin">Super Administrateur</option>
                                </select>
                                <small class="form-text text-muted">
                                    <strong>Éditeur :</strong> Contenu, services, galerie<br>
                                    <strong>Admin :</strong> + Encadreurs, paramètres<br>
                                    <strong>Super Admin :</strong> + Gestion utilisateurs
                                </small>
                            </div>
                            
                            <div class="form-group" id="passwordGroup">
                                <label for="userPassword">Mot de passe *</label>
                                <input type="password" 
                                       class="form-control" 
                                       id="userPassword" 
                                       name="password" 
                                       minlength="6"
                                       required>
                                <small class="form-text text-muted">
                                    Minimum 6 caractères
                                </small>
                            </div>
                            
                            <div class="form-check" id="activeCheckContainer" style="display: none;">
                                <input type="checkbox" 
                                       class="form-check-input" 
                                       id="userActive" 
                                       name="is_active">
                                <label class="form-check-label" for="userActive">
                                    Utilisateur actif
                                </label>
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

<!-- Modal de changement de mot de passe -->
<div class="modal fade" id="passwordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
                <input type="hidden" name="action" value="change_password">
                <input type="hidden" name="id" id="passwordUserId">
                
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-key mr-2"></i>
                        Changer le mot de passe
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <p>Utilisateur : <strong id="passwordUsername"></strong></p>
                    
                    <div class="form-group">
                        <label for="newPassword">Nouveau mot de passe *</label>
                        <input type="password" 
                               class="form-control" 
                               id="newPassword" 
                               name="new_password" 
                               minlength="6"
                               required>
                        <small class="form-text text-muted">
                            Minimum 6 caractères
                        </small>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>
                        Annuler
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-key mr-1"></i>
                        Changer le mot de passe
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Données des utilisateurs pour JavaScript
const usersData = <?= json_encode($users) ?>;

function createUser() {
    document.getElementById('userForm').reset();
    document.getElementById('formAction').value = 'create';
    document.getElementById('userId').value = '';
    document.getElementById('modalTitle').innerHTML = '<i class="fas fa-plus mr-2"></i>Nouvel utilisateur';
    document.getElementById('activeCheckContainer').style.display = 'none';
    document.getElementById('passwordGroup').style.display = 'block';
    document.getElementById('userPassword').required = true;
    $('#userModal').modal('show');
}

function editUser(userId) {
    const user = usersData.find(u => u.id == userId);
    if (!user) return;
    
    document.getElementById('formAction').value = 'update';
    document.getElementById('userId').value = user.id;
    document.getElementById('userFirstName').value = user.first_name;
    document.getElementById('userLastName').value = user.last_name;
    document.getElementById('userUsername').value = user.username;
    document.getElementById('userEmail').value = user.email;
    document.getElementById('userRole').value = user.role;
    document.getElementById('userActive').checked = user.is_active == 1;
    
    document.getElementById('modalTitle').innerHTML = '<i class="fas fa-edit mr-2"></i>Modifier l\'utilisateur';
    document.getElementById('activeCheckContainer').style.display = 'block';
    document.getElementById('passwordGroup').style.display = 'none';
    document.getElementById('userPassword').required = false;
    
    $('#userModal').modal('show');
}

function changePassword(userId, username) {
    document.getElementById('passwordUserId').value = userId;
    document.getElementById('passwordUsername').textContent = username;
    document.getElementById('newPassword').value = '';
    $('#passwordModal').modal('show');
}

function viewActivity(userId, username) {
    // TODO: Implémenter la vue de l'activité utilisateur
    window.open('logs.php?user=' + userId, '_blank');
}

$(document).ready(function() {
    // Initialiser DataTable
    $('#usersTable').DataTable({
        "order": [[ 0, "asc" ]],
        "columnDefs": [
            { "orderable": false, "targets": -1 }
        ]
    });
    
    // Validation du nom d'utilisateur
    $('#userUsername').on('input', function() {
        const value = $(this).val();
        const sanitized = value.replace(/[^a-zA-Z0-9_]/g, '');
        if (value !== sanitized) {
            $(this).val(sanitized);
        }
    });
});
</script>

<?php
require_once 'includes/footer.php';
?>