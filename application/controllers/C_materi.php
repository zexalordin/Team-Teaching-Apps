<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_materi extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model('m_soal');
        $this->load->model('m_penugasan');
        $this->load->model('m_materi');
        $this->load->model('m_dosen');
        $this->load->model('m_team_teaching');
        $this->load->library('email');
		date_default_timezone_set("Asia/Jakarta");
	}
	public function is_login(){
		if(!$this->session->userdata('status')){
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
    public function atur_materi() {
		$this->is_login();
		$comp = array(
			"title" => "Atur materi",
			"sidebar" => $this->sidebar(),
			"header" => $this->header(),
			"content" => $this ->view_atur_materi(),
		);
		$this->load->view('v_template',$comp);
	}
	public function view_atur_materi() {
		$team_teaching = $this->m_team_teaching->get_daftar_team_teachingXmata_kuliah(array('id_dosen'=>$this->session->userdata('id')),"id_tt");
		for ($i=0; $i < count($team_teaching); $i++) { 
			$data['materi'][$i] = $this->m_materi->get_rows_materi(array('materi.id_tt'=>$team_teaching[$i]['id_tt']),"bab_materi");
		}
		$data['dosen'] = $this->m_dosen->get_daftar_dosen(array(),"id_dosen");
		$data['team_teaching'] = $team_teaching;
		return $this->load->view("v_daftar_atur_materi",$data,true);
	}
	public function tambah_materi() {
		$this->is_login();
		$comp = array(
			"title" => "Tambah materi",
			"sidebar" => $this->sidebar(),
			"header" => $this->header(),
			"content" => $this ->view_tambah_materi(),
		);
		$this->load->view('v_template',$comp);
	}
	public function view_tambah_materi() {
		$data['team_teaching']  = $this->m_team_teaching->get_daftar_team_teachingXmata_kuliah(array('id_dosen'=>$this->session->userdata('id')),"id_tt");
		//$data['team_teaching'] = $this->m_team_teaching->get_data_team_teaching($this->session->userdata('id'));
		//$data['dosen'] = $this->m_dosen->get_daftar_dosen(array(),"id_dosen");
		return $this->load->view("v_tambah_materi",$data,true);
	}
	public function edit_materi($id_materi) {
		$this->is_login();
		$comp = array(
			"title" => "Edit materi",
			"sidebar" => $this->sidebar(),
			"header" => $this->header(),
			"content" => $this ->view_edit_materi($id_materi),
		);
		$this->load->view('v_template',$comp);
	}
	public function view_edit_materi($id_materi) {
		$where = array('id_materi'=>$id_materi);
		$data['materi'] = $this->m_materi->get_materi($where);
		return $this->load->view("v_edit_materi",$data,true);
	}

	//proses
	public function proses_tambah_materi(){
		$nama_materi = $_POST['nama_materi'];
		$bab_materi = $_POST['bab_materi'];

		if (isset($_POST['team_teaching'])) {
			$id_team_teaching = $_POST['team_teaching'];
		}else{
			$where = array('id_dosen'=>$this->session->userdata('id'));
			$id_tt = $this->m_team_teaching->get_team_teaching($where);
			$id_team_teaching = $id_tt->id_tt;
		}
		//print_r($kuota_ambil);

		$data_insert = array(
			'nama_materi' => $nama_materi,
			'bab_materi' => $bab_materi,
			'id_tt' => $id_team_teaching,
		);
		$res = $this->m_materi->input_materi($data_insert);
		if($res>=1){
			$this->session->set_flashdata('input_msg', 'success');
		}else{
			$this->session->set_flashdata('input_msg', 'failed');
		}
		redirect(base_url()."atur-materi");
	}
	public function proses_edit_materi($id){
		$nama_materi = $_POST['nama_materi'];
		$bab_materi = $_POST['bab_materi'];

		$data_update = array(
			'nama_materi' => $nama_materi,
			'bab_materi' => $bab_materi,
		);
		$where = array('id_materi'=>$id);
		$res = $this->m_materi->update_materi($data_update,$where);
		if($res>=1){
			$this->session->set_flashdata('edit_msg', 'success');
		}else{
			$this->session->set_flashdata('edit_msg', 'failed');
		}
		redirect(base_url()."edit-materi/".$id);
	}
	public function proses_hapus_materi($id){
		$where = array('id_materi'=>$id);
		$res= $this->m_materi->delete_materi($where);
		if($res>=1){
			$this->session->set_flashdata('delete_msg', 'success');
		}else{
			$this->session->set_flashdata('delete_msg', 'failed');
		}
		redirect(base_url('atur-materi'));
	}
}
