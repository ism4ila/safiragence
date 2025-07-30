<?php
/**
 * Système d'authentification admin pour SAFIR CMS
 */

require_once '../includes/config.php';

class Auth {
    private $pdo;
    
    public function __construct() {
        try {
            $this->pdo = new PDO(
                'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            die('Erreur de connexion : ' . $e->getMessage());
        }
    }
    
    /**
     * Authentifier un administrateur
     */
    public function login($username, $password) {
        try {
            // Vérification anti-brute force
            if ($this->isBruteForceAttempt()) {
                return ['success' => false, 'message' => 'Trop de tentatives. Réessayez dans 15 minutes.'];
            }
            
            $stmt = $this->pdo->prepare(
                "SELECT id, username, email, password, role, first_name, last_name, is_active 
                 FROM admins WHERE (username = ? OR email = ?) AND is_active = 1"
            );
            $stmt->execute([$username, $username]);
            $admin = $stmt->fetch();
            
            if ($admin && password_verify($password, $admin['password'])) {
                // Connexion réussie
                $this->createSession($admin);
                $this->updateLastLogin($admin['id']);
                $this->logActivity($admin['id'], 'login_success');
                $this->clearLoginAttempts();
                
                return ['success' => true, 'admin' => $admin];
            } else {
                // Connexion échouée
                $this->recordLoginAttempt();
                $this->logActivity(null, 'login_failed', ['username' => $username]);
                
                return ['success' => false, 'message' => 'Identifiants incorrects.'];
            }
        } catch (PDOException $e) {
            error_log('Erreur login : ' . $e->getMessage());
            return ['success' => false, 'message' => 'Erreur système.'];
        }
    }
    
    /**
     * Créer une session admin
     */
    private function createSession($admin) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        $_SESSION['admin_email'] = $admin['email'];
        $_SESSION['admin_role'] = $admin['role'];
        $_SESSION['admin_name'] = $admin['first_name'] . ' ' . $admin['last_name'];
        $_SESSION['login_time'] = time();
        
        // Régénérer l'ID de session pour sécurité
        session_regenerate_id(true);
    }
    
    /**
     * Vérifier si l'admin est connecté
     */
    public function isLoggedIn() {
        return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
    }
    
    /**
     * Obtenir les informations de l'admin connecté
     */
    public function getAdmin() {
        if (!$this->isLoggedIn()) {
            return null;
        }
        
        return [
            'id' => $_SESSION['admin_id'],
            'username' => $_SESSION['admin_username'],
            'email' => $_SESSION['admin_email'],
            'role' => $_SESSION['admin_role'],
            'name' => $_SESSION['admin_name'],
            'login_time' => $_SESSION['login_time']
        ];
    }
    
    /**
     * Déconnecter l'admin
     */
    public function logout() {
        if ($this->isLoggedIn()) {
            $this->logActivity($_SESSION['admin_id'], 'logout');
        }
        
        // Détruire toutes les variables de session
        $_SESSION = array();
        
        // Détruire le cookie de session
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        // Détruire la session
        session_destroy();
    }
    
    /**
     * Vérifier les permissions selon le rôle
     */
    public function hasPermission($permission) {
        if (!$this->isLoggedIn()) {
            return false;
        }
        
        $role = $_SESSION['admin_role'];
        
        $permissions = [
            'super_admin' => ['*'], // Toutes permissions
            'admin' => [
                'view_dashboard', 'manage_content', 'manage_services', 
                'manage_encadreurs', 'manage_reservations', 'manage_gallery',
                'view_messages', 'manage_settings'
            ],
            'editor' => [
                'view_dashboard', 'manage_content', 'manage_services',
                'manage_gallery', 'view_messages'
            ]
        ];
        
        if ($role === 'super_admin') {
            return true;
        }
        
        return in_array($permission, $permissions[$role] ?? []);
    }
    
    /**
     * Middleware de protection des pages admin
     */
    public function requireAuth($permission = null) {
        if (!$this->isLoggedIn()) {
            header('Location: login.php');
            exit;
        }
        
        if ($permission && !$this->hasPermission($permission)) {
            header('Location: dashboard.php?error=access_denied');
            exit;
        }
    }
    
    /**
     * Protection anti-brute force
     */
    private function isBruteForceAttempt() {
        $ip = $_SERVER['REMOTE_ADDR'];
        $attempts = $_SESSION['login_attempts'][$ip] ?? 0;
        $last_attempt = $_SESSION['last_attempt'][$ip] ?? 0;
        
        // Réinitialiser après 15 minutes
        if (time() - $last_attempt > 900) {
            unset($_SESSION['login_attempts'][$ip]);
            unset($_SESSION['last_attempt'][$ip]);
            return false;
        }
        
        return $attempts >= 5;
    }
    
    /**
     * Enregistrer une tentative de connexion
     */
    private function recordLoginAttempt() {
        $ip = $_SERVER['REMOTE_ADDR'];
        $_SESSION['login_attempts'][$ip] = ($_SESSION['login_attempts'][$ip] ?? 0) + 1;
        $_SESSION['last_attempt'][$ip] = time();
    }
    
    /**
     * Effacer les tentatives de connexion
     */
    private function clearLoginAttempts() {
        $ip = $_SERVER['REMOTE_ADDR'];
        unset($_SESSION['login_attempts'][$ip]);
        unset($_SESSION['last_attempt'][$ip]);
    }
    
    /**
     * Mettre à jour la dernière connexion
     */
    private function updateLastLogin($admin_id) {
        $stmt = $this->pdo->prepare("UPDATE admins SET last_login = NOW() WHERE id = ?");
        $stmt->execute([$admin_id]);
    }
    
    /**
     * Enregistrer l'activité
     */
    private function logActivity($admin_id, $action, $data = []) {
        try {
            $stmt = $this->pdo->prepare(
                "INSERT INTO activity_logs (admin_id, action, new_values, ip_address, user_agent) 
                 VALUES (?, ?, ?, ?, ?)"
            );
            $stmt->execute([
                $admin_id,
                $action,
                json_encode($data),
                $_SERVER['REMOTE_ADDR'] ?? null,
                $_SERVER['HTTP_USER_AGENT'] ?? null
            ]);
        } catch (PDOException $e) {
            error_log('Erreur log activité : ' . $e->getMessage());
        }
    }
    
    /**
     * Générer un token CSRF
     */
    public function generateCSRFToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    /**
     * Vérifier le token CSRF
     */
    public function verifyCSRFToken($token) {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}

// Instance globale
$auth = new Auth();
?>