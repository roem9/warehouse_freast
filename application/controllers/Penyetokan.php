<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Penyetokan extends MY_Controller {

    public function index(){
        $level = $this->session->userdata("level");

        if($level == "Super Admin" || $level == "Gudang") {
            $data['title'] = 'Tambah Penyetokan';
            $data['menu'] = 'Penyetokan';
            $data['dropdown'] = 'tambahPenyetokan';

            $data['modal'] = ["modal_laporan"];

            $data['js'] = [
                "ajax.js",
                "function.js",
                "helper.js",
                "modules/penyetokan.js",
            ];

            $this->load->view("pages/penyetokan/tambah", $data);
        } else {
            // jika level kasir arahkan ke penjualan
            redirect(base_url("penjualan"));
        }
    }

    public function list(){
        $level = $this->session->userdata("level");

        if($level == "Super Admin" || $level == "Gudang") {
            $data['title'] = 'List Penyetokan';
            $data['menu'] = 'Penyetokan';
            $data['dropdown'] = 'listPenyetokan';

            $data['modal'] = ["modal_laporan"];

            $data['js'] = [
                "ajax.js",
                "function.js",
                "helper.js",
                "load_data/penyetokan_reload.js",
                "modules/penyetokan.js",
            ];

            $this->load->view("pages/penyetokan/list", $data);
        } else {
            // jika level kasir arahkan ke penjualan
            redirect(base_url("penjualan"));
        }
    }

    public function arsip(){
        $level = $this->session->userdata("level");

        if($level == "Super Admin") {
            $data['title'] = 'List Arsip Penyetokan';
            $data['menu'] = 'Penyetokan';
            $data['dropdown'] = 'arsipPenyetokan';

            $data['modal'] = ["modal_laporan"];

            $data['js'] = [
                "ajax.js",
                "function.js",
                "helper.js",
                "load_data/penyetokan_reload.js",
                "modules/penyetokan.js",
            ];

            $this->load->view("pages/penyetokan/list", $data);
        } else if($level == "Kasir") {
            redirect(base_url("penjualan"));
        } else if($level == "Gudang") {
            redirect(base_url("penyetokan"));
        }
    }

    public function detail($id_penyetokan){
        $level = $this->session->userdata("level");

        if($level == "Super Admin" || $level == "Gudang") {
            $data['title'] = 'Detail Penyetokan';
            $data['menu'] = 'Penyetokan';

            $data['modal'] = ["modal_laporan"];

            $data['js'] = [
                "ajax.js",
                "function.js",
                "helper.js",
                "modules/penyetokan.js",
            ];

            $data['penyetokan'] = $this->penyetokan->get_one("penyetokan", ["md5(id_penyetokan)" => $id_penyetokan]);
            $data['detail_penyetokan'] = $this->penyetokan->get_all("detail_penyetokan", ["md5(id_penyetokan)" => $id_penyetokan]);

            $this->load->view("pages/penyetokan/detail", $data);
        } else {
            // jika level kasir arahkan ke penjualan
            redirect(base_url("penjualan"));
        }

    }

    public function add_penyetokan(){
        $data = $this->penyetokan->add_penyetokan();
        echo json_encode($data);
    }

    public function load_penyetokan($status = ""){
        header('Content-Type: application/json');
        $output = $this->penyetokan->load_penyetokan($status);
        echo $output;
    }

    public function arsip_penyetokan(){
        $data = $this->penyetokan->arsip_penyetokan();
        echo json_encode($data);
    }
    
    public function buka_arsip_penyetokan(){
        $data = $this->penyetokan->buka_arsip_penyetokan();
        echo json_encode($data);
    }

    public function edit_penyetokan(){
        $data = $this->penyetokan->edit_penyetokan();
        echo json_encode($data);
    }
}

/* End of file Penyetokan.php */
