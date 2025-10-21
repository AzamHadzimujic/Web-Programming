// Blog page functionality
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('blog-form');
    const postsContainer = document.getElementById('posts-container');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const title = document.getElementById('post-title').value;
        const content = document.getElementById('post-content').value;
    });
});