<?php
/**
 * Template pour créer rapidement une nouvelle table - SAFIR CMS
 * Modifiez les variables ci-dessous selon vos besoins
 */

require_once 'includes/config.php';

// ======= CONFIGURATION DE LA TABLE =======
$table_name = 'ma_nouvelle_table';  // CHANGEZ ICI
$sql = "
CREATE TABLE IF NOT EXISTS {$table_name} (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL,
    description TEXT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    sort_order INT DEFAULT 0,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES admins(id) ON DELETE SET NULL
)";

// ======= EXÉCUTION =======
try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    $pdo->exec($sql);
    echo "✅ Table '{$table_name}' créée avec succès!\n";
    
    // Vérifier la structure
    $stmt = $pdo->query("DESCRIBE {$table_name}");
    echo "\n📋 Structure de la table :\n";
    while ($row = $stmt->fetch()) {
        echo "- {$row['Field']} ({$row['Type']})\n";
    }
    
} catch (PDOException $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
}
?>