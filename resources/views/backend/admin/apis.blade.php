@extends('backend.index')

@section('content-admin-css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
@endsection

@section('content')
<div class="container mt-4">
    <!-- PUNTO 1 -->
    <h4><strong>API de Geolocalización</strong></h4>

    <div class="alert alert-warning d-none" id="geo-error" role="alert">
        El navegador bloqueó el acceso a tu ubicación. Asegúrate de estar accediendo desde <code>localhost</code> o por <code>HTTPS</code>.
    </div>

    <div class="mb-3">
        <p><strong>Latitud:</strong> <span id="latitud">-</span></p>
        <p><strong>Longitud:</strong> <span id="longitud">-</span></p>
    </div>

    <div id="map" style="height: 400px;"></div>

    <hr class="my-4">

    <!-- PUNTO 2 -->
    <h4><strong>API de Canvas</strong></h4>
    <p>Dibuja con el mouse en el lienzo. Haz clic en "Guardar imagen" para descargarla.</p>

    <div class="mb-3">
        <canvas id="canvas" width="500" height="300" style="border:1px solid #000000;"></canvas>
    </div>

    <button id="btnGuardar" class="btn btn-success">Guardar imagen (.png)</button>

    <hr class="my-4">

    <!-- PUNTO 3 -->
    <h4><strong>API de Video embebido</strong></h4>
    <p>Control personalizado de un video local.</p>

    <div class="mb-3">
        <video id="videoPlayer" width="500" height="300" style="border: 1px solid #000;" controls>
            <source src="{{ asset('videos/demo.mp4') }}" type="video/mp4">
            Tu navegador no soporta video HTML5.
        </video>
    </div>

    <div class="mb-3">
        <button class="btn btn-primary" id="btnPlay">▶️ Reproducir</button>
        <button class="btn btn-warning" id="btnPause">⏸️ Pausar</button>
        <button class="btn btn-info" id="btnRetroceder">⏪ -10s</button>
        <button class="btn btn-info" id="btnAdelantar">⏩ +10s</button>
    </div>

    <div class="mb-3">
        <label>Velocidad de reproducción:</label>
        <input type="range" id="velocidad" min="0.5" max="2" step="0.1" value="1">
        <span id="velocidadActual">1x</span>
    </div>

    <div class="mb-3">
        <label>Volumen:</label>
        <input type="range" id="volumen" min="0" max="1" step="0.1" value="1">
        <span id="volumenActual">100%</span>
    </div>

    <div class="mb-3">
        <p><strong>Tiempo actual:</strong> <span id="tiempoActual">0:00</span> / <strong>Duración:</strong> <span id="duracionTotal">0:00</span></p>
        <p><strong>Estado:</strong> <span id="estadoVideo">Detenido</span></p>
    </div>
</div>
@endsection

@section('content-admin-js')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        // PUNTO 1: GEOLOCALIZACIÓN
        document.addEventListener("DOMContentLoaded", () => {
            try {
                if ("geolocation" in navigator) {
                    navigator.geolocation.getCurrentPosition((position) => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;

                        document.getElementById('latitud').textContent = lat.toFixed(6);
                        document.getElementById('longitud').textContent = lng.toFixed(6);

                        const map = L.map('map').setView([lat, lng], 13);

                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; OpenStreetMap contributors'
                        }).addTo(map);

                        L.marker([lat, lng]).addTo(map)
                            .bindPopup('Tu ubicación actual')
                            .openPopup();

                    }, (error) => {
                        console.warn("Error geolocalización:", error.message);
                        document.getElementById('geo-error').classList.remove('d-none');
                    });
                } else {
                    document.getElementById('geo-error').classList.remove('d-none');
                }
            } catch (e) {
                console.error("Error inesperado:", e);
                document.getElementById('geo-error').classList.remove('d-none');
            }
        });
    </script>

    <script>
        // PUNTO 2: CANVAS
        let canvas = document.getElementById("canvas");
        let ctx = canvas.getContext("2d");
        let dibujando = false;

        canvas.addEventListener("mousedown", (e) => {
            dibujando = true;
            ctx.beginPath();
            ctx.moveTo(e.offsetX, e.offsetY);
        });

        canvas.addEventListener("mousemove", (e) => {
            if (dibujando) {
                ctx.lineTo(e.offsetX, e.offsetY);
                ctx.strokeStyle = "#000000";
                ctx.lineWidth = 2;
                ctx.stroke();
            }
        });

        canvas.addEventListener("mouseup", () => dibujando = false);
        canvas.addEventListener("mouseleave", () => dibujando = false);

        document.getElementById("btnGuardar").addEventListener("click", () => {
            try {
                const enlace = document.createElement("a");
                enlace.href = canvas.toDataURL("image/png");
                enlace.download = "dibujo.png";
                enlace.click();
            } catch (err) {
                console.error("Error al guardar imagen:", err);
            }
        });
    </script>

    <script>
        // PUNTO 3: VIDEO EMBEBIDO PERSONALIZADO
        const video = document.getElementById("videoPlayer");
        const btnPlay = document.getElementById("btnPlay");
        const btnPause = document.getElementById("btnPause");
        const btnAdelantar = document.getElementById("btnAdelantar");
        const btnRetroceder = document.getElementById("btnRetroceder");
        const velocidad = document.getElementById("velocidad");
        const volumen = document.getElementById("volumen");

        const tiempoActual = document.getElementById("tiempoActual");
        const duracionTotal = document.getElementById("duracionTotal");
        const estadoVideo = document.getElementById("estadoVideo");
        const velocidadActual = document.getElementById("velocidadActual");
        const volumenActual = document.getElementById("volumenActual");

        function formatearTiempo(segundos) {
            const m = Math.floor(segundos / 60);
            const s = Math.floor(segundos % 60).toString().padStart(2, '0');
            return `${m}:${s}`;
        }

        video.addEventListener("loadedmetadata", () => {
            duracionTotal.textContent = formatearTiempo(video.duration);
        });

        video.addEventListener("timeupdate", () => {
            tiempoActual.textContent = formatearTiempo(video.currentTime);
        });

        video.addEventListener("play", () => {
            estadoVideo.textContent = "Reproduciendo";
        });

        video.addEventListener("pause", () => {
            estadoVideo.textContent = "Pausado";
        });

        video.addEventListener("ended", () => {
            estadoVideo.textContent = "Finalizado";
        });

        btnPlay.addEventListener("click", () => video.play());
        btnPause.addEventListener("click", () => video.pause());
        btnAdelantar.addEventListener("click", () => video.currentTime += 10);
        btnRetroceder.addEventListener("click", () => video.currentTime -= 10);

        velocidad.addEventListener("input", () => {
            video.playbackRate = parseFloat(velocidad.value);
            velocidadActual.textContent = velocidad.value + "x";
        });

        volumen.addEventListener("input", () => {
            video.volume = parseFloat(volumen.value);
            volumenActual.textContent = Math.round(video.volume * 100) + "%";
        });
    </script>
@endsection
