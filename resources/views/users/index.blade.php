@extends('layout.admin.tabler')
@section('contents')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col"> <!-- Page pre-title -->
                    <div class="page-pretitle"> Users </div>
                    <h2 class="page-title"> Data Pengguna </h2>
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
                                        <div class="alert alert-success"> {{ Session::get('success') }} </div>
                                        @endif @if (Session::get('warning'))
                                            <div class="alert alert-warning"> {{ Session::get('warning') }} </div>
                                        @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12"> <a href="#" class="btn" id="btnTambahKaryawan"> <svg
                                            xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus"
                                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 5l0 14"></path>
                                            <path d="M5 12l14 0"></path>
                                        </svg> Tambah Data </a>
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
                                        <table class="table-bordered table">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama</th>
                                                    <th>Email</th>
                                                    <th>Password</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($users as $d)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $d->name }}</td>
                                                        <td>{{ $d->email }}</td>
                                                        <td>{{ $d->password }}</td>
                                                        <td>
                                                            <div class="">
                                                                <div class="">
                                                                    <form action="/users/{{ $d->id }}/delete"
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
                                                                                    fill="none"> </path>
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

    {{-- model-input --}}
    <div class="modal modal-blur fade" id="modal-inputkaryawan" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Input Data Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/users/store" method="post" id="formKaryawan" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12">

                                <div class="input-icon mb-3"> <span class="input-icon-addon">
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
                                    <input type="text" value="" name="nama" class="form-control"
                                        placeholder="Nama" required
                                        oninvalid="this.setCustomValidity('Nama Harus disi !')"
                                        onchange="this.setCustomValidity('')">
                                </div>
                                <div class="input-icon mb-3"> <span class="input-icon-addon">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/user --> <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-section" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M20 20h.01"></path>
                                            <path d="M4 20h.01"></path>
                                            <path d="M8 20h.01"></path>
                                            <path d="M12 20h.01"></path>
                                            <path d="M16 20h.01"></path>
                                            <path d="M20 4h.01"></path>
                                            <path d="M4 4h.01"></path>
                                            <path d="M8 4h.01"></path>
                                            <path d="M12 4h.01"></path>
                                            <path d="M16 4l0 .01"></path>
                                            <path
                                                d="M4 8m0 1a1 1 0 0 1 1 -1h14a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-14a1 1 0 0 1 -1 -1z">
                                            </path>
                                        </svg>
                                    </span>
                                    <input type="email" value="" name="email" class="form-control"
                                        placeholder="Email" required
                                        oninvalid="this.setCustomValidity('Email Harus disi !')"
                                        onchange="this.setCustomValidity('')">
                                </div>
                                <div class="input-icon mb-3"> <span class="input-icon-addon">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-password-user" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M12 17v4" />
                                            <path d="M10 20l4 -2" />
                                            <path d="M10 18l4 2" />
                                            <path d="M5 17v4" />
                                            <path d="M3 20l4 -2" />
                                            <path d="M3 18l4 2" />
                                            <path d="M19 17v4" />
                                            <path d="M17 20l4 -2" />
                                            <path d="M17 18l4 2" />
                                            <path d="M9 6a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                            <path d="M7 14a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2" />
                                        </svg>
                                    </span>
                                    <input type="password" value="" name="password" class="form-control"
                                        placeholder="Password " required
                                        oninvalid="this.setCustomValidity('Password Harus disi !')"
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
    @endsection
    @push('myscript')
        <script>
            $(function() {
                $("#btnTambahKaryawan").click(function() {
                    $("#modal-inputkaryawan").modal("show");
                });

                $(".edit").click(function() {
                    var nik = $(this).attr('nik');
                    $.ajax({
                        type: 'POST',
                        url: '/karyawan/edit',
                        cache: false,
                        data: {
                            _token: "{{ csrf_token() }}",
                            nik: nik

                        },
                        success: function(respond) {
                            $("#loadeditform").html(respond);
                        }
                    })
                    $("#modal-editkaryawan").modal("show");
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
