<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Artikel_model extends MY_Model {

    public function add_artikel(){
        $tipe_ukuran = $this->input->post("tipe_ukuran");
        unset($_POST['tipe_ukuran']);
        
        $nomor_terkecil = $this->input->post("nomor_terkecil");
        $nomor_terbesar = $this->input->post("nomor_terbesar");
        unset($_POST['nomor_terkecil']);
        unset($_POST['nomor_terbesar']);

        // simpan ukuran dalam array
        $ukuran = [];
        if(isset($_POST['ukuran'])){
            $ukuran = $this->input->post("ukuran");
            unset($_POST['ukuran']);
        }

        $_POST['harga'] = rupiah_to_int($_POST['harga']);
        
        // jika tipe ukuran = tanpa ukuran
        if($tipe_ukuran == "Tanpa Ukuran"){
            $data = [];
            foreach ($_POST as $key => $value) {
                $data[$key] = $this->input->post($key);
            }

            $query = $this->add_data("artikel", $data);
        } else if($tipe_ukuran == "Ukuran Alphabet"){
            $data = [];
            foreach ($_POST as $key => $value) {
                $data[$key] = $this->input->post($key);
            }

            if($ukuran){
                foreach ($ukuran as $ukuran) {
                    $data['ukuran'] = $ukuran;
                    $query = $this->add_data("artikel", $data);
                }
            } else {
                $query = $this->add_data("artikel", $data);
            }
        } else if($tipe_ukuran == "Ukuran Angka"){
            $data = [];
            foreach ($_POST as $key => $value) {
                $data[$key] = $this->input->post($key);
            }
            

            for ($i=$nomor_terkecil; $i <= $nomor_terbesar; $i++) { 
                $data['ukuran'] = $i;
                $query = $this->add_data("artikel", $data);
            }
        }


        if($query) return 1;
        else return 0;
    }

    public function edit_artikel(){
        // edit seluruh artikel dengan kondisi memiliki nama artikel dan produk yang sama
        $id_artikel = $this->input->post("id_artikel");

        $artikel = $this->get_one("artikel", ["id_artikel" => $id_artikel]);

        unset($_POST['id_artikel']);

        $_POST['harga'] = rupiah_to_int($_POST['harga']);

        $data = [];
        foreach ($_POST as $key => $value) {
            $data[$key] = $this->input->post($key);
        }

        $query = $this->edit_data("artikel", ["nama_artikel" => $artikel['nama_artikel'], "produk" => $artikel['produk']], $data);
        if($query) return 1;
        else return 0;
    }

    public function get_artikel(){
        $id_artikel = $this->input->post("id_artikel");
        $data = $this->get_one("artikel", ["id_artikel" => $id_artikel]);
        return $data;
    }
    
    public function get_all_artikel(){
        $artikel = $this->get_all("artikel", ["hapus" => 0], "nama_artikel");
        
        $data = [];
        foreach ($artikel as $i => $artikel) {
            $data[$i] = $artikel;
            $data[$i]['stok'] = stok_artikel($artikel['id_artikel']);
        }

        return $data;
    }

    public function arsip_artikel(){
        $id_artikel = $this->input->post("id_artikel");

        $data = $this->edit_data("artikel", ["id_artikel" => $id_artikel], ["hapus" => 1]);
        if($data) return 1;
        else return 0;
    }

    public function buka_arsip_artikel(){
        $id_artikel = $this->input->post("id_artikel");

        $data = $this->edit_data("artikel", ["id_artikel" => $id_artikel], ["hapus" => 0]);
        if($data) return 1;
        else return 0;
    }

    public function add_produk(){
        $data = [];
        foreach ($_POST as $key => $value) {
            $data[$key] = $this->input->post($key);
        }

        $query = $this->add_data("produk", $data);
        if($query) return 1;
        else return 0;
    }

    public function edit_produk(){
        $id_produk = $this->input->post("id_produk");
        unset($_POST['id_produk']);

        $data = [];
        foreach ($_POST as $key => $value) {
            $data[$key] = $this->input->post($key);
        }

        $query = $this->edit_data("produk", ["id_produk" => $id_produk], $data);
        if($query) return 1;
        else return 0;
    }

    public function get_produk(){
        $id_produk = $this->input->post("id_produk");
        $data = $this->get_one("produk", ["id_produk" => $id_produk]);
        return $data;
    }

    public function arsip_produk(){
        $id_produk = $this->input->post("id_produk");

        $data = $this->edit_data("produk", ["id_produk" => $id_produk], ["hapus" => 1]);
        if($data) return 1;
        else return 0;
    }

    public function load_artikel($status){
        $this->datatables->select('id_artikel, produk, nama_artikel, harga, diskon, hapus, ukuran');
        $this->datatables->from('artikel');

        $this->datatables->add_column('stok','$1', 'stok_artikel(id_artikel)');

        if($status == "arsip") $this->datatables->where("hapus", "1");
        else $this->datatables->where("hapus", "0");

        if($status == "arsip"){
            $this->datatables->add_column('menu','
                        <span class="dropdown">
                        <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">
                            '.tablerIcon("menu-2", "me-1").'
                            Menu
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item detailArtikel" data-bs-toggle="modal" href="#detailArtikel" data-id="$1">
                                '.tablerIcon("info-circle", "me-1").'
                                Detail Artikel
                            </a>
                            <a class="dropdown-item bukaArsipArtikel" href="javascript:void(0)" data-id="$1">
                                '.tablerIcon("archive", "me-1").'
                                Buka Arsip
                            </a>
                        </div>
                        </span>', 'id_artikel');
        } else {
            $this->datatables->add_column('menu','
                        <span class="dropdown">
                        <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">
                            '.tablerIcon("menu-2", "me-1").'
                            Menu
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item detailArtikel" data-bs-toggle="modal" href="#detailArtikel" data-id="$1">
                                '.tablerIcon("info-circle", "me-1").'
                                Detail Artikel
                            </a>
                            <a class="dropdown-item arsipArtikel" href="javascript:void(0)" data-id="$1">
                                '.tablerIcon("archive", "me-1").'
                                Arsipkan
                            </a>
                        </div>
                        </span>', 'id_artikel');
        }

        return $this->datatables->generate();
    }

    public function load_produk(){
        $this->datatables->select('id_produk, produk');
        $this->datatables->from('produk');
        $this->datatables->where("hapus", "0");
        $this->datatables->add_column('menu','
                    <span class="dropdown">
                    <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">
                        '.tablerIcon("menu-2", "me-1").'
                        Menu
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item detailProduk" data-bs-toggle="modal" href="#detailProduk" data-id="$1">
                            '.tablerIcon("info-circle", "me-1").'
                            Detail Produk
                        </a>
                        <a class="dropdown-item arsipProduk" href="javascript:void(0)" data-id="$1">
                            '.tablerIcon("trash", "me-1").'
                            Hapus
                        </a>
                    </div>
                    </span>', 'id_produk');

        return $this->datatables->generate();
    }

}

/* End of file Artikel_model.php */
