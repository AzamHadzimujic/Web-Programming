// Activities page functionality
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('activity-form');
    const activityList = document.getElementById('activities-list');
    
    // Load activities from localStorage
    loadActivities();
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const type = document.getElementById('activity-type').value;
        const duration = document.getElementById('activity-duration').value;
        const distance = document.getElementById('activity-distance').value;
    });
});