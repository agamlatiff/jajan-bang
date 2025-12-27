// Wait for html5-qrcode library to be available
function initQRScanner() {
    if (typeof Html5QrcodeScanner === "undefined") {
        console.error("Html5QrcodeScanner not loaded");
        alert("QR Scanner library tidak tersedia. Silakan refresh halaman.");
        return;
    }

    navigator.mediaDevices
        .getUserMedia({ video: { facingMode: "environment" } })
        .then(function (stream) {
            // Stop the stream immediately - Html5QrcodeScanner will manage its own
            stream.getTracks().forEach((track) => track.stop());

            let html5QRCodeScanner = new Html5QrcodeScanner("reader", {
                fps: 10,
                qrbox: { width: 250, height: 250 },
                aspectRatio: /Mobi/i.test(window.navigator.userAgent)
                    ? 16 / 9
                    : 9 / 16,
                facingMode: "environment",
            });

            function onScanSuccess(decodedText, decodedResult) {
                // Extract table number from QR value
                let tableNumber = decodedText.split("/").pop();

                // Validate table number format (e.g., A1234)
                if (!/^[a-zA-Z]\d{4}$/.test(tableNumber)) {
                    alert("Format QR code tidak valid: " + tableNumber);
                    return;
                }

                fetch("/store-qr-result", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                    },
                    body: JSON.stringify({
                        table_number: tableNumber,
                    }),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.status === "success") {
                            html5QRCodeScanner.clear();
                            window.location.href = "/";
                        } else {
                            console.error("Failed to store QR result", data);
                            alert(
                                "Gagal menyimpan data QR: " +
                                    (data.message || "Unknown error"),
                            );
                        }
                    })
                    .catch((error) => {
                        console.error("Error sending QR data:", error);
                        alert(
                            "Terjadi kesalahan saat memproses QR code. Silakan coba lagi.",
                        );
                    });
            }

            html5QRCodeScanner.render(onScanSuccess);
        })
        .catch(function (err) {
            console.error("Izin akses kamera ditolak: ", err);
            alert("Izin akses kamera dibutuhkan untuk scan kode QR.");
        });
}

// Initialize when DOM is ready
if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initQRScanner);
} else {
    initQRScanner();
}
