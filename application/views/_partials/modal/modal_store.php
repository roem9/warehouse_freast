<div class="modal modal-blur fade" id="addStore" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Store</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="user" id="formAddStore">
                    <div class="form-floating mb-3">
                        <input type="text" name="nama_store" class="form form-control form-control-sm required">
                        <label class="col-form-label">Nama Store</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="nama_pemilik" class="form form-control form-control-sm required">
                        <label class="col-form-label">Nama Pemilik</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="no_hp" class="form form-control form-control-sm required number">
                        <label class="col-form-label">No. Handphone</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn me-3" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary btnTambah">Tambah</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="detailStore" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Store</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_store" class="form required">
                <div class="form-floating mb-3">
                    <input type="text" name="nama_store" class="form form-control form-control-sm required">
                    <label class="col-form-label">Nama Store</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="nama_pemilik" class="form form-control form-control-sm required">
                    <label class="col-form-label">Nama Pemilik</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="no_hp" class="form form-control form-control-sm required number">
                    <label class="col-form-label">No. Handphone</label>
                </div>
            </div>
            <div class="modal-footer">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn me-3" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary btnEdit">Edit</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="addKonsinyasi" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Consigment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formKonsinyasi">
                    <input type="hidden" name="id_store" class="form">
                    <div class="card mb-3">
                        <div class="card-body">
                            <table class="table card-table table-vcenter text-dark">
                                <thead>
                                    <tr>
                                        <th class="w-1">No</th>
                                        <th>Artikel</th>
                                        <th style="width : 20%">QTY</th>
                                        <th style="width : 20%">CONS</th>
                                        <th style="width : 20%">DISC</th>
                                    </tr>
                                </thead>
                                <tbody id="listOfArtikel">
                                </tbody>
                            </table>
                            <div class="form-floating mt-3">
                                <input type="text" name="cari_artikel" class="form-control form-control-sm">
                                <label class="col-form-label">Input Artikel</label>
                            </div>

                            <ul class="list-group listOfArtikelSelect" style="display:none">
                            </ul>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="datetime-local" name="tgl_konsinyasi" class="form form-control form-control-sm required" style="background-color: white">
                        <label class="col-form-label">Tgl. Consigment</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea name="keterangan" class="form form-control form-control-sm required" data-bs-toggle="autosize"></textarea>
                        <label class="col-form-label">Catatan</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn me-3" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="btnSimpan" style="display:none">Tambah Penyetokan</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="detailKonsinyasi" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Consigment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formDetailKonsinyasi">
                    <input type="hidden" name="id_store" class="form">
                    <input type="hidden" name="id_konsinyasi" class="form">
                    <div class="card mb-3">
                        <div class="card-body">
                            <table class="table card-table table-vcenter text-dark">
                                <thead>
                                    <tr>
                                        <th class="w-1">No</th>
                                        <th>Artikel</th>
                                        <th style="width : 20%">QTY</th>
                                        <th style="width : 20%">CONS</th>
                                        <th style="width : 20%">DISC</th>
                                    </tr>
                                </thead>
                                <tbody id="listOfArtikelDetail">
                                </tbody>
                            </table>
                            <div class="form-floating mt-3">
                                <input type="text" name="cari_artikel" class="form-control form-control-sm">
                                <label class="col-form-label">Input Artikel</label>
                            </div>

                            <ul class="list-group listOfArtikelSelect" style="display:none">
                            </ul>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="datetime-local" name="tgl_konsinyasi" class="form form-control form-control-sm required" style="background-color: white">
                        <label class="col-form-label">Tgl. Consigment</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea name="keterangan" class="form form-control form-control-sm required" data-bs-toggle="autosize"></textarea>
                        <label class="col-form-label">Catatan</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn me-3" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="btnEdit">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="addRetur" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Retur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formRetur">
                    <input type="hidden" name="id_store" class="form">
                    <div class="card mb-3">
                        <div class="card-body">
                            <table class="table card-table table-vcenter text-dark">
                                <thead>
                                    <tr>
                                        <th class="w-1">No</th>
                                        <th>Artikel</th>
                                        <th style="width : 20%">QTY</th>
                                        <th style="width : 20%">CONS</th>
                                        <th style="width : 20%">DISC</th>
                                    </tr>
                                </thead>
                                <tbody id="listOfArtikelRetur">
                                </tbody>
                            </table>
                            <div class="form-floating mt-3">
                                <input type="text" name="cari_artikel" class="form-control form-control-sm">
                                <label class="col-form-label">Input Artikel</label>
                            </div>

                            <ul class="list-group listOfArtikelSelect" style="display:none">
                            </ul>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="datetime-local" name="tgl_retur" class="form form-control form-control-sm required" style="background-color: white">
                        <label class="col-form-label">Tgl. Retur</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea name="keterangan" class="form form-control form-control-sm required" data-bs-toggle="autosize"></textarea>
                        <label class="col-form-label">Catatan</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn me-3" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="btnSimpan">Tambah Retur</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="detailRetur" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Retur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formDetailRetur">
                    <input type="hidden" name="id_store" class="form">
                    <input type="hidden" name="id_retur" class="form">
                    <div class="card mb-3">
                        <div class="card-body">
                            <table class="table card-table table-vcenter text-dark">
                                <thead>
                                    <tr>
                                        <th class="w-1">No</th>
                                        <th>Artikel</th>
                                        <th style="width : 20%">QTY</th>
                                        <th style="width : 20%">CONS</th>
                                        <th style="width : 20%">DISC</th>
                                    </tr>
                                </thead>
                                <tbody id="listOfArtikelReturDetail">
                                </tbody>
                            </table>
                            <div class="form-floating mt-3">
                                <input type="text" name="cari_artikel" class="form-control form-control-sm">
                                <label class="col-form-label">Input Artikel</label>
                            </div>

                            <ul class="list-group listOfArtikelSelect" style="display:none">
                            </ul>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="datetime-local" name="tgl_retur" class="form form-control form-control-sm required" style="background-color: white">
                        <label class="col-form-label">Tgl. Retur</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea name="keterangan" class="form form-control form-control-sm required" data-bs-toggle="autosize"></textarea>
                        <label class="col-form-label">Catatan</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn me-3" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="btnEdit">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="addPencairan" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pencairan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="user" id="formAddPencairan">
                    <input type="hidden" name="id_store" class="form">
                    <div class="form-floating mb-3">
                        <input type="date" name="tgl_pencairan" class="form form-control form-control-sm required">
                        <label class="col-form-label">Tgl. Pencairan</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="nominal" class="form form-control form-control-sm required rupiah">
                        <label class="col-form-label">Nominal</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea name="catatan" class="form form-control form-control-sm required" data-bs-toggle="autosize"></textarea>
                        <label class="col-form-label">Catatan</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn me-3" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary btnTambah">Tambah</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="detailPencairan" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pencairan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="user" id="formDetailPencairan">
                    <input type="hidden" name="id_store" class="form">
                    <input type="hidden" name="id_pencairan" class="form">
                    <div class="form-floating mb-3">
                        <input type="date" name="tgl_pencairan" class="form form-control form-control-sm required">
                        <label class="col-form-label">Tgl. Pencairan</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="nominal" class="form form-control form-control-sm required rupiah">
                        <label class="col-form-label">Nominal</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea name="catatan" class="form form-control form-control-sm required" data-bs-toggle="autosize"></textarea>
                        <label class="col-form-label">Catatan</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn me-3" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary btnEdit">Ubah</button>
                </div>
            </div>
        </div>
    </div>
</div>