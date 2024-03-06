<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Laporan Presensi</title>

    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>
        @page {
            size: A4
        }

        .datapresensi {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .datapresensi tr th {
            background-color: #dbdbdb;
            border: 1px solid black;
            padding: 8px;
            font-size: 10px;

        }

        .datapresensi tr td {

            border: 1px solid black;
            font-size: 11px;
            padding: 8px;

        }

        .avatar {
            --tblr-avatar-size: 2.5rem;
            --tblr-avatar-status-size: 0.75rem;
            --tblr-avatar-bg: var(--tblr-bg-surface-secondary);
            --tblr-avatar-box-shadow: var(--tblr-box-shadow-border);
            --tblr-avatar-font-size: 1rem;
            --tblr-avatar-icon-size: 1.5rem;
            position: relative;
            width: var(--tblr-avatar-size);
            height: var(--tblr-avatar-size);
            font-size: var(--tblr-avatar-font-size);
            font-weight: var(--tblr-font-weight-medium);
            line-height: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--tblr-secondary);
            text-align: center;
            text-transform: uppercase;
            vertical-align: bottom;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background: var(--tblr-avatar-bg) no-repeat center/cover;
            border-radius: var(--tblr-border-radius);
            box-shadow: var(--tblr-avatar-box-shadow);
        }
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->

<body class="F4 landscape">

    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet padding-10mm">

        <table style="width: 100%">
            <tr>
                <td style="width: 30px">
                    <img src="{{ asset('assets/img/logowk.png') }}" width="90" height="90" alt="">
                </td>
                <td>
                    <p class="fw-bold">
                        LAPORAN ABSENSI KARYAWAN <br>
                        PERIODE {{ strtoupper($namabulan[$bulan]) }} {{ $tahun }} <br>
                        LABORATORIUM KLINIK WIJAYA KUSUMA <br>
                        PT. ANWAR MEDIKA LABORATORIUM
                    </p>
                </td>
            </tr>

        </table>

        <table class=" datapresensi ">
            <thead>
                <tr style="text-align: center;">
                    <th rowspan="2">Nik</th>
                    <th rowspan="2">Nama Karyawan</th>
                    <th colspan="31">Tanggal</th>
                    <th rowspan="2">TH</th>
                </tr>
                <tr>
                    <?php
                    for ($i=1; $i < 32; $i++) {
                    ?>
                    <th>{{ $i }}</th>
                    <?php
                        }
                    ?>

                </tr>
            </thead>
            <tbody>
                @foreach ($rekap as $d)
                    <tr>
                        <td>{{ $d->nik }}</td>
                        <td>{{ $d->nama_lengkap }}</td>
                        <?php
                        $totalhadir = 0;
                        for ($i=1; $i < 32; $i++) {
                            $tgl = "tgl_".$i;
                            if(empty($d->$tgl)){
                            $hadir = ['',''];
                            }else {
                                $hadir = explode("-",$d->$tgl);
                                $totalhadir += 1;
                            }
                        ?>
                        <td>
                            <span
                                style="color: {{ $hadir[0] > $d->jam_masuk ? 'red' : '' }}">{{ $hadir[0] }}</span><br>
                            <span style="color: {{ $hadir[1] < $d->jam_pulang ? 'red' : '' }}">{{ $hadir[1] }}</span>
                        </td>
                        <?php
                            }
                        ?>
                        <td>{{ $totalhadir }}</td>
                    </tr>
                @endforeach
            </tbody>

        </table>


        <table width="100%" style="margin-top: 100px">
            <tr>
                <td colspan="2" style="text-align: right;">Sumenep, {{ date('d-m-Y') }}</td>
            </tr>
            <tr>
                <td style="text-align: center; vertical-align: bottom" height="100px">
                    <u>MALIHAH</u><br>
                    <i><b>HRD Manager</b></i>
                </td>
                <td style="text-align: center; vertical-align: bottom">
                    <u>FAUZI</u><br>
                    <i><b>Direktur</b></i>
                </td>
            </tr>
        </table>

    </section>

</body>
<script>
    < script src = "https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity = "sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin = "anonymous" >
</script>
</script>

</html>
