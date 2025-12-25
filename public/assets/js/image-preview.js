document.getElementById("imageInput").onchange = function (event) {
    const [file] = event.target.files;
    if (file) {
        const preview = document.getElementById("preview");
        preview.src = URL.createObjectURL(file);
        preview.style.display = "block";
    }
};
