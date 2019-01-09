<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_matkul extends CI_Controller {

	function __construct(){
		parent::__construct();		
        $this->load->model('m_matkul');
        $this->load->model('m_kjfd');
        $this->load->model('m_team_teaching');
        $this->load->model('m_soal');
        $this->load->model('m_penugasan');
        $this->load->model('m_dosen');
        $this->load->model('m_materi');
		date_default_timezone_set("Asia/Jakarta");
	}
	public function is_login(){
		if(!$this->session->userdata('status')){
			redirect(base_url());
		}
	}
	public function is_kajur(){
		$role = unserialize($this->session->userdata('role'));
        if (($key = array_search(1, $role)) === false) {
			redirect(base_url());
		}
	}
	public function sidebar() {
		$tt = $this->m_team_teaching->get_data_partOfTeam("anggota_tt",'"'.$this->session->userdata('id').'"',array());
		$penugasan = $this->m_penugasan->get_rows_penugasan(array('status_penugasan'=>0),"nama_penugasan");
		$counter_penugasan = 0;
		for ($i=0; $i < count($penugasan) ; $i++) { 
			$cek_id_tt = false;
			for ($j=0; $j < count($tt); $j++) { 
				if ($penugasan[$i]['id_tt'] == $tt[$j]['id_tt']) {
					$counter_penugasan++;
					break;
				}
			}
		}
		$data['counter_penugasan']=$counter_penugasan;
		return $this->load->view("v_sidebar",$data,true);
	}
	public function header() {
		$where = array();
		$penugasan = $this->m_penugasan->get_daftar_penugasan($where,"id_penugasan");
		$notifikasi = array();
		$header_notif = array();
		$link_notif = array();
		$counter_notif1 = 0;
		for ($i=0; $i <count($penugasan) ; $i++) { 
			$addNotification = false;
			$dosen = unserialize($penugasan[$i]['id_ambil_penugasan']);
			$materi = unserialize($penugasan[$i]['materi_penugasan']);
			$soal = unserialize($penugasan[$i]['tingkat_kesulitan']);
			$header_notif[$counter_notif1] = $penugasan[$i]['nama_penugasan'];
			date_default_timezone_set("Asia/Jakarta");
	     	$now = new DateTime();
	        $today = new DateTime($now->format('Y-m-d'));
	        $otherDate = new DateTime($penugasan[$i]['batas_penugasan']);
	        $batas_pengambilan = new DateTime($penugasan[$i]['batas_pengambilan']);
	        $interval = date_diff($today, $otherDate);
	        $interval_batas_pengambilan = date_diff($today, $batas_pengambilan);
	        if ($interval->format('%R%a')>0 && count($dosen)>0 && $interval_batas_pengambilan->format('%R%a')<=0) {
	        	$counter_notif2 = 0;
				for ($j=0; $j < count($materi); $j++) {
					if (in_array($this->session->userdata('id'), $dosen[$j])) {
						$jum_soal = 0;
						for ($k=0; $k < count($soal[$j]); $k++) { 
							$jum_soal = $jum_soal + (int)$soal[$j][$k];
						}
						$id_materi = $this->m_materi->get_materi(array('id_materi'=>$materi[$j]))->id_materi;
						$where = array('soal.id_penugasan'=>$penugasan[$i]['id_penugasan'], 'soal.id_materi'=>$id_materi, 'id_dosen'=>$this->session->userdata('id'));
						$cek_soal = $this->m_soal->get_daftar_soal($where,'id_soal');
						$count_soal_kosong = 0;
						foreach ($cek_soal as $cs) {
							if ($cs['soal']=='') {
								$count_soal_kosong++;
							}
						}
						$judul_materi = $this->m_materi->get_materi(array('id_materi'=>$materi[$j]));
						if ($count_soal_kosong>0) {
							$addNotification = true;
							$notifikasi[$counter_notif1][$counter_notif2] = $judul_materi->nama_materi." tanggungan soal : ".$count_soal_kosong;
							$link_notif[$counter_notif1][$counter_notif2] = base_url('edit-soal/'.$penugasan[$i]['id_penugasan'].'/'.$j);
							//$counter_notif1++;
							$counter_notif2++;
						}else if(count($cek_soal)==0){
							$addNotification = true;
							$notifikasi[$counter_notif1][$counter_notif2] = $judul_materi->nama_materi." tanggungan soal : ".$jum_soal;
							$link_notif[$counter_notif1][$counter_notif2] = base_url('buat-soal/'.$penugasan[$i]['id_penugasan'].'/'.$j);
							//$counter_notif1++;
							$counter_notif2++;
						}
					}
				}
				if ($addNotification) {
					$counter_notif1++;
				}
				
			}
		}
		$data['notifikasi'] = $notifikasi;
		$data['header_notif'] = $header_notif;
		$data['link_notif'] = $link_notif;
		return $this->load->view("v_header",$data,true);
    }
    public function daftar_matkul() {
		$this->is_login();
		$this->is_kajur();
		$comp = array(
			"title" => "Daftar Mata Kuliah",
			"sidebar" => $this->sidebar(),
			"header" => $this->header(),
			"content" => $this ->view_daftar_matkul(),
		);
		$this->load->view('v_template',$comp);
	}
	public function view_daftar_matkul() {
		$where = array();
		$data['matkul'] = $this->m_matkul->get_daftar_matkulxKjfd($where);
		return $this->load->view("v_daftar_matkul",$data,true);
	}
	public function tambah_matkul() {
		$this->is_login();
		$this->is_kajur();
		$comp = array(
			"title" => "Tambah Mata Kuliah",
			"sidebar" => $this->sidebar(),
			"header" => $this->header(),
			"content" => $this ->view_tambah_matkul(),
		);
		$this->load->view('v_template',$comp);
	}
	public function view_tambah_matkul() {
		$where = array();
		$data['kjfd'] = $this->m_kjfd->get_daftar_kjfd($where,'nama_kjfd');
		return $this->load->view("v_tambah_matkul",$data,true);
	}
	public function edit_matkul($id) {
		$this->is_login();
		$this->is_kajur();
		$comp = array(
			"title" => "Edit Mata Kuliah",
			"sidebar" => $this->sidebar(),
			"header" => $this->header(),
			"content" => $this ->view_edit_matkul($id),
		);
		$this->load->view('v_template',$comp);
	}
	public function view_edit_matkul($id){
		$where = array('id_matkul'=>$id);
        $data['matkul'] = $this->m_matkul->get_matkul($where);
        $data['kjfd'] = $this->m_kjfd->get_daftar_kjfd(array(),'nama_kjfd');
		return $this->load->view('v_edit_matkul',$data,true);
    }
    
    //proses
    public function proses_tambah_matkul(){
		$kode = $_POST['kode_matkul'];
		$nama = $_POST['nama_matkul'];
		$id_kjfd = $_POST['kjfd'];
		$where = array('kode_matkul'=>$kode);
		if ($this->m_matkul->cek_kode_matkul($where) > 0) {
			$this->session->set_flashdata('input_msg', 'terpakai');
			redirect(base_url('tambah-matkul'));
		}else{
			$data_insert = array(
				'kode_matkul' => $kode,
				'nama_matkul' => $nama,
				'id_kjfd' => $id_kjfd,
			);
			$res = $this->m_matkul->input_matkul($data_insert);
			$where = array('kode_matkul'=>$kode);
			$matkul = $this->m_matkul->get_matkul($where);
			$where = array('id_kjfd'=>$id_kjfd);
			$kjfd = $this->m_kjfd->get_kjfd($where);
			$data_insert = array(
                'id_matkul' => $matkul->id_matkul,
                'id_dosen' => $kjfd->id_dosen,
                'anggota_tt' => serialize(array())
			);
			$this->m_team_teaching->input_team_teaching($data_insert);
			//set role team teaching
			$dosen = $this->m_dosen->get_dosen(array('id_dosen'=>$kjfd->id_dosen));
			$role = unserialize($dosen->role);
			echo "string";
			if (!in_array(3, $role)){
				echo "tes";
			  	array_push($role,3);
				$ser_role = serialize($role);
				$data_update = array(
					'role' => $ser_role,
				);
				$where = array('id_dosen'=>$kjfd->id_dosen);
				$this->m_dosen->update_dosen($data_update,$where);
			}
			

			if($res>=1){
				$this->session->set_flashdata('input_msg', 'success');
			}else{
				$this->session->set_flashdata('input_msg', 'failed');
			}
			redirect(base_url('mata-kuliah'));
		}
	}
	public function proses_edit_matkul($id){
		$kode = $_POST['kode_matkul'];
		$nama = $_POST['nama_matkul'];
		$id_kjfd = $_POST['kjfd'];
		
		$where =array('id_matkul'=>$id);
		$matkul = $this->m_matkul->get_matkul($where);
		$where = array('kode_matkul'=>$kode);
		if (($matkul->kode_matkul != $kode) && ($this->m_matkul->cek_kode_matkul($where) > 0)) {
			$this->session->set_flashdata('edit_msg', 'terpakai');
		}else{
			//update mata kuliah
			$data_update = array(
				'kode_matkul' => $kode,
				'nama_matkul' => $nama,
				'id_kjfd' => $id_kjfd,
			);
			$where = array('id_matkul'=>$id);
			$res = $this->m_matkul->update_matkul($data_update,$where);
			//end

			if($res>=1){
				$this->session->set_flashdata('edit_msg', 'success');
			}else{
				$this->session->set_flashdata('edit_msg', 'failed');
			}
		}
		redirect(base_url()."edit-matkul/".$id);
	}
	public function proses_hapus_matkul($id){
		$where = array('id_matkul'=>$id);
		$tt = $this->m_team_teaching->get_team_teaching($where);
		echo $tt->id_dosen;
		$this->m_team_teaching->delete_team_teaching($where);
		$daftar_tt = $this->m_team_teaching->get_daftar_team_teaching(array('id_dosen'=>$tt->id_dosen),'id_tt');
		print_r($daftar_tt);

		//unset role team teaching
			$dosen = $this->m_dosen->get_dosen(array('id_dosen'=>$tt->id_dosen));
			$role = unserialize($dosen->role);
			if (count($daftar_tt)==0) {
				if (($key = array_search(3, $role)) !== false) {
				    unset($role[$key]);
				}
				print_r($role);
				$ser_role = serialize($role);
				$data_update = array(
					'role' => $ser_role,
				);
				$this->m_dosen->update_dosen($data_update,array('id_dosen'=>$tt->id_dosen));
			}
		$res= $this->m_matkul->delete_matkul($where);
		if($res>=1){
			$this->session->set_flashdata('delete_msg', 'success');
		}else{
			$this->session->set_flashdata('delete_msg', 'failed');
		}
		redirect(base_url('mata-kuliah'));
	}
}
