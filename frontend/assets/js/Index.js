document.addEventListener('DOMContentLoaded', function() {
    const navToggle = document.querySelector('.nav-toggle');
    const navLinks = document.querySelector('.nav-links');
    const overlay = document.querySelector('.sidebar-overlay');
    const body = document.body;
    
    function toggleSidebar() {
        navToggle.classList.toggle('active');
        navLinks.classList.toggle('active');
        overlay.classList.toggle('active');
        body.classList.toggle('sidebar-open');
    }
    
    navToggle.addEventListener('click', toggleSidebar);
    
    // Close sidebar when clicking on overlay
    overlay.addEventListener('click', toggleSidebar);
    
    // Close sidebar when clicking on a link (optional)
    const navItems = document.querySelectorAll('.nav-links a');
    navItems.forEach(item => {
        item.addEventListener('click', function() {
            if (window.innerWidth <= 480) {
                toggleSidebar();
            }
        });
    });
    
    // Close sidebar on window resize if it becomes larger than 480px
    window.addEventListener('resize', function() {
        if (window.innerWidth > 480) {
            navToggle.classList.remove('active');
            navLinks.classList.remove('active');
            overlay.classList.remove('active');
            body.classList.remove('sidebar-open');
        }
    });
});