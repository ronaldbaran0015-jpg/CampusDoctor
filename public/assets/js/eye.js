const pwFields = document.querySelectorAll(".password");
const eyeOpen = document.querySelector("#eye-open");
const eyeClosed = document.querySelector("#eye-closed");
const toggleBtn = document.querySelector(".showHidePw");
pwFields.forEach(pwField => {
    toggleBtn.addEventListener("click", () => {
        if (pwField.type === "password") {
            pwField.type = "text";
            eyeClosed.classList.add("d-none");   // hide eye-slash
            eyeOpen.classList.remove("d-none");  // show eye
        } else {
            pwField.type = "password";
            eyeOpen.classList.add("d-none");     // hide eye
            eyeClosed.classList.remove("d-none");// show eye-slash
        }
    });
});


