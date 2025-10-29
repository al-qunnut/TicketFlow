// Toast notification function
function showToast(message, type = 'success') {
    // Remove existing toast if any
    const existingToast = document.getElementById('toast');
    if (existingToast) {
        existingToast.remove();
    }
    
    // Create new toast
    const toast = document.createElement('div');
    toast.id = 'toast';
    toast.className = `toast toast-${type}`;
    toast.textContent = message;
    
    document.body.appendChild(toast);
    
    // Auto remove after 4 seconds
    setTimeout(() => {
        toast.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 4000);
}

// Add slideOut animation
const style = document.createElement('style');
style.textContent = `
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

// Auto-hide flash messages
document.addEventListener('DOMContentLoaded', () => {
    const toast = document.getElementById('toast');
    if (toast) {
        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 4000);
    }
});

// Form validation helper
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return true;
    
    let isValid = true;
    const inputs = form.querySelectorAll('[required]');
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            isValid = false;
            input.classList.add('error');
            const errorEl = document.getElementById(input.id + '-error');
            if (errorEl) {
                errorEl.textContent = 'This field is required';
            }
        } else {
            input.classList.remove('error');
            const errorEl = document.getElementById(input.id + '-error');
            if (errorEl) {
                errorEl.textContent = '';
            }
        }
    });
    
    return isValid;
}

// Clear error on input
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('error');
            const errorEl = document.getElementById(this.id + '-error');
            if (errorEl) {
                errorEl.textContent = '';
            }
        });
    });
});

// Mobile menu toggle (if needed)
function toggleMobileMenu() {
    const nav = document.querySelector('.navbar-nav');
    if (nav) {
        nav.classList.toggle('mobile-open');
    }
}

// Confirm before leaving page with unsaved changes
let formChanged = false;

document.addEventListener('DOMContentLoaded', () => {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('change', () => {
            formChanged = true;
        });
        
        form.addEventListener('submit', () => {
            formChanged = false;
        });
    });
});

window.addEventListener('beforeunload', (e) => {
    if (formChanged) {
        e.preventDefault();
        e.returnValue = '';
    }
});

// Keyboard shortcuts
document.addEventListener('keydown', (e) => {
    // Ctrl/Cmd + K for search (future feature)
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        // Open search modal
    }
    
    // ESC to close modals
    if (e.key === 'Escape') {
        const modals = document.querySelectorAll('.modal-overlay');
        modals.forEach(modal => {
            modal.style.display = 'none';
        });
    }
});

// Accessibility: Skip to main content
document.addEventListener('DOMContentLoaded', () => {
    const skipLink = document.createElement('a');
    skipLink.href = '#main';
    skipLink.className = 'sr-only';
    skipLink.textContent = 'Skip to main content';
    skipLink.style.cssText = `
        position: absolute;
        top: -40px;
        left: 0;
        background: var(--primary-color);
        color: white;
        padding: 8px;
        text-decoration: none;
        z-index: 100;
    `;
    skipLink.addEventListener('focus', function() {
        this.style.top = '0';
    });
    skipLink.addEventListener('blur', function() {
        this.style.top = '-40px';
    });
    document.body.insertBefore(skipLink, document.body.firstChild);
});

// Console welcome message
console.log('%c🎫 TicketFlow', 'font-size: 24px; font-weight: bold; color: #4F46E5;');
console.log('%cWelcome to TicketFlow - Modern Ticket Management System', 'font-size: 14px; color: #6B7280;');
