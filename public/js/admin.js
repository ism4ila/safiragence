// JavaScript pour l'administration SAFIR
document.addEventListener('DOMContentLoaded', function() {
    
    // Auto-hide alerts après 5 secondes
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    // Confirmation de suppression
    const deleteButtons = document.querySelectorAll('button[type="submit"]');
    deleteButtons.forEach(button => {
        const form = button.closest('form');
        if (form && form.method === 'POST' && form.querySelector('input[name="_method"][value="DELETE"]')) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                const confirmMessage = 'Êtes-vous sûr de vouloir supprimer cet élément ? Cette action est irréversible.';
                
                if (confirm(confirmMessage)) {
                    form.submit();
                }
            });
        }
    });

    // Toggle sidebar - Réduire/Agrandir le menu
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.querySelector('.sidebar');
    const adminContainer = document.querySelector('.admin-container');
    
    if (sidebarToggle && sidebar) {
        // Récupérer l'état du localStorage
        const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        if (isCollapsed) {
            sidebar.classList.add('collapsed');
            adminContainer.classList.add('sidebar-collapsed');
            sidebarToggle.querySelector('i').classList.replace('bi-chevron-left', 'bi-chevron-right');
        }
        
        sidebarToggle.addEventListener('click', function() {
            const isCurrentlyCollapsed = sidebar.classList.contains('collapsed');
            
            if (isCurrentlyCollapsed) {
                // Agrandir
                sidebar.classList.remove('collapsed');
                adminContainer.classList.remove('sidebar-collapsed');
                sidebarToggle.querySelector('i').classList.replace('bi-chevron-right', 'bi-chevron-left');
                localStorage.setItem('sidebarCollapsed', 'false');
            } else {
                // Réduire
                sidebar.classList.add('collapsed');
                adminContainer.classList.add('sidebar-collapsed');
                sidebarToggle.querySelector('i').classList.replace('bi-chevron-left', 'bi-chevron-right');
                localStorage.setItem('sidebarCollapsed', 'true');
            }
        });
        
        // Toggle pour mobile (comportement différent)
        if (window.innerWidth <= 768) {
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('show');
            });
            
            // Fermer sidebar en cliquant à l'extérieur sur mobile
            document.addEventListener('click', function(e) {
                if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                    sidebar.classList.remove('show');
                }
            });
        }
    }

    // Animation des liens du menu au hover
    const navLinks = document.querySelectorAll('.admin-nav .nav-link');
    navLinks.forEach(link => {
        link.addEventListener('mouseenter', function() {
            if (!sidebar.classList.contains('collapsed')) {
                this.style.transform = 'translateX(4px)';
            }
        });
        
        link.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });

    // Animation des boutons au hover
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-1px)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Validation des formulaires
    const forms = document.querySelectorAll('.needs-validation');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });

    // Recherche en temps réel dans les tableaux
    const searchInputs = document.querySelectorAll('.table-search');
    searchInputs.forEach(searchInput => {
        const table = searchInput.dataset.target ? document.querySelector(searchInput.dataset.target) : searchInput.closest('.card').querySelector('table');
        
        if (table) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const rows = table.querySelectorAll('tbody tr');
                
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            });
        }
    });

    // Tri des colonnes de tableau
    const sortableHeaders = document.querySelectorAll('.sortable');
    sortableHeaders.forEach(header => {
        header.style.cursor = 'pointer';
        header.innerHTML += ' <i class="bi bi-arrow-down-up ms-1"></i>';
        
        header.addEventListener('click', function() {
            const table = this.closest('table');
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));
            const cellIndex = Array.from(this.parentNode.children).indexOf(this);
            
            const isAscending = this.classList.contains('asc');
            
            // Réinitialiser tous les headers
            sortableHeaders.forEach(h => h.classList.remove('asc', 'desc'));
            
            // Marquer le header actuel
            this.classList.add(isAscending ? 'desc' : 'asc');
            
            rows.sort((a, b) => {
                const aText = a.children[cellIndex].textContent.trim();
                const bText = b.children[cellIndex].textContent.trim();
                
                // Essayer de comparer comme nombres d'abord
                const aNum = parseFloat(aText);
                const bNum = parseFloat(bText);
                
                if (!isNaN(aNum) && !isNaN(bNum)) {
                    return isAscending ? bNum - aNum : aNum - bNum;
                }
                
                // Sinon comparer comme texte
                return isAscending ? bText.localeCompare(aText) : aText.localeCompare(bText);
            });
            
            rows.forEach(row => tbody.appendChild(row));
        });
    });

    // Tooltips Bootstrap
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Popovers Bootstrap
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });

    // Prévisualisation d'images
    const imageInputs = document.querySelectorAll('input[type="file"][accept*="image"]');
    imageInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    let preview = input.parentNode.querySelector('.image-preview');
                    if (!preview) {
                        preview = document.createElement('img');
                        preview.className = 'image-preview mt-2';
                        preview.style.maxWidth = '200px';
                        preview.style.maxHeight = '200px';
                        preview.style.objectFit = 'cover';
                        preview.style.borderRadius = '8px';
                        input.parentNode.appendChild(preview);
                    }
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    });

    // Compteur de caractères pour les textareas
    const textareas = document.querySelectorAll('textarea[maxlength]');
    textareas.forEach(textarea => {
        const maxLength = textarea.getAttribute('maxlength');
        const counter = document.createElement('small');
        counter.className = 'text-muted';
        counter.style.float = 'right';
        textarea.parentNode.appendChild(counter);
        
        const updateCounter = () => {
            const remaining = maxLength - textarea.value.length;
            counter.textContent = `${remaining} caractères restants`;
            counter.style.color = remaining < 50 ? '#E74C3C' : '#6C757D';
        };
        
        textarea.addEventListener('input', updateCounter);
        updateCounter();
    });

    // Animation des cartes au chargement
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.3s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });

    console.log('SAFIR Admin JS chargé avec succès');
});