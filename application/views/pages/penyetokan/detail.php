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
                        <h2 class="page-title text-nowrap">
                            <?= $title?>
                        </h2>
                    </div>
                </div>
                </div>
            </div>
            <div class="page-body">
                <div class="container-xl">
                    <form id="formPenyetokan">
                        <!-- <h5>List Artikel</h5> -->
                        <div class="card mb-3">
                            <div class="card-body">
                                <table class="table card-table table-vcenter text-dark">
                                    <thead>
                                        <tr>
                                            <th class="w-1">No</th>
                                            <th>Artikel</th>
                                            <th style="width : 30%">QTY</th>
                                        </tr>
                                    </thead>
                                    <tbody class="listOfArtikel">
                                        <?php 
                                            $i = 1;
                                            foreach ($detail_penyetokan as $detail) :?>
                                            <tr id="<?= $i?>">
                                                <td>
                                                    <input type="hidden" name="id_artikel" value="<?= $detail['id_artikel']?>">
                                                    <span class="urut"><?= $i?></span>
                                                </td>
                                                <td><a href="javascript:void(0)" class="hapusArtikel text-danger" data-id="<?= $i?>" data-nama="<?= $detail['nama_artikel'] . " " . $detail['ukuran']?>"><?= $detail['nama_artikel'] . " " . $detail['ukuran']?></a></td>
                                                <td class="text-right"><input type="number" name="qty" class="form form-control form-control-md required" value="<?= $detail['qty']?>"></td>
                                            </tr>
                                        <?php 
                                            $i++;
                                            endforeach;?>
                                    </tbody>
                                </table>

                                <div class="form-floating mt-3">
                                    <input type="text" name="cari_artikel" class="form-control form-control-sm">
                                    <label class="col-form-label">Input Artikel</label>
                                </div>

                                <?php $artikel = list_artikel();?>
                                <ul class="list-group" id="listOfArtikel" style="display:none">
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

                        <input type="hidden" name="id_penyetokan" value="<?= $penyetokan['id_penyetokan']?>" class="form">
                        <div class="form-floating mb-3">
                            <input type="date" name="tgl_penyetokan" class="form form-control form-control-sm required" value="<?= $penyetokan['tgl_penyetokan']?>">
                            <label class="col-form-label">Tgl. Penyetokan</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea name="keterangan" class="form form-control form-control-sm required" data-bs-toggle="autosize"><?= $penyetokan['keterangan']?></textarea>
                            <label class="col-form-label">Keterangan</label>
                        </div>

                        <div class="d-grid gap-2 mb-3">
                            <a href="javascript:void(0)" class="btn btn-md btn-primary" id="btnEdit">
                                <?= tablerIcon("device-floppy", "me-1")?>
                                Simpan Perubahan
                            </a>
                        </div>
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
        let urut = <?= COUNT($detail_penyetokan);?>
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
