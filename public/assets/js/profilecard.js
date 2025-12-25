 const toggle = document.querySelector(".toggler");
        const content = document.querySelector(".profile-card");
        toggle.addEventListener("mouseover", () => content.style.visibility = 'visible');
        content.addEventListener("mouseleave", () => content.style.visibility = 'hidden');
        document.addEventListener("click", (e) => {
            if (!content.contains(e.target) && e.target !== toggle) {
                content.style.visibility = 'hidden';
            }
        });