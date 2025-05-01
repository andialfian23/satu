<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    
    public function __construct(){
        parent::__construct();

        if ((empty($_SESSION['username_app']) or $_SESSION['username_app'] == FALSE)
            || (empty($_SESSION['login_app']) or $_SESSION['login_app'] == FALSE)
        ) {
            redirect(base_url("Auth"));
        }

        
        $this->load->library('encryption');
    }

	public function index()
	{
        $data['content'] = 'dashboard/home';
        $data['custom_js'] = 'home';
        $this->load->view('admin/index',$data);
    }

	public function index2()
	{
        $this->load->view('dashboard/template');
    }
	
    public function show_apk(){
        $username = $_SESSION['username_app'];
        $query = $this->db->query("SELECT a.app_name, a.url,
                    au.id_user, au.id_level, l.app_level, l.level_name,
                    a.cipher_name, a.cipher_mode, a.cipher_key
                FROM t_app_user as au
                INNER JOIN t_level as l ON au.id_level = l.id_level
                INNER JOIN t_app as a ON l.id_app = l.id_app
                INNER JOIN t_user as u ON au.id_user = u.id_user 
                WHERE u.username = '{$username}'
                ORDER BY a.app_name ASC
                ");
        $data = '';
        
        if($query){
            foreach($query->result() as $key){
                $time = date('Y-m-d H:i:s');
                $plain_text = "$time#" . $key->id_user . "#" . $key->id_level . "#" . $key->app_level;
                $hash = $this->encryption($plain_text, $key->cipher_name, $key->cipher_mode, $key->cipher_key);
    
                $data .= '<div class="card_app">
                            <div class="img_app"></div>
                            <div class="text_app">
                                <p class="h3">'.$key->app_name.'</p>
                                <a href="'.$key->url.'/'.$hash.'" class="btn btn-success btn-sm font-weight-bold" target="_blank">
                                    Login AS '.$key->level_name.'</a>
                            </div>
                        </div>';
            }
        }
        $output = [
            'data' => $data
        ];
        echo json_encode($output);
    }

    private function encryption($plain_text,$cipher,$mode,$salt_key)
    {
        $this->encryption->initialize(array(
            'cipher' => $cipher,
            'mode' => $mode,
            'key' => $salt_key
        ));
        $ciphertext = $this->encryption->encrypt($plain_text);
        return str_replace('=', '', base64_encode($ciphertext));
    }
}