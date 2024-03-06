@extends('layout.admin.tabler')
@section('contents')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col"> <!-- Page pre-title -->
                    <div class="page-pretitle"> Karyawan </div>
                    <h2 class="page-title"> Data Karyawan </h2>
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
                            <div class="row mt-2">
                                <div class="col-12">
                                    <form action="/karyawan" method="get">
                                        <div class="row">
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <div class="input-icon">
                                                        <input type="text" value="{{ Request('nama_karyawan') }}"
                                                            name="nama_karyawan" id="nama_karyawan" class="form-control"
                                                            placeholder="Nama..." aria-label="Search in website">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <select class="form-select" name="kode_dpt" id="kode_dpt">
                                                    <option value="">Pilih Departement</option>
                                                    @foreach ($departemen as $d)
                                                        <option {{ Request('kode_dpt') == $d->kode ? 'selected' : '' }}
                                                            value="{{ $d->kode }}">{{ $d->nama }}</option>
                                                    @endforeach
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
                                                    </svg> Cari </button>
                                            </div>

                                            <div class="col-2" style="margin-left: 40px">
                                                <a href="/karyawan" class="btn"> <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-refresh" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"> </path>
                                                        <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4"></path>
                                                        <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4"></path>
                                                    </svg> Refresh</a>
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
                                        <table class="table-bordered table">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>NIK</th>
                                                    <th>Nama</th>
                                                    <th>Jabatan</th>
                                                    <th>No. Hp</th>
                                                    <th>Foto</th>
                                                    <th>Departemen</th>
                                                    <th>Kantor Cabang</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($karyawan as $d)
                                                    @php $path = Storage::url("uploads/karyawan/" . $d->foto); @endphp <tr>
                                                        <td>{{ $loop->iteration + $karyawan->firstItem() - 1 }}</td>
                                                        <td>{{ $d->nik }}</td>
                                                        <td>{{ $d->nama_lengkap }}</td>
                                                        <td>{{ $d->jabatan }}</td>
                                                        <td>{{ $d->no_hp }}</td>
                                                        <td>
                                                            @if (empty($d->foto))
                                                                <img src="{{ asset('assets/img/no_photo.png') }}"
                                                                    class="avatar" alt="">
                                                            @else
                                                                <img src="{{ url($path) }}" class="avatar"
                                                                    alt="">
                                                            @endif
                                                        </td>
                                                        <td>{{ $d->nama }}</td>
                                                        <td>{{ $d->nama_cab }}</td>
                                                        <td>
                                                            <div class="">
                                                                <div class="">
                                                                    <a href="#" class="edit btn btn-info btn-sm"
                                                                        nik="{{ $d->nik }}"><svg
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            class="icon icon-tabler icon-tabler-edit"
                                                                            width="24" height="24"
                                                                            viewBox="0 0 24 24" stroke-width="2"
                                                                            stroke="currentColor" fill="none"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round">
                                                                            <path stroke="none" d="M0 0h24v24H0z"
                                                                                fill="none"> </path>
                                                                            <path
                                                                                d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1">
                                                                            </path>
                                                                            <path
                                                                                d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z">
                                                                            </path>
                                                                            <path d="M16 5l3 3"></path>
                                                                        </svg>
                                                                    </a>
                                                                </div>

                                                                <div class="">
                                                                    <form action="/karyawan/{{ $d->nik }}/delete"
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
                                        </table> {{ $karyawan->links('pagination::bootstrap-5') }}
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
    <div class="modal modal-blur fade" id="modal-editkaryawan" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body" id="loadeditform"> </div>
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
                    <form action="/karyawan/store" method="post" id="formKaryawan" enctype="multipart/form-data">
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
                                    <input type="text" value="{{ $project }}" name="nik" id="nik"
                                        class="form-control" placeholder="Nik" readonly>
                                </div>
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
                                    <input type="text" value="" name="nama_lengkap" class="form-control"
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
                                    <input type="text" value="" name="jabatan" class="form-control"
                                        placeholder="Jabatan" required
                                        oninvalid="this.setCustomValidity('Jabatan Harus disi !')"
                                        onchange="this.setCustomValidity('')">
                                </div>
                                <div class="input-icon mb-3"> <span class="input-icon-addon">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-phone-plus" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path
                                                d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2">
                                            </path>
                                            <path d="M15 6h6m-3 -3v6"></path>
                                        </svg>
                                    </span>
                                    <input type="text" value="" name="no_hp" class="form-control"
                                        placeholder="No Hp" required
                                        oninvalid="this.setCustomValidity('No Hp Harus disi !')"
                                        onchange="this.setCustomValidity('')">
                                </div>
                                <div class="mb-3">
                                    <div class="form-label">Upload Foto</div>
                                    <input type="file" name="foto" class="form-control" required
                                        oninvalid="this.setCustomValidity('Foto Harus disi !')"
                                        onchange="this.setCustomValidity('')" />
                                </div>
                                <div class="mb-3">
                                    <select class="form-select" name="kode_dpt" id="kode_dpt" required
                                        oninvalid="this.setCustomValidity('Departemen Harus disi !')"
                                        onchange="this.setCustomValidity('')">
                                        <option value="">Pilih Departement</option>
                                        @foreach ($departemen as $d)
                                            <option {{ Request('kode_dpt') == $d->kode ? 'selected' : '' }}
                                                value="{{ $d->kode }}">{{ $d->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <select class="form-select" name="kode_cabang" id="kode_cabang" required
                                        oninvalid="this.setCustomValidity('Cabang Harus disi !')"
                                        onchange="this.setCustomValidity('')">
                                        <option value="">Pilih Cabang Kantor</option>
                                        @foreach ($cabang as $d)
                                            <option {{ Request('kode_cabang') == $d->kode_cab ? 'selected' : '' }}
                                                value="{{ $d->kode_cab }}">{{ $d->nama_cab }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-password-fingerprint" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M17 8c.788 1 1 2 1 3v1"></path>
                                            <path d="M9 11c0 -1.578 1.343 -3 3 -3s3 1.422 3 3v2"></path>
                                            <path d="M12 11v2"></path>
                                            <path
                                                d="M6 12v-1.397c-.006 -1.999 1.136 -3.849 2.993 -4.85a6.385 6.385 0 0 1 6.007 -.005">
                                            </path>
                                            <path d="M12 17v4"></path>
                                            <path d="M10 20l4 -2"></path>
                                            <path d="M10 18l4 2"></path>
                                            <path d="M5 17v4"></path>
                                            <path d="M3 20l4 -2"></path>
                                            <path d="M3 18l4 2"></path>
                                            <path d="M19 17v4"></path>
                                            <path d="M17 20l4 -2"></path>
                                            <path d="M17 18l4 2"></path>
                                        </svg>
                                    </span>
                                    <input type="password" name="password" value="" class="form-control"
                                        placeholder="Password" required
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
