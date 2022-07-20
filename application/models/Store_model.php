<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Store_model extends MY_Model {

    public function add_store(){
        $data = [];
        foreach ($_POST as $key => $value) {
            $data[$key] = $this->input->post($key);
        }
        
        $query = $this->add_data("store", $data);
        
        if($query) return 1;
        else return 0;
    }

    public function edit_store(){
        $id_store = $this->input->post("id_store");

        $data = [];
        foreach ($_POST as $key => $value) {
            $data[$key] = $this->input->post($key);
        }

        $query = $this->edit_data("store", ["id_store" => $id_store], $data);
        if($query) return 1;
        else return 0;
    }

    public function get_store(){
        $id_store = $this->input->post("id_store");
        $data = $this->get_one("store", ["id_store" => $id_store]);
        return $data;
    }

    public function load_store(){
        $this->datatables->select('id_store, nama_store, nama_pemilik, no_hp');
        $this->datatables->from('store');
        $this->datatables->add_column('nominal','$1','assetStore(id_store)');
        $this->datatables->add_column('menu','
                    <span class="dropdown">
                    <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">
                        '.tablerIcon("menu-2", "me-1").'
                        Menu
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item detailStore" data-bs-toggle="modal" href="#detailStore" data-id="$1">
                            '.tablerIcon("info-circle", "me-1").'
                            Detail Store
                        </a>
                        <a class="dropdown-item" href="'.base_url().'store/detail/$2" target="_blank">
                            '.tablerIcon("building-warehouse", "me-1").'
                            Consigment
                        </a>
                    </div>
                    </span>', 'id_store, md5(id_store)');

        return $this->datatables->generate();
    }

    public function add_konsinyasi(){
        $id_artikel = $this->input->post("id_artikel");
        $qty = $this->input->post("qty");
        $diskon = $this->input->post("diskon");
        $disc_sale = $this->input->post("disc_sale");

        unset($_POST['id_artikel']);
        unset($_POST['qty']);
        unset($_POST['diskon']);
        unset($_POST['disc_sale']);

        $data = [];
        foreach ($_POST as $key => $value) {
            $data[$key] = $this->input->post($key);
        }

        $data['id_admin'] = $this->session->userdata('id_admin');

        date_default_timezone_set('Asia/Makassar');
        $data['tgl_konsinyasi'] = date("Y-m-d H:i:s");

        $id_konsinyasi = $this->add_data("konsinyasi", $data);

        foreach ($id_artikel as $i => $id_artikel) {
            $artikel = $this->get_one("artikel", ["id_artikel" => $id_artikel]);
            $data = [
                "id_konsinyasi" => $id_konsinyasi,
                "id_artikel" => $id_artikel,
                "nama_artikel" => $artikel['nama_artikel'],
                "ukuran" => $artikel['ukuran'],
                "qty" => $qty[$i],
                "harga" => $artikel['harga'],
                "diskon" => $diskon[$i],
                "disc_sale" => $disc_sale[$i]
            ];

            $query = $this->add_data("detail_konsinyasi", $data);
        }
        
        if($query) return 1;
        else return 0;
    }

    public function get_all_konsinyasi(){
        $data['konsinyasi'] = [];
        
        $id_store = $this->input->post("id_store");
        $konsinyasi = $this->store->get_all("konsinyasi", ["id_store" => $id_store]);
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

        return $data['konsinyasi'];
    }

    public function edit_konsinyasi(){
        $id_konsinyasi = $this->input->post("id_konsinyasi");
        $id_artikel = $this->input->post("id_artikel");
        $qty = $this->input->post("qty");
        $diskon = $this->input->post("diskon");
        $disc_sale = $this->input->post("disc_sale");

        unset($_POST['id_konsinyasi']);
        unset($_POST['id_artikel']);
        unset($_POST['qty']);
        unset($_POST['diskon']);
        unset($_POST['disc_sale']);

        $data = [];
        foreach ($_POST as $key => $value) {
            $data[$key] = $this->input->post($key);
        }

        $this->edit_data("konsinyasi", ["id_konsinyasi" => $id_konsinyasi], $data);

        $this->delete_data("detail_konsinyasi", ["id_konsinyasi" => $id_konsinyasi]);

        foreach ($id_artikel as $i => $id_artikel) {
            $artikel = $this->get_one("artikel", ["id_artikel" => $id_artikel]);
            $data = [
                "id_konsinyasi" => $id_konsinyasi,
                "id_artikel" => $id_artikel,
                "nama_artikel" => $artikel['nama_artikel'],
                "ukuran" => $artikel['ukuran'],
                "qty" => $qty[$i],
                "harga" => $artikel['harga'],
                "diskon" => $diskon[$i],
                "disc_sale" => $disc_sale[$i]
            ];

            $query = $this->add_data("detail_konsinyasi", $data);
        }
        
        if($query) return 1;
        else return 0;
    }

    public function detail_konsinyasi(){
        $id_konsinyasi = $this->input->post("id_konsinyasi");

        $data['konsinyasi'] = $this->get_one("konsinyasi", ["id_konsinyasi" => $id_konsinyasi]);
        $data['konsinyasi']['tgl_konsinyasi'] = date("Y-m-d\TH:i", strtotime($data['konsinyasi']['tgl_konsinyasi']));
        $data['detail_konsinyasi'] = $this->get_all("detail_konsinyasi", ["id_konsinyasi" => $id_konsinyasi]);

        return $data;
    }

    public function add_retur(){
        $id_artikel = $this->input->post("id_artikel");
        $qty = $this->input->post("qty");
        $diskon = $this->input->post("diskon");
        $disc_sale = $this->input->post("disc_sale");

        unset($_POST['id_artikel']);
        unset($_POST['qty']);
        unset($_POST['diskon']);
        unset($_POST['disc_sale']);

        $data = [];
        foreach ($_POST as $key => $value) {
            $data[$key] = $this->input->post($key);
        }

        $data['id_admin'] = $this->session->userdata('id_admin');

        date_default_timezone_set('Asia/Makassar');
        $data['tgl_retur'] = date("Y-m-d H:i:s");

        $id_retur = $this->add_data("retur", $data);

        foreach ($id_artikel as $i => $id_artikel) {
            $artikel = $this->get_one("artikel", ["id_artikel" => $id_artikel]);
            $data = [
                "id_retur" => $id_retur,
                "id_artikel" => $id_artikel,
                "nama_artikel" => $artikel['nama_artikel'],
                "ukuran" => $artikel['ukuran'],
                "qty" => $qty[$i],
                "harga" => $artikel['harga'],
                "diskon" => $diskon[$i],
                "disc_sale" => $disc_sale[$i]
            ];

            $query = $this->add_data("detail_retur", $data);
        }
        
        if($query) return 1;
        else return 0;
    }

    public function get_all_retur(){
        $data['retur'] = [];
        
        $id_store = $this->input->post("id_store");
        $retur = $this->store->get_all("retur", ["id_store" => $id_store]);
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

        return $data['retur'];
    }

    public function detail_retur(){
        $id_retur = $this->input->post("id_retur");

        $data['retur'] = $this->get_one("retur", ["id_retur" => $id_retur]);
        $data['retur']['tgl_retur'] = date("Y-m-d\TH:i", strtotime($data['retur']['tgl_retur']));
        $data['detail_retur'] = $this->get_all("detail_retur", ["id_retur" => $id_retur]);

        return $data;
    }

    public function edit_retur(){
        $id_retur = $this->input->post("id_retur");
        $id_artikel = $this->input->post("id_artikel");
        $qty = $this->input->post("qty");
        $diskon = $this->input->post("diskon");
        $disc_sale = $this->input->post("disc_sale");

        unset($_POST['id_retur']);
        unset($_POST['id_artikel']);
        unset($_POST['qty']);
        unset($_POST['diskon']);
        unset($_POST['disc_sale']);

        $data = [];
        foreach ($_POST as $key => $value) {
            $data[$key] = $this->input->post($key);
        }

        $this->edit_data("retur", ["id_retur" => $id_retur], $data);

        $this->delete_data("detail_retur", ["id_retur" => $id_retur]);

        foreach ($id_artikel as $i => $id_artikel) {
            $artikel = $this->get_one("artikel", ["id_artikel" => $id_artikel]);
            $data = [
                "id_retur" => $id_retur,
                "id_artikel" => $id_artikel,
                "nama_artikel" => $artikel['nama_artikel'],
                "ukuran" => $artikel['ukuran'],
                "qty" => $qty[$i],
                "harga" => $artikel['harga'],
                "diskon" => $diskon[$i],
                "disc_sale" => $disc_sale[$i]
            ];

            $query = $this->add_data("detail_retur", $data);
        }
        
        if($query) return 1;
        else return 0;
    }

    // pencairan 
    public function add_pencairan(){
        $data = [
            "id_store" => $this->input->post("id_store"),
            "tgl_pencairan" => $this->input->post("tgl_pencairan"),
            "nominal" => rupiah_to_int($this->input->post("nominal")),
            "catatan" => $this->input->post("catatan")
        ];
        
        $query = $this->add_data("pencairan_store", $data);
        
        if($query) return 1;
        else return 0;
    }

    public function edit_pencairan(){
        $id_pencairan = $this->input->post("id_pencairan");

        $data = [
            "id_store" => $this->input->post("id_store"),
            "tgl_pencairan" => $this->input->post("tgl_pencairan"),
            "nominal" => rupiah_to_int($this->input->post("nominal")),
            "catatan" => $this->input->post("catatan")
        ];

        $query = $this->edit_data("pencairan_store", ["id_pencairan" => $id_pencairan], $data);
        if($query) return 1;
        else return 0;
    }

    public function get_pencairan(){
        $id_pencairan = $this->input->post("id_pencairan");
        $data = $this->get_one("pencairan_store", ["id_pencairan" => $id_pencairan]);
        return $data;
    }

    public function get_all_pencairan(){
        $id_store = $this->input->post("id_store");
        $pencairan = $this->get_all("pencairan_store", ["id_store" => $id_store]);
        return $pencairan;
    }
}

/* End of file User_model.php */
