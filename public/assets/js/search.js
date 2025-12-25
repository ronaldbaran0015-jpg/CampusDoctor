const searchToggle = document.querySelector('.searchToggle');
const desktopSearchBox = document.getElementById('desktopSearchBox');
const mobileOverlay = document.getElementById('mobileSearchOverlay');
const closeSearch = document.getElementById('closeSearch');
const mobileInput = document.getElementById('mobileSearchInput');
function isMobile() {
    return window.innerWidth < 768;
}
// Temporary pls resolve the issue when desktop mode
function isDesktop() {
    return window.innerWidth > 768;
}

searchToggle.addEventListener('click', () => {
    if (isMobile() || isDesktop()) {
        mobileOverlay.style.display = 'flex';
        setTimeout(() => mobileInput.focus(), 100);
    } else {
        desktopSearchBox.style.display = desktopSearchBox.style.display === 'block' ? 'none' : 'block';
        document.form_search.query.focus();
    }
});

closeSearch.addEventListener('click', () => {
    mobileOverlay.style.display = 'none';
});
