<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class App_model extends CI_Model{
    private function _get_query($column_order)
    {
        $column_search = $column_order;
        
        $this->db->select('id_app,app_name,is_active,cipher_name,cipher_mode,cipher_key,url,app_image');
        $this->db->from('t_app');

        $i = 0;
        foreach ($column_search as $item) // looping awal
        {
            if ($this->input->post('search',TRUE)['value']) 
            {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $this->input->post('search',TRUE)['value']);
                } else {
                    $this->db->or_like($item, $this->input->post('search',TRUE)['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
        if ($this->input->post('order',TRUE)) {
            $this->db->order_by($column_order[$this->input->post('order',TRUE)['0']['column']], $this->input->post('order',TRUE)['0']['dir']);
        } else {
            $this->db->order_by('id_app', 'ASC');
        }
    }
    
    public function records($column_order)
    {
        $this->_get_query($column_order);
        
        if ($this->input->post('length',TRUE) != -1) {
            $this->db->limit($this->input->post('length',TRUE), $this->input->post('start',TRUE));
        } 

        $query = $this->db->get();
        if ($query) {
            return $query->result();
        }
    }
    
    public function recordsFiltered($column_order)
    {
        $this->_get_query($column_order);
        return $this->db->get()->num_rows();
    }
    
    public function recordsTotal()
    {
        $this->db->query("SELECT * FROM t_app");
        return $this->db->count_all_results();
    }
    
    public function get_cipher($cipher_name=null)
    {
        if($cipher_name==null){
            return $this->db->get('t_cipher');
        }else{
            return $this->db->get_where('t_cipher',['cipher_name'=>$cipher_name]);
        }
    }
}
?>