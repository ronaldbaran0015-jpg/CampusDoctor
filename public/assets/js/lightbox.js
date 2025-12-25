
const toggler = document.getElementById('toggler');
const lightbox = document.getElementById('lightbox')

toggler.addEventListener('click', () => {
    lightbox.classList.add('active');
});

function closeLightbox() {
    lightbox.classList.remove('active');
}

function clearTextFields(classname){
    const inputField = document.querySelectorAll(`.${classname}`);
    inputField.forEach(field=>{
        field.value= '';
    });

}
