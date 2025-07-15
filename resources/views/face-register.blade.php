<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Wajah - {{ $user->name ?? 'User' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>

</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="text-center">
        <h1 class="text-2xl font-bold mb-4">Daftarkan Wajah: {{ $user->name ?? 'Anda' }}</h1>
        <video id="video" width="300" autoplay muted class="rounded shadow"></video>
        <form id="form" method="POST" action="{{ $user ? route('admin.karyawan.face.store', $user->id) : route('face.register.store') }}">
            @csrf
            <input type="hidden" name="descriptor" id="descriptor">
            <button id="submitBtn" type="submit" disabled
                class="mt-4 bg-blue-700 text-white py-2 px-4 rounded opacity-50 cursor-not-allowed hover:bg-blue-800 transition">
                Simpan Wajah
            </button>
            <p id="status" class="mt-2 text-sm text-gray-600">Menunggu wajah terdeteksi...</p>
        </form>
    </div>

    <script>
        const video = document.getElementById('video');
        const submitBtn = document.getElementById('submitBtn');
        const statusText = document.getElementById('status');

        Promise.all([
    faceapi.nets.tinyFaceDetector.loadFromUri('/models'),
    faceapi.nets.faceRecognitionNet.loadFromUri('/models'),
    faceapi.nets.faceLandmark68Net.loadFromUri('/models'),
])
.then(startVideo)
.catch(err => {
    statusText.innerText = 'Gagal memuat model face-api.js. Cek koneksi dan folder /models';
    console.error('Model load error:', err);
});


        function startVideo() {
            navigator.mediaDevices.getUserMedia({ video: {} })
                .then(stream => video.srcObject = stream)
                .catch(err => console.error(err));
        }

        video.addEventListener('play', async () => {
            const canvas = faceapi.createCanvasFromMedia(video);
            document.body.append(canvas);

            const displaySize = { width: video.width, height: video.height };
            faceapi.matchDimensions(canvas, displaySize);

            const interval = setInterval(async () => {
                const detection = await faceapi.detectSingleFace(video, new faceapi.TinyFaceDetectorOptions())
                    .withFaceLandmarks().withFaceDescriptor();

                if (detection) {
                    const descriptor = Array.from(detection.descriptor);
                    document.getElementById('descriptor').value = JSON.stringify(descriptor);
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    statusText.innerText = 'Wajah berhasil terdeteksi. Siap untuk disimpan!';
                    clearInterval(interval);
                }
            }, 1000);
        });
    </script>

    <script src="{{ asset('js/face-api.min.js') }}"></script>
<script src="{{ asset('js/camera.js') }}"></script>


</body>
</html>
