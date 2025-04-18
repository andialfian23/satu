<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Level extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        if ((empty($_SESSION['username_app']) or $_SESSION['username_app'] == FALSE)
            || (empty($_SESSION['login_app']) or $_SESSION['login_app'] == FALSE)
        ) {
            redirect(base_url("Auth"));
        }

        $this->load->model('level_model');
    }

    public function index()
    {
        $data['title'] = 'Level App';
        $data['content'] = 'level/index_level';
        $data['apps'] = $this->db->get('t_app');
        // $data['custom_js'] = 'level';
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
        $column_order     = array('id_level', 'id_app', 'app_name', 'app_level', 'level_name');
        $query  = $this->level_model->records($column_order);
        $data   = array();
        foreach ($query as $key) {
            $data[] = [
                'id_level'  => $key->id_level,
                'id_app'    => $key->id_app,
                'app_name'  => $key->app_name,
                'app_level' => $key->app_level,
                'level_name'=> $key->level_name,
            ];
        }

        $output = array(
            "draw"              => $this->input->post('draw',TRUE),
            "recordsFiltered"   => $this->level_model->recordsFiltered($column_order),
            "recordsTotal"      => $this->level_model->recordsTotal(),
            "data"              => $data,
        );

		echo json_encode($output);
    }

    public function insert()
    {
        $id_app = $this->input->post('id_app',TRUE);
        $app_level = $this->input->post('app_level','TRUE');
        $cek_app_level = $this->db->get_where('t_level',['id_app'=>$id_app,'app_level'=>$app_level]);
        $message = "Create Level is failed";
        $status = 0;
        if($cek_app_level->num_rows() > 0){
            $message = "Level has used";
        }else{
            $values = [
                'id_app' => $id_app,
                'app_level' => $app_level,
                'level_name' => $this->input->post('level_name',TRUE)
            ];
            $insert = $this->db->insert('t_level',$values);
            if($insert){
                $status=1;
                $message = "Create Level is successfully";
            }
        } 
        $output = [
            'status' => $status,
            'message' => $message
        ];
        echo json_encode($output);
    }

    public function update()
    {
        $status = 0;
        $message = "Updated data is failed";
        $id_level = $this->input->post('id_level',TRUE);
        if($id_level){
            $where = ['id_level'=>$id_level];
            $set = [
                'id_app' => $this->input->post('id_app',TRUE),
                'app_level' => $this->input->post('app_level',TRUE),
                'level_name' => $this->input->post('level_name',TRUE)
            ];
            $update = $this->db->where($where)->update('t_level',$set);
            if($update){
                $status = 1;
                $message = "Update data is successfully";
            }
        }

        $output = [
            'status' => $status,
            'message' => $message
        ];
        echo json_encode($output);
    }

    public function delete()
    {
        $status = 0;
        $message = "Delete level is failed";
        $id_level = $this->input->post('id_level',TRUE);
        if($id_level){
            $delete = $this->db->where(['id_level'=>$id_level])->delete('t_level');
            if($delete){
                $status=1;
                $message = "Delete level is successfully";
            }
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
        $id_level = $this->input->post('id_level',TRUE);
        if($id_level){
            $where = ['id_level'=>$id_level];
            $query = $this->db->get_where('t_level',$where);
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
}