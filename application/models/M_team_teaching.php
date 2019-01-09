<?php
class M_team_teaching extends CI_Model{
    public $tabel = 'team_teaching';
    
    public function get_daftar_team_teaching($where,$asc){
		$this->db->order_by($asc,'ASC');
        $query=$this->db->get_where($this->tabel,$where);
        return $query->result_array();
    }
    public function get_team_teaching($where){
		$this->db->where($where);
		$data=$this->db->get($this->tabel);
        return $data->row();
    }
    public function get_daftar_team_teachingXmata_kuliah($where,$asc){
    	$this->db->order_by($asc,'ASC');
		$this->db->where($where);
		$this->db->select('*');    
		$this->db->from($this->tabel);
		$this->db->join('mata_kuliah', 'team_teaching.id_matkul = mata_kuliah.id_matkul');
		$data=$this->db->get();
        return $data->result_array();
	}
    public function get_row_team_teaching($id_tt){
		$this->db->where("team_teaching.id_tt = ".$id_tt);
		$this->db->select('*');    
		$this->db->from("mata_kuliah");
		$this->db->join("kjfd", 'mata_kuliah.id_kjfd = kjfd.id_kjfd');
		$this->db->join("team_teaching", 'mata_kuliah.id_matkul = team_teaching.id_matkul');
		$this->db->join("dosen", 'dosen.id_dosen = team_teaching.id_dosen','left outer');
		$data=$this->db->get();
        return $data->row();
	}
    public function input_team_teaching($data){
		$res = $this->db->insert($this->tabel,$data);
		return $res;
    }
    public function update_team_teaching($data,$where){
		$this->db->update($this->tabel,$data,$where);
        return $this->db->affected_rows();
    }
    public function delete_team_teaching($where){
			$this->db->delete($this->tabel,$where);
			return $this->db->affected_rows();
    }
    public function get_data_team_teaching($id){
		$this->db->where("kjfd.id_dosen = ".$id);
		$this->db->select('*');    
		$this->db->from("mata_kuliah");
		$this->db->join("kjfd", 'mata_kuliah.id_kjfd = kjfd.id_kjfd');
		$this->db->join("team_teaching", 'mata_kuliah.id_matkul = team_teaching.id_matkul');
		$this->db->join("dosen", 'dosen.id_dosen = team_teaching.id_dosen','left outer');
		$data=$this->db->get();
        return $data->result_array();
	}
	public function get_data_team_teaching_by_ketua_tim($id){
		$this->db->where("team_teaching.id_dosen = ".$id);
		$this->db->select('*');    
		$this->db->from("mata_kuliah");
		$this->db->join("kjfd", 'mata_kuliah.id_kjfd = kjfd.id_kjfd');
		$this->db->join("team_teaching", 'mata_kuliah.id_matkul = team_teaching.id_matkul');
		$this->db->join("dosen", 'dosen.id_dosen = team_teaching.id_dosen','left outer');
		$data=$this->db->get();
        return $data->result_array();
	}
	public function get_data_partOfTeam($column,$keyword,$where){
		$this->db->where($where);
		$this->db->where($column." LIKE '%".$keyword."%'");
		$this->db->from($this->tabel);
		$data=$this->db->get();
        return $data->result_array();
	}
}
