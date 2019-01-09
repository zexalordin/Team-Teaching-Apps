<?php
class M_kjfd extends CI_Model{
    public $tabel = 'kjfd';
    
    public function get_daftar_kjfdxdosen($where){
		$this->db->where($where);
		$this->db->select('*');    
		$this->db->from($this->tabel);
		$this->db->join('dosen', $this->tabel.'.id_dosen = dosen.id_dosen');
		$data=$this->db->get();
        return $data->result_array();
    }
    public function get_daftar_kjfd($where,$asc){
		$this->db->order_by($asc,'ASC');
        $query=$this->db->get_where($this->tabel,$where);
        return $query->result_array();
    }
    public function get_kjfd($where){
		$this->db->where($where);
		$data=$this->db->get($this->tabel);
        return $data->row();
    }
    public function input_kjfd($data){
		$res = $this->db->insert($this->tabel,$data);
		return $res;
    }
    public function update_kjfd($data,$where){
		$this->db->update($this->tabel,$data,$where);
        return $this->db->affected_rows();
    }
    public function delete_kjfd($where){
		$this->db->delete($this->tabel,$where);
		return $this->db->affected_rows();
    }
    public function count_kjfd(){
		return $this->db->count_all($this->tabel);
	}
    public function count_kjfd_where($where){
        $this->db->where($where);
        $this->db->from($this->tabel);
        return $this->db->count_all_results();
    }
}
