<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends MY_Model {

    public function add_user(){
        $data = [];
        foreach ($_POST as $key => $value) {
            if($key == "password")
                $data[$key] = md5($this->input->post($key));
            else 
                $data[$key] = $this->input->post($key);

        }
        
        $query = $this->add_data("admin", $data);
        
        if($query) return 1;
        else return 0;
    }

    public function edit_user(){
        $id_admin = $this->input->post("id_admin");

        $data = [];
        foreach ($_POST as $key => $value) {
            if($key == "password"){
                if($this->input->post("password") != ""){
                    $data[$key] = md5($this->input->post($key));
                }
            }
            else 
                $data[$key] = $this->input->post($key);

        }

        $query = $this->edit_data("admin", ["id_admin" => $id_admin], $data);
        if($query) return 1;
        else return 0;
    }

    public function get_user(){
        $id_admin = $this->input->post("id_admin");
        $data = $this->get_one("admin", ["id_admin" => $id_admin]);
        return $data;
    }

    public function load_user(){
        $this->datatables->select('id_admin, nama, username, hapus, level');
        $this->datatables->from('admin');

        $this->datatables->add_column('menu','
                    <span class="dropdown">
                    <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">
                        '.tablerIcon("menu-2", "me-1").'
                        Menu
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item detailUser" data-bs-toggle="modal" href="#detailUser" data-id="$1">
                            '.tablerIcon("info-circle", "me-1").'
                            Detail User
                        </a>
                    </div>
                    </span>', 'id_admin');

        return $this->datatables->generate();
    }
}

/* End of file User_model.php */
