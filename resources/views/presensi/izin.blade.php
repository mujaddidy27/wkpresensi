@extends('layout.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Data Izin</div>
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
    <div class="fab-button bottom-right" style="margin-bottom: 70px">
        <a href="/presensi/buatizin" class="fab"><ion-icon name="add-outline" style="font-size: 30px"></ion-icon></a>
    </div>
    @foreach ($dataizin as $d)
        <div class="wor">
            <div class="col">
                <ul class="listview image-listview">
                    <li>
                        <div class="item">
                            <div class="in">
                                <div>
                                    <b>{{ date('d-m-Y', strtotime($d->tgl_izin)) }}
                                        ({{ $d->status_izin == 's' ? 'Sakit' : 'Izin' }})
                                    </b><br>
                                    <small class="text-muted">{{ $d->keterangan_izin }}</small>
                                </div>
                                @if ($d->status == 0)
                                    <span class="badge bg-warning">Waiting</span>
                                @elseif ($d->status == 1)
                                    <span class="badge bg-success">Approved</span>
                                @elseif ($d->status == 2)
                                    <span class="badge bg-danger">Decline</span>
                                @endif
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    @endforeach
@endsection
