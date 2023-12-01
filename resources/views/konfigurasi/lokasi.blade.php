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
                        Konfigurasi Lokasi
                    </h2>
                </div>

            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-6">
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
                            <form action="/konfigurasi/updatelokasikantor" target="_blank" method="post">
                                @csrf


                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="input-icon mb-3">
                                            <span class="input-icon-addon">
                                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-map" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M3 7l6 -3l6 3l6 -3v13l-6 3l-6 -3l-6 3v-13" />
                                                    <path d="M9 4v13" />
                                                    <path d="M15 7v13" />
                                                </svg>
                                            </span>
                                            <input type="text" value="{{ $lokasi_kantor->lokasi_kantor }}"
                                                name="lokasi_kantor" class="form-control" placeholder="Lokasi Kantor">
                                        </div>
                                        <div class="input-icon mb-3">
                                            <span class="input-icon-addon">
                                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-chart-radar" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M12 3l9.5 7l-3.5 11h-12l-3.5 -11z" />
                                                    <path d="M12 7.5l5.5 4l-2.5 5.5h-6.5l-2 -5.5z" />
                                                    <path d="M2.5 10l9.5 3l9.5 -3" />
                                                    <path d="M12 3v10l6 8" />
                                                    <path d="M6 21l6 -8" />
                                                </svg>
                                            </span>
                                            <input type="text" value="{{ $lokasi_kantor->radius }}" name="radius"
                                                class="form-control" placeholder="Radius">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary w-100">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-square-rounded-letter-u"
                                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M10 8v6a2 2 0 1 0 4 0v-6" />
                                                    <path
                                                        d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z" />
                                                </svg>
                                                Update
                                            </button>
                                        </div>
                                    </div>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
