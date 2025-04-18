<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    
	public function index()
	{
		$this->load->view('login');
	}

    public function login(){
        $username = $this->input->post('username',TRUE);
        $password = $this->input->post('password',TRUE);
        $user = htmlspecialchars($username, true);
        // $pass = htmlspecialchars(md5($password), true);
        $pass = htmlspecialchars($password, true);
        
        $qry = $this->db->get_where('t_user',['username'=>$user]);
        if ($qry) {
            $data = $qry->row();
            if ($pass == $data->password) {
                $_SESSION["username_app"]   = $data->username;
                $_SESSION["title_app"]      = $data->title;
                $_SESSION["login_app"]  = 1;
            
                $output = [
                    'kode' => 1,
                    'pesan' => "Login Berhasil !!! <meta http-equiv='refresh' content='0; url=".base_url('Dashboard')."'>",
                ];
            } else {
                $output = [
                    'kode' => 0,
                    'pesan' => $data->password.' Password Salah !!!',
                ];
            }
        } else {
            $output = [
                'kode' => 0,
                'pesan' => 'Username Tidak Teraftar',
            ];
        }

        echo json_encode($output);
    }

    public function logout(){
        unset(
            $_SESSION['username_app'],
            $_SESSION['title_app'],
            $_SESSION['login_app'],
            // $_SESSION['API_KEY']
        );

        echo "  halaman akan tertutup dalam 2 detik
                <script>
                setTimeout(function () { window.location.href='" . base_url('Auth') . "';}, 1000);
                </script>";
    }
}