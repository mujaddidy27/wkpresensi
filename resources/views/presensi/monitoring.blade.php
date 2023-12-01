@extends('layout.admin.tabler')
@section('contents')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->

                    <h2 class="page-title">
                        Monitoring Presensi
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
                            <div class="row mt-2 ">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12">
                                            <form action="/departemen" method="get">
                                                <div class="row">
                                                    <div class="col-2">
                                                        <div class="form-group">
                                                            <div class="input-icon">
                                                                <span class="input-icon-addon">
                                                                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="icon icon-tabler icon-tabler-credit-card"
                                                                        width="24" height="24" viewBox="0 0 24 24"
                                                                        stroke-width="2" stroke="currentColor"
                                                                        fill="none" stroke-linecap="round"
                                                                        stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                            fill="none"></path>
                                                                        <path
                                                                            d="M3 5m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z">
                                                                        </path>
                                                                        <path d="M3 10l18 0"></path>
                                                                        <path d="M7 15l.01 0"></path>
                                                                        <path d="M11 15l2 0"></path>
                                                                    </svg>
                                                                </span>
                                                                <input type="text" name="tanggal" id="tanggal"
                                                                    value="{{ date('Y-m-d') }}" class="form-control"
                                                                    aria-label="Search in website" readonly>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>NIK</th>
                                                    <th>Nama Karyawan</th>
                                                    <th>Departemen</th>
                                                    <th>Jam Masuk</th>
                                                    <th>Foto Masuk</th>
                                                    <th>Jam Pulang</th>
                                                    <th>Foto Pulang</th>
                                                    <th>Keterangan</th>
                                                    <th>Lokasi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="loadpresensi"> </tbody>
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
    <div class="modal modal-blur fade" id="modal-tampilkanpeta" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Lokasi Absen Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="loadmap">

                </div>

            </div>
        </div>
    </div>
@endsection
@push('myscript')
    <script>
        $(function() {
            $("#tanggal").datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd'
            }).datepicker('update', new Date());

            function loadpresensi() {
                var tanggal = $("#tanggal").val();
                $.ajax({
                    type: 'POST',
                    url: '/getpresensi',
                    data: {
                        _token: "{{ csrf_token() }}",
                        tanggal: tanggal
                    },
                    cache: false,
                    success: function(respond) {
                        $("#loadpresensi").html(respond);
                    }
                });
            }
            $("#tanggal").change(function(e) {
                loadpresensi();
            });
            loadpresensi();
        });
    </script>
@endpush
