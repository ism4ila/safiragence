import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    // Enhanced UX interactions
    initializeAnimations();
    initializeFormEnhancements();
    initializeButtonEffects();
    initializeNavigation();
    initializeToasts();
    initializeLoading();
});

// Animation system
function initializeAnimations() {
    const animatedItems = document.querySelectorAll('.service-card, .gallery-item, .form-container, .card');
    
    const observer = new IntersectionObserver(entries => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.classList.add('fade-in-up');
                }, index * 100);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '-50px'
    });

    animatedItems.forEach(item => {
        observer.observe(item);
    });
}

// Enhanced form interactions
function initializeFormEnhancements() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        // Add floating labels
        const formControls = form.querySelectorAll('.form-control');
        formControls.forEach(control => {
            const label = control.previousElementSibling;
            if (label && label.tagName === 'LABEL') {
                const wrapper = document.createElement('div');
                wrapper.className = 'form-floating mb-3';
                control.parentNode.insertBefore(wrapper, control);
                wrapper.appendChild(control);
                wrapper.appendChild(label);
                control.setAttribute('placeholder', ' ');
            }
        });

        // Form validation feedback - only for contact forms specifically
        // Exclude admin forms, auth forms, and gallery forms
        const isAdminForm = form.action && form.action.includes('/safir/');
        const isAuthForm = form.id === 'loginForm' || (form.action && form.action.includes('/login'));
        const isGalleryForm = form.id === 'galleryForm';
        const hasFormSpecificScript = form.querySelector('script') || form.parentNode.querySelector('script');
        
        if (!isAdminForm && !isAuthForm && !isGalleryForm && !hasFormSpecificScript &&
            (form.classList.contains('contact-form') || 
            (form.action && form.action.includes('/contact')) ||
            (form.querySelector('#message') && form.querySelector('#name') && form.querySelector('#email')))) {
            
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.classList.add('btn-loading');
                    submitBtn.disabled = true;
                    
                    // Simulate form processing
                    setTimeout(() => {
                        submitBtn.classList.remove('btn-loading');
                        submitBtn.disabled = false;
                        showToast('Votre message a été envoyé avec succès !', 'success');
                    }, 2000);
                }
            });
        }

        // Real-time validation
        const inputs = form.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.addEventListener('blur', validateInput);
            input.addEventListener('input', clearValidation);
        });
        
        // Character counter for textarea
        const messageField = form.querySelector('#message');
        const charCount = form.querySelector('#char-count');
        if (messageField && charCount) {
            messageField.addEventListener('input', (e) => {
                const count = e.target.value.length;
                charCount.textContent = count;
                
                if (count > 500) {
                    charCount.classList.add('text-danger');
                } else {
                    charCount.classList.remove('text-danger');
                }
            });
        }
    });
}

// Input validation
function validateInput(e) {
    const input = e.target;
    const value = input.value.trim();
    
    // Remove existing feedback
    const existingFeedback = input.parentNode.querySelector('.invalid-feedback');
    if (existingFeedback) {
        existingFeedback.remove();
    }
    
    input.classList.remove('is-valid', 'is-invalid');
    
    // Validate based on input type
    let isValid = true;
    let message = '';
    
    if (input.hasAttribute('required') && !value) {
        isValid = false;
        message = 'Ce champ est requis';
    } else if (input.type === 'email' && value && !isValidEmail(value)) {
        isValid = false;
        message = 'Veuillez entrer une adresse email valide';
    } else if (input.type === 'tel' && value && !isValidPhone(value)) {
        isValid = false;
        message = 'Veuillez entrer un numéro de téléphone valide';
    }
    
    if (isValid && value) {
        input.classList.add('is-valid');
    } else if (!isValid) {
        input.classList.add('is-invalid');
        const feedback = document.createElement('div');
        feedback.className = 'invalid-feedback';
        feedback.textContent = message;
        input.parentNode.appendChild(feedback);
    }
}

function clearValidation(e) {
    const input = e.target;
    input.classList.remove('is-valid', 'is-invalid');
    const feedback = input.parentNode.querySelector('.invalid-feedback');
    if (feedback) {
        feedback.remove();
    }
}

function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function isValidPhone(phone) {
    return /^[\+]?[0-9\s\-\(\)]{10,}$/.test(phone);
}

// Button effects
function initializeButtonEffects() {
    const buttons = document.querySelectorAll('.btn');
    
    buttons.forEach(button => {
        button.classList.add('btn-ripple');
        
        button.addEventListener('mousedown', (e) => {
            const rect = button.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const ripple = document.createElement('span');
            ripple.className = 'ripple';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            
            button.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
}

// Enhanced navigation
function initializeNavigation() {
    const navbar = document.querySelector('.navbar');
    const navLinks = document.querySelectorAll('.nav-link');
    
    // Active link highlighting
    const currentPage = window.location.pathname.split('/').pop();
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href === currentPage || (currentPage === '' && href === 'index.php')) {
            link.classList.add('active');
        }
    });
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Navbar scroll effect
    let lastScrollTop = 0;
    window.addEventListener('scroll', () => {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        if (scrollTop > lastScrollTop && scrollTop > 100) {
            navbar.style.transform = 'translateY(-100%)';
        } else {
            navbar.style.transform = 'translateY(0)';
        }
        
        lastScrollTop = scrollTop;
    });
}

// Toast notifications
function initializeToasts() {
    // Create toast container if it doesn't exist
    if (!document.querySelector('.toast-container')) {
        const container = document.createElement('div');
        container.className = 'toast-container';
        document.body.appendChild(container);
    }
}

function showToast(message, type = 'success') {
    const container = document.querySelector('.toast-container');
    const toast = document.createElement('div');
    toast.className = `toast toast-${type} show`;
    toast.setAttribute('role', 'alert');
    
    toast.innerHTML = `
        <div class="toast-body d-flex align-items-center">
            <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="toast"></button>
        </div>
    `;
    
    container.appendChild(toast);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        toast.classList.add('fade');
        setTimeout(() => {
            toast.remove();
        }, 300);
    }, 5000);
    
    // Manual close
    const closeBtn = toast.querySelector('.btn-close');
    closeBtn.addEventListener('click', () => {
        toast.classList.add('fade');
        setTimeout(() => {
            toast.remove();
        }, 300);
    });
}

// Loading system
function initializeLoading() {
    // Create loading overlay
    const loadingOverlay = document.createElement('div');
    loadingOverlay.className = 'loading-overlay';
    loadingOverlay.innerHTML = '<div class="loading-spinner"></div>';
    document.body.appendChild(loadingOverlay);
}

function showLoading() {
    const overlay = document.querySelector('.loading-overlay');
    overlay.classList.add('show');
}

function hideLoading() {
    const overlay = document.querySelector('.loading-overlay');
    overlay.classList.remove('show');
}

// Utility functions
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Export functions for global use
window.showToast = showToast;
window.showLoading = showLoading;
window.hideLoading = hideLoading;

// Gallery page specific logic
if (document.querySelector('.gallery-grid')) {
    initializeGallery();
}

function initializeGallery() {
    const filters = document.querySelectorAll('.gallery-filters .nav-link');
    const grid = document.querySelector('.gallery-grid');
    const items = Array.from(grid.querySelectorAll('.gallery-item'));
    const loadMoreBtn = document.querySelector('#loadMoreBtn');
    const modal = new bootstrap.Modal(document.getElementById('imageModal'));
    const modalImage = document.getElementById('modalImage');
    const modalTitle = document.getElementById('modalTitle');
    
    let currentFilter = 'all';
    let visibleItems = 8;
    
    // Filter logic
    filters.forEach(filter => {
        filter.addEventListener('click', (e) => {
            e.preventDefault();
            filters.forEach(f => f.classList.remove('active'));
            e.target.classList.add('active');
            currentFilter = e.target.dataset.filter;
            applyFilter();
        });
    });
    
    // Load more logic
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', () => {
            visibleItems += 4;
            applyFilter();
        });
    }
    
    // Modal logic
    grid.addEventListener('click', (e) => {
        const target = e.target.closest('.gallery-btn');
        if (target) {
            const card = target.closest('.gallery-card');
            const image = card.querySelector('.gallery-image');
            const title = card.querySelector('.gallery-info h5');
            
            modalImage.src = image.src;
            modalTitle.textContent = title.textContent;
            modal.show();
        }
    });
    
    function applyFilter() {
        let filteredItems = items;
        
        if (currentFilter !== 'all') {
            filteredItems = items.filter(item => item.dataset.category === currentFilter);
        }
        
        items.forEach(item => item.style.display = 'none');
        
        filteredItems.slice(0, visibleItems).forEach(item => {
            item.style.display = 'block';
        });
        
        if (loadMoreBtn) {
            if (visibleItems >= filteredItems.length) {
                loadMoreBtn.style.display = 'none';
            } else {
                loadMoreBtn.style.display = 'block';
            }
        }
    }
    
    // Initial filter
    applyFilter();
}

$(document).ready(function() {
    $('.card').hover(function() {
        $(this).addClass('shadow-lg').css('cursor', 'pointer'); 
    }, function() {
        $(this).removeClass('shadow-lg');
    });
});
