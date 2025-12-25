
const toggleSidebarBtn = document.getElementById('toggleSidebar');
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');

toggleSidebarBtn.addEventListener('click', () => {
    sidebar.classList.toggle('show-sidebar');
    overlay.classList.toggle('active');
});

overlay.addEventListener('click', () => {
    sidebar.classList.remove('show-sidebar');
    overlay.classList.remove('active');
});

