<?php
class M_komentar extends CI_Model{
    public $tabel = 'komentar';
    
    public function input_komentar($data){
		$res = $this->db->insert($this->tabel,$data);
		return $res;
    }
    public function get_komentar($where,$desc){
		$this->db->order_by($desc,'DESC');
		$this->db->where($where);
		$this->db->select('*');    
		$this->db->from($this->tabel);
		$this->db->join("dosen", $this->tabel.'.'."id_dosen".' = '."dosen".'.'."id_dosen");
		$data=$this->db->get();
        return $data->result_array();
	}
	public function delete_komentar($where){
			$this->db->delete($this->tabel,$where);
			return $this->db->affected_rows();
    }
}
