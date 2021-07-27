<header class="navbar navbar-expand-md navbar-light sticky-top d-print-none">
    <div class="container-xl">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
        <span class="navbar-toggler-icon"></span>
    </button>
    <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
        <a href="#">
        <!-- <img src="<?= base_url()?>assets/static/logo.png" width="110" height="32" alt="Tabler" class="navbar-brand-image"> -->
        <img src="<?= base_url()?>assets/img/logo.jpeg" width="110" height="32" alt="Tabler" class="navbar-brand-image">
        </a>
    </h1>
    <div class="navbar-nav flex-row order-md-last">
        <div class="nav-item dropdown">
        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
            <?php if($this->session->userdata("level") == "Super Admin") :?>
                <img src="<?= base_url()?>assets/tabler-icons-1.39.1/icons/user.svg" class="rounded" alt="Górą ty" width="30" height="30">
            <?php elseif($this->session->userdata("level") == "Kasir") :?>
                <img src="<?= base_url()?>assets/tabler-icons-1.39.1/icons/shopping-cart-plus.svg" class="rounded" alt="Górą ty" width="30" height="30">
            <?php elseif($this->session->userdata("level") == "Gudang") :?>
                <img src="<?= base_url()?>assets/tabler-icons-1.39.1/icons/building-warehouse.svg" class="rounded" alt="Górą ty" width="30" height="30">
            <?php endif;?>
            <div class="d-none d-xl-block ps-2">
            <!-- <div>Paweł Kuna</div> -->
            <div class="mt-1 small text-muted"><?= ucwords($this->session->userdata('level'))?></div>
            </div>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            <a href="<?= base_url()?>auth/logout" class="dropdown-item">Logout</a>
        </div>
        </div>
    </div>
    </div>
</header>