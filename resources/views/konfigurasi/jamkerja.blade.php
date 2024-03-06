@extends('layout.admin.tabler')
@section('contents')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    {{-- <div class="page-pretitle">
                    Karyawan
                </div> --}}
                    <h2 class="page-title">
                        Konfigurasi Jam Kerja
                    </h2>
                </div>

            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    @if (Session::get('success'))
                                        <div class="alert alert-success">

                                            {{ Session::get('success') }}

                                        </div>
                                    @endif
                                    @if (Session::get('warning'))
                                        <div class="alert alert-warning">

                                            {{ Session::get('warning') }}

                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <a href="#" class="btn" id="btnTambahShift">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus"
                                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 5l0 14"></path>
                                            <path d="M5 12l14 0"></path>
                                        </svg>
                                        Tambah Data
                                    </a>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <form action="/konfigurasi" method="get">
                                        <div class="row">
                                            <div class="col-2">
                                                <select class="form-select" name="kode_cabang" id="">
                                                    <option value="">Semua Jam Shift</option>
                                                </select>
                                            </div>

                                            <div class="col-2">
                                                <button type="submit" class="btn btn-primary">
                                                    <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                                        <path d="M21 21l-6 -6" />
                                                    </svg>
                                                    Cari
                                                </button>
                                            </div>
                                            <div class="col-2" style="margin-left: 40px">
                                                <a href="/konfigurasi/jamkerja" class="btn">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-refresh" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                        </path>
                                                        <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4"></path>
                                                        <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4"></path>
                                                    </svg>
                                                    Refresh</a>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                            <style>
                                .table th {
                                    text-align: center;
                                    vertical-align: middle;
                                }

                                .table td {
                                    vertical-align: middle;
                                    text-align: center;
                                }
                            </style>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Kode Shift</th>
                                                    <th>Nama Shift</th>
                                                    <th>Awal Jam Masuk</th>
                                                    <th>Jam Masuk</th>
                                                    <th>Akhir Jam Masuk</th>
                                                    <th>Jam Pulang</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($jam_kerja as $d)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $d->kode_shift }}</td>
                                                        <td>{{ $d->nama_shift }}</td>
                                                        <td>{{ $d->awal_jam_masuk }}</td>
                                                        <td>{{ $d->jam_masuk }}</td>
                                                        <td>{{ $d->akhir_jam_masuk }}</td>
                                                        <td>{{ $d->jam_pulang }}</td>

                                                        <td>
                                                            <div class="">
                                                                <div class=" ">
                                                                    <button href="#" class="edit btn btn-info btn-sm"
                                                                        kode_shift = "{{ $d->kode_shift }}">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            class="icon icon-tabler icon-tabler-edit"
                                                                            width="24" height="24"
                                                                            viewBox="0 0 24 24" stroke-width="2"
                                                                            stroke="currentColor" fill="none"
                                                                            stroke-linecap="round" stroke-linejoin="round">
                                                                            <path stroke="none" d="M0 0h24v24H0z"
                                                                                fill="none">
                                                                            </path>
                                                                            <path
                                                                                d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1">
                                                                            </path>
                                                                            <path
                                                                                d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z">
                                                                            </path>
                                                                            <path d="M16 5l3 3"></path>
                                                                        </svg>
                                                                    </button>
                                                                </div>

                                                                <div class="">
                                                                    <form action="/konfigurasi/{{ $d->kode_shift }}/delete"
                                                                        method="POST">
                                                                        @csrf

                                                                        <a class="btn btn-danger btn-sm delete-confirm">

                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                class="icon icon-tabler icon-tabler-circle-minus danger"
                                                                                width="24" height="24"
                                                                                viewBox="0 0 24 24" stroke-width="2"
                                                                                stroke="currentColor" fill="none"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round">
                                                                                <path stroke="none" d="M0 0h24v24H0z"
                                                                                    fill="none">
                                                                                </path>
                                                                                <path
                                                                                    d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0">
                                                                                </path>
                                                                                <path d="M9 12l6 0"></path>
                                                                            </svg>

                                                                        </a>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        {{-- {{ $karyawan->links('pagination::bootstrap-5') }} --}}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- model-edit --}}
    <div class="modal modal-blur fade" id="modal-editshift" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Shift</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="loadeditform">

                </div>

            </div>
        </div>
    </div>
    {{-- model-input --}}
    <div class="modal modal-blur fade" id="modal-inputshift" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Input Data Shift</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="/konfigurasi/store" method="post" id="formJamShift" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-credit-card" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path
                                                d="M3 5m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z">
                                            </path>
                                            <path d="M3 10l18 0"></path>
                                            <path d="M7 15l.01 0"></path>
                                            <path d="M11 15l2 0"></path>
                                        </svg>
                                    </span>
                                    <input type="text" value="{{ $project }}" name="kode_shift" id="kode_shift"
                                        class="form-control" placeholder="Kode Shift" readonly>
                                </div>
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-id-badge-2" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M7 12h3v4h-3z"></path>
                                            <path
                                                d="M10 6h-6a1 1 0 0 0 -1 1v12a1 1 0 0 0 1 1h16a1 1 0 0 0 1 -1v-12a1 1 0 0 0 -1 -1h-6">
                                            </path>
                                            <path
                                                d="M10 3m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v3a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z">
                                            </path>
                                            <path d="M14 16h2"></path>
                                            <path d="M14 12h4"></path>
                                        </svg>
                                    </span>
                                    <input type="text" value="" name="nama_shift" class="form-control"
                                        placeholder="Nama Shift" required
                                        oninvalid="this.setCustomValidity('Nama Shift Harus disi !')"
                                        onchange="this.setCustomValidity('')">

                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        Awal Jam Masuk
                                    </span>
                                    <input type="time" value="" name="awal_jam_masuk" class="form-control"
                                        required oninvalid="this.setCustomValidity('Awal Jam Masuk Harus disi !')"
                                        onchange="this.setCustomValidity('')">
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        Jam Masuk
                                    </span>
                                    <input type="time" value="" name="jam_masuk" class="form-control" required
                                        oninvalid="this.setCustomValidity('Jam Masuk Harus disi !')"
                                        onchange="this.setCustomValidity('')">
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        Akhir Jam Masuk
                                    </span>
                                    <input type="time" value="" name="akhir_jam_masuk" class="form-control"
                                        required oninvalid="this.setCustomValidity('Akhir Jam Masuk Harus disi !')"
                                        onchange="this.setCustomValidity('')">
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        Jam Pulang
                                    </span>
                                    <input type="time" value="" name="jam_pulang" class="form-control"
                                        placeholder="Jam Pulang" required
                                        oninvalid="this.setCustomValidity('Jam Pulang Harus disi !')"
                                        onchange="this.setCustomValidity('')">
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn me-auto" data-bs-dismiss="modal">Batal</button>
                                <button class="btn btn-primary">Simpan</button>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('myscript')
    <script>
        $(function() {
            $("#btnTambahShift").click(function() {
                $("#modal-inputshift").modal("show");
            });

            $(".edit").click(function() {
                var kode_shift = $(this).attr('kode_shift');

                $.ajax({
                    type: 'POST',
                    url: '/konfigurasi/editjam',
                    cache: false,
                    data: {
                        _token: "{{ csrf_token() }}",
                        kode_shift: kode_shift

                    },
                    success: function(respond) {
                        $("#loadeditform").html(respond);
                    }
                });

                $("#modal-editshift").modal("show");
            });

            $(".delete-confirm").click(function(e) {
                var form = $(this).closest('form');
                e.preventDefault();
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                        Swal.fire({
                            title: "Deleted!",
                            text: "Your file has been deleted.",
                            icon: "success"
                        });
                    }
                });
            });

            $("#formCabang").submit(function() {
                var kode = $('#kode_cabang').val();
                var nama = $('#nama_cabang').val();
                var lokasi = $('#lokasi_cabang').val();
                var radius = $('#radius_cabang').val();

                if (nama == "") {
                    // alert('Kode Cabang Harus Diisi !');
                    Swal.fire({
                        title: 'Warning !',
                        text: 'Kode Cabang Harus Diisi !',
                        icon: 'warning !',
                        confirmButtonText: 'Ok'
                    });
                    return false;
                }
            })
        });
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
@endpush
