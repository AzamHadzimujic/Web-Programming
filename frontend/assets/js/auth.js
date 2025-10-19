// Auth page functionality
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    const profileSection = document.getElementById('profile-section');
    
    // Register form submission
    registerForm?.addEventListener('submit', function(e) {
        e.preventDefault();
        const username = document.getElementById('register-username').value;
        const email = document.getElementById('register-email').value;
        const password = document.getElementById('register-password').value;
        alert('Registered successfully! Please login with your new account.');
        registerForm.classList.add('hidden');
        loginForm.classList.remove('hidden');
        registerForm.reset();
    });

    // Login form submission
    loginForm?.addEventListener('submit', function(e) {
        e.preventDefault();
        const email = document.getElementById('login-email').value;
        const password = document.getElementById('login-password').value;
    });

    // Logout functionality
    document.getElementById('logout-btn')?.addEventListener('click', function() {
        loginForm.reset();
    });
});