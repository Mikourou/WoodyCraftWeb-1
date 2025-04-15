/* Formulaire de paiement */

function toggleForm(formId) {

    // Cacher tous les formulaires
    const forms = document.querySelectorAll('.hidden');
    forms.forEach(form => {
        form.classList.add('hidden');
    });

    // Afficher le formulaire sélectionné
    const selectedForm = document.getElementById(formId);
    selectedForm.classList.toggle('hidden');
}
