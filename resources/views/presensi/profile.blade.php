@extends('layout.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Profile</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
@endsection

@section('content')
    <style>
        * {
            margin: 0;
            padding: 0
        }

        body {
            background-color: #000
        }

        .card {
            width: 350px;
            background-color: #efefef;
            border: none;
            cursor: pointer;
            transition: all 0.5s;
        }

        .image img {
            transition: all 0.5s
        }

        .card:hover .image img {
            transform: scale(1.5)
        }

        .btn {
            height: 140px;
            width: 140px;
            border-radius: 50%
        }

        .name {
            font-size: 22px;
            font-weight: bold
        }

        .idd {
            font-size: 14px;
            font-weight: 600
        }

        .idd1 {
            font-size: 12px
        }

        .number {
            font-size: 22px;
            font-weight: bold
        }

        .follow {
            font-size: 12px;
            font-weight: 500;
            color: #444444
        }

        .btn1 {
            height: 40px;
            width: 150px;
            border: none;

            color: white;
            font-size: 15px
        }

        .text span {
            font-size: 13px;
            color: #545454;
            font-weight: 500
        }

        .icons i {
            font-size: 19px
        }

        hr .new1 {
            border: 1px solid
        }

        .join {
            font-size: 14px;
            color: #a0a0a0;
            font-weight: bold
        }

        .date {
            background-color: #ccc
        }
    </style>
    <div class="container mt-4 mb-4 p-3 d-flex justify-content-center">
        <div class="card p-4">
            <div class=" image d-flex flex-column justify-content-center align-items-center">
                <button class="btn btn-primary">
                    @if (!empty(Auth::guard('karyawan')->user()->foto))
                        @php
                            $path = Storage::url('uploads/karyawan/' . Auth::guard('karyawan')->user()->foto);
                        @endphp
                        {{-- <img src="{{ url($path) }}" height="100" width="100" /> --}}
                        <img src="{{ url($path) }}" alt="avatar" class="imaged " height="100">
                    @else
                        <img src="assets/img/sample/avatar/avatar1.jpg" alt="avatar" class="imaged w64 rounded">
                    @endif

                </button>
                <span class="name mt-3">{{ Auth::guard('karyawan')->user()->nama_lengkap }}</span>
                <span class="idd">{{ Auth::guard('karyawan')->user()->nik }}</span>
                <div class="d-flex flex-row justify-content-center align-items-center gap-2">
                    <span class="idd1">{{ Auth::guard('karyawan')->user()->jabatan }}</span>

                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-hierarchy-2" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M10 3h4v4h-4z" />
                        <path d="M3 17h4v4h-4z" />
                        <path d="M17 17h4v4h-4z" />
                        <path d="M7 17l5 -4l5 4" />
                        <path d="M12 7l0 6" />
                    </svg>
                </div>
                   <span class="idd1">{{ Auth::guard('karyawan')->user()->no_hp }}</span>
                <form action="/editprofile" method="get">
                    <div class=" d-flex mt-2">
                        <button class="btn1 btn-primary">Edit Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
