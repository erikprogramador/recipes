import 'materialize-css';

// TODO: Migrate this file when front end work starts
const labels = document.querySelectorAll('label');
const fileInput = document.querySelector('input[type=file]');
fileInput.addEventListener('change', event => {
    const id = event.target.getAttribute('id');
    let label = [];
    labels.forEach(element => {
        if (element.getAttribute('for') == id) {
            label = element;
        }
    });
    label.innerHTML = `${event.explicitOriginalTarget.files[0].name} Loaded`;
});
