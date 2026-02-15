@extends('layouts.app')

@section('title', 'Scan QR Code')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Scan QR Code</h1>
    <p class="text-gray-600">Point your camera at the QR code to scan</p>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-md mx-auto text-center">
    <div id="scanner-area">
        <div class="border-2 border-gray-300 rounded-lg p-2 mb-4 bg-black">
            <video id="video" width="100%" height="300" autoplay playsinline class="rounded-lg"></video>
            <canvas id="canvas" class="hidden"></canvas>
        </div>

        <button id="start-btn" onclick="startQRScanner()"
            class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 font-semibold">
            📷 Start QR Scanner
        </button>

        <button id="stop-btn" onclick="stopQRScanner()"
            class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 font-semibold hidden">
            ❌ Stop Scanner
        </button>

        <p id="scan-status" class="mt-4 text-sm text-gray-600">
            Click "Start QR Scanner" to begin
        </p>
    </div>

    <!-- QR Result -->
    <div id="qr-result" class="mt-6 p-4 bg-green-50 rounded-lg hidden">
        <p class="text-green-600 font-semibold">✅ QR Code Scanned</p>
        <p id="qr-result-text" class="text-gray-700 mt-2 font-mono bg-white p-2 rounded border"></p>

        <div class="mt-4 space-x-2">
            <button id="mark-attendance-btn" onclick="processQRCode()"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Mark Attendance
            </button>

            <button onclick="scanAgain()"
                class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                Scan Again
            </button>
        </div>
    </div>

    <!-- Success -->
    <div id="success-message" class="mt-6 p-4 bg-green-50 rounded-lg hidden"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.js"></script>

<script>
let videoStream = null;
let scanInterval = null;
let scannedData = '';

async function startQRScanner() {
    videoStream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } });
    const video = document.getElementById('video');
    video.srcObject = videoStream;
    video.play();

    document.getElementById('start-btn').classList.add('hidden');
    document.getElementById('stop-btn').classList.remove('hidden');
    startScanning();
}

function startScanning() {
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');

    scanInterval = setInterval(() => {
        if (video.readyState === video.HAVE_ENOUGH_DATA) {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

            const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            const code = jsQR(imageData.data, imageData.width, imageData.height);

            if (code) onQRCodeScanned(code.data);
        }
    }, 200);
}

function onQRCodeScanned(data) {
    scannedData = data;
    stopQRScanner();

    document.getElementById('qr-result-text').textContent = data;
    document.getElementById('scanner-area').classList.add('hidden');
    document.getElementById('qr-result').classList.remove('hidden');
}

function stopQRScanner() {
    if (videoStream) videoStream.getTracks().forEach(t => t.stop());
    clearInterval(scanInterval);

    document.getElementById('start-btn').classList.remove('hidden');
    document.getElementById('stop-btn').classList.add('hidden');
}

function processQRCode() {

    let token = scannedData;

    if (scannedData.includes('/attendance/scan/')) {
        token = scannedData.split('/attendance/scan/')[1];
    }

    fetch('{{ route("student.attendance.mark") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            token: token   // ✅ THIS IS THE FIX
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById('qr-result').classList.add('hidden');
            document.getElementById('success-message').classList.remove('hidden');
            document.getElementById('success-message').innerHTML = `
                <h3 class="text-green-600 font-bold">Attendance Marked Successfully</h3>
                <p>${data.message}</p>
            `;
        } else {
            alert(data.message);
            scanAgain();
        }
    })
    .catch(err => {
        alert('Error occurred');
        scanAgain();
    });
}

function scanAgain() {
    scannedData = '';
    document.getElementById('scanner-area').classList.remove('hidden');
    document.getElementById('qr-result').classList.add('hidden');
    document.getElementById('success-message').classList.add('hidden');
}
</script>
@endsection
