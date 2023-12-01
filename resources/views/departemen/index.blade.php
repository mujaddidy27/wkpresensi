@extends('layout.admin.tabler')
@section('contents')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->

                    <h2 class="page-title">
                        Data Departemen
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
                                    <a href="#" class="btn" id="btnTambahDepartemen">
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
                                    <form action="/departemen" method="get">
                                        <div class="row">
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <div class="input-icon">

                                                        <input type="text" value="{{ Request('nama_dpt') }}"
                                                            name="nama_dpt" id="nama_dpt" class="form-control"
                                                            placeholder="Nama..." aria-label="Search in website">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-2">
                                                        <button type="submit" class="btn btn-primary">
                                                            <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon"
                                                                width="24" height="24" viewBox="0 0 24 24"
                                                                stroke-width="2" stroke="currentColor" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                                                <path d="M21 21l-6 -6" />
                                                            </svg>
                                                            Cari
                                                        </button>
                                                    </div>
                                                    <div class="col-2">
                                                        <a href="/departemen" class="btn">
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
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Kode Dept</th>
                                                    <th>Nama Dept</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($departemen as $d)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $d->kode }}</td>
                                                        <td>{{ $d->nama }}</td>
                                                        <td>
                                                            <div class="row">
                                                                <div class="col-2 ">
                                                                    <button href="#" class="edit btn btn-info btn-sm"
                                                                        kode_dpt = "{{ $d->kode }}"><svg
                                                                            xmlns="http://www.w3.org/2000/svg"
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
                                                                &ensp;
                                                                <div class="col-2 ml-1">
                                                                    <form action="/departemen/{{ $d->kode }}/delete"
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
    <div class="modal modal-blur fade" id="modal-editdepartemen" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Departemen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="loadeditform">

                </div>

            </div>
        </div>
    </div>
    {{-- model-input --}}
    <div class="modal modal-blur fade" id="modal-inputdepartemen" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Input Data Departemen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="/departemen/store" method="post" id="formDepartemen" enctype="multipart/form-data">
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
                                    <input type="text" value="" name="kode_dpt" id="kode_dpt"
                                        class="form-control" placeholder="Kode Departemen">
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
                                    <input type="text" value="" name="nama_dpt" class="form-control"
                                        placeholder="Nama Departemen">
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary">Simpan</button>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Batal</button>

                </div>
            </div>
        </div>
    </div>
@endsection
@push('myscript')
    <script>
        $(function() {
            $("#btnTambahDepartemen").click(function() {
                $("#modal-inputdepartemen").modal("show");
            });

            $(".edit").click(function() {
                var kode_dpt = $(this).attr('kode_dpt');
                $.ajax({
                    type: 'POST',
                    url: '/departemen/edit',
                    cache: false,
                    data: {
                        _token: "{{ csrf_token() }}",
                        kode_dpt: kode_dpt

                    },
                    success: function(respond) {
                        $("#loadeditform").html(respond);
                    }
                })
                $("#modal-editdepartemen").modal("show");
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

            $("#formKaryawan").submit(function() {
                var nik = $('nik').val();
                var nama_lengkap = $('nama_karyawan').val();
                var jabatan = $('jabatan').val();
                var no_hp = $('no_hp').val();
                var kode_dpt = $('nik').val();

                if (nik == "") {
                    alert('Nik Harus Diisi !');
                    $("nik").focus();
                    // Swal.fire({
                    //     title: 'Warning !',
                    //     text: 'Nik Harus Diisi !',
                    //     icon: 'warning !',
                    //     confirmButtonText: 'Ok'
                    // });
                    return false;
                }
            })
        });
    </script>
@endpush
