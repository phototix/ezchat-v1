document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');

    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            let isValid = true;

            const inputs = form.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                // Check for required fields
                if (input.hasAttribute('required') && !input.value) {
                    isValid = false;
                    showValidationError(input, 'This field is required.');
                } else {
                    clearValidationError(input);
                }
                
                // Example: Add more specific validation rules here
                if (input.type === 'email' && input.value && !validateEmail(input.value)) {
                    isValid = false;
                    showValidationError(input, 'Invalid email format.');
                } else {
                    clearValidationError(input);
                }
            });

            if (!isValid) {
                event.preventDefault(); // Prevent form submission if validation fails
            }
        });
    });

    function showValidationError(input, message) {
        let error = input.nextElementSibling;
        if (!error || !error.classList.contains('error-message')) {
            error = document.createElement('div');
            error.className = 'error-message';
            input.parentNode.insertBefore(error, input.nextSibling);
        }
        error.textContent = message;
    }

    function clearValidationError(input) {
        const error = input.nextElementSibling;
        if (error && error.classList.contains('error-message')) {
            error.remove();
        }
    }

    function validateEmail(email) {
        const re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return re.test(email);
    }
});
