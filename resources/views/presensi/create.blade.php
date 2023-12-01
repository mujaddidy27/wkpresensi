@extends('layout.presensi')

@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">E-Presensi</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
@endsection

<style>
    .webcam-capture,
    .webcam-capture video {
        display: inline-block;
        width: 100% !important;
        margin: auto;
        height: auto !important;
        border-radius: 15px;
    }

    #map {
        height: 200px;
        display: inline-block;
        width: 100% !important;
        border-radius: 15px;
        margin-bottom: 70px;
    }
</style>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
@section('content')
    <div class="row" style="margin-top: 70px">
        <div class="col">
            <input type="hidden" id="lokasi">
            <div class="webcam-capture" id="webcam-capture"></div>
        </div>
    </div>
    <div class="row mt-1">
        <div class="col">
            @if ($cek > 0)
                <button id="takeabsen" class="btn btn-danger btn-block">
                    <ion-icon name="camera-outline"></ion-icon>Absen
                    Pulang
                </button>
            @else
                <button id="takeabsen" class="btn btn-primary btn-block">
                    <ion-icon name="camera-outline"></ion-icon>Absen
                    Masuk
                </button>
            @endif
        </div>
    </div>
    <div class="row mb-10 mt-1">
        <div class="col">
            <div id="map"></div>
        </div>
    </div>
    <div class="row mb-10">
        <div class="col">

        </div>
    </div>

    <audio id="notif_in">
        <source src="{{ asset('assets/sound/notif_in.mp3') }}" type="audio/mpeg">
    </audio>
    <audio id="notif_out">
        <source src="{{ asset('assets/sound/notif_out.mp3') }}" type="audio/mpeg">
    </audio>
    <audio id="notif_error">
        <source src="{{ asset('assets/sound/notif_error.mp3') }}" type="audio/mpeg">
    </audio>
    <audio id="notif_radius">
        <source src="{{ asset('assets/sound/notif_radius.mp3') }}" type="audio/mpeg">
    </audio>
@endsection

@push('myscript')
    <script>
        var notif_in = document.getElementById('notif_in')
        var notif_out = document.getElementById('notif_out')
        var notif_error = document.getElementById('notif_error')
        var notif_radius = document.getElementById('notif_radius')
        Webcam.set({
            height: 480,
            widht: 640,
            image_formate: 'jpeg',
            jpeg_quality: 80
        });
        Webcam.attach('webcam-capture');

        var lokasi = document.getElementById('lokasi');
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        }

        function successCallback(position) {
            lokasi.value = position.coords.latitude + "," + position.coords.longitude;
            var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 16);
            var lok_kantor = "{{ $lokasi_kantor->lokasi_kantor }}";
            var lok = lok_kantor.split(",");
            var lat_kantor = lok[0];
            var long_kantor = lok[1];
            var radius = "{{ $lokasi_kantor->radius }}";
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 20,
                attribution: '© OpenStreetMap'
            }).addTo(map);
            var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
            var circle = L.circle([lat_kantor, long_kantor], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: radius
            }).addTo(map);
        }

        function errorCallback(position) {

        }

        $('#takeabsen').click(function(e) {
            Webcam.snap(function(uri) {
                image = uri;
            });
            var lokasi = $("#lokasi").val();
            $.ajax({
                type: 'POST',
                url: '/presensi/store',
                data: {
                    _token: "{{ csrf_token() }}",
                    image: image,
                    lokasi: lokasi
                },
                cache: false,
                success: function(respond) {
                    var status = respond.split("|");
                    if (status[0] == "success") {
                        if (status[2] == "in") {
                            notif_in.play();
                        } else {
                            notif_out.play();
                        }
                        Swal.fire({
                            title: 'Berhasil !',
                            text: status[1],
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        })
                        setTimeout("location.href= '/dashboard'", 3000);
                    } else {
                        if (status[2] == "luar") {
                            notif_radius.play();
                            Swal.fire({
                                title: 'Error !',
                                text: status[1],
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            })
                        } else {
                            notif_error.play();
                            Swal.fire({
                                title: 'Error !',
                                text: status[1],
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            })
                            setTimeOut("location.href= '/dashboard'", 3000);
                        }
                    }
                }
            });
        });
    </script>
@endpush
