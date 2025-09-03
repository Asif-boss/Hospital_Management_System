document.addEventListener('DOMContentLoaded', function() {
    // login/register tab switching
    initTabSwitching();
});


function initTabSwitching() {
    const tabButtons = document.querySelectorAll('.tab-btn');
    const forms = document.querySelectorAll('.auth-form');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tabType = this.getAttribute('data-tab');
            
            // Update active tab
            tabButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Show corresponding form
            forms.forEach(form => {
                form.classList.remove('active');
                if (form.id === tabType + 'Form') {
                    form.classList.add('active');
                }
            });
        });
    });
}