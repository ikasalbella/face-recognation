<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Face Recognition</title>
    <script src="https://cdn.tailwindcss.com"></script>
   <script defer src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>
</head>
<body class="min-h-screen bg-white font-sans flex flex-col items-center overflow-hidden">

    <!-- Header -->
<div class="w-full bg-blue-800 text-white px-6 py-5 text-left">
    <h1 class="text-xl font-bold">Hallo, {{ auth()->user()->name }}!</h1>
    <p class="mt-2 text-sm">Ayo absen dulu di sini.<br>Pastikan wajah kamu terlihat jelas dan berada tepat di depan kamera, ya!</p>
</div>

{{-- 💡 Tampilkan pesan error jika ada --}}
@if(session('error'))
    <div class="bg-red-100 text-red-800 p-3 rounded mb-4 w-full max-w-xs">
        {{ session('error') }}
    </div>
@endif

<!-- Kamera -->
<div class="relative w-full max-w-xs sm:max-w-sm mt-6 mb-4 aspect-[3/4] rounded-lg overflow-hidden">
    <video id="video" autoplay muted playsinline class="absolute w-full h-full object-cover rounded-lg"></video>
    <canvas id="overlay" class="absolute w-full h-full top-0 left-0"></canvas>
    <div class="absolute top-[10%] left-[10%] w-[80%] h-[80%] border-4 border-white rounded pointer-events-none"></div>
</div>


    <!-- Tombol -->
    <div class="flex justify-center gap-4 w-full max-w-xs px-4 mb-6">
        <button id="retakeBtn" class="flex-1 py-2 rounded-lg border-2 border-blue-800 text-blue-800 font-semibold hover:bg-blue-50">Retake</button>
        <button id="nextBtn" class="next flex-1 py-2 rounded-lg bg-blue-800 text-white font-semibold hover:bg-blue-900">Next</button>
    </div>

    <!-- Script -->
    <script>
        const video = document.getElementById('video');
        const nextBtn = document.getElementById('nextBtn');
        const savedDescriptor = @json(auth()->user()->face_descriptor ? json_decode(auth()->user()->face_descriptor) : null);

        // Load models
        Promise.all([
    faceapi.nets.tinyFaceDetector.loadFromUri('/models'),
    faceapi.nets.faceRecognitionNet.loadFromUri('/models'),
    faceapi.nets.faceLandmark68Net.loadFromUri('/models')
])
.then(startVideo);

        function startVideo() {
            navigator.mediaDevices.getUserMedia({ video: {} })
                .then(stream => video.srcObject = stream)
                .catch(err => console.error(err));
        }

        nextBtn.addEventListener('click', async () => {
            const detection = await faceapi
                .detectSingleFace(video, new faceapi.TinyFaceDetectorOptions())
                .withFaceLandmarks()
                .withFaceDescriptor();

            if (!detection || !savedDescriptor) {
                alert('Wajah tidak terdeteksi atau belum tersimpan.');
                return;
            }

            const currentDescriptor = detection.descriptor;
            const distance = faceapi.euclideanDistance(currentDescriptor, savedDescriptor);

            if (distance < 0.5) {
                // Wajah cocok
                fetch("{{ route('face.absen') }}", {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ hasil: 'berhasil' })
                }).then(res => res.json()).then(data => {
                    window.location.href = data.redirect;
                });
            } else {
                // Tidak cocok
                window.location.href = "{{ route('absen.fail') }}";
            }
        });

        // Retake logic (optional reload)
        document.getElementById('retakeBtn').addEventListener('click', () => {
            location.reload();
        });
    </script>
</body>
</html>
