function showForm(formId) {
    const forms = document.querySelectorAll('.form-box');
    forms.forEach(form => {
        form.classList.remove('active');
        form.style.display = 'none'; // Ensure inactive forms are hidden
    });
    
    const activeForm = document.getElementById(formId);
    activeForm.classList.add('active');
    activeForm.style.display = 'block'; // Make the active form visible
}