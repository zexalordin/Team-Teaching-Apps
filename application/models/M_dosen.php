<?php
class M_dosen extends CI_Model{
    public $tabel = 'dosen';
    

    public function register($data){
		$res = $this->db->insert($this->tabel,$data);
		return $res;
    }
    function cek_dosen($where){		
		return $this->db->get_where($this->tabel,$where);
	}
    public function aktivasi($data,$where){
		$this->db->update($this->tabel,$data,$where);
        return $this->db->affected_rows();
    }
    public function update_dosen($data,$where){
		$this->db->update($this->tabel,$data,$where);
        return $this->db->affected_rows();
    }
    public function delete_dosen($where){
		$this->db->delete($this->tabel,$where);
		return $this->db->affected_rows();
	}
    public function get_daftar_dosen($where,$asc){
		$this->db->order_by($asc,'ASC');
        $query=$this->db->get_where($this->tabel,$where);
        return $query->result_array();
    }
    public function get_dosen($where){
		$this->db->where($where);
		$data=$this->db->get($this->tabel);
        return $data->row();
    }
    public function count_dosen(){
		return $this->db->count_all($this->tabel);
	}
}
