<?php
/**
 * Script d'initialisation des paramètres par défaut - SAFIR CMS
 * À exécuter une seule fois pour créer les paramètres de base
 */

require_once '../includes/config.php';

try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    // Paramètres par défaut à insérer
    $default_settings = [
        // Paramètres généraux
        ['site_name', 'SAFIR', 'text', 'general', 'Nom du site web', 1],
        ['site_tagline', 'Votre agence de voyage de confiance', 'text', 'general', 'Slogan du site', 1],
        ['site_description', 'Agence SAFIR spécialisée dans l\'organisation du HADJ et OUMRA, vente de billets d\'avion, voyages d\'affaires et tourisme.', 'textarea', 'general', 'Description générale du site', 1],
        ['site_logo', '', 'text', 'general', 'URL du logo principal', 1],
        ['site_favicon', '', 'text', 'general', 'URL du favicon', 1],
        
        // Contact
        ['contact_email', 'contact@safir.cm', 'email', 'contact', 'Email principal de contact', 1],
        ['contact_phone', '+237 XXX XXX XXX', 'text', 'contact', 'Téléphone principal', 1],
        ['contact_phone_2', '', 'text', 'contact', 'Téléphone secondaire', 1],
        ['address', 'Cameroun', 'textarea', 'contact', 'Adresse complète', 1],
        ['opening_hours', 'Lundi - Vendredi: 8h00 - 17h00', 'textarea', 'contact', 'Horaires d\'ouverture', 1],
        
        // Réseaux sociaux
        ['facebook_url', '', 'url', 'social', 'URL de la page Facebook', 1],
        ['instagram_url', '', 'url', 'social', 'URL du compte Instagram', 1],
        ['twitter_url', '', 'url', 'social', 'URL du compte Twitter', 1],
        ['linkedin_url', '', 'url', 'social', 'URL du profil LinkedIn', 1],
        ['youtube_url', '', 'url', 'social', 'URL de la chaîne YouTube', 1],
        ['whatsapp_number', '', 'text', 'social', 'Numéro WhatsApp (format international)', 1],
        
        // SEO
        ['meta_title', 'SAFIR - Agence de voyages et de tourisme', 'text', 'seo', 'Titre par défaut pour le SEO', 1],
        ['meta_description', 'Agence SAFIR spécialisée dans l\'organisation du HADJ et OUMRA, vente de billets d\'avion, voyages d\'affaires et tourisme au Cameroun.', 'textarea', 'seo', 'Description par défaut pour le SEO', 1],
        ['meta_keywords', 'SAFIR, voyage, tourisme, HADJ, OUMRA, pèlerinage, billets avion, Cameroun', 'text', 'seo', 'Mots-clés par défaut', 1],
        ['google_analytics', '', 'text', 'seo', 'Code Google Analytics (GA4)', 1],
        ['google_site_verification', '', 'text', 'seo', 'Code de vérification Google Search Console', 1],
        
        // Email
        ['smtp_host', '', 'text', 'email', 'Serveur SMTP', 1],
        ['smtp_port', '587', 'number', 'email', 'Port SMTP', 1],
        ['smtp_username', '', 'text', 'email', 'Nom d\'utilisateur SMTP', 1],
        ['smtp_password', '', 'text', 'email', 'Mot de passe SMTP', 1],
        ['smtp_encryption', 'tls', 'text', 'email', 'Chiffrement SMTP (tls/ssl)', 1],
        
        // Avancé
        ['maintenance_mode', '0', 'boolean', 'advanced', 'Mode maintenance du site', 1],
        ['cache_enabled', '1', 'boolean', 'advanced', 'Activer le cache', 1],
        ['debug_mode', '0', 'boolean', 'advanced', 'Mode debug (développement uniquement)', 1],
        ['max_upload_size', '10', 'number', 'advanced', 'Taille max upload en MB', 1],
        ['timezone', 'Africa/Douala', 'text', 'advanced', 'Fuseau horaire', 1]
    ];
    
    $inserted = 0;
    $skipped = 0;
    
    foreach ($default_settings as $setting) {
        // Vérifier si le paramètre existe déjà
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM site_settings WHERE setting_key = ?");
        $stmt->execute([$setting[0]]);
        
        if ($stmt->fetchColumn() == 0) {
            // Insérer le nouveau paramètre
            $stmt = $pdo->prepare("
                INSERT INTO site_settings 
                (setting_key, setting_value, setting_type, setting_group, description, is_editable) 
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute($setting);
            $inserted++;
        } else {
            $skipped++;
        }
    }
    
    echo "✅ Initialisation des paramètres terminée !\n";
    echo "📊 $inserted paramètres ajoutés\n";
    echo "⚠️  $skipped paramètres déjà existants\n";
    echo "\n🔗 Accès admin : http://localhost/safir/admin/settings.php\n";
    
} catch (PDOException $e) {
    echo "❌ Erreur : " . $e->getMessage() . "\n";
}
?>