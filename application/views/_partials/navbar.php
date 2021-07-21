<div class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar navbar-light">
        <div class="container-xl">
            <ul class="navbar-nav">
            <?php if($this->session->userdata("level") == "Super Admin") :?>
                <li class="nav-item dropdown" id="Artikel">
                    <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" role="button" aria-expanded="false" >
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg width="24" height="24" class="me-3">
                                <use xlink:href="<?= base_url()?>assets/tabler-icons-1.39.1/tabler-sprite.svg#tabler-shirt" />
                            </svg> 
                        </span>
                        <span class="nav-link-title">
                            Artikel
                        </span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" id="listArtikel" href="<?= base_url()?>artikel" >
                            List Artikel
                        </a>
                        <a class="dropdown-item" id="arsipArtikel" href="<?= base_url()?>artikel/arsip" >
                            Arsip Artikel
                        </a>
                        <a class="dropdown-item" id="produkArtikel" href="<?= base_url()?>artikel/produk" >
                            List Produk
                        </a>
                    </div>
                </li>

                <li class="nav-item dropdown" id="Penyetokan">
                    <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" role="button" aria-expanded="false" >
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg width="24" height="24" class="me-3">
                                <use xlink:href="<?= base_url()?>assets/tabler-icons-1.39.1/tabler-sprite.svg#tabler-building-warehouse" />
                            </svg> 
                        </span>
                        <span class="nav-link-title">
                            Penyetokan
                        </span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" id="tambahPenyetokan" href="<?= base_url()?>penyetokan" >
                            Tambah Penyetokan
                        </a>
                        <a class="dropdown-item" id="listPenyetokan" href="<?= base_url()?>penyetokan/list" >
                            List Penyetokan
                        </a>
                        <a class="dropdown-item" id="arsipPenyetokan" href="<?= base_url()?>penyetokan/arsip" >
                            Arsip Penyetokan
                        </a>
                    </div>
                </li>

                <li class="nav-item dropdown" id="Penjualan">
                    <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" role="button" aria-expanded="false" >
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg width="24" height="24" class="me-3">
                                <use xlink:href="<?= base_url()?>assets/tabler-icons-1.39.1/tabler-sprite.svg#tabler-shopping-cart-plus" />
                            </svg> 
                        </span>
                        <span class="nav-link-title">
                            Penjualan
                        </span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" id="tambahPenjualan" href="<?= base_url()?>penjualan" >
                            Tambah Penjualan
                        </a>
                        <a class="dropdown-item" id="listPenjualan" href="<?= base_url()?>penjualan/list" >
                            List Penjualan
                        </a>
                        <a class="dropdown-item" id="arsipPenjualan" href="<?= base_url()?>penjualan/arsip" >
                            Arsip Penjualan
                        </a>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#downloadLaporan" data-bs-toggle="modal" role="button" aria-expanded="false" >
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg width="24" height="24" class="me-3">
                                <use xlink:href="<?= base_url()?>assets/tabler-icons-1.39.1/tabler-sprite.svg#tabler-report-analytics" />
                            </svg> 
                        </span>
                        <span class="nav-link-title">
                            Laporan
                        </span>
                    </a>
                </li>
            <?php elseif($this->session->userdata("level") == "Kasir") :?>
                <li class="nav-item dropdown" id="Penjualan">
                    <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" role="button" aria-expanded="false" >
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg width="24" height="24" class="me-3">
                                <use xlink:href="<?= base_url()?>assets/tabler-icons-1.39.1/tabler-sprite.svg#tabler-shopping-cart-plus" />
                            </svg> 
                        </span>
                        <span class="nav-link-title">
                            Penjualan
                        </span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" id="tambahPenjualan" href="<?= base_url()?>penjualan" >
                            Tambah Penjualan
                        </a>
                        <a class="dropdown-item" id="listPenjualan" href="<?= base_url()?>penjualan/list" >
                            List Penjualan
                        </a>
                        <a class="dropdown-item" id="arsipPenjualan" href="<?= base_url()?>penjualan/arsip" >
                            Arsip Penjualan
                        </a>
                    </div>
                </li>
            <?php elseif($this->session->userdata("level") == "Gudang") :?>
                <li class="nav-item dropdown" id="Penyetokan">
                    <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" role="button" aria-expanded="false" >
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg width="24" height="24" class="me-3">
                                <use xlink:href="<?= base_url()?>assets/tabler-icons-1.39.1/tabler-sprite.svg#tabler-building-warehouse" />
                            </svg> 
                        </span>
                        <span class="nav-link-title">
                            Penyetokan
                        </span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" id="tambahPenyetokan" href="<?= base_url()?>penyetokan" >
                            Tambah Penyetokan
                        </a>
                        <a class="dropdown-item" id="listPenyetokan" href="<?= base_url()?>penyetokan/list" >
                            List Penyetokan
                        </a>
                        <a class="dropdown-item" id="arsipPenyetokan" href="<?= base_url()?>penyetokan/arsip" >
                            Arsip Penyetokan
                        </a>
                    </div>
                </li>
            <?php endif;?>
            </ul>
        </div>
        </div>
    </div>
</div>