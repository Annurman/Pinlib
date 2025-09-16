
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OCR ISBN</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        #video-container {
            position: relative;
            width: 320px;
            height: 240px;
        }
        #video {
            width: 100%;
            height: 100%;
        }
        #overlay {
            position: absolute;
            top: 30%;
            left: 29%;
            width: 45%;
            height: 35%;
            border: 2px solid red;
            box-sizing: border-box;
        }
        #captured-image {
            margin-top: 10px;
            max-width: 300px;
            display: none;
        }
    </style>
</head>
<body>

<!-- Modal Scan -->
<div class="modal fade" id="scanModal" tabindex="-1" aria-labelledby="scanModalLabel" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scanModalLabel">Scan ISBN</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="video-container">
                    <video id="video" autoplay></video>
                    <div id="overlay"></div> <!-- Kotak Panduan -->
                </div>
                <button id="capture" class="btn btn-warning mt-2">Ambil Gambar</button>
                <canvas id="canvas" style="display:none;"></canvas>
                <p id="resultText" class="mt-2">Hasil akan muncul di sini...</p>
                <img id="captured-image" alt="Hasil Scan" style="display:none; max-width:100%; border-radius: 10px; margin-top:10px;">

                
                <button id="use-isbn" class="btn btn-success mt-2" style="display:none;">Gunakan ISBN</button>
            </div>
        </div>
    </div>
</div>
  ,
    

    <script src="https://cdn.jsdelivr.net/npm/tesseract.js@5.0.0"></script>
<script>
        const video = document.getElementById("video");
        const canvas = document.getElementById("canvas");
        const ctx = canvas.getContext("2d", { willReadFrequently: true });
        const resultText = document.getElementById("resultText");
        const captureBtn = document.getElementById("capture");
        const capturedImage = document.getElementById("captured-image");
        const useIsbnBtn = document.getElementById("use-isbn");

        

        // 🔴 **Akses Kamera**
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => { video.srcObject = stream; })
            .catch(err => { console.error("Gagal akses kamera:", err); });

        // 📷 **Ambil Gambar dari Kotak Panduan & OCR**
        captureBtn.addEventListener("click", () => {
            const videoWidth = video.videoWidth;
            const videoHeight = video.videoHeight;

            // Sesuaikan ukuran canvas agar pas dengan ukuran video
            canvas.width = videoWidth;
            canvas.height = videoHeight;
            ctx.drawImage(video, 0, 0, videoWidth, videoHeight);

            // Kotak panduan dalam proporsi video
            const boxX = videoWidth * 0.27 ;  // Mulai dari 20% dari kiri
            const boxY = videoHeight * 0.22; // Mulai dari 30% dari atas
            const boxWidth = videoWidth * 0.45;
            const boxHeight = videoHeight * 0.35;
            
            // Ambil bagian gambar hanya dalam kotak merah
            const croppedImage = ctx.getImageData(boxX, boxY, boxWidth, boxHeight);

            // Ubah canvas agar hanya menampilkan area dalam kotak merah
            canvas.width = boxWidth;
            canvas.height = boxHeight;
            ctx.putImageData(croppedImage, 0, 0);

            let imageData = canvas.toDataURL("image/jpeg", 0.8);  // Format JPEG lebih stabil
            capturedImage.src = imageData;
            capturedImage.style.display = "block"; // Tampilkan hasil crop

            // 🚀 **OCR Menggunakan Tesseract**
            Tesseract.recognize(imageData, "eng", { logger: m => console.log(m) })
                .then(({ data: { text } }) => {
                    console.log("Hasil OCR Mentah:", text);

                    let lines = text.split("\n");
                    let isbnLine = lines.find(line => /isbn/i.test(line));

                    if (isbnLine) {
                        console.log("Baris ISBN:", isbnLine);

                        let cleanedText = isbnLine
                            .replace(/[^0-9Xx‘’“”–—-]/gi, "") // Hapus karakter aneh
                            .replace(/[‘’“”–—]/g, "-")        // Ubah karakter miring jadi strip
                            .replace(/1sbn/i, "ISBN")         // Perbaiki "1SBN" -> "ISBN"
                            .replace(/\s+/g, " ");            // Hilangkan spasi ganda

                        console.log("Setelah Dibersihkan:", cleanedText);

                        let match = cleanedText.match(/(?:ISBN[-\s]*)?(97[89][-\s]?\d{1,5}[-\s]?\d{1,7}[-\s]?\d{1,7}[-\s]?\d{1})/i);

                        if (match) {
                            let isbn = match[1]
                                .replace(/[^0-9Xx]/g, "") // Hapus karakter selain angka & X
                                .trim();                  // Hilangkan spasi

                            console.log("ISBN Akhir:", isbn);

                            if (isbn.length === 13 || isbn.length === 10) {
                                resultText.innerHTML =   `✅ ISBN Ditemukan: <b>${isbn}</b>  `;
                                processISBN(isbn);

                            } else {
                                resultText.innerHTML =   `⚠️ ISBN terdeteksi: <b>${isbn}</b> (Format kurang tepat)  `;
                            }
                        } else {
                            resultText.innerHTML = "❌ ISBN tidak valid atau salah terbaca!";
                        }
                    } else {
                        resultText.innerHTML = "❌ Tidak ditemukan ISBN dalam hasil OCR!";
                    }
                })
                .catch(err => {
                    console.error("OCR Error:", err);
                    resultText.innerHTML = "❌ Gagal membaca teks dari gambar.";
                });
        });

        function processISBN(isbn) {
    if (isbn) {
        localStorage.setItem("scannedISBN", isbn); // Simpan hasil scan
        document.getElementById("resultText").innerText = "ISBN: " + isbn; // Tampilkan hasil

        // Tunggu 1 detik, lalu tutup modal otomatis
        setTimeout(() => {
            let modalElement = document.getElementById("scanModal");
            let modal = bootstrap.Modal.getInstance(modalElement);
            modal.hide();

             // 🔥 Hapus backdrop secara manual
    document.querySelector(".modal-backdrop")?.remove(); 
    document.body.classList.remove("modal-open"); // Hapus efek modal aktif di body

        }, 1000);
    }
}


    document.getElementById("scanModal").addEventListener("shown.bs.modal", () => {
        setTimeout(() => {
            video.play(); // Pastikan video berjalan
            fixOverlayPosition();
        }, 500); // Delay dikit biar ukuran video kebaca
    });

    function fixOverlayPosition() {
        const videoWidth = video.videoWidth || 640;
        const videoHeight = video.videoHeight || 480;

        console.log(`Video Size (Updated): ${videoWidth} x ${videoHeight}`);

        // Recalculate overlay position
        const overlay = document.getElementById("overlay");
        overlay.style.width = `${videoWidth * 0.5}px`;  // 50% dari video width
        overlay.style.height = `${videoHeight * 0.4}px`; // 30% dari video height
        overlay.style.left = `${videoHeight * 0.5}px`;
        overlay.style.top = `${(videoHeight - overlay.offsetHeight) / 2}px`;

        console.log(`Overlay Updated: ${overlay.style.left}, ${overlay.style.top}`);
    }
</script>

   

</body>
</html>
