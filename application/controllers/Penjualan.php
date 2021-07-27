<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan extends MY_Controller {

    public function index(){
        $level = $this->session->userdata("level");

        if($level == "Super Admin" || $level == "Kasir") {
            $data['title'] = 'Tambah Penjualan';
            $data['menu'] = 'Penjualan';
            $data['dropdown'] = 'tambahPenjualan';

            $data['modal'] = ["modal_laporan"];

            $data['js'] = [
                "ajax.js",
                "function.js",
                "helper.js",
                "modules/penjualan.js",
            ];

            $this->load->view("pages/penjualan/tambah", $data);
        } else {
            // jika level gudang arahkan ke penyetokan
            redirect(base_url("penyetokan"));
        }
    }

    public function list(){
        $level = $this->session->userdata("level");

        if($level == "Super Admin" || $level == "Kasir") {
            $data['title'] = 'List Penjualan';
            $data['menu'] = 'Penjualan';
            $data['dropdown'] = 'listPenjualan';

            $data['modal'] = ["modal_laporan"];

            $data['js'] = [
                "ajax.js",
                "function.js",
                "helper.js",
                "load_data/penjualan_reload.js",
                "modules/penjualan.js",
            ];

            $this->load->view("pages/penjualan/list", $data);
        } else {
            // jika level gudang arahkan ke penyetokan
            redirect(base_url("penyetokan"));
        }
    }

    public function arsip(){
        $level = $this->session->userdata("level");

        if($level == "Super Admin") {
            $data['title'] = 'List Arsip Penjualan';
            $data['menu'] = 'Penjualan';
            $data['dropdown'] = 'arsipPenjualan';

            $data['modal'] = ["modal_laporan"];

            $data['js'] = [
                "ajax.js",
                "function.js",
                "helper.js",
                "load_data/penjualan_reload.js",
                "modules/penjualan.js",
            ];

            $this->load->view("pages/penjualan/list", $data);
        } else if($level == "Kasir") {
            redirect(base_url("penjualan"));
        } else if($level == "Gudang") {
            redirect(base_url("penyetokan"));
        }
    }

    public function detail($id_penjualan){
        $level = $this->session->userdata("level");

        if($level == "Super Admin" || $level == "Kasir") {
            $data['title'] = 'Detail Penjualan';
            $data['menu'] = 'Penjualan';

            $data['modal'] = ["modal_laporan"];

            $data['js'] = [
                "ajax.js",
                "function.js",
                "helper.js",
                "modules/penjualan.js",
            ];

            $data['penjualan'] = $this->penjualan->get_one("penjualan", ["md5(id_penjualan)" => $id_penjualan]);
            $data['detail_penjualan'] = $this->penjualan->get_all("detail_penjualan", ["md5(id_penjualan)" => $id_penjualan]);

            $this->load->view("pages/penjualan/detail", $data);
        } else {
            // jika level gudang arahkan ke penyetokan
            redirect(base_url("penyetokan"));
        }
    }

    public function add_penjualan(){
        $data = $this->penjualan->add_penjualan();
        echo json_encode($data);
    }

    public function load_penjualan($status = ""){
        header('Content-Type: application/json');
        $output = $this->penjualan->load_penjualan($status);
        echo $output;
    }

    public function arsip_penjualan(){
        $data = $this->penjualan->arsip_penjualan();
        echo json_encode($data);
    }
    
    public function buka_arsip_penjualan(){
        $data = $this->penjualan->buka_arsip_penjualan();
        echo json_encode($data);
    }

    public function edit_penjualan(){
        $data = $this->penjualan->edit_penjualan();
        echo json_encode($data);
    }
}

/* End of file Penjualan.php */
