<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        if ((empty($_SESSION['username_app']) or $_SESSION['username_app'] == FALSE)
            || (empty($_SESSION['login_app']) or $_SESSION['login_app'] == FALSE)
        ) {
            redirect(base_url("Auth"));
        }
    }

    public function index(){
        $data['title'] = 'User';
        $data['content'] = 'user/index_user';
        $data['custom_js'] = 'user';
        $data['template_css'] = [
            'datatables-bs4/css/dataTables.bootstrap4.min.css',
            'datatables-responsive/css/responsive.bootstrap4.min.css',
        ];
        $data['template_js'] = [
            'datatables/jquery.dataTables.min.js',
            'datatables-bs4/js/dataTables.bootstrap4.min.js',
            'datatables-responsive/js/dataTables.responsive.min.js',
            'datatables-responsive/js/responsive.bootstrap4.min.js',
        ];
        $data['users'] = $this->db->get('t_user');
        $this->load->view('admin/index',$data);
    }
}