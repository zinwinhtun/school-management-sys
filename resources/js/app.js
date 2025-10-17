// Simple Bootstrap import - remove all manual initialization
import 'bootstrap';

console.log('Bootstrap JavaScript loaded successfully');

// Just a simple DOM ready check
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded');
    console.log('Bootstrap version:', bootstrap ? 'Loaded' : 'Not loaded');
});