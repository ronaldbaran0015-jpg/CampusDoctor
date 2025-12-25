
const themeButton = document.querySelector('#darkSwitch');
const iconTheme = document.getElementById('theme-icon');
const themetext = document.getElementById('theme-txt');

// Load theme preference from localStorage
// Function to load theme preference from localStorage
const loadDataFromLocalstorage = () => {
    const themeColor = localStorage.getItem("themeColor");
    const isLightMode = themeColor === "light_mode";
    document.body.classList.toggle("light-mode", isLightMode);
    iconTheme.classList.toggle("bx-moon", isLightMode);
    iconTheme.classList.toggle("bx-sun", !isLightMode);
    themetext.innerHTML = isLightMode ? "Dark mode" : "Light mode";
    if (isLightMode) {
        themeButton.setAttribute('checked', true);
    } else {
        themeButton.removeAttribute('checked');
    }
};

// Event listener for theme toggle button
themeButton.addEventListener("click", () => {
    const isLightMode = document.body.classList.toggle("light-mode");
    localStorage.setItem("themeColor", isLightMode ? "light_mode" : "dark_mode");
    iconTheme.classList.toggle("bx-moon", isLightMode);
    iconTheme.classList.toggle("bx-sun", !isLightMode);
    themetext.innerHTML = isLightMode ? "Dark mode" : "Light mode";
});

loadDataFromLocalstorage();