<div class="modal modal-blur fade" id="addArtikel" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Artikel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="user" id="formAddArtikel">
                    <div class="form-floating mb-3">
                        <input type="text" name="nama_artikel" class="form form-control form-control-sm required">
                        <label class="col-form-label">Nama Artikel</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select name="produk" class="form form-control form-control-sm required">
                            <option value="">Pilih Produk</option>
                            <?php 
                                $produk = produk();
                                foreach ($produk as $produk) :?>

                                <option value="<?= $produk['produk']?>"><?= $produk['produk']?></option>

                            <?php endforeach;?>
                        </select>
                        <label class="col-form-label">Produk</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="harga" class="form form-control form-control-sm required rupiah">
                        <label class="col-form-label">Harga</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="diskon" class="form form-control form-control-sm required number">
                        <label class="col-form-label">Diskon (%)</label>
                    </div>

                    <div class="form-floating mb-3">
                        <select name="tipe_ukuran" class="form form-control form-control-sm required">
                            <option value="">Pilih Tipe Ukuran</option>
                            <option value="Tanpa Ukuran">Tanpa Ukuran</option>
                            <option value="Ukuran Alphabet">Ukuran Alphabet</option>
                            <option value="Ukuran Angka">Ukuran Angka</option>
                        </select>
                        <label class="col-form-label">Tipe Ukuran</label>
                    </div>

                    <div class="ukuranAlphabet" style="display:none">
                        <h4>List Ukuran Alphabet</h4>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-4 mb-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="ukuran" value="XS" class="custom-control-input" id="XS">
                                        <label class="custom-control-label" for="XS">XS</label>
                                    </div>
                                </div>
                                <div class="col-4 mb-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="ukuran" value="S" class="custom-control-input" id="S">
                                        <label class="custom-control-label" for="S">S</label>
                                    </div>
                                </div>
                                <div class="col-4 mb-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="ukuran" value="M" class="custom-control-input" id="M">
                                        <label class="custom-control-label" for="M">M</label>
                                    </div>
                                </div>
                                <div class="col-4 mb-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="ukuran" value="L" class="custom-control-input" id="L">
                                        <label class="custom-control-label" for="L">L</label>
                                    </div>
                                </div>
                                <div class="col-4 mb-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="ukuran" value="XL" class="custom-control-input" id="XL">
                                        <label class="custom-control-label" for="XL">XL</label>
                                    </div>
                                </div>
                                <div class="col-4 mb-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="ukuran" value="XXL" class="custom-control-input" id="XXL">
                                        <label class="custom-control-label" for="XXL">XXL</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="ukuranAngka" style="display:none">
                        <h4>List Ukuran Angka</h4>
                        <div class="form-floating mb-3">
                            <input type="text" name="nomor_terkecil" class="form form-control form-control-sm number">
                            <label class="col-form-label">Nomor Terkecil</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="nomor_terbesar" class="form form-control form-control-sm number">
                            <label class="col-form-label">Nomor Terbesar</label>
                        </div>
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

<div class="modal modal-blur fade" id="detailArtikel" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Artikel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_artikel" class="form required">
                <div class="form-floating mb-3">
                    <input type="text" name="nama_artikel" class="form form-control form-control-sm required">
                    <label class="col-form-label">Nama Artikel</label>
                </div>
                <div class="form-floating mb-3">
                    <select name="produk" class="form form-control form-control-sm required">
                        <option value="">Pilih Produk</option>
                        <?php 
                            $produk = produk();
                            foreach ($produk as $produk) :?>

                            <option value="<?= $produk['produk']?>"><?= $produk['produk']?></option>

                        <?php endforeach;?>
                    </select>
                    <label class="col-form-label">Produk</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="ukuran" class="form form-control form-control-sm">
                    <label class="col-form-label">Ukuran</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="harga" class="form form-control form-control-sm required rupiah">
                    <label class="col-form-label">Harga</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="diskon" class="form form-control form-control-sm required number">
                    <label class="col-form-label">Diskon (%)</label>
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

<div class="modal modal-blur fade" id="addProduk" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="user" id="formAddProduk">
                    <div class="form-floating mb-3">
                        <input type="text" name="produk" class="form form-control form-control-sm required">
                        <label class="col-form-label">Nama Produk</label>
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

<div class="modal modal-blur fade" id="detailProduk" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_produk" class="form required">
                <div class="form-floating mb-3">
                    <input type="text" name="produk" class="form form-control form-control-sm required">
                    <label class="col-form-label">Nama Produk</label>
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