const video = document.getElementById('video');
const overlay = document.getElementById('overlay');
const ctx = overlay.getContext('2d');
const nextBtn = document.querySelector('.next');

// Tombol next dimatikan awalnya
nextBtn.disabled = true;
nextBtn.classList.add('opacity-50', 'cursor-not-allowed');

// Load model-model face-api
Promise.all([
  faceapi.nets.tinyFaceDetector.loadFromUri('/models'),
  faceapi.nets.faceLandmark68Net.loadFromUri('/models'),
  faceapi.nets.faceRecognitionNet.loadFromUri('/models')
]).then(startVideo);

function startVideo() {
  navigator.mediaDevices.getUserMedia({ video: true })
    .then(stream => {
      video.srcObject = stream;
      video.addEventListener('playing', onPlay);
    })
    .catch(err => {
      alert("Tidak dapat mengakses kamera: " + err.message);
    });
}

async function onPlay() {
  overlay.width = video.videoWidth;
  overlay.height = video.videoHeight;

  const displaySize = { width: video.videoWidth, height: video.videoHeight };
  faceapi.matchDimensions(overlay, displaySize);

  setInterval(async () => {
    const detection = await faceapi
      .detectSingleFace(video, new faceapi.TinyFaceDetectorOptions())
      .withFaceLandmarks()
      .withFaceDescriptor();

    ctx.clearRect(0, 0, overlay.width, overlay.height);

    if (detection) {
      const resized = faceapi.resizeResults(detection, displaySize);
      faceapi.draw.drawDetections(overlay, resized);
      faceapi.draw.drawFaceLandmarks(overlay, resized);

      nextBtn.disabled = false;
      nextBtn.classList.remove('opacity-50', 'cursor-not-allowed');
    } else {
      nextBtn.disabled = true;
      nextBtn.classList.add('opacity-50', 'cursor-not-allowed');
    }
  }, 300);
}

// Saat tombol Next ditekan
nextBtn.addEventListener('click', async () => {
  const detection = await faceapi
    .detectSingleFace(video, new faceapi.TinyFaceDetectorOptions())
    .withFaceLandmarks()
    .withFaceDescriptor();

  if (!detection) {
    alert('Wajah tidak terdeteksi');
    return;
  }

  const descriptor = Array.from(detection.descriptor);

  fetch('/face', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify({ descriptor: JSON.stringify(descriptor) })
  })
  .then(res => res.json())
  .then(data => {
    if (data.redirect) {
      window.location.href = data.redirect;
    } else {
      alert('Tidak ada respon redirect dari server.');
    }
  })
  .catch(err => {
    alert('Gagal mengirim data: ' + err.message);
  });
});
