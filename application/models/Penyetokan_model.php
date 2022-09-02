<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Penyetokan_model extends MY_Model {

    public function add_penyetokan(){
        $id_artikel = $this->input->post("id_artikel");
        $qty = $this->input->post("qty");

        unset($_POST['id_artikel']);
        unset($_POST['qty']);

        $data = [];
        foreach ($_POST as $key => $value) {
            $data[$key] = $this->input->post($key);
        }

        $data['id_admin'] = $this->session->userdata('id_admin');

        date_default_timezone_set('Asia/Makassar');
        $data['tgl_penyetokan'] = date("Y-m-d H:i:s");

        $id_penyetokan = $this->add_data("penyetokan", $data);

        foreach ($id_artikel as $i => $id_artikel) {
            $artikel = $this->get_one("artikel", ["id_artikel" => $id_artikel]);
            $data = [
                "id_penyetokan" => $id_penyetokan,
                "id_artikel" => $id_artikel,
                "nama_artikel" => $artikel['nama_artikel'],
                "ukuran" => $artikel['ukuran'],
                "qty" => $qty[$i],
            ];

            $query = $this->add_data("detail_penyetokan", $data);
        }
        
        if($query) return 1;
        else return 0;
    }

    public function arsip_penyetokan(){
        $id_penyetokan = $this->input->post("id_penyetokan");

        $data = $this->edit_data("penyetokan", ["id_penyetokan" => $id_penyetokan], ["hapus" => 1]);
        $data = $this->edit_data("detail_penyetokan", ["id_penyetokan" => $id_penyetokan], ["hapus" => 1]);
        
        if($data) return 1;
        else return 0;
    }

    public function buka_arsip_penyetokan(){
        $id_penyetokan = $this->input->post("id_penyetokan");

        $data = $this->edit_data("penyetokan", ["id_penyetokan" => $id_penyetokan], ["hapus" => 0]);
        $data = $this->edit_data("detail_penyetokan", ["id_penyetokan" => $id_penyetokan], ["hapus" => 0]);

        if($data) return 1;
        else return 0;
    }

    public function load_penyetokan($status){
        $id_admin = $this->session->userdata('id_admin');
        $level = $this->session->userdata("level");

        $this->datatables->select('id_penyetokan, tgl_penyetokan, keterangan');
        $this->datatables->from('penyetokan');

        if($status == "arsip") $this->datatables->where("hapus", "1");
        else $this->datatables->where("hapus", "0");

        if($level <> "Super Admin"){
            $date = date("Y-m-d");
            $date = date('Y-m-d', strtotime('-1 days', strtotime($date)));
            $this->datatables->where("id_admin", $id_admin);
            $this->datatables->where("tgl_penyetokan >= ", $date);
        }

        $this->datatables->add_column("tgl", "$1", "tgl_waktu(tgl_penyetokan, TRUE)");
        $this->datatables->add_column("stok", "$1", "item_penyetokan(id_penyetokan)");
        $this->datatables->add_column("asset", "$1", "assetPenyetokan(id_penyetokan)");

        if($status == "arsip"){
            $this->datatables->add_column('menu','
                        <span class="dropdown">
                        <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">
                            '.tablerIcon("menu-2", "me-1").'
                            Menu
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" target="_blank" href="'.base_url().'penyetokan/detail/$2" data-id="$1">
                                '.tablerIcon("info-circle", "me-1").'
                                Detail Penyetokan
                            </a>
                            <a class="dropdown-item bukaArsipPenyetokan" href="javascript:void(0)" data-id="$1">
                                '.tablerIcon("archive", "me-1").'
                                Buka Arsip
                            </a>
                        </div>
                        </span>', 'id_penyetokan, md5(id_penyetokan)');
        } else {
            if($level == "Super Admin"){
                $this->datatables->add_column('menu','
                            <span class="dropdown">
                            <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">
                                '.tablerIcon("menu-2", "me-1").'
                                Menu
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" target="_blank" href="'.base_url().'penyetokan/detail/$2" data-id="$1">
                                    '.tablerIcon("info-circle", "me-1").'
                                    Detail Penyetokan
                                </a>
                                <a class="dropdown-item arsipPenyetokan" href="javascript:void(0)" data-id="$1">
                                    '.tablerIcon("archive", "me-1").'
                                    Arsipkan
                                </a>
                            </div>
                            </span>', 'id_penyetokan, md5(id_penyetokan)');
            } else {
                $this->datatables->add_column('menu','
                            <span class="dropdown">
                            <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">
                                '.tablerIcon("menu-2", "me-1").'
                                Menu
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" target="_blank" href="'.base_url().'penyetokan/detail/$2" data-id="$1">
                                    '.tablerIcon("info-circle", "me-1").'
                                    Detail Penyetokan
                                </a>
                            </div>
                            </span>', 'id_penyetokan, md5(id_penyetokan)');
            }
        }

        return $this->datatables->generate();
    }

    public function edit_penyetokan(){
        $id_penyetokan = $this->input->post("id_penyetokan");
        $id_artikel = $this->input->post("id_artikel");
        $qty = $this->input->post("qty");

        unset($_POST['id_penyetokan']);
        unset($_POST['id_artikel']);
        unset($_POST['qty']);

        $data = [];
        foreach ($_POST as $key => $value) {
            $data[$key] = $this->input->post($key);
        }

        $this->edit_data("penyetokan", ["id_penyetokan" => $id_penyetokan], $data);

        $this->delete_data("detail_penyetokan", ["id_penyetokan" => $id_penyetokan]);

        foreach ($id_artikel as $i => $id_artikel) {
            $artikel = $this->get_one("artikel", ["id_artikel" => $id_artikel]);
            $data = [
                "id_penyetokan" => $id_penyetokan,
                "id_artikel" => $id_artikel,
                "nama_artikel" => $artikel['nama_artikel'],
                "ukuran" => $artikel['ukuran'],
                "qty" => $qty[$i],
            ];

            $query = $this->add_data("detail_penyetokan", $data);
        }
        
        if($query) return 1;
        else return 0;
    }

}

/* End of file Penyetokan_model.php */
