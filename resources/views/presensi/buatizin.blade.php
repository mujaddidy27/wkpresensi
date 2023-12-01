@extends('layout.presensi')
@section('header')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
    <style>
        .datepicker-modal {
            max-height: 430px !important;
        }

        .datepicker-date-display {
            background-color: #0b8cd7;
        }

        .datepicker-cancel,
        .datepicker-clear,
        .datepicker-today,
        .datepicker-done {
            color: #0b8cd7;
            padding: 0 1rem;
        }
    </style>
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Ajukan Izin</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
@endsection
@section('content')
    <div class="row" style="margin-top: 4rem">
        <div class="col">
            @php
                $messegsuccess = Session::get('success');
                $messegerror = Session::get('error');
            @endphp
            @if (Session::get('success'))
                <div class="alert alert-success">
                    {{ $messegsuccess }}
                </div>
            @endif
            @if (Session::get('error'))
                <div class="alert alert-danger">
                    {{ $messegerror }}
                </div>
            @endif
        </div>
    </div>
    <form action="/presensi/ajukanizin" method="POST" enctype="multipart/form-data" id="formizin">
        @csrf
        <div class="col">
            <div class="form-group ">
                <div class="input-wrapper">
                    <input type="text" class="form-control datepicker" id="tgl_izin" placeholder="Tanggal"
                        name="tgl_izin">
                </div>
            </div>
            <div class="form-group">

                <div class="input-field">

                    <select class="status" id="status" name="status">
                        <option value="" disabled selected>Pilih Status</option>
                        <option value="i">Izin</option>
                        <option value="s">Sakit</option>
                    </select>
                    <label>Status Izin</label>
                </div>

            </div>
            <div class="form-group">
                <div class="input-field">
                    <textarea name="keterangan" id="keterangan" class="materialize-textarea"></textarea>
                    <label for="textarea1">Keterangan</label>
                </div>
            </div>
            <div class="custom-file-upload" id="foto">
                <input type="file" name="foto" id="fileuploadInput" accept=".png, .jpg, .jpeg">
                <label for="fileuploadInput">
                    <span>
                        <strong>
                            <ion-icon name="cloud-upload-outline" role="img" class="md hydrated"
                                aria-label="cloud upload outline"></ion-icon>
                            <i>Tap to Upload</i>
                        </strong>
                    </span>
                </label>
            </div>
            <div class="form-group boxed">
                <div class="input-wrapper">
                    <button type="submit" class="btn btn-primary btn-block">
                        <ion-icon name="send-outline"></ion-icon>
                        Ajukan
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection
@push('myscript')
    <script>
        var currYear = (new Date()).getFullYear();

        $(document).ready(function() {
            $(".datepicker").datepicker({
                format: "yyyy-mm-dd"
            });
            $("#formizin").submit(function() {
                var tgl_izin = $("#tgl_izin").val();
                var status = $("#status").val();
                var keterangan = $("#keterangan").val();
                if (tgl_izin == "") {
                    alert('Tangal harus diisi ...!')
                    return false;
                } else if (status == "") {
                    alert('Status izin harus diisi ...!')
                    return false;
                } else if (keterangan == "") {
                    alert('Keterangan harus diisi ...!')
                    return false;
                }
            });

        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('select');
            var instances = M.FormSelect.init(elems, options);
        });

        // Or with jQuery

        $(document).ready(function() {
            $('select').formSelect();
        });

        $('#textarea1').val('');
        M.textareaAutoResize($('#textarea1'));
    </script>
@endpush
