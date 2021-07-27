<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends MY_Controller {
    public function downloadLaporan(){
        $level = $this->session->userdata('level');
        
        if ($level == "Super Admin") {
            $this->laporan->downloadLaporan();
        } else if($level == "Kasir") {
            redirect(base_url("penjualan"));
        } else if($level == "Gudang") {
            redirect(base_url("penyetokan"));
        }
    }

}

/* End of file Laporan.php */
