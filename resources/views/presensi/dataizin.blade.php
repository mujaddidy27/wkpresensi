@extends('layout.admin.tabler')
@section('contents')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->

                    <h2 class="page-title">
                        Data Izin Karyawan
                    </h2>
                </div>

            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row mt-2">
                <div class="card">
                    <div class="card-body">
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
                        <div class="row">
                            <div class="col-12">
                                <form action="/presensi/dataizin" method="GET" autocomplete="off">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="input-icon mb-3">

                                                <input type="date" value="{{ Request('dari') }}" name="dari"
                                                    class="form-control" placeholder="Dari">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="input-icon mb-3">

                                                <input type="date" value="{{ Request('sampai') }}" name="sampai"
                                                    class="form-control" placeholder="Sampai">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="input-icon mb-3">
                                                <span class="input-icon-addon">
                                                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-id-badge-2" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M7 12h3v4h-3z" />
                                                        <path
                                                            d="M10 6h-6a1 1 0 0 0 -1 1v12a1 1 0 0 0 1 1h16a1 1 0 0 0 1 -1v-12a1 1 0 0 0 -1 -1h-6" />
                                                        <path
                                                            d="M10 3m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v3a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" />
                                                        <path d="M14 16h2" />
                                                        <path d="M14 12h4" />
                                                    </svg>
                                                </span>
                                                <input type="text" value="{{ Request('nama_lengkap') }}"
                                                    name="nama_lengkap" id="nama_lengkap" class="form-control"
                                                    placeholder="Nama">
                                            </div>
                                        </div>
                                        <div class="col-3">

                                            <select name="status_konfirmasi" id="status_konfirmasi" class="form-select">
                                                <option value="">Pilih Status</option>
                                                <option value="0"
                                                    {{ Request('status_konfirmasi') == '0' ? 'selected' : '' }}>Pending
                                                </option>
                                                <option value="1"
                                                    {{ Request('status_konfirmasi') == 1 ? 'selected' : '' }}>Disetujui
                                                </option>
                                                <option value="2"
                                                    {{ Request('status_konfirmasi') == 2 ? 'selected' : '' }}>Ditolak
                                                </option>
                                            </select>

                                        </div>

                                        <div class="col-2 ">

                                            <button class="btn " type="submit">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-search" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                                    <path d="M21 21l-6 -6" />
                                                </svg> Cari
                                            </button>

                                        </div>
                                        <div class="col-1 " style="margin-left: 40px; margin-top: 10px">

                                            <a href="/presensi/dataizin" class="btn btn-primary btn-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-refresh" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
                                                    <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
                                                </svg> Refresh
                                            </a>

                                        </div>

                                    </div>



                                </form>
                            </div>
                        </div>
                        <div class="col-12">
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
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIK</th>
                                            <th>Tanggal Izin</th>
                                            <th>Nama Karyawan</th>
                                            <th>Jabatan</th>
                                            <th>Status Izin</th>
                                            <th>Keterangan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>


                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($dataizin as $d)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $d->nik }}</td>
                                                <td>{{ date('d-m-Y', strtotime($d->tgl_izin)) }}</td>
                                                <td>{{ $d->nama_lengkap }}</td>
                                                <td>{{ $d->jabatan }}</td>
                                                <td>{{ $d->status_izin == 'i' ? 'Izin' : 'Sakit' }}</td>
                                                <td>{{ $d->keterangan_izin }}</td>
                                                <td>
                                                    @if ($d->status == 1)
                                                        <span class="badge bg-success">Disetujui</span>
                                                    @elseif ($d->status == 2)
                                                        <span class="badge bg-danger">Ditolak</span>
                                                    @else
                                                        <span class="badge bg-warning">Pending</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($d->status == 0)
                                                        <a href="#" class="btn btn-sm btn-primary" id="approve"
                                                            id_izin="{{ $d->id }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="icon icon-tabler icon-tabler-door-enter"
                                                                width="24" height="24" viewBox="0 0 24 24"
                                                                stroke-width="2" stroke="currentColor" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M13 12v.01" />
                                                                <path d="M3 21h18" />
                                                                <path d="M5 21v-16a2 2 0 0 1 2 -2h6m4 10.5v7.5" />
                                                                <path d="M21 7h-7m3 -3l-3 3l3 3" />
                                                            </svg>
                                                            Konfirmasi
                                                        </a>
                                                    @else
                                                        <a href="/presensi/{{ $d->id }}/batalapprove"
                                                            class="btn btn-sm btn-danger">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="icon icon-tabler icon-tabler-square-rounded-x"
                                                                width="24" height="24" viewBox="0 0 24 24"
                                                                stroke-width="2" stroke="currentColor" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M10 10l4 4m0 -4l-4 4" />
                                                                <path
                                                                    d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z" />
                                                            </svg>
                                                            Batalkan
                                                        </a>
                                                    @endif

                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                {{ $dataizin->links('pagination::bootstrap-5') }}


                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="modal-dataizin" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/presensi/konfirmasiizin" method="POST">
                        @csrf
                        <input type="hidden" name="id_izinform" id="id_izinform">
                        <div class="row">
                            <div class="col-12">
                                <div class="input-icon mb-3">
                                    <select name="status" id="status" class="form-select">
                                        <option value="1">Disetujui</option>
                                        <option value="2">Ditolak</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-device-floppy" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                                            <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                            <path d="M14 4l0 4l-6 0l0 -4" />
                                        </svg>
                                        Submit
                                    </button>
                                </div>
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
            $("#approve").click(function(e) {
                e.preventDefault();
                var id = $(this).attr("id_izin");
                $("#id_izinform").val(id);
                $("#modal-dataizin").modal("show");
            });


        });
    </script>
@endpush
