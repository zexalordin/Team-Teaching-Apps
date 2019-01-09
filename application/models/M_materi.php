<?php
class M_materi extends CI_Model{
    public $tabel = 'materi';
    
    public function get_daftar_materi($where,$asc){
		$this->db->order_by($asc,'ASC');
        $query=$this->db->get_where($this->tabel,$where);
        return $query->result_array();
    }
    public function get_rows_materi($where,$asc){
    	$this->db->order_by($asc,'ASC');
		$this->db->where($where);
		$this->db->select('*');    
		$this->db->from("materi");
		$this->db->join("team_teaching", 'materi.id_tt = team_teaching.id_tt');
		$this->db->join("mata_kuliah", 'team_teaching.id_matkul = mata_kuliah.id_matkul');
		$data=$this->db->get();
        return $data->result_array();
    }
    public function get_row_materi($where){
		$this->db->where($where);
		$this->db->select('*');    
		$this->db->from("materi");
		$this->db->join("team_teaching", 'materi.id_tt = team_teaching.id_tt');
		$this->db->join("mata_kuliah", 'team_teaching.id_matkul = mata_kuliah.id_matkul');
		$data=$this->db->get();
        return $data->row();
	}
    public function get_materi($where){
		$this->db->where($where);
		$data=$this->db->get($this->tabel);
        return $data->row();
    }
    public function input_materi($data){
		$res = $this->db->insert($this->tabel,$data);
		return $res;
    }
    public function update_materi($data,$where){
		$this->db->update($this->tabel,$data,$where);
        return $this->db->affected_rows();
    }
    public function delete_materi($where){
			$this->db->delete($this->tabel,$where);
			return $this->db->affected_rows();
    }
}
