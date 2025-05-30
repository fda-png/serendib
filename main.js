// Mobile Menu Toggle
const menuToggle = document.getElementById('menuToggle');
const mobileMenu = document.getElementById('mobileMenu');
const mobileOverlay = document.getElementById('mobileOverlay');

if (menuToggle) {
    menuToggle.addEventListener('click', () => {
        mobileMenu.classList.toggle('active');
        mobileOverlay.classList.toggle('active');
    });
    
    mobileOverlay.addEventListener('click', () => {
        mobileMenu.classList.remove('active');
        mobileOverlay.classList.remove('active');
    });
}

// Form Validation
function validateForm(form) {
    let valid = true;
    form.querySelectorAll('.form-input').forEach(input => {
        if (!input.value.trim()) {
            showAlert(`Please fill in ${input.previousElementSibling.textContent}`, 'error');
            valid = false;
        }
    });
    return valid;
}

// Alert System
function showAlert(message, type) {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;
    
    const alert = document.createElement('div');
    alert.className = `alert alert-${type}`;
    alert.innerHTML = `
        <div style="padding: 15px 20px; background: ${type === 'success' ? 'rgba(0, 200, 83, 0.15)' : 'rgba(255, 87, 87, 0.15)'}; 
            border-radius: var(--border-radius); 
            border: 1px solid ${type === 'success' ? 'rgba(0, 200, 83, 0.3)' : 'rgba(255, 87, 87, 0.3)'};
            backdrop-filter: var(--glass-blur);
            display: flex;
            align-items: center;
            gap: 12px;
            max-width: 300px;
            animation: fadeInUp 0.4s ease forwards;
        ">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}" 
               style="font-size: 20px; color: ${type === 'success' ? '#00c853' : '#ff5252'}"></i>
            <span>${message}</span>
        </div>
    `;
    
    alertContainer.appendChild(alert);
    
    setTimeout(() => {
        alert.style.animation = 'fadeOut 0.4s ease forwards';
        setTimeout(() => alert.remove(), 400);
    }, 4000);
}

// Initialize animations
document.addEventListener('DOMContentLoaded', () => {
    // Scroll animations
    const fadeElements = document.querySelectorAll('.fade-in');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'fadeInUp 0.8s ease forwards';
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    
    fadeElements.forEach(el => observer.observe(el));
    
    // Form submissions
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) e.preventDefault();
        });
    });
    
    // Gallery interactions
    document.querySelectorAll('.reaction-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const icon = this.querySelector('i');
            if (icon.classList.contains('fa-heart')) {
                icon.classList.replace('fa-heart', 'fa-heart-circle-check');
            } else {
                icon.classList.replace('fa-heart-circle-check', 'fa-heart');
            }
        });
    });
});