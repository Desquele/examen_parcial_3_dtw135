@extends('backend.index')

@section('content-admin-css')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
@endsection

@section('content')
<div class="container mt-4">
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

    <h4><strong>API de Canvas</strong></h4>
    <p>Dibuja con el mouse en el lienzo. Haz clic en "Guardar imagen" para descargarla.</p>

    <div class="mb-3">
        <canvas id="canvas" width="500" height="300" style="border:1px solid #000000;"></canvas>
    </div>

    <button id="btnGuardar" class="btn btn-success">Guardar imagen (.png)</button>
@endsection

@section('content-admin-js')
    <!-- Leaflet JS -->
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
        // PUNTO 2: API DE CANVAS
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

        canvas.addEventListener("mouseup", () => {
            dibujando = false;
        });

        canvas.addEventListener("mouseleave", () => {
            dibujando = false;
        });

        document.getElementById("btnGuardar").addEventListener("click", () => {
            try {
                const enlace = document.createElement("a");
                enlace.href = canvas.toDataURL("image/png");
                enlace.download = "dibujo.png";
                enlace.click();
            } catch (err) {
                console.error("Error al guardar imagen:", err);
                alert("Hubo un problema al guardar la imagen.");
            }
        });
    </script>
@endsection
