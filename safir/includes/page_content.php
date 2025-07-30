<?php
/**
 * Helper pour charger le contenu des pages depuis la BDD - SAFIR CMS
 */

/**
 * Charger le contenu d'une page depuis la base de données
 * @param string $slug Le slug de la page (ex: 'home', 'about', 'contact')
 * @return array|null Les données de la page ou null si introuvable
 */
function getPageContent($slug) {
    static $pdo = null;
    static $cache = [];
    
    // Cache pour éviter les requêtes multiples
    if (isset($cache[$slug])) {
        return $cache[$slug];
    }
    
    // Connexion à la base de données si pas déjà faite
    if ($pdo === null) {
        try {
            $pdo = new PDO(
                'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            error_log('Erreur connexion BDD page_content: ' . $e->getMessage());
            return null;
        }
    }
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM pages WHERE slug = ? AND is_active = 1");
        $stmt->execute([$slug]);
        $page = $stmt->fetch();
        
        if ($page) {
            // Remplacer les variables dans le contenu
            $page['content'] = replacePageVariables($page['content']);
            $page['title'] = replacePageVariables($page['title']);
            $page['meta_title'] = replacePageVariables($page['meta_title']);
            $page['meta_description'] = replacePageVariables($page['meta_description']);
        }
        
        $cache[$slug] = $page;
        return $page;
        
    } catch (PDOException $e) {
        error_log('Erreur récupération page ' . $slug . ': ' . $e->getMessage());
        return null;
    }
}

/**
 * Remplacer les variables dans le contenu
 * @param string $content Le contenu avec les variables
 * @return string Le contenu avec les variables remplacées
 */
function replacePageVariables($content) {
    if (!$content) return $content;
    
    static $variables = null;
    
    // Charger les variables depuis les paramètres du site
    if ($variables === null) {
        $variables = getSiteSettings();
    }
    
    // Variables prédéfinies
    $replacements = [
        '{{site_name}}' => $variables['site_name'] ?? 'SAFIR',
        '{{site_tagline}}' => $variables['site_tagline'] ?? 'Votre agence de voyage de confiance',
        '{{contact_email}}' => $variables['contact_email'] ?? 'contact@safir.cm',
        '{{contact_phone}}' => $variables['contact_phone'] ?? '+237 XXX XXX XXX',
        '{{address}}' => $variables['address'] ?? 'Cameroun',
        '{{facebook_url}}' => $variables['facebook_url'] ?? '',
        '{{instagram_url}}' => $variables['instagram_url'] ?? '',
        '{{whatsapp_number}}' => $variables['whatsapp_number'] ?? '',
        '{{current_year}}' => date('Y'),
        '{{current_date}}' => date('d/m/Y'),
    ];
    
    return str_replace(array_keys($replacements), array_values($replacements), $content);
}

/**
 * Charger les paramètres du site
 * @return array Les paramètres du site
 */
function getSiteSettings() {
    static $pdo = null;
    static $settings = null;
    
    // Cache des paramètres
    if ($settings !== null) {
        return $settings;
    }
    
    // Connexion à la base de données
    if ($pdo === null) {
        try {
            $pdo = new PDO(
                'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
                DB_USER,
                DB_PASS,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            error_log('Erreur connexion BDD settings: ' . $e->getMessage());
            return [];
        }
    }
    
    try {
        $stmt = $pdo->query("SELECT setting_key, setting_value FROM site_settings");
        $settings = [];
        
        while ($row = $stmt->fetch()) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        
        return $settings;
        
    } catch (PDOException $e) {
        error_log('Erreur récupération settings: ' . $e->getMessage());
        return [];
    }
}

/**
 * Charger les services actifs
 * @return array Liste des services
 */
function getActiveServices() {
    static $pdo = null;
    static $services = null;
    
    if ($services !== null) {
        return $services;
    }
    
    if ($pdo === null) {
        try {
            $pdo = new PDO(
                'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
                DB_USER,
                DB_PASS,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            return [];
        }
    }
    
    try {
        $stmt = $pdo->query("
            SELECT * FROM services 
            WHERE is_active = 1 
            ORDER BY sort_order, title
        ");
        $services = $stmt->fetchAll();
        return $services;
        
    } catch (PDOException $e) {
        return [];
    }
}

/**
 * Charger les encadreurs par ville
 * @return array Liste des encadreurs groupés par ville
 */
function getEncadreursByCity() {
    static $pdo = null;
    static $encadreurs = null;
    
    if ($encadreurs !== null) {
        return $encadreurs;
    }
    
    if ($pdo === null) {
        try {
            $pdo = new PDO(
                'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
                DB_USER,
                DB_PASS,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            return [];
        }
    }
    
    try {
        $stmt = $pdo->query("
            SELECT e.*, c.name as city_name
            FROM encadreurs e
            JOIN cities c ON e.city_id = c.id
            WHERE e.is_active = 1 AND c.is_active = 1
            ORDER BY c.name, e.full_name
        ");
        
        $result = [];
        while ($row = $stmt->fetch()) {
            $result[$row['city_name']][] = $row;
        }
        
        $encadreurs = $result;
        return $encadreurs;
        
    } catch (PDOException $e) {
        return [];
    }
}
?>