<?php
class M_soal extends CI_Model{
    public $tabel = 'soal';
    
    public function get_daftar_soal($where,$asc){
		$this->db->order_by($asc,'ASC');
        $this->db->where($where);
        $this->db->select('*,soal.tingkat_kesulitan');    
        $this->db->from($this->tabel);
        $this->db->join("penugasan", 'soal.id_penugasan = penugasan.id_penugasan');
        $this->db->join("materi", 'soal.id_materi = materi.id_materi');
        $data=$this->db->get();
        //$query=$this->db->get_where($this->tabel,$where);
        return $data->result_array();
    }
    public function get_soal($where){
		$this->db->where($where);
		$data=$this->db->get($this->tabel);
        return $data->row();
	}
    public function input_soal($data){
		$res = $this->db->insert($this->tabel,$data);
		return $res;
    }
    public function update_soal($data,$where){
		$this->db->update($this->tabel,$data,$where);
        return $this->db->affected_rows();
    }
    public function delete_soal($where){
        $this->db->delete($this->tabel,$where);
        return $this->db->affected_rows();
    }
}
