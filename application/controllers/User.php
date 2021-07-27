<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

    public function index(){
        if($this->session->userdata("level") == "Super Admin") {
            $data['title'] = 'List User';
            $data['menu'] = "User";
            $data['dropdown'] = "listUser"; 
            $data['modal'] = ["modal_user", "modal_laporan"];
            $data['js'] = [
                "ajax.js",
                "function.js",
                "helper.js",
                "load_data/user_reload.js",
                "modules/user.js",
            ];
    
            $this->load->view("pages/user/list", $data);
        } else if($this->session->userdata("level") == "Kasir") {
            redirect(base_url("penjualan"));
        } else if($this->session->userdata("level") == "Gudang") {
            redirect(base_url("penyetokan"));
        }
    }

    public function add_user(){
        $data = $this->user->add_user();
        echo json_encode($data);
    }

    public function get_user(){
        $data = $this->user->get_user();
        echo json_encode($data);
    }

    public function edit_user(){
        $data = $this->user->edit_user();
        echo json_encode($data);
    }
    
    public function load_user(){
        header('Content-Type: application/json');
        $output = $this->user->load_user();
        echo $output;
    }
}

/* End of file User.php */
