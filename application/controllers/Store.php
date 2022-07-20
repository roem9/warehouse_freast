<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Store extends MY_Controller {

    public function index(){
        if($this->session->userdata("level") == "Super Admin") {
            $data['title'] = 'List Store';
            $data['menu'] = "Store";
            $data['dropdown'] = "listUser"; 
            $data['modal'] = ["modal_store", "modal_laporan"];
            $data['js'] = [
                "ajax.js",
                "function.js",
                "helper.js",
                "load_data/store_reload.js",
                "modules/store.js",
            ];
    
            $this->load->view("pages/store/list", $data);
        } else if($this->session->userdata("level") == "Kasir") {
            redirect(base_url("penjualan"));
        } else if($this->session->userdata("level") == "Gudang") {
            redirect(base_url("penyetokan"));
        }
    }

    public function add_store(){
        $data = $this->store->add_store();
        echo json_encode($data);
    }

    public function get_store(){
        $data = $this->store->get_store();
        echo json_encode($data);
    }

    public function edit_store(){
        $data = $this->store->edit_store();
        echo json_encode($data);
    }
    
    public function load_store(){
        header('Content-Type: application/json');
        $output = $this->store->load_store();
        echo $output;
    }

    public function detail($id_store){
        if($this->session->userdata("level") == "Super Admin") {
            
            $data['store'] = $this->store->get_one("store", ["md5(id_store)" => $id_store]);
            $data['title'] = 'Store ' . $data['store']['nama_store'];
            $data['menu'] = "Store";
            $data['dropdown'] = "listUser"; 
            $data['modal'] = ["modal_store", "modal_laporan"];
            $data['js'] = [
                "ajax.js",
                "function.js",
                "helper.js",
                // "load_data/store_reload.js",
                "modules/store.js",
            ];

            $data['konsinyasi'] = [];
            $konsinyasi = $this->store->get_all("konsinyasi", ["md5(id_store)" => $id_store]);
            foreach ($konsinyasi as $i => $konsinyasi) {
                $data['konsinyasi'][$i] = $konsinyasi;
                
                $data['konsinyasi'][$i]['item'] = 0;
                $data['konsinyasi'][$i]['total'] = 0;

                $item = $this->store->get_all("detail_konsinyasi", ["id_konsinyasi" => $konsinyasi['id_konsinyasi']]);
                foreach ($item as $item) {
                    $data['konsinyasi'][$i]['item'] += $item['qty'];
                    $data['konsinyasi'][$i]['total'] += $item['qty'] * (($item['harga'] - ($item['harga'] * ($item['disc_sale'] / 100))) - (($item['harga'] - ($item['harga'] * ($item['disc_sale'] / 100))) * ($item['diskon'] / 100)));
                }
            }

            $data['retur'] = [];
            $retur = $this->store->get_all("retur", ["md5(id_store)" => $id_store]);
            foreach ($retur as $i => $retur) {
                $data['retur'][$i] = $retur;
                
                $data['retur'][$i]['item'] = 0;
                $data['retur'][$i]['total'] = 0;

                $item = $this->store->get_all("detail_retur", ["id_retur" => $retur['id_retur']]);
                foreach ($item as $item) {
                    $data['retur'][$i]['item'] += $item['qty'];
                    $data['retur'][$i]['total'] += $item['qty'] * (($item['harga'] - ($item['harga'] * ($item['disc_sale'] / 100))) - (($item['harga'] - ($item['harga'] * ($item['disc_sale'] / 100))) * ($item['diskon'] / 100)));
                }
            }

            $data['pencairan'] = [];
            $data['pencairan'] = $this->store->get_all("pencairan_store", ["md5(id_store)" => $id_store]);
    
            $this->load->view("pages/store/consigment", $data);
        } else if($this->session->userdata("level") == "Kasir") {
            redirect(base_url("penjualan"));
        } else if($this->session->userdata("level") == "Gudang") {
            redirect(base_url("penyetokan"));
        }
    }

    public function add_konsinyasi(){
        $data = $this->store->add_konsinyasi();
        echo json_encode($data);
    }

    public function edit_konsinyasi(){
        $data = $this->store->edit_konsinyasi();
        echo json_encode($data);
    }

    public function get_all_konsinyasi(){
        $data = $this->store->get_all_konsinyasi();
        echo json_encode($data);
    }

    public function detail_konsinyasi(){
        $data = $this->store->detail_konsinyasi();
        echo json_encode($data);
    }

    public function add_retur(){
        $data = $this->store->add_retur();
        echo json_encode($data);
    }

    public function get_all_retur(){
        $data = $this->store->get_all_retur();
        echo json_encode($data);
    }

    public function edit_retur(){
        $data = $this->store->edit_retur();
        echo json_encode($data);
    }

    public function detail_retur(){
        $data = $this->store->detail_retur();
        echo json_encode($data);
    }

    // pencairan 
    public function add_pencairan(){
        $data = $this->store->add_pencairan();
        echo json_encode($data);
    }

    public function get_all_pencairan(){
        $data = $this->store->get_all_pencairan();
        echo json_encode($data);
    }

    public function get_pencairan(){
        $data = $this->store->get_pencairan();
        echo json_encode($data);
    }

    public function edit_pencairan(){
        $data = $this->store->edit_pencairan();
        echo json_encode($data);
    }

    public function detail_pencairan(){
        $data = $this->store->detail_pencairan();
        echo json_encode($data);
    }

    public function get_asset_store(){
        $id_store = $this->input->post("id_store");

        echo assetStore($id_store);
    }
}

/* End of file store.php */
