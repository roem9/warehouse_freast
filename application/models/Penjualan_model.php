<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan_model extends MY_Model {

    public function add_penjualan(){
        // var_dump($_POST);
        // exit();

        $id_artikel = $this->input->post("id_artikel");
        $qty = $this->input->post("qty");
        $diskon = $this->input->post("diskon");
        $sub_total = $this->input->post("sub_total");

        $cash = rupiah_to_int($_POST['cash']);
        $kembali = rupiah_to_int($_POST['kembali']);

        unset($_POST['id_artikel']);
        unset($_POST['qty']);
        unset($_POST['diskon']);
        unset($_POST['sub_total']);
        unset($_POST['cash']);
        unset($_POST['kembali']);


        $data = [];
        foreach ($_POST as $key => $value) {
            $data[$key] = $this->input->post($key);
        }

        $data['id_admin'] = $this->session->userdata('id_admin');
        $data['cash'] = $cash;
        $data['kembali'] = $kembali;

        date_default_timezone_set('Asia/Makassar');
        $data['tgl_penjualan'] = date("Y-m-d H:i:s");

        $id_penjualan = $this->add_data("penjualan", $data);

        foreach ($id_artikel as $i => $id_artikel) {
            $artikel = $this->get_one("artikel", ["id_artikel" => $id_artikel]);
            $data = [
                "id_penjualan" => $id_penjualan,
                "id_artikel" => $id_artikel,
                "nama_artikel" => $artikel['nama_artikel'],
                "ukuran" => $artikel['ukuran'],
                "qty" => $qty[$i],
                "harga" => $artikel['harga'],
                "diskon" => $diskon[$i],
                "sub_total" => $sub_total[$i],
            ];

            $query = $this->add_data("detail_penjualan", $data);
        }
        
        if($query) return 1;
        else return 0;
    }

    public function arsip_penjualan(){
        $id_penjualan = $this->input->post("id_penjualan");

        $data = $this->edit_data("penjualan", ["id_penjualan" => $id_penjualan], ["hapus" => 1]);
        $data = $this->edit_data("detail_penjualan", ["id_penjualan" => $id_penjualan], ["hapus" => 1]);
        
        if($data) return 1;
        else return 0;
    }

    public function buka_arsip_penjualan(){
        $id_penjualan = $this->input->post("id_penjualan");

        $data = $this->edit_data("penjualan", ["id_penjualan" => $id_penjualan], ["hapus" => 0]);
        $data = $this->edit_data("detail_penjualan", ["id_penjualan" => $id_penjualan], ["hapus" => 0]);

        if($data) return 1;
        else return 0;
    }

    public function load_penjualan($status){
        $id_admin = $this->session->userdata('id_admin');
        $level = $this->session->userdata("level");

        $this->datatables->select('id_penjualan, tgl_penjualan, keterangan, total');
        $this->datatables->from('penjualan');

        if($status == "arsip") $this->datatables->where("hapus", "1");
        else $this->datatables->where("hapus", "0");

        if($level <> "Super Admin"){
            $date = date("Y-m-d");
            $this->datatables->where("id_admin", $id_admin);
            $this->datatables->where("tgl_penjualan >= ", $date);
        }

        $this->datatables->add_column("tgl", "$1", "tgl_waktu(tgl_penjualan, TRUE)");
        $this->datatables->add_column("stok", "$1", "item_penjualan(id_penjualan)");

        if($status == "arsip"){
            $this->datatables->add_column('menu','
                        <span class="dropdown">
                        <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">
                            '.tablerIcon("menu-2", "me-1").'
                            Menu
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" target="_blank" href="'.base_url().'penjualan/detail/$2" data-id="$1">
                                '.tablerIcon("info-circle", "me-1").'
                                Detail Penjualan
                            </a>
                            <a class="dropdown-item bukaArsipPenjualan" href="javascript:void(0)" data-id="$1">
                                '.tablerIcon("archive", "me-1").'
                                Buka Arsip
                            </a>
                        </div>
                        </span>', 'id_penjualan, md5(id_penjualan)');
        } else {
            if($level == "Super Admin"){
                $this->datatables->add_column('menu','
                            <span class="dropdown">
                            <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">
                                '.tablerIcon("menu-2", "me-1").'
                                Menu
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" target="_blank" href="'.base_url().'penjualan/detail/$2" data-id="$1">
                                    '.tablerIcon("info-circle", "me-1").'
                                    Detail Penjualan
                                </a>
                                <a class="dropdown-item arsipPenjualan" href="javascript:void(0)" data-id="$1">
                                    '.tablerIcon("archive", "me-1").'
                                    Arsipkan
                                </a>
                            </div>
                            </span>', 'id_penjualan, md5(id_penjualan)');
            } else {
                $this->datatables->add_column('menu','
                            <span class="dropdown">
                            <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">
                                '.tablerIcon("menu-2", "me-1").'
                                Menu
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" target="_blank" href="'.base_url().'penjualan/detail/$2" data-id="$1">
                                    '.tablerIcon("info-circle", "me-1").'
                                    Detail Penjualan
                                </a>
                            </div>
                            </span>', 'id_penjualan, md5(id_penjualan)');
            }
        }

        return $this->datatables->generate();
    }

    public function edit_penjualan(){
        $id_penjualan = $this->input->post("id_penjualan");
        $id_artikel = $this->input->post("id_artikel");
        $qty = $this->input->post("qty");
        $diskon = $this->input->post("diskon");
        $sub_total = $this->input->post("sub_total");

        $cash = rupiah_to_int($_POST['cash']);
        $kembali = rupiah_to_int($_POST['kembali']);

        unset($_POST['id_artikel']);
        unset($_POST['qty']);
        unset($_POST['diskon']);
        unset($_POST['sub_total']);
        unset($_POST['cash']);
        unset($_POST['kembali']);

        $data = [];
        foreach ($_POST as $key => $value) {
            $data[$key] = $this->input->post($key);
        }
        
        $data['cash'] = $cash;
        $data['kembali'] = $kembali;

        $this->edit_data("penjualan", ["id_penjualan" => $id_penjualan], $data);

        $this->delete_data("detail_penjualan", ["id_penjualan" => $id_penjualan]);

        foreach ($id_artikel as $i => $id_artikel) {
            $artikel = $this->get_one("artikel", ["id_artikel" => $id_artikel]);
            $data = [
                "id_penjualan" => $id_penjualan,
                "id_artikel" => $id_artikel,
                "nama_artikel" => $artikel['nama_artikel'],
                "ukuran" => $artikel['ukuran'],
                "qty" => $qty[$i],
                "harga" => $artikel['harga'],
                "diskon" => $diskon[$i],
                "sub_total" => $sub_total[$i],
            ];

            $query = $this->add_data("detail_penjualan", $data);
        }
        if($query) return 1;
        else return 0;
    }

}

/* End of file Penjualan_model.php */
