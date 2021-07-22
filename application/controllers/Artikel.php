<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Artikel extends MY_Controller {

    public function index(){
        $data['title'] = 'List Artikel';
        $data['menu'] = "Artikel";
        $data['dropdown'] = "listArtikel"; 
        $data['modal'] = ["modal_artikel", "modal_laporan"];
        $data['js'] = [
            "ajax.js",
            "function.js",
            "helper.js",
            "load_data/artikel_reload.js",
            "modules/artikel.js",
        ];

        $this->load->view("pages/artikel/list", $data);
    }

    public function arsip(){
        $data['title'] = 'List Arsip Artikel';
        $data['menu'] = "Artikel";
        $data['dropdown'] = "arsipArtikel";
        $data['modal'] = ["modal_artikel", "modal_laporan"];
        $data['js'] = [
            "ajax.js",
            "function.js",
            "helper.js",
            "load_data/artikel_reload.js",
            "modules/artikel.js",
        ];

        $this->load->view("pages/artikel/list", $data);
    }

    public function produk(){
        $data['title'] = 'List Produk';
        $data['menu'] = "Artikel";
        $data['dropdown'] = "produkArtikel";
        $data['modal'] = ["modal_artikel", "modal_laporan"];
        $data['js'] = [
            "ajax.js",
            "function.js",
            "helper.js",
            "load_data/produk_reload.js",
            "modules/artikel.js",
        ];

        $this->load->view("pages/artikel/produk", $data);
    }

    public function add_artikel(){
        $data = $this->artikel->add_artikel();
        echo json_encode($data);
    }

    public function get_artikel(){
        $data = $this->artikel->get_artikel();
        echo json_encode($data);
    }

    public function get_all_artikel(){
        $data = $this->artikel->get_all_artikel();
        echo json_encode($data);
    }

    public function edit_artikel(){
        $data = $this->artikel->edit_artikel();
        echo json_encode($data);
    }

    public function arsip_artikel(){
        $data = $this->artikel->arsip_artikel();
        echo json_encode($data);
    }

    public function buka_arsip_artikel(){
        $data = $this->artikel->buka_arsip_artikel();
        echo json_encode($data);
    }

    public function add_produk(){
        $data = $this->artikel->add_produk();
        echo json_encode($data);
    }

    public function edit_produk(){
        $data = $this->artikel->edit_produk();
        echo json_encode($data);
    }
    
    public function get_produk(){
        $data = $this->artikel->get_produk();
        echo json_encode($data);
    }

    public function arsip_produk(){
        $data = $this->artikel->arsip_produk();
        echo json_encode($data);
    }

    public function load_artikel($status = ""){
        header('Content-Type: application/json');
        $output = $this->artikel->load_artikel($status);
        echo $output;
    }

    public function load_produk(){
        header('Content-Type: application/json');
        $output = $this->artikel->load_produk();
        echo $output;
    }
}

/* End of file Artikel.php */
