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

    .jam-digital-malasngoding {

        background-color: #27272783;
        position: absolute;
        top: 1px;
        right: 5px;
        z-index: 9999;
        width: 150px;
        border-radius: 10px;
        padding: 5px;
    }



    .jam-digital-malasngoding p {
        color: #fff;
        font-size: 16px;
        text-align: center;
        margin-top: 0;
        margin-bottom: 0;
    }
</style>
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css"
    integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.6/dist/umd/popper.min.js"
    integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous">
</script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
@section('content')
    <div class="row" style="margin-top:  70px">
        <div class="col-12">
            @php
                $messegsuccess = Session::get('success');
                $messegerror = Session::get('error');
            @endphp
            @if (Session::get('success'))
                <div class="alert alert-info">
                    {{ $messegsuccess }}
                </div>
            @endif
            @if (Session::get('error'))
                <div class="alert alert-danger">
                    {{ $messegerror }}
                </div>
            @endif
        </div>
        <div class="col-12">
            <input type="hidden" id="lokasi">
            <div class="webcam-capture" id="webcam-capture"></div>
            <div class="jam-digital-malasngoding">
                <p>{{ date('d-m-Y') }}</p>
                <p id="jam"></p>
                <p>{{ $shift_karyawan->nama_shift }}</p>
                <p>Mulai:{{ date('H:i', strtotime($shift_karyawan->awal_jam_masuk)) }}</p>
                <p>Masuk:{{ date('H:i', strtotime($shift_karyawan->jam_masuk)) }}</p>
                <p>Akhir:{{ date('H:i', strtotime($shift_karyawan->akhir_jam_masuk)) }}</p>
                <p>Pulang:{{ date('H:i', strtotime($shift_karyawan->jam_pulang)) }}</p>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <form action="/presensi/pilihshift" method="post" id="formKaryawan" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12">
                    <select class="form-select" name="kode_shift" id="kode_shift" required
                        oninvalid="this.setCustomValidity('Pilih Shift Dulu !')" onchange="this.setCustomValidity('')">
                        <option value="">Pilih Shift</option>
                        @foreach ($shift as $d)
                            <option {{ $karyawan->kode_shift == $d->kode_shift ? 'selected' : '' }}
                                value="{{ $d->kode_shift }}">{{ $d->nama_shift }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-success" style="margin-top: 10px">Pilih</button>
            </div>
        </form>
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
    <script type="text/javascript">
        window.onload = function() {
            jam();
        }

        function jam() {
            var e = document.getElementById('jam'),
                d = new Date(),
                h, m, s;
            h = d.getHours();
            m = set(d.getMinutes());
            s = set(d.getSeconds());

            e.innerHTML = h + ':' + m + ':' + s;

            setTimeout('jam()', 1000);
        }

        function set(e) {
            e = e < 10 ? '0' + e : e;
            return e;
        }
    </script>
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
            var lok_kantor = "{{ $lokasi_kantor->lokasi_cab }}";
            var lok = lok_kantor.split(",");
            var lat_kantor = lok[0];
            var long_kantor = lok[1];
            var radius = "{{ $lokasi_kantor->radius }}";
            L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
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
