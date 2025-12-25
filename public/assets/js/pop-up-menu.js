const menuBtn = document.getElementById('menuBtn');
const menu = document.getElementById('menu');

menuBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    menu.classList.toggle('show');
});

// Hide menu when clicking outside
document.addEventListener('click', () => {
    menu.classList.remove('show');
});