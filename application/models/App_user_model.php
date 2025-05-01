<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class App_user_model extends CI_Model {
    
    private function _get_query($id_level,$id_app)
    {
        $column_order = array('id_user','username','title','id_level','app_level','level_name');
        $column_search = $column_order;
        
        $this->db->select('id_user,username,title,id_level, app_level, level_name')
            ->from("(SELECT u.id_user, u.username, u.title,
                        l.id_level, l.app_level, l.level_name
                    FROM t_user as u
                    INNER JOIN t_app_user as au ON u.id_user=au.id_user
                    INNER JOIN t_level as l ON au.id_level=l.id_level 
                    WHERE au.id_level = {$id_level} AND l.id_app={$id_app}
                    ) 
                    as v");

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
            $this->db->order_by('username', 'ASC');
        }
    }
    
    public function records($id_level,$id_app)
    {
        $this->_get_query($id_level,$id_app);
        
        if ($this->input->post('length',TRUE) != -1) {
            $this->db->limit($this->input->post('length',TRUE), $this->input->post('start',TRUE));
        } 

        $query = $this->db->get();
        if ($query) {
            return $query->result();
        }
    }
    
    public function recordsFiltered($id_level,$id_app)
    {
        $this->_get_query($id_level,$id_app);
        return $this->db->get()->num_rows();
    }
    
    public function recordsTotal()
    {
        $this->db->query("SELECT u.id_user, u.username, u.title 
                    FROM t_user as u
                    INNER JOIN t_app_user as au ON u.id_user = au.id_user
                    INNER JOIN t_level as l ON au.id_level=l.id_level");
                    
        return $this->db->count_all_results();
    }
}
?>