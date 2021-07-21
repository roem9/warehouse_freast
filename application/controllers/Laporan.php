<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends MY_Controller {

    public function stok(){
        $this->laporan->stok();
    }

    public function penyetokan(){
        $this->laporan->penyetokan();
    }

    public function downloadLaporan(){
        $this->laporan->downloadLaporan();
    }

}

/* End of file Laporan.php */
