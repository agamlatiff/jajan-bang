// Wait for html5-qrcode library to be available
let html5QrCode;

function initQRScanner() {
    if (typeof Html5Qrcode === "undefined") {
        console.error("Html5Qrcode library not loaded");
        // Retry once after 500ms
        setTimeout(() => {
            if (typeof Html5Qrcode !== "undefined") initQRScanner();
        }, 500);
        return;
    }

    const html5QrCode = new Html5Qrcode("reader");
    const qrConfig = { fps: 10, qrbox: { width: 250, height: 250 } };

    // Start scanning
    html5QrCode
        .start(
            { facingMode: "environment" },
            qrConfig,
            onScanSuccess,
            (errorMessage) => {
                // parse error, ignore it.
            },
        )
        .catch((err) => {
            console.error("Error starting scanner", err);
            document
                .getElementById("scanner-error")
                ?.classList.remove("hidden");
        });

    // Save instance for controls
    window.qrScannerInstance = html5QrCode;
}

function onScanSuccess(decodedText, decodedResult) {
    // Determine if it's a URL or direct code
    let tableNumber = decodedText;
    if (decodedText.includes("/")) {
        tableNumber = decodedText.split("/").pop();
    }

    // Validate table number format (e.g., A1234 or simple number/string)
    // Relaxed validation to allow various formats if needed, or stick to regex
    // if (!/^[a-zA-Z]\d{4}$/.test(tableNumber)) {
    //     console.warn("Potential invalid format: " + tableNumber);
    // }

    if (window.isScanningProcessing) return;
    window.isScanningProcessing = true;

    // Visual feedback (optional)
    if (navigator.vibrate) navigator.vibrate(200);

    fetch("/store-qr-result", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({ table_number: tableNumber }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.status === "success") {
                window.location.href = "/";
            } else {
                alert(
                    "Gagal menyimpan data QR: " +
                        (data.message || "Unknown error"),
                );
                window.isScanningProcessing = false;
            }
        })
        .catch((error) => {
            console.error("Error sending QR data:", error);
            alert("Terjadi kesalahan saat memproses QR code.");
            window.isScanningProcessing = false;
        });
}

// Control Functions
window.toggleFlash = function () {
    if (window.qrScannerInstance) {
        window.qrScannerInstance.getState().then((state) => {
            if (
                state === Html5QrcodeScannerState.SCANNING ||
                state === Html5QrcodeScannerState.PAUSED
            ) {
                window.qrScannerInstance
                    .applyVideoConstraints({
                        advanced: [{ torch: true }], // This toggle logic is complex, usually simple 'torch': true/false
                    })
                    .catch((err) => console.log(err));
            }
        });
        // Note: Toggle support in Html5Qrcode is tricky without track access tracking.
        // Simplified: accessing the track to toggle.
        // For now, we'll try to just catch errors if not supported.
    }
};

window.scanFromFile = function (input) {
    if (input.files.length === 0) return;
    const imageFile = input.files[0];

    // Scan file
    const html5QrCode = new Html5Qrcode("reader"); // Use separate instance or existing?
    // Using existing instance might be busy.
    // Ideally clear existing and scan file.

    if (window.qrScannerInstance) {
        window.qrScannerInstance
            .stop()
            .then(() => {
                window.qrScannerInstance
                    .scanFile(imageFile, true)
                    .then((decodedText) => {
                        onScanSuccess(decodedText);
                    })
                    .catch((err) => {
                        alert("Gagal memindai gambar: " + err);
                        initQRScanner(); // Restart camera
                    });
            })
            .catch((err) => {
                console.error("Failed to stop scanner", err);
            });
    }
};

// Initialize when DOM is ready
if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initQRScanner);
} else {
    initQRScanner();
}
