<?php
/**
 * Helper pour charger le contenu des services depuis la BDD - SAFIR CMS
 */

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
 * Charger un service depuis la base de données
 * @param string $slug Le slug du service (ex: 'hadj', 'oumra', 'voyages')
 * @return array|null Les données du service ou null si introuvable
 */
function getServiceContent($slug) {
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
            error_log('Erreur connexion BDD service_content: ' . $e->getMessage());
            return null;
        }
    }
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM services WHERE slug = ? AND is_active = 1");
        $stmt->execute([$slug]);
        $service = $stmt->fetch();
        
        if ($service) {
            // Remplacer les variables dans le contenu
            $service['description'] = replaceServiceVariables($service['description']);
            $service['short_description'] = replaceServiceVariables($service['short_description']);
            $service['title'] = replaceServiceVariables($service['title']);
            $service['meta_title'] = replaceServiceVariables($service['meta_title']);
            $service['meta_description'] = replaceServiceVariables($service['meta_description']);
            
            // Traiter la galerie JSON
            if ($service['gallery']) {
                $service['gallery_images'] = json_decode($service['gallery'], true) ?: [];
            } else {
                $service['gallery_images'] = [];
            }
        }
        
        $cache[$slug] = $service;
        return $service;
        
    } catch (PDOException $e) {
        error_log('Erreur récupération service ' . $slug . ': ' . $e->getMessage());
        return null;
    }
}

/**
 * Charger tous les services actifs
 * @param bool $featured_only Charger seulement les services en vedette
 * @return array Liste des services
 */
function getAllServices($featured_only = false) {
    static $pdo = null;
    static $cache = [];
    
    $cache_key = $featured_only ? 'featured' : 'all';
    
    if (isset($cache[$cache_key])) {
        return $cache[$cache_key];
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
        $sql = "SELECT * FROM services WHERE is_active = 1";
        if ($featured_only) {
            $sql .= " AND is_featured = 1";
        }
        $sql .= " ORDER BY sort_order, title";
        
        $stmt = $pdo->query($sql);
        $services = $stmt->fetchAll();
        
        // Traiter chaque service
        foreach ($services as &$service) {
            $service['description'] = replaceServiceVariables($service['description']);
            $service['short_description'] = replaceServiceVariables($service['short_description']);
            
            if ($service['gallery']) {
                $service['gallery_images'] = json_decode($service['gallery'], true) ?: [];
            } else {
                $service['gallery_images'] = [];
            }
        }
        
        $cache[$cache_key] = $services;
        return $services;
        
    } catch (PDOException $e) {
        return [];
    }
}

/**
 * Remplacer les variables dans le contenu des services
 * @param string $content Le contenu avec les variables
 * @return string Le contenu avec les variables remplacées
 */
function replaceServiceVariables($content) {
    if (!$content) return $content;
    
    static $variables = null;
    
    // Charger les variables depuis les paramètres du site
    if ($variables === null) {
        $variables = getSiteSettings();
    }
    
    // Variables spécifiques aux services
    $replacements = [
        '{{site_name}}' => $variables['site_name'] ?? 'SAFIR',
        '{{contact_email}}' => $variables['contact_email'] ?? 'contact@safir.cm',
        '{{contact_phone}}' => $variables['contact_phone'] ?? '+237 XXX XXX XXX',
        '{{whatsapp_number}}' => $variables['whatsapp_number'] ?? '',
        '{{current_year}}' => date('Y'),
    ];
    
    return str_replace(array_keys($replacements), array_values($replacements), $content);
}

/**
 * Générer le schéma JSON-LD pour un service
 * @param array $service Les données du service
 * @return string Le JSON-LD
 */
function generateServiceSchema($service) {
    if (!$service) return '';
    
    $settings = getSiteSettings();
    
    $schema = [
        "@context" => "https://schema.org",
        "@type" => "Service",
        "name" => $service['title'],
        "description" => strip_tags($service['short_description'] ?: $service['description']),
        "provider" => [
            "@type" => "TravelAgency",
            "name" => $settings['site_name'] ?? 'SAFIR',
            "url" => "https://" . $_SERVER['HTTP_HOST'],
            "telephone" => $settings['contact_phone'] ?? '',
            "email" => $settings['contact_email'] ?? ''
        ]
    ];
    
    if ($service['price']) {
        $schema['offers'] = [
            "@type" => "Offer",
            "price" => $service['price'],
            "priceCurrency" => "XAF"
        ];
    }
    
    if ($service['featured_image']) {
        $schema['image'] = "https://" . $_SERVER['HTTP_HOST'] . "/uploads/services/" . $service['featured_image'];
    }
    
    return json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

/**
 * Construire les méta tags pour un service
 * @param array $service Les données du service
 * @return array Les méta tags
 */
function getServiceMetaTags($service) {
    if (!$service) return [];
    
    $settings = getSiteSettings();
    $base_url = "https://" . $_SERVER['HTTP_HOST'];
    
    return [
        'title' => $service['meta_title'] ?: $service['title'] . ' - ' . ($settings['site_name'] ?? 'SAFIR'),
        'description' => $service['meta_description'] ?: strip_tags($service['short_description'] ?: $service['description']),
        'keywords' => $service['meta_keywords'] ?? '',
        'og_title' => $service['title'],
        'og_description' => strip_tags($service['short_description'] ?: $service['description']),
        'og_image' => $service['featured_image'] ? $base_url . "/uploads/services/" . $service['featured_image'] : '',
        'og_url' => $base_url . "/service_" . $service['slug'] . ".php"
    ];
}
?>