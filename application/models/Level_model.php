<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Level_model extends CI_Model {
    private function _get_query($column_order)
    {
        $column_search = $column_order;
        
        $this->db->select('id_level, id_app, app_name, app_level, level_name')
            ->from("(SELECT l.*, a.app_name 
                    FROM t_level as l
                    INNER JOIN t_app as a ON l.id_app = a.id_app) as v");

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
            $this->db->order_by('id_level', 'ASC');
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
        $this->db->query("SELECT l.*, a.app_name 
                    FROM t_level as l
                    INNER JOIN t_app as a ON l.id_app = a.id_app");
        return $this->db->count_all_results();
    }
}
?>