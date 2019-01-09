<?php
class M_cetak_soal extends CI_Model{
    public $tabel = 'cetak_soal';
    
    public function get_daftar_cetak_soal($where,$desc){
		$this->db->order_by($desc,'DESC');
        $query=$this->db->get_where($this->tabel,$where);
        return $query->result_array();
    }
    public function get_cetak_soal_terakhir($desc){
    	$query = $this->db->query("SELECT * FROM ".$this->tabel." ORDER BY ".$desc." DESC LIMIT 1");
		$result = $query->result_array();
		return $result;
    }
    public function input_cetak_soal($data){
		$res = $this->db->insert($this->tabel,$data);
		return $res;
    }
    public function update_cetak_soal($data,$where){
		$this->db->update($this->tabel,$data,$where);
        return $this->db->affected_rows();
    }
}
