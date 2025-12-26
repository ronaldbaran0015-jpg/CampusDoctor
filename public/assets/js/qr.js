
document.addEventListener("DOMContentLoaded", () => {

    const downloadBtn = document.getElementById("downloadBtn");
    const qrContainer = document.getElementById("qrImage");
    const appoid = document.getElementById("appoid").value.trim();
    const receiptElement = document.getElementById("receiptElement");
    // Decoration
    const triangles = document.querySelectorAll('.triangle-top, .triangle-bottom');
    const numDecos = Math.floor(document.querySelector('.receipt').offsetWidth / 10);
    const decoHtml = Array(numDecos).fill(0).map(() => '<div class="deco"></div>').join('');

    triangles.forEach((triangle) => {
        triangle.innerHTML = decoHtml;
    });

    // Backend URL encoded
    const backendURL = `http://10.124.222.44:8000/appointment/verify/${appoid}`;

    // Online QR API
    const apiQR = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(backendURL)}`;

    // Try loading QR from online API first
    const qrImg = new Image();
    
    qrImg.crossOrigin = "anonymous"; // critical for html2canvas

    qrImg.onload = () => {
        // Convert to Base64 so html2canvas can capture it
        const tempCanvas = document.createElement("canvas");
        tempCanvas.width = qrImg.width;
        tempCanvas.height = qrImg.height;

        const ctx = tempCanvas.getContext("2d");
        ctx.drawImage(qrImg, 0, 0);

        const base64QR = tempCanvas.toDataURL("image/png");

        qrContainer.innerHTML = `<img src="${base64QR}" width="200" height="200">`;
        console.log("Online QR Loaded");
    };

    // If API fails → fallback to offline JS QR
    qrImg.onerror = () => {
        qrContainer.innerHTML = "";

        new QRCode(qrContainer, {
            text: backendURL,
            width: 200,
            height: 200
        });

        console.log("Offline QR generated");
    };

    // Load online QR
    qrImg.src = apiQR;

    // Download receipt as PNG
    downloadBtn.addEventListener("click", () => {
        // Delay to ensure QR is rendered
        setTimeout(() => {
            html2canvas(receiptElement, {
                useCORS: true,
                scale: 3, // HD quality
            }).then(canvas => {
                const link = document.createElement("a");
                link.download = `Receipt-${appoid}.png`;
                link.href = canvas.toDataURL("image/png");
                link.click();
            });
        }, 300);
    });
});