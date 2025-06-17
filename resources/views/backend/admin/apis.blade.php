@extends('backend.index')

@section('content-admin-css')
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
@endsection

@section('content-admin-js')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
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
@endsection
