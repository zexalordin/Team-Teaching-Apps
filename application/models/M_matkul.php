<?php
class M_matkul extends CI_Model{
    public $tabel = 'mata_kuliah';
    
    public function get_daftar_matkulxKjfd($where){
			$this->db->where($where);
			$this->db->select('*');    
			$this->db->from($this->tabel);
			$this->db->join('kjfd', $this->tabel.'.id_kjfd = kjfd.id_kjfd');
			$data=$this->db->get();
					return $data->result_array();
    }
    public function get_matkul($where){
			$this->db->where($where);
			$data=$this->db->get($this->tabel);
      		return $data->row();
    }
    public function input_matkul($data){
			$res = $this->db->insert($this->tabel,$data);
			return $res;
    }
    public function update_matkul($data,$where){
		$this->db->update($this->tabel,$data,$where);
      	return $this->db->affected_rows();
    }
    public function delete_matkul($where){
			$this->db->delete($this->tabel,$where);
			return $this->db->affected_rows();
    }
    public function cek_kode_matkul($where){
		$this->db->where($where);
		$this->db->from($this->tabel);
		return $this->db->count_all_results();
	}
	public function count_matkul(){
		return $this->db->count_all($this->tabel);
	}
	public function count_matkul_where($where){
		$this->db->where($where);
		$this->db->from($this->tabel);
		return $this->db->count_all_results();
	}
}
