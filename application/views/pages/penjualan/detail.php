<?php $this->load->view("_partials/header")?>
    <div class="wrapper">
        <div class="sticky-top">
            <?php $this->load->view("_partials/navbar-header")?>
            <?php $this->load->view("_partials/navbar")?>
        </div>
        <div class="page-wrapper">
        <div class="container-xl">
                <!-- Page title -->
                <div class="page-header d-print-none">
                <div class="row align-items-center">
                    <div class="col">
                    <h2 class="page-title">
                        <?= $title?>
                    </h2>
                    </div>
                </div>
                </div>
            </div>
            <div class="page-body">
                <div class="container-xl">
                    <form id="formPenjualan">

                        <!-- <h5>List Artikel</h5> -->
                        <div class="card mb-3">
                            <div class="card-body">
                                <table class="table card-table table-vcenter text-dark">
                                    <thead>
                                        <tr>
                                            <!-- <th class="w-1">No</th> -->
                                            <th>Artikel</th>
                                            <th style="width: 20%">QTY</th>
                                            <th style="width: 20%">Disc</th>
                                        </tr>
                                    </thead>
                                    <tbody class="listOfArtikel">
                                        <?php 
                                            $i = 1;
                                            foreach ($detail_penjualan as $detail) :?>
                                                <tr id="<?= $i?>">
                                                    <td>
                                                        <?php if($this->session->userdata("level") == "Super Admin"):?>
                                                            <a href="javascript:void(0)" class="hapusArtikel text-danger" data-id="<?= $i?>" data-nama="<?= $detail['nama_artikel'] . ' ' . $detail['ukuran']?>"><?= $detail['nama_artikel'] . ' ' . $detail['ukuran']?></a> <br>
                                                        <?php else :?>
                                                            <?= $detail['nama_artikel'] . ' ' . $detail['ukuran']?><br>
                                                        <?php endif;?>
                                                        <small>
                                                            Harga : <?= rupiah($detail['harga'])?> <br>
                                                            Sub Total : <span id="sub_total-<?= $i?>"><?= rupiah($detail['sub_total'])?></span>
                                                        </small>
                                                    </td>
                                                    <td class="text-right"><input type="number" name="qty" id="qty-<?= $i?>" class="form form-control form-control-md required number" value="<?= $detail['qty']?>" data-id="<?= $i?>" style="padding-left: 5px; padding-right: 5px" <?= ($this->session->userdata("level") == "Super Admin") ? "" : "readonly"?>></td>
                                                    <td class="text-right">
                                                        <input type="hidden" name="harga" value="<?= $detail['harga']?>" id="harga-<?= $i?>">
                                                        <input type="hidden" name="sub_total" value="<?= $detail['sub_total']?>" id="sub-<?= $i?>" value="0">
                                                        <input type="hidden" name="id_artikel" value="<?= $detail['id_artikel']?>">
                                                        <input type="number" name="diskon" value="<?= $detail['diskon']?>" class="form form-control form-control-md required number" id="diskon-<?= $i?>" data-id="<?= $i?>" style="padding-left: 5px; padding-right: 5px" <?= ($this->session->userdata("level") == "Super Admin") ? "" : "readonly"?>>
                                                    </td>
                                                </tr>
                                        <?php 
                                            $i++;
                                            endforeach;?>
                                    </tbody>
                                </table>

                                <?php if($this->session->userdata("level") == "Super Admin") :?>
                                    <div class="form-floating mt-3">
                                        <input type="text" name="cari_artikel" class="form-control form-control-sm">
                                        <label class="col-form-label">Input Artikel</label>
                                    </div>
                                <?php endif;?>

                                <?php $artikel = list_artikel();?>
                                <ul class="list-group mb-3" id="listOfArtikel" style="display:none">
                                    <?php foreach ($artikel as $artikel) :?>
                                        <!-- <li class="list-group-item list-group-item-light text-dark">
                                            <div class="d-flex justify-content-between">
                                                <?= $artikel['nama_artikel'] . " " . $artikel['ukuran'] . " (" . stok_artikel($artikel['id_artikel']) . ")"?>
                                                <a href="javascript:void(0)" class="artikel text-success" data-id="<?= $artikel['id_artikel']?>">
                                                    <?= tablerIcon("square-plus", "me-1")?>
                                                </a>
                                            </div>
                                        </li> -->
                                    <?php endforeach;?>
                                </ul>
                            </div>
                        </div>
                        
                        <input type="hidden" name="id_penjualan" class="form" value="<?= $penjualan['id_penjualan']?>">
                        <div class="form-floating mb-3">
                            <input type="hidden" name="total" value="<?= $penjualan['total']?>" class="form">
                            <input type="text" name="total_belanja" class="form-control form-control-sm required" value="<?= rupiah($penjualan['total'])?>" style="background-color: white" readonly>
                            <label class="col-form-label">Total</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="cash" class="form form-control form-control-sm rupiah" value="<?= rupiah($penjualan['cash'])?>" style="background-color: white" <?= ($this->session->userdata("level") == "Super Admin") ? "" : "readonly"?>>
                            <label class="col-form-label">Uang</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="kembali" class="form form-control form-control-sm rupiah" style="background-color: white" readonly value="<?= rupiah($penjualan['kembali'])?>">
                            <label class="col-form-label">Kembalian</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select name="tipe_pembayaran" class="form form-control form-control-sm required">
                                <option <?= ($penjualan['tipe_pembayaran'] == "") ? 'selected' : '';?> value="">Pilih Tipe Pembayaran</option>
                                <option <?= ($penjualan['tipe_pembayaran'] == "Tunai") ? 'selected' : '';?> value="Tunai">Tunai</option>
                                <option <?= ($penjualan['tipe_pembayaran'] == "Transfer") ? 'selected' : '';?> value="Transfer">Transfer</option>
                            </select>
                            <label for="">Tipe Pembayaran</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="datetime-local" name="tgl_penjualan" class="form form-control form-control-sm required" style="background-color: white" value="<?= date("Y-m-d\TH:i", strtotime($penjualan['tgl_penjualan']));?>" <?= ($this->session->userdata("level") == "Super Admin") ? "" : "readonly"?>>
                            <label class="col-form-label">Tgl. Penjualan</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea name="keterangan" class="form form-control form-control-sm required" data-bs-toggle="autosize" style="background-color: white" <?= ($this->session->userdata("level") == "Super Admin") ? "" : "readonly"?>><?= $penjualan['keterangan']?></textarea>
                            <label class="col-form-label">Keterangan</label>
                        </div>
                        
                        <?php if($this->session->userdata("level") == "Super Admin") :?>
                            <div class="d-grid gap-2 mb-3">
                                <a href="javascript:void(0)" class="btn btn-md btn-primary" id="btnEdit">
                                    <?= tablerIcon("device-floppy", "me-1")?>
                                    Simpan Perubahan
                                </a>
                            </div>
                        <?php endif;?>
                    </form>
                    
                </div>
            </div>
            <?php $this->load->view("_partials/footer-bar")?>
        </div>
    </div>

    <!-- load modal -->
    <?php 
        if(isset($modal)) :
            foreach ($modal as $i => $modal) {
                $this->load->view("_partials/modal/".$modal);
            }
        endif;
    ?>

    <script>
        $("#<?= $menu?>").addClass("active")
        let urut = <?= COUNT($detail_penjualan);?>;
        let index = <?= COUNT($detail_penjualan);?>;
    </script>

    <!-- load javascript -->
    <?php  
        if(isset($js)) :
            foreach ($js as $i => $js) :?>
                <script src="<?= base_url()?>assets/myjs/<?= $js?>"></script>
                <?php 
            endforeach;
        endif;    
    ?>

<?php $this->load->view("_partials/footer")?>
