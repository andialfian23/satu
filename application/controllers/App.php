<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        if ((empty($_SESSION['username_app']) or $_SESSION['username_app'] == FALSE)
            || (empty($_SESSION['login_app']) or $_SESSION['login_app'] == FALSE)
        ) {
            redirect(base_url("Auth"));
        }

        $this->load->model('App_model');
    }
    
    public function index()
    {
        $data['title'] = 'App';
        $data['content'] = 'app/index_app';
        // $data['custom_js'] = 'app';
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
        $this->load->view('index',$data);
    }

    public function show()
    {
        $column_order     = array('id_app', 'app_name', 'is_active','cipher_name', 'cipher_mode','cipher_key','url','app_image');
        $query  = $this->App_model->records($column_order);
        $data   = array();
        foreach ($query as $key) {
            $data[] = [
                'id_app'     => $key->id_app,
                'app_name'   => $key->app_name,
                'is_active'  => $key->is_active,
                'cipher_name'=> $key->cipher_name,
                'cipher_mode'=> $key->cipher_mode,
                'cipher_key'=> $key->cipher_key,
                'url'        => $key->url,
                'app_image'  => $key->app_image!=null?$key->app_image:'',
            ];
        }

        $output = array(
            "draw"              => $this->input->post('draw',TRUE),
            "recordsFiltered"   => $this->App_model->recordsFiltered($column_order),
            "recordsTotal"      => $this->App_model->recordsTotal(),
            "data"              => $data,
        );

		echo json_encode($output);
    }
    
    public function insert()
    {
        $status = 0;
        $message = "App data could not be added, Please try again";
        $app_image = NULL;
        if ((!empty($_FILES)) && ($_FILES['app_image']['size'] > 0)) {
            $app_image = null;
            if ($_FILES['app_image']['name']) {
                $config['upload_path'] = './images/app_image';
                $config['allowed_types'] = 'jpg|png';
                $config['max_size'] = '4000';
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('app_image')) {
                    $app_image = $this->upload->data('file_name');
                }
            }
        }
        
        $values = [
            'app_name' => $this->input->post('app_name',TRUE),
            'url' => $this->input->post('url'),
            'app_image' => $app_image,
            'is_active' => 1,
            'cipher_name' => $this->input->post('cipher_name'),
            'cipher_mode' => $this->input->post('cipher_mode',TRUE),
            'cipher_key' => $this->input->post('cipher_key',TRUE),
        ];
        $insert = $this->db->insert('t_app',$values);
        if($insert){
            $status = 1;
            $message = "App data has been successfully added";
        }
        $output = [
            'status' => $status,
            'message' => $message
        ];
        echo json_encode($output);
    }
    
    public function update($id_app = null)
    {
        if ($id_app == null) {
            redirect(base_url('App'));
        }
        $status = 0;
        $message = "Update data is failed";
        if ((!empty($_FILES)) && ($_FILES['app_image']['size'] > 0)) {
            $where = ['id_app'=>$id_app];
            $app = $this->db->get_where('t_app',$where)->row();
            if ($_FILES['app_image']['name']) {
                $config['upload_path'] = './images/app_image';
                $config['allowed_types'] = 'jpg|png';
                $config['max_size'] = '4000';
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('app_image')) {
                    $app_image = $this->upload->data('file_name');
                    unlink("./images/app_image/" . $app->app_image);
                    $this->db->where($where)->update('t_sistem',['app_image' => $app_image]);
                }
            }
        }

        $set = [
            'app_name' => $this->input->post('app_name',TRUE),
            'url' => $this->input->post('url'),
            'cipher_name' => $this->input->post('cipher_name',TRUE),
            'cipher_mode' => $this->input->post('cipher_mode',TRUE),
            'cipher_key' => $this->input->post('cipher_key',TRUE),
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $_SESSION['app_username']
        ];
        $update = $this->db->where($where)->update('t_sistem',$set);
        if($update){
            $status = 1;
            $message = "Update data is successfully";
        }
        $output = ['status'=>$status];
        echo json_encode($output);
    }
    
    public function delete()
    {
        $id_app = $this->input->post('id_app',TRUE);
        if ($id_app == null) {
            redirect(base_url('App'));
        }
        
        $where = ['id_app' => $id_app];
        $app = $this->db->get_where('t_app',$where)->row();
        unlink("./images/app_image/" . $app->app_image);
        $delete = $this->db->where($where)->delete('t_app');
        $status =0;
        if($delete){
            $status =1;
        }
        $output = [
            'status' => $status,
            'message' => $message
        ];
        echo json_encode($output);
    }

    public function get()
    {
        $status = 0;
        $id_app = $this->input->post('id_app',TRUE);
        if($id_app){
            $where = ['id_app'=>$id_app];
            $query = $this->db->get_where('t_app',$where);
            if($query){
                $status = 1;
                $data = $query->row();
            }
        }
        $output = [
            'status' => $status,
            'data' => $data,
        ];
        echo json_encode($output);
    }

    public function is_active()
    {
        $id_app = $this->input->post('id_app');
        $status = $this->input->post('show_sistem');
        $where = ['id_app' => $id_app];
        $set = [
            'is_active' =>  $status
        ];
        $this->db->where($where)->update('t_app', $set);
        $app_name = $this->db->get_where('t_app',$where)->row()->app_name;
        if ($status == 1) {
            $message = 'Actived <b> ' . $app_name . '</b> SUCCESS';
        } else {
            $message = 'Non-Active <b> ' . $app_name . '</b> SUCCESS';
        }
        
        $output = [
            'status' => $status,
            'message' => $message
        ];
        echo json_encode($output);
    }

    public function load_cipher()
    {
        $output = [
            'data' => $this->App_model->get_cipher()->result()
        ];
        echo json_encode($output);
    }

    public function load_cipher_mode()
    {
        $cipher_name = $this->input->post('cipher_name');
        $data = $this->App_model->get_cipher($cipher_name)->row()->cipher_mode;
        $data = explode("|",$data);
        $output = ['data' => $data];
        echo json_encode($output);
    }
}