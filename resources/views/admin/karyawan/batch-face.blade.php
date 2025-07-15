@extends('layouts.app')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Daftarkan Wajah Otomatis</h2>

    <p class="mb-4 text-gray-600">Pastikan semua foto berada di <code>public/storage/wajah/</code> dan bernama sesuai NIP.</p>

    <div id="face-container" class="grid grid-cols-2 gap-4">
        @foreach($users as $user)
            <div class="border p-4">
                <p class="font-semibold">{{ $user->name }} ({{ $user->nip }})</p>
                <img id="foto-{{ $user->id }}" src="{{ asset('storage/wajah/'.$user->nip.'.jpg') }}" alt="Wajah {{ $user->name }}" class="w-32 my-2">
                <button onclick="prosesWajah({{ $user->id }}, '{{ route('admin.karyawan.face.store', $user->id) }}', '{{ asset('storage/wajah/'.$user->nip.'.jpg') }}')" class="bg-blue-500 text-white px-4 py-2 rounded">Daftarkan</button>
            </div>
        @endforeach
    </div>
</div>

<script defer src="/js/face-api.min.js"></script>
<script>
    async function prosesWajah(userId, postUrl, imageUrl) {
        await faceapi.nets.ssdMobilenetv1.load('/models');
        await faceapi.nets.faceRecognitionNet.load('/models');
        await faceapi.nets.faceLandmark68Net.load('/models');

        const img = await faceapi.fetchImage(imageUrl);
        const detection = await faceapi.detectSingleFace(img).withFaceLandmarks().withFaceDescriptor();

        if (!detection) {
            alert("Wajah tidak terdeteksi.");
            return;
        }

        const descriptor = JSON.stringify(Array.from(detection.descriptor));

        const form = new FormData();
        form.append('descriptor', descriptor);
        form.append('_token', '{{ csrf_token() }}');

        const response = await fetch(postUrl, {
            method: 'POST',
            body: form
        });

        if (response.ok) {
            alert('Berhasil disimpan!');
        } else {
            alert('Gagal simpan.');
        }
    }
</script>
@endsection
