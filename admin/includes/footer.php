            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Footer -->
    <footer class="main-footer">
        <strong>Copyright &copy; <?= date('Y') ?> <a href="../index.php">SAFIR</a>.</strong>
        Tous droits réservés.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0.0
        </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery avec fallback -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js" onerror="this.onerror=null;this.src='assets/js/jquery.min.js';"></script>
<!-- Bootstrap avec fallback -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" onerror="this.onerror=null;this.src='../js/bootstrap.min.js';"></script>
<!-- AdminLTE avec fallback -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js" onerror="this.onerror=null;this.src='assets/js/adminlte.min.js';"></script>

<!-- Script de base pour fonctionnalité minimale -->
<script>
// Fallback basique si jQuery ne charge pas
if (typeof jQuery === 'undefined') {
    document.addEventListener('DOMContentLoaded', function() {
        // Menu toggle pour mobile
        const menuToggle = document.querySelector('[data-widget="pushmenu"]');
        const sidebar = document.querySelector('.main-sidebar');
        
        if (menuToggle && sidebar) {
            menuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                sidebar.classList.toggle('show');
            });
        }
        
        // Fermer les alertes
        const alerts = document.querySelectorAll('.alert [data-dismiss="alert"]');
        alerts.forEach(function(alert) {
            alert.addEventListener('click', function() {
                this.closest('.alert').style.display = 'none';
            });
        });
    });
}
</script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Configuration globale des DataTables
    $.extend(true, $.fn.dataTable.defaults, {
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/French.json"
        },
        "responsive": true,
        "autoWidth": false,
        "pageLength": 25,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Tous"]],
        "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
               '<"row"<"col-sm-12"tr>>' +
               '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
    });
    
    // Actualiser les compteurs de notification
    updateNotificationCounts();
    
    // Actualiser toutes les 30 secondes
    setInterval(updateNotificationCounts, 30000);
    
    // Confirmation de suppression
    $('.btn-delete').on('click', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Cette action est irréversible !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Oui, supprimer !',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });
    
    // Auto-masquer les alertes après 5 secondes
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
});

function updateNotificationCounts() {
    $.ajax({
        url: 'ajax/notifications.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#messages-count').text(data.messages || 0);
            $('#notifications-count').text(data.reservations || 0);
            $('#sidebar-messages-count').text(data.messages || 0);
            $('#sidebar-reservations-count').text(data.reservations || 0);
            
            // Masquer les badges si zéro
            $('.navbar-badge, .badge').each(function() {
                if ($(this).text() == '0') {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
        },
        error: function() {
            console.log('Erreur lors de la mise à jour des notifications');
        }
    });
}

// Fonction pour afficher les messages de succès/erreur
function showAlert(type, message) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const icon = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-triangle';
    
    const alert = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            <i class="${icon} me-2"></i>
            ${message}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    `;
    
    $('.content-header').after(alert);
    
    // Auto-masquer après 5 secondes
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
}

// Fonction pour formater les nombres
function formatNumber(num) {
    return new Intl.NumberFormat('fr-FR').format(num);
}

// Fonction pour formater les dates
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('fr-FR', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}
</script>

<?php if (isset($additional_js)): ?>
    <?= $additional_js ?>
<?php endif; ?>

</body>
</html>