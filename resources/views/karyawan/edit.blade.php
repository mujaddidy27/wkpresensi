<form action="/karyawan/{{ $karyawan->nik }}/update" method="post" id="formKaryawan" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-credit-card"
                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M3 5m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z">
                        </path>
                        <path d="M3 10l18 0"></path>
                        <path d="M7 15l.01 0"></path>
                        <path d="M11 15l2 0"></path>
                    </svg>
                </span>
                <input type="text" value="{{ $karyawan->nik }}" name="nik" id="nik" class="form-control"
                    placeholder="Nik" disabled>
            </div>
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id-badge-2"
                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M7 12h3v4h-3z"></path>
                        <path d="M10 6h-6a1 1 0 0 0 -1 1v12a1 1 0 0 0 1 1h16a1 1 0 0 0 1 -1v-12a1 1 0 0 0 -1 -1h-6">
                        </path>
                        <path d="M10 3m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v3a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z">
                        </path>
                        <path d="M14 16h2"></path>
                        <path d="M14 12h4"></path>
                    </svg>
                </span>
                <input type="text" value="{{ $karyawan->nama_lengkap }}" name="nama_lengkap" class="form-control"
                    placeholder="Nama">
            </div>
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-section" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
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
                        <path d="M4 8m0 1a1 1 0 0 1 1 -1h14a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-14a1 1 0 0 1 -1 -1z">
                        </path>
                    </svg>
                </span>
                <input type="text" value="{{ $karyawan->jabatan }}" name="jabatan" class="form-control"
                    placeholder="Jabatan">
            </div>
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone-plus"
                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path
                            d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2">
                        </path>
                        <path d="M15 6h6m-3 -3v6"></path>
                    </svg>
                </span>
                <input type="text" value="{{ $karyawan->no_hp }}" name="no_hp" class="form-control"
                    placeholder="No Hp">
            </div>
            <div class="mb-3">
                <div class="form-label">Upload Foto</div>
                <input type="file" name="foto" class="form-control" />
            </div>
            <div class="mb-3">
                <select class="form-select" name="kode_dpt" id="kode_dpt">
                    <option>Pilih Departement</option>
                    @foreach ($departemen as $d)
                        <option {{ $karyawan->kode_dpt == $d->kode ? 'selected' : '' }} value="{{ $d->kode }}">
                            {{ $d->nama }}</option>
                    @endforeach

                </select>
            </div>
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-password-fingerprint"
                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M17 8c.788 1 1 2 1 3v1"></path>
                        <path d="M9 11c0 -1.578 1.343 -3 3 -3s3 1.422 3 3v2"></path>
                        <path d="M12 11v2"></path>
                        <path d="M6 12v-1.397c-.006 -1.999 1.136 -3.849 2.993 -4.85a6.385 6.385 0 0 1 6.007 -.005">
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
                <input type="password" name="password" value="{{ $karyawan->password }}" class="form-control"
                    placeholder="Password">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn me-auto" data-bs-dismiss="modal">Batal</button>
            <button class="btn btn-primary">Update</button>
        </div>
    </div>

</form>
