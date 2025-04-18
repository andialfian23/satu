<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Control extends CI_Controller {
    
    public function __construct(){
        parent::__construct();

        if (
            (empty($_SESSION['username']) or $_SESSION['username'] == FALSE)
            || (empty($_SESSION['logged_in']) or $_SESSION['logged_in'] == FALSE)
        ) {
            redirect(base_url("Auth"));
        }

        
        $this->load->library('encryption');
    }

    public function index(){
        $data['content'] = 'index_control';
        $this->load->view('index',$data);
    }
}