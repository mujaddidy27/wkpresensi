<form action="/cabang/{{ $cabang->kode_cab }}/update" method="post" id="formCabang" enctype="multipart/form-data">
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
                <input type="text" value="{{ $cabang->kode_cab }}" name="kode_cabang" id="kode_cabang"
                    class="form-control" placeholder="Kode Cabang" required
                    oninvalid="this.setCustomValidity('Kode Cabang Harus disi !')" onchange="this.setCustomValidity('')"
                    disabled>
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
                <input type="text" value="{{ $cabang->nama_cab }}" name="nama_cabang" class="form-control"
                    placeholder="Nama Cabang" required oninvalid="this.setCustomValidity('Nama Cabang Harus disi !')"
                    onchange="this.setCustomValidity('')">

            </div>
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M3 7l6 -3l6 3l6 -3v13l-6 3l-6 -3l-6 3v-13" />
                        <path d="M9 4v13" />
                        <path d="M15 7v13" />
                    </svg>
                </span>
                <input type="text" value="{{ $cabang->lokasi_cab }}" name="lokasi_cabang" class="form-control"
                    placeholder="Lokasi Cabang" required
                    oninvalid="this.setCustomValidity('Lokasi Cabang Harus disi !')"
                    onchange="this.setCustomValidity('')">
            </div>
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-gradienter"
                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M3.227 14c.917 4 4.497 7 8.773 7c4.277 0 7.858 -3 8.773 -7" />
                        <path d="M20.78 10a9 9 0 0 0 -8.78 -7a8.985 8.985 0 0 0 -8.782 7" />
                        <path d="M12 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                    </svg>
                </span>
                <input type="text" value="{{ $cabang->radius }}" name="radius_cabang" class="form-control"
                    placeholder="Radius Lokasi" required
                    oninvalid="this.setCustomValidity('Radius Lokasi Cabang Harus disi !')"
                    onchange="this.setCustomValidity('')">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn me-auto" data-bs-dismiss="modal">Batal</button>
            <button class="btn btn-primary">Update</button>
        </div>
    </div>

</form>
