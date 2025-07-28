<?php
/**
 * Dashboard principal - SAFIR CMS
 */

$page_title = 'Dashboard';
require_once 'includes/header.php';

// Récupération des statistiques
try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    // Statistiques de base
    $stats = [];
    
    // Nombre total d'encadreurs
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM encadreurs WHERE is_active = 1");
    $stats['encadreurs'] = $stmt->fetch()['count'];
    
    // Nombre de réservations par statut
    $stmt = $pdo->query("SELECT status, COUNT(*) as count FROM reservations GROUP BY status");
    $reservations_stats = [];
    while ($row = $stmt->fetch()) {
        $reservations_stats[$row['status']] = $row['count'];
    }
    $stats['reservations_total'] = array_sum($reservations_stats);
    $stats['reservations_pending'] = $reservations_stats['pending'] ?? 0;
    $stats['reservations_confirmed'] = $reservations_stats['confirmed'] ?? 0;
    
    // Messages de contact non lus
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM contact_messages WHERE status = 'new'");
    $stats['messages_new'] = $stmt->fetch()['count'];
    
    // Services actifs
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM services WHERE is_active = 1");
    $stats['services'] = $stmt->fetch()['count'];
    
    // Réservations récentes (30 derniers jours)
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM reservations WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)");
    $stats['reservations_recent'] = $stmt->fetch()['count'];
    
    // Statistiques par ville
    $stmt = $pdo->query("
        SELECT c.name as city, COUNT(e.id) as encadreurs_count 
        FROM cities c 
        LEFT JOIN encadreurs e ON c.id = e.city_id AND e.is_active = 1 
        GROUP BY c.id, c.name 
        ORDER BY encadreurs_count DESC 
        LIMIT 5
    ");
    $cities_stats = $stmt->fetchAll();
    
    // Réservations récentes
    $stmt = $pdo->query("
        SELECT r.*, s.title as service_title, c.name as city_name
        FROM reservations r 
        LEFT JOIN services s ON r.service_id = s.id 
        LEFT JOIN encadreurs e ON r.id = e.id
        LEFT JOIN cities c ON e.city_id = c.id
        ORDER BY r.created_at DESC 
        LIMIT 5
    ");
    $recent_reservations = $stmt->fetchAll();
    
    // Messages récents
    $stmt = $pdo->query("
        SELECT * FROM contact_messages 
        ORDER BY created_at DESC 
        LIMIT 5
    ");
    $recent_messages = $stmt->fetchAll();
    
} catch (PDOException $e) {
    $stats = [
        'encadreurs' => 0,
        'reservations_total' => 0,
        'reservations_pending' => 0,
        'reservations_confirmed' => 0,
        'messages_new' => 0,
        'services' => 0,
        'reservations_recent' => 0
    ];
    $cities_stats = [];
    $recent_reservations = [];
    $recent_messages = [];
}
?>

<!-- Statistiques principales -->
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="info-box">
            <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Encadreurs</span>
                <span class="info-box-number"><?= number_format($stats['encadreurs']) ?></span>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="info-box">
            <span class="info-box-icon bg-success"><i class="fas fa-calendar-check"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Réservations</span>
                <span class="info-box-number"><?= number_format($stats['reservations_total']) ?></span>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="info-box">
            <span class="info-box-icon bg-warning"><i class="fas fa-envelope"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Nouveaux Messages</span>
                <span class="info-box-number"><?= number_format($stats['messages_new']) ?></span>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="info-box">
            <span class="info-box-icon bg-danger"><i class="fas fa-concierge-bell"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Services Actifs</span>
                <span class="info-box-number"><?= number_format($stats['services']) ?></span>
            </div>
        </div>
    </div>
</div>

<!-- Statistiques détaillées -->
<div class="row">
    <div class="col-md-8">
        <!-- Graphique des réservations -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-bar mr-1"></i>
                    Évolution des réservations
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="chart">
                    <canvas id="reservationsChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <!-- Répartition par statut -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-pie-chart mr-1"></i>
                    Statut des réservations
                </h3>
            </div>
            <div class="card-body">
                <div class="chart">
                    <canvas id="statusChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tableaux de données -->
<div class="row">
    <div class="col-md-6">
        <!-- Encadreurs par ville -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-map-marker-alt mr-1"></i>
                    Encadreurs par ville
                </h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Ville</th>
                            <th>Encadreurs</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cities_stats as $city): ?>
                        <tr>
                            <td><?= htmlspecialchars($city['city']) ?></td>
                            <td>
                                <span class="badge badge-info"><?= $city['encadreurs_count'] ?></span>
                            </td>
                            <td>
                                <a href="encadreurs.php?city=<?= urlencode($city['city']) ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <!-- Activité récente -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-clock mr-1"></i>
                    Activité récente
                </h3>
            </div>
            <div class="card-body">
                <div class="timeline timeline-inverse">
                    <?php foreach (array_slice($recent_reservations, 0, 3) as $reservation): ?>
                    <div class="time-label">
                        <span class="bg-success">
                            <?= date('d/m/Y', strtotime($reservation['created_at'])) ?>
                        </span>
                    </div>
                    <div>
                        <i class="fas fa-calendar bg-info"></i>
                        <div class="timeline-item">
                            <h3 class="timeline-header">
                                <strong><?= htmlspecialchars($reservation['client_name']) ?></strong>
                                a réservé <em><?= htmlspecialchars($reservation['service_title']) ?></em>
                            </h3>
                            <div class="timeline-body">
                                Référence: <?= htmlspecialchars($reservation['reference']) ?><br>
                                Statut: <span class="badge badge-warning"><?= ucfirst($reservation['status']) ?></span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    
                    <div>
                        <i class="far fa-clock bg-gray"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Messages récents -->
<?php if (!empty($recent_messages)): ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-envelope mr-1"></i>
                    Messages récents
                </h3>
                <div class="card-tools">
                    <a href="messages.php" class="btn btn-primary btn-sm">
                        <i class="fas fa-eye mr-1"></i>
                        Voir tous
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Sujet</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_messages as $message): ?>
                        <tr>
                            <td><?= date('d/m/Y H:i', strtotime($message['created_at'])) ?></td>
                            <td><?= htmlspecialchars($message['name']) ?></td>
                            <td><?= htmlspecialchars($message['email']) ?></td>
                            <td><?= htmlspecialchars(substr($message['subject'], 0, 50)) ?>...</td>
                            <td>
                                <?php
                                $badge_class = [
                                    'new' => 'badge-danger',
                                    'read' => 'badge-warning',
                                    'replied' => 'badge-success',
                                    'archived' => 'badge-secondary'
                                ];
                                $status_labels = [
                                    'new' => 'Nouveau',
                                    'read' => 'Lu',
                                    'replied' => 'Répondu',
                                    'archived' => 'Archivé'
                                ];
                                ?>
                                <span class="badge <?= $badge_class[$message['status']] ?? 'badge-secondary' ?>">
                                    <?= $status_labels[$message['status']] ?? $message['status'] ?>
                                </span>
                            </td>
                            <td>
                                <a href="messages.php?view=<?= $message['id'] ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
// Graphique des réservations (Chart.js sera ajouté plus tard)
$(document).ready(function() {
    // Placeholder pour les graphiques
    console.log('Dashboard chargé avec succès');
    
    // Actualiser les données toutes les 5 minutes
    setInterval(function() {
        location.reload();
    }, 300000);
});
</script>

<?php
$additional_js = '
<script>
    // JavaScript spécifique au dashboard
    console.log("Dashboard JavaScript chargé");
</script>
';

require_once 'includes/footer.php';
?>