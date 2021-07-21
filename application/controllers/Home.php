<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }

    public function index(){
        
        $level = $this->session->userdata("level");
        if($level == "Super Admin")
            redirect(base_url('agency/batch'),'refresh');
        else 
            redirect(base_url('agency/list'),'refresh');
        
    }
}

/* End of file Home.php */
