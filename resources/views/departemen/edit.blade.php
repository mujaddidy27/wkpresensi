<form action="/departemen/{{ $departemen->kode }}/update" method="post" id="formDepartemen" enctype="multipart/form-data">
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
                <input type="text" value="{{ $departemen->kode }}" name="kode_dpt" id="kode_dpt"
                    class="form-control" placeholder="Kode Dept" disabled>
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
                <input type="text" value="{{ $departemen->nama }}" name="nama_dpt" class="form-control"
                    placeholder="Nama Dept" required oninvalid="this.setCustomValidity('Nama Departemen Harus disi !')"
                    onchange="this.setCustomValidity('')">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn me-auto" data-bs-dismiss="modal">Batal</button>
            <button class="btn btn-primary">Update</button>
        </div>
    </div>

</form>
