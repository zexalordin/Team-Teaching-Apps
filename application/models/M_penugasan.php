<?php
class M_penugasan extends CI_Model{
    public $tabel = 'penugasan';
    
    public function get_daftar_penugasan($where,$asc){
		$this->db->order_by($asc,'ASC');
        $query=$this->db->get_where($this->tabel,$where);
        return $query->result_array();
    }
    public function get_rows_penugasan($where,$asc){
    	$this->db->order_by($asc,'ASC');
		$this->db->where($where);
		$this->db->select('*');    
		$this->db->from("penugasan");
		$this->db->join("team_teaching", 'penugasan.id_tt = team_teaching.id_tt');
		$this->db->join("mata_kuliah", 'team_teaching.id_matkul = mata_kuliah.id_matkul');
		$data=$this->db->get();
        return $data->result_array();
    }
    public function get_row_penugasan($where){
		$this->db->where($where);
		$this->db->select('*');    
		$this->db->from("penugasan");
		$this->db->join("team_teaching", 'penugasan.id_tt = team_teaching.id_tt');
		$this->db->join("mata_kuliah", 'team_teaching.id_matkul = mata_kuliah.id_matkul');
		$data=$this->db->get();
        return $data->row();
	}
    public function get_penugasan($where){
		$this->db->where($where);
		$data=$this->db->get($this->tabel);
        return $data->row();
    }
    public function input_penugasan($data){
		$res = $this->db->insert($this->tabel,$data);
		return $res;
    }
    public function update_penugasan($data,$where){
		$this->db->update($this->tabel,$data,$where);
        return $this->db->affected_rows();
    }
    public function delete_penugasan($where){
			$this->db->delete($this->tabel,$where);
			return $this->db->affected_rows();
    }
}
