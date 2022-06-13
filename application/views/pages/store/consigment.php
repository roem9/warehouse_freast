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
                    <h4>Total Asset : <span id="assetStore"><?= rupiah(assetStore($store['id_store']))?></span></h4>
                    <div class="d-flex justify-content-between mb-3">
                        <span>
                            <a href="javascript:void(0)" class="btn btn-primary me-1 btnConsigment">Consigment</a>
                            <a href="javascript:void(0)" class="btn btn-secondary me-1 btnRetur">Retur</a>
                            <a href="javascript:void(0)" class="btn btn-secondary me-1 btnPencairan">Pencairan</a>
                        </span>
                    </div>

                    <div class="row">

                        <div class="col-12" id="menuConsigment">
                            <div class="card shadow mb-4 overflow-auto">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-3">
                                        <div>
                                            <h4>List Consigment</h4>
                                        </div>
                                        <div>
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#addKonsinyasi" class="btn btn-success btnAddKonsinyasi" data-id="<?= $store['id_store'];?>">Tambah Consingment</a>
                                        </div>
                                    </div>
                                    <table id="dataTable" class="table card-table table-vcenter text-dark">
                                        <thead>
                                            <tr>
                                                <th class="text-dark w-1" style="font-size: 11px">No</th>
                                                <th class="text-dark desktopmobile-l mobile-p tablet-l tablet-p" style="font-size: 11px">Tgl. Pengiriman</th>
                                                <th class="text-dark desktop" style="font-size: 11px">Item</th>
                                                <th class="text-dark desktop" style="font-size: 11px">Total</th>
                                                <th class="text-dark desktop" style="font-size: 11px">Catatan</th>
                                                <th class="text-dark desktop w-1" style="font-size: 11px">Detail</th>
                                                <th class="text-dark desktop w-1" style="font-size: 11px">Retur</th>
                                            </tr>
                                        </thead>
                                        <tbody id="listKonsinyasi">
                                            <?php 
                                                $no = 1;
                                                foreach ($konsinyasi as $data) :?>
                                                <tr>
                                                    <td><?= $no?></td>
                                                    <td><?= $data['tgl_konsinyasi']?></td>
                                                    <td><?= $data['item']?></td>
                                                    <td><?= rupiah($data['total'])?></td>
                                                    <td><?= $data['keterangan']?></td>
                                                    <td><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#detailKonsinyasi" data-id="<?= $data['id_konsinyasi']?>" class="btn btn-info btnDetailKonsinyasi"><?= tablerIcon("info-circle", "")?></a></td>
                                                    <td><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#addRetur" data-id="<?= $data['id_konsinyasi']?>" data-id_store="<?= $store['id_store']?>" class="btn btn-warning btnReturKonsinyasi"><?= tablerIcon("truck-return", "")?></a></td>
                                                </tr>
                                            <?php 
                                                $no++;
                                                endforeach;?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-12" id="menuPencairan" style="display:none">
                            <div class="card shadow mb-4 overflow-auto">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-3">
                                        <div>
                                            <h4>List Pencairan</h4>
                                        </div>
                                        <div>
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#addPencairan" class="btn btn-success btnAddPencairan" data-id="<?= $store['id_store'];?>">Tambah Pencairan</a>
                                        </div>
                                    </div>
                                    <table id="dataTable" class="table card-table table-vcenter text-dark">
                                        <thead>
                                            <tr>
                                                <th class="text-dark desktopmobile-l mobile-p tablet-l tablet-p" style="font-size: 11px">No.</th>
                                                <th class="text-dark desktopmobile-l mobile-p tablet-l tablet-p" style="font-size: 11px">Tgl. Pencairan</th>
                                                <th class="text-dark desktop" style="font-size: 11px">Nominal</th>
                                                <th class="text-dark desktop" style="font-size: 11px">Catatan</th>
                                                <th class="text-dark desktop w-1" style="font-size: 11px">Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody id="listPencairan">
                                            <?php 
                                                $no = 1;
                                                foreach ($pencairan as $data) :?>
                                                <tr>
                                                    <td><?= $no?></td>
                                                    <td><?= $data['tgl_pencairan']?></td>
                                                    <td><?= rupiah($data['nominal'])?></td>
                                                    <td><?= $data['catatan']?></td>
                                                    <td><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#detailPencairan" data-id="<?= $data['id_pencairan']?>" class="btn btn-info detailPencairan"><?= tablerIcon("info-circle", "")?></a></td>
                                                </tr>
                                            <?php 
                                                $no++;
                                                endforeach;?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-12" id="menuRetur" style="display:none">
                            <div class="card shadow mb-4 overflow-auto">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-3">
                                        <div>
                                            <h4>List Retur</h4>
                                        </div>
                                        <div>
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#addRetur" class="btn btn-success btnAddRetur" data-id="<?= $store['id_store'];?>">Tambah Retur</a>
                                        </div>
                                    </div>
                                    <table id="dataTable" class="table card-table table-vcenter text-dark">
                                        <thead>
                                            <tr>
                                                <th class="text-dark w-1" style="font-size: 11px">No</th>
                                                <th class="text-dark desktopmobile-l mobile-p tablet-l tablet-p" style="font-size: 11px">Tgl. Retur</th>
                                                <th class="text-dark desktop" style="font-size: 11px">Item</th>
                                                <th class="text-dark desktop" style="font-size: 11px">Total</th>
                                                <th class="text-dark desktop" style="font-size: 11px">Catatan</th>
                                                <th class="text-dark desktop w-1" style="font-size: 11px">Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody id="listRetur">
                                            <?php 
                                                $no = 1;
                                                foreach ($retur as $data) :?>
                                                <tr>
                                                    <td><?= $no?></td>
                                                    <td><?= $data['tgl_retur']?></td>
                                                    <td><?= $data['item']?></td>
                                                    <td><?= rupiah($data['total'])?></td>
                                                    <td><?= $data['keterangan']?></td>
                                                    <td><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#detailRetur" data-id="<?= $data['id_retur']?>" class="btn btn-info btnDetailRetur"><?= tablerIcon("info-circle", "")?></a></td>
                                                </tr>
                                            <?php 
                                                $no++;
                                                endforeach;?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

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
        $("#<?= $dropdown?>").addClass("active")
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