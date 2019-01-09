<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_penugasan extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model('m_komentar');
        $this->load->model('m_soal');
        $this->load->model('m_penugasan');
        $this->load->model('m_materi');
        $this->load->model('m_dosen');
        $this->load->model('m_team_teaching');
        $this->load->model('m_cetak_soal');
        $this->load->model('m_matkul');
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
    //Ketua TT
	public function atur_penugasan() {
		$this->is_login();
		$comp = array(
			"title" => "Atur Penugasan",
			"sidebar" => $this->sidebar(),
			"header" => $this->header(),
			"content" => $this ->view_atur_penugasan(),
		);
		$this->load->view('v_template',$comp);
	}
	public function view_atur_penugasan() {
		$team_teaching = $this->m_team_teaching->get_daftar_team_teachingXmata_kuliah(array('id_dosen'=>$this->session->userdata('id')),"id_tt");
		for ($i=0; $i < count($team_teaching); $i++) { 
			$data['penugasan'][$i] = $this->m_penugasan->get_rows_penugasan(array('penugasan.id_tt'=>$team_teaching[$i]['id_tt']),"batas_penugasan");
		}
		//print_r($data['penugasan']);
		//$data['penugasan'] = $this->m_penugasan->get_daftar_penugasan(array(),"batas_penugasan");
		$data['dosen'] = $this->m_dosen->get_daftar_dosen(array(),"id_dosen");
		$data['team_teaching'] = $team_teaching;
		return $this->load->view("v_daftar_atur_penugasan",$data,true);
	}
	public function progres_penugasan($id) {
		$this->is_login();
		$comp = array(
			"title" => "Progres Penugasan",
			"sidebar" => $this->sidebar(),
			"header" => $this->header(),
			"content" => $this ->view_progres_penugasan($id),
		);
		$this->load->view('v_template',$comp);
	}
	public function view_progres_penugasan($id) {
		$where = array('id_penugasan'=>$id);
		$data['penugasan'] = $this->m_penugasan->get_penugasan($where);
		$id_ambil_penugasan = unserialize($data['penugasan']->id_ambil_penugasan);
		$status_penugasan_anggota = unserialize($data['penugasan']->status_penugasan_anggota);
		$materi_penugasan = unserialize($data['penugasan']->materi_penugasan);
		$tingkat_kesulitan = unserialize($data['penugasan']->tingkat_kesulitan);

		$tt = $this->m_team_teaching->get_data_partOfTeam("anggota_tt",'"'.$this->session->userdata('id').'"',array('id_tt'=>$data['penugasan']->id_tt));
		$anggota_tt = unserialize($tt[0]['anggota_tt']);
		for ($i=0; $i < count($anggota_tt); $i++) { 
			$data['nama_anggota_tt'][$i] = $this->m_dosen->get_dosen(array('id_dosen'=>$anggota_tt[$i]));
			$index = 0;
			$data['materi_diambil'][$i]=null;
			$data['soal_dibuat'][$i]=null;
			$data['status_materi_diambil'][$i]=null;
			for ($j=0; $j < count($id_ambil_penugasan); $j++) { 
			 	if (in_array($anggota_tt[$i], $id_ambil_penugasan[$j])) {
			 		$index_materi = array_search($anggota_tt[$i], $id_ambil_penugasan[$j]);
			 		$data['materi_diambil'][$i][$index] = $this->m_materi->get_materi(array('id_materi'=>$materi_penugasan[$j]));
			 		
			 		$data['status_materi_diambil'][$i][$index] = $status_penugasan_anggota[$j][$index_materi];
			 		$tmp_soal = $this->m_soal->get_daftar_soal(array('soal.id_penugasan'=>$id,'soal.id_materi'=>$materi_penugasan[$j],'id_dosen'=>$anggota_tt[$i], 'soal!='=>''),'id_soal');
			 		$data['soal_dibuat'][$i][$index] = count($tmp_soal);
			 		$data['kebutuhan_soal_anggota'][$i][$index] = array_sum($tingkat_kesulitan[$j]);
			 		$index++;
			 	}else{
			 		$data['kebutuhan_soal_anggota'][$i][$index] = 0;
			 		$data['materi_diambil'][$i][$index] = null;
			 		$data['soal_dibuat'][$i][$index] = 0;
			 		$data['status_materi_diambil'][$i][$index] = null;
			 		$index++;
			 	}
			}
		}
		for ($i=0; $i < count($materi_penugasan); $i++) { 
			$data['kebutuhan_soal'][$i] = array_sum($tingkat_kesulitan[$i]);
		}

		
		//echo count($data['materi_diambil'][0]);
		// print_r($data['nama_anggota_tt']);
		 // print_r($data['materi_diambil']);
		 // print_r($data['status_materi_diambil']);
		// print_r($data['soal_dibuat']);
		// print_r($data['kebutuhan_soal_anggota']);
		 // print_r(unserialize($data['penugasan']->id_ambil_penugasan));
		 // print_r(unserialize($data['penugasan']->status_penugasan_anggota));
		// // print_r(unserialize($data['penugasan']->materi_penugasan));
		// print_r(unserialize($data['penugasan']->tingkat_kesulitan));
		return $this->load->view("v_progres_penugasan",$data,true);
	}
	public function tambah_penugasan() {
		$this->is_login();
		$comp = array(
			"title" => "Tambah Penugasan",
			"sidebar" => $this->sidebar(),
			"header" => $this->header(),
			"content" => $this ->view_tambah_penugasan(),
		);
		$this->load->view('v_template',$comp);
	}
	public function view_tambah_penugasan() {
		$team_teaching  = $this->m_team_teaching->get_daftar_team_teachingXmata_kuliah(array('id_dosen'=>$this->session->userdata('id')),"id_tt");
		for ($i=0; $i < count($team_teaching); $i++) { 
			$data['materi'][$i] = $this->m_materi->get_rows_materi(array('materi.id_tt'=>$team_teaching[$i]['id_tt']),"nama_materi");
		}
		$data['team_teaching'] = $team_teaching;
		//$data['team_teaching'] = $this->m_team_teaching->get_data_team_teaching($this->session->userdata('id'));
		//$data['dosen'] = $this->m_dosen->get_daftar_dosen(array(),"id_dosen");
		return $this->load->view("v_tambah_penugasan",$data,true);
	}
	public function edit_penugasan($id_penugasan) {
		$this->is_login();
		$comp = array(
			"title" => "Edit Penugasan",
			"sidebar" => $this->sidebar(),
			"header" => $this->header(),
			"content" => $this ->view_edit_penugasan($id_penugasan),
		);
		$this->load->view('v_template',$comp);
	}
	public function view_edit_penugasan($id_penugasan) {
		//$data['team_teaching'] = $this->m_team_teaching->get_data_team_teaching($this->session->userdata('id'));
		$data['dosen'] = $this->m_dosen->get_daftar_dosen(array(),"id_dosen");
		$where = array('id_penugasan'=>$id_penugasan);
		$data['penugasan'] = $this->m_penugasan->get_penugasan($where);
		$team_teaching  = $this->m_team_teaching->get_daftar_team_teachingXmata_kuliah(array('id_dosen'=>$this->session->userdata('id')),"id_tt");
		for ($i=0; $i < count($team_teaching); $i++) { 
			$data['materi'][$i] = $this->m_materi->get_rows_materi(array('materi.id_tt'=>$team_teaching[$i]['id_tt']),"nama_materi");
		}
		$data['team_teaching'] = $team_teaching;
		return $this->load->view("v_edit_penugasan",$data,true);
	}
	public function evaluasi_penugasan_ketua($id_penugasan) {
		$this->is_login();
		$comp = array(
			"title" => "Evaluasi Penugasan",
			"sidebar" => $this->sidebar(),
			"header" => $this->header(),
			"content" => $this ->view_evaluasi_penugasan_ketua($id_penugasan),
		);
		$this->load->view('v_template',$comp);
	}
	public function view_evaluasi_penugasan_ketua($id_penugasan) {
		$where = array('id_penugasan'=>$id_penugasan);
		$data['penugasan'] = $this->m_penugasan->get_penugasan($where);
		$where = array('soal.id_penugasan'=>$id_penugasan);
		$data['soal'] = $this->m_soal->get_daftar_soal($where,'id_soal');
		$data['dosen'] = array();
		foreach ($data['soal'] as $soal) {
			$where = array('id_dosen'=>$soal['id_dosen']);
			$dosen = $this->m_dosen->get_dosen($where);
			array_push($data['dosen'], $dosen->nama_dosen);
		}
		return $this->load->view("v_edit_soal_evaluasi",$data,true);
	}
	public function evaluasi_bank_soal($id_tt){
		$this->is_login();
		$comp = array(
			"title" => "Evaluasi Bank Soal",
			"sidebar" => $this->sidebar(),
			"header" => $this->header(),
			"content" => $this ->view_evaluasi_bank_soal($id_tt),
		);
		$this->load->view('v_template',$comp);
	}
	public function view_evaluasi_bank_soal($id_tt){
		$where = array('materi.id_tt'=>$id_tt);
		$materi = $this->m_materi->get_rows_materi($where,'nama_materi');
		$soal = array();
		$data_materi = array();
		for ($i=0; $i < count($materi); $i++) { 
			$where = array('soal.id_materi'=>$materi[$i]['id_materi'],'status_penugasan'=>1);
			$tmp_soal = $this->m_soal->get_daftar_soal($where,'id_soal');
			for ($j=0; $j < count($tmp_soal); $j++) { 
				array_push($data_materi,$materi[$i]['nama_materi']);
				array_push($soal,$tmp_soal[$j]);
			}
		}
		//print_r($soal);
		$data['materi'] = $materi;
		$data['data_materi'] = $data_materi;
		$data['team_teaching'] = $this->m_team_teaching->get_row_team_teaching($id_tt);
		$data['soal'] = $soal;
		$data['dosen'] = array();
		foreach ($data['soal'] as $soal) {
			$where = array('id_dosen'=>$soal['id_dosen']);
			$dosen = $this->m_dosen->get_dosen($where);
			array_push($data['dosen'], $dosen->nama_dosen);
		}
		return $this->load->view("v_evaluasi_bank_soal",$data,true);
	}
	//END Ketua TT

	//DOSEN
	public function penugasan() {
		$this->is_login();
		$comp = array(
			"title" => "Penugasan",
			"sidebar" => $this->sidebar(),
			"header" => $this->header(),
			"content" => $this ->view_penugasan(),
		);
		$this->load->view('v_template',$comp);
	}
	public function view_penugasan() {
		$data = array();
		$data['penugasan'] = array();
		$tt = $this->m_team_teaching->get_data_partOfTeam("anggota_tt",'"'.$this->session->userdata('id').'"',array());
		$penugasan = $this->m_penugasan->get_rows_penugasan(array('status_penugasan'=>0),"nama_penugasan");
		$index_penugasan = 0;
		for ($i=0; $i < count($penugasan) ; $i++) { 
			$cek_id_tt = false;
			for ($j=0; $j < count($tt); $j++) { 
				if ($penugasan[$i]['id_tt'] == $tt[$j]['id_tt']) {
					$cek_id_tt = true;
					break;
				}
			}
			if ($cek_id_tt) {
				$data['penugasan'][$index_penugasan] = $penugasan[$i];
				$index_penugasan++;
			}
		}
		return $this->load->view("v_daftar_penugasan",$data,true);
	}
	public function detail_penugasan($id) {
		$this->is_login();
		$comp = array(
			"title" => "Penugasan",
			"sidebar" => $this->sidebar(),
			"header" => $this->header(),
			"content" => $this ->view_detail_penugasan($id),
		);
		$this->load->view('v_template',$comp);
	}
	public function view_detail_penugasan($id) {
		$where = array('id_penugasan'=>$id);
		$data['team_teaching_anggota'] = $this->m_team_teaching->get_data_team_teaching_by_ketua_tim($this->session->userdata('id'));
		$data['dosen'] = $this->m_dosen->get_daftar_dosen(array(),"nama_dosen");
		$data['penugasan'] = $this->m_penugasan->get_penugasan($where);
		$data['id_ketua_tim'] = $this->m_team_teaching->get_team_teaching(array('id_tt'=>$data['penugasan']->id_tt))->id_dosen;
		$materi = unserialize($data['penugasan']->materi_penugasan);
		for ($i=0; $i < count($materi) ; $i++) { 
			$data['materi'][$i] = $this->m_materi->get_materi(array('id_materi'=>$materi[$i]));
		}
		return $this->load->view("v_detail_penugasan",$data,true);
	}
	public function buat_soal($id,$index) {
		$this->is_login();
		$comp = array(
			"title" => "Buat Soal",
			"sidebar" => $this->sidebar(),
			"header" => $this->header(),
			"content" => $this ->view_buat_soal($id,$index),
		);
		$this->load->view('v_template',$comp);
	}
	public function view_buat_soal($id,$index) {
		$where = array('id_penugasan'=>$id);
		$data['penugasan'] = $this->m_penugasan->get_row_penugasan($where);
		$data['index'] = $index;
		$materi = unserialize($data['penugasan']->materi_penugasan);
		$data['materi_penugasan'] = $this->m_materi->get_materi(array('id_materi'=>$materi[$index]));
		return $this->load->view("v_buat_soal",$data,true);
	}
	public function edit_soal($id,$index) {
		$this->is_login();
		$comp = array(
			"title" => "Edit Soal",
			"sidebar" => $this->sidebar(),
			"header" => $this->header(),
			"content" => $this ->view_edit_soal($id,$index),
		);
		$this->load->view('v_template',$comp);
	}
	public function view_edit_soal($id,$index) {
		$where = array('id_penugasan'=>$id);
		$data['penugasan'] = $this->m_penugasan->get_row_penugasan($where);
		$materi = unserialize($data['penugasan']->materi_penugasan);
		$data['materi_penugasan'] = $this->m_materi->get_materi(array('id_materi'=>$materi[$index]));
		$tingkat_kesulitan = unserialize($data['penugasan']->tingkat_kesulitan);
		$id_materi = $this->m_materi->get_materi(array('id_materi'=>$materi[$index]))->id_materi;
		$where = array('soal.id_penugasan'=>$id,'soal.id_materi'=>$id_materi,'id_dosen'=>$this->session->userdata('id'));
		$data['soal'] =$this->m_soal->get_daftar_soal($where,'soal.tingkat_kesulitan');
		$data['index'] = $index;
		return $this->load->view("v_edit_soal",$data,true);
	}
	public function evaluasi_penugasan($id) {
		$this->is_login();
		$comp = array(
			"title" => "Evaluasi Penugasan",
			"sidebar" => $this->sidebar(),
			"header" => $this->header(),
			"content" => $this ->view_evaluasi_penugasan($id),
		);
		$this->load->view('v_template',$comp);
	}
	public function view_evaluasi_penugasan($id) {
		$where = array('id_penugasan'=>$id);
		$data['penugasan'] = $this->m_penugasan->get_penugasan($where);
		$where = array('id_tt'=>$data['penugasan']->id_tt);
		$data['team_teaching'] = $this->m_team_teaching->get_team_teaching($where);
		$where = array('soal.id_penugasan'=>$id);
		$data['soal'] = $this->m_soal->get_daftar_soal($where,'id_soal');
		$data['dosen'] = array();
		foreach ($data['soal'] as $soal) {
			$where = array('id_dosen'=>$soal['id_dosen']);
			$dosen = $this->m_dosen->get_dosen($where);
			array_push($data['dosen'], $dosen->nama_dosen);
		}
		return $this->load->view("v_evaluasi_penugasan",$data,true);
    }

    public function riwayat_cetak_soal(){
		$this->is_login();
		$comp = array(
			"title" => "Riwayat Cetak Soal",
			"sidebar" => $this->sidebar(),
			"header" => $this->header(),
			"content" => $this ->view_riwayat_cetak_soal(),
		);
		$this->load->view('v_template',$comp);
	}
	public function view_riwayat_cetak_soal() {
		$team_teaching = $this->m_team_teaching->get_daftar_team_teachingXmata_kuliah(array('id_dosen'=>$this->session->userdata('id')),"id_tt");
		$id_matkul = array();
		for ($i=0; $i < count($team_teaching); $i++) { 
			$id_matkul[$i] = $team_teaching[$i]['id_matkul'];
		}
		$tmp_cetak_soal = $this->m_cetak_soal->get_daftar_cetak_soal(array(),'id_cetak');
		$riwayat_cetak_soal = array();
		$matkul = array();
		$dosen = array();
		$index = 0;
		for ($i=0; $i < count($tmp_cetak_soal); $i++) { 
			if (in_array($tmp_cetak_soal[$i]['id_matkul'], $id_matkul)) {
				$matkul[$index] = $this->m_matkul->get_matkul(array('id_matkul'=>$tmp_cetak_soal[$i]['id_matkul']))->nama_matkul;
				$dosen[$index] = $this->m_dosen->get_dosen(array('id_dosen'=>$tmp_cetak_soal[$i]['id_dosen']))->nama_dosen;
				$riwayat_cetak_soal[$index] = $tmp_cetak_soal[$i];
				$index++;
			}
		}
		$data['nama_dosen'] = $dosen;
		$data['nama_matkul'] = $matkul;
		$data['riwayat_cetak_soal'] = $riwayat_cetak_soal;
		return $this->load->view("v_riwayat_cetak_soal",$data,true);
    }

	public function cetak_soal(){
		$this->is_login();
		$comp = array(
			"title" => "Cetak Soal",
			"sidebar" => $this->sidebar(),
			"header" => $this->header(),
			"content" => $this ->view_cetak_soal(),
		);
		$this->load->view('v_template',$comp);
	}
	public function view_cetak_soal() {
		$team_teaching = $this->m_team_teaching->get_daftar_team_teachingXmata_kuliah(array('id_dosen'=>$this->session->userdata('id')),"id_tt");
		//print_r($team_teaching);
		$materi = array();
		for ($i=0; $i < count($team_teaching); $i++) { 
			$materi[$i] = $this->m_materi->get_rows_materi(array('materi.id_tt'=>$team_teaching[$i]['id_tt']),'bab_materi');
		}
		//print_r($materi);
		$soal = array();
		for ($i=0; $i < count($materi); $i++) { 
			for ($j=0; $j < count($materi[$i]); $j++) { 
				$soal[$i][$j] = $this->m_soal->get_daftar_soal(array('soal.id_materi'=>$materi[$i][$j]['id_materi'], 'soal!='=>'', 'status_penugasan'=> 1),'id_soal');
			}
		}
		//print_r($soal);
		$data['team_teaching'] = $team_teaching;
		$data['materi'] = $materi;
		$data['soal'] = $soal;
		return $this->load->view("v_cetak_soal",$data,true);
    }
    public function pilih_cetak_soal($id_tt){
		$this->is_login();
		$comp = array(
			"title" => "Cetak Soal",
			"sidebar" => $this->sidebar(),
			"header" => $this->header(),
			"content" => $this ->view_pilih_cetak_soal($id_tt),
		);
		$this->load->view('v_template',$comp);
	}
	public function view_pilih_cetak_soal($id_tt) {
		$materi = $this->m_materi->get_rows_materi(array('materi.id_tt'=>$id_tt),'nama_materi');
		$soal = array();
		for ($j=0; $j < count($materi); $j++) { 
			$soal[$j] = $this->m_soal->get_daftar_soal(array('soal.id_materi'=>$materi[$j]['id_materi'],'status_penugasan'=> 1),'id_soal');
		}

		//print_r($soal);
		$data['materi'] = $materi;
		$data['soal'] = $soal;
		$dosen = array();
		for ($i=0; $i < count($soal) ; $i++) { 
			for ($j=0; $j < count($soal[$i]) ; $j++) { 
				$where = array('id_dosen'=>$soal[$i][$j]['id_dosen']);
				$dosen[$i][$j] = $this->m_dosen->get_dosen($where)->nama_dosen;
			}
		}
		// print_r($materi);
		$data['dosen'] = $dosen;
		return $this->load->view("v_pilih_cetak_soal",$data,true);
    }
    public function review_soal(){
    	$this->is_login();
    	$status = $_POST['status_review'];
    	if ($status == 'acak') {
    		$id_materi = $_POST['id_materi'];
			$jum_soal_mudah = $_POST['jum_soal_mudah'];
			$jum_soal_sedang = $_POST['jum_soal_sedang'];
			$jum_soal_sulit = $_POST['jum_soal_sulit'];
			$nama_matkul = $_POST['nama_matkul'];
			$comp = array(
				"title" => "Cetak Soal",
				"sidebar" => $this->sidebar(),
				"header" => $this->header(),
				"content" => $this ->view_review_soal_acak($id_materi,$jum_soal_mudah,$jum_soal_sedang,$jum_soal_sulit,$nama_matkul),
			);
    	}else{
    		$id_soal = $_POST['id_soal'];
			$nama_matkul = $_POST['nama_matkul'];
			$comp = array(
				"title" => "Cetak Soal",
				"sidebar" => $this->sidebar(),
				"header" => $this->header(),
				"content" => $this ->view_review_soal_pilih($id_soal,$nama_matkul),
			);
    	}

		$this->load->view('v_template',$comp);
	}
	public function view_review_soal_acak($id_materi,$jum_soal_mudah,$jum_soal_sedang,$jum_soal_sulit,$nama_matkul){
		// $id_materi = $_POST['id_materi'];
		// $jum_soal_mudah = $_POST['jum_soal_mudah'];
		// $jum_soal_sedang = $_POST['jum_soal_sedang'];
		// $jum_soal_sulit = $_POST['jum_soal_sulit'];
		// $nama_matkul = $_POST['nama_matkul'];

		$soal = array();
		$estimasi_waktu = array();
		$index = 0;
		
		for ($i=0; $i <count($id_materi) ; $i++) { 
			$id_soal_dipakai_mudah = array();
			$id_soal_dipakai_sedang = array();
			$id_soal_dipakai_sulit = array();

			$id_soal_mudah = $this->m_soal->get_daftar_soal(array('soal.id_materi'=>$id_materi[$i], 'soal.tingkat_kesulitan'=>0, 'soal!='=>'', 'status_penugasan'=> 1),'id_soal');
			for ($j=0; $j <count($id_soal_mudah) ; $j++) { 
				$id_soal_dipakai_mudah[$i][$j] = $id_soal_mudah[$j]['id_soal'];
			}
			$id_soal_sedang = $this->m_soal->get_daftar_soal(array('soal.id_materi'=>$id_materi[$i], 'soal.tingkat_kesulitan'=>1, 'soal!='=>'', 'status_penugasan'=> 1),'id_soal');
			for ($j=0; $j <count($id_soal_sedang) ; $j++) { 
				$id_soal_dipakai_sedang[$i][$j] = $id_soal_sedang[$j]['id_soal'];
			}
			$id_soal_sulit = $this->m_soal->get_daftar_soal(array('soal.id_materi'=>$id_materi[$i], 'soal.tingkat_kesulitan'=>2, 'soal!='=>'', 'status_penugasan'=> 1),'id_soal');
			for ($j=0; $j <count($id_soal_sulit) ; $j++) { 
				$id_soal_dipakai_sulit[$i][$j] = $id_soal_sulit[$j]['id_soal'];
			}
			for ($j=0; $j <$jum_soal_mudah[$i] ; $j++) {
				//get random key
				$key = rand(0,count($id_soal_dipakai_mudah[$i])-1);
				//print_r($id_soal_dipakai[$i]);
				//echo "key - ".$key;
				$tmp_soal = $this->m_soal->get_soal(array('id_soal'=>$id_soal_dipakai_mudah[$i][$key]));
				unset($id_soal_dipakai_mudah[$i][$key]);
				$id_soal_dipakai_mudah[$i] = array_values($id_soal_dipakai_mudah[$i]);
				//end get random key
				$soal[$index]['id_soal'] = $tmp_soal->id_soal;
				$soal[$index]['id_penugasan'] = $tmp_soal->id_penugasan;
				$soal[$index]['id_materi'] = $tmp_soal->id_materi;
				$soal[$index]['id_dosen'] = $tmp_soal->id_dosen;
				$soal[$index]['tingkat_kesulitan'] = $tmp_soal->tingkat_kesulitan;
				$soal[$index]['soal'] = $tmp_soal->soal;
				$soal[$index]['opsi'] = $tmp_soal->opsi;
				$soal[$index]['tanggal_buat'] = $tmp_soal->tanggal_buat;
				$estimasi_waktu[$index] = $tmp_soal->estimasi_pengerjaan_soal;
				$index++;
			}
			for ($j=0; $j <$jum_soal_sedang[$i] ; $j++) {
				//get random key
				$key = rand(0,count($id_soal_dipakai_sedang[$i])-1);
				//print_r($id_soal_dipakai[$i]);
				//echo "key - ".$key;
				$tmp_soal = $this->m_soal->get_soal(array('id_soal'=>$id_soal_dipakai_sedang[$i][$key]));
				unset($id_soal_dipakai_sedang[$i][$key]);
				$id_soal_dipakai_sedang[$i] = array_values($id_soal_dipakai_sedang[$i]);
				//end get random key
				$soal[$index]['id_soal'] = $tmp_soal->id_soal;
				$soal[$index]['id_penugasan'] = $tmp_soal->id_penugasan;
				$soal[$index]['id_materi'] = $tmp_soal->id_materi;
				$soal[$index]['id_dosen'] = $tmp_soal->id_dosen;
				$soal[$index]['tingkat_kesulitan'] = $tmp_soal->tingkat_kesulitan;
				$soal[$index]['soal'] = $tmp_soal->soal;
				$soal[$index]['opsi'] = $tmp_soal->opsi;
				$soal[$index]['tanggal_buat'] = $tmp_soal->tanggal_buat;
				$estimasi_waktu[$index] = $tmp_soal->estimasi_pengerjaan_soal;
				$index++;
			}
			for ($j=0; $j <$jum_soal_sulit[$i] ; $j++) {
				//get random key
				$key = rand(0,count($id_soal_dipakai_sulit[$i])-1);
				//print_r($id_soal_dipakai[$i]);
				//echo "key - ".$key;
				$tmp_soal = $this->m_soal->get_soal(array('id_soal'=>$id_soal_dipakai_sulit[$i][$key]));
				unset($id_soal_dipakai_sulit[$i][$key]);
				$id_soal_dipakai_sulit[$i] = array_values($id_soal_dipakai_sulit[$i]);
				//end get random key
				$soal[$index]['id_soal'] = $tmp_soal->id_soal;
				$soal[$index]['id_penugasan'] = $tmp_soal->id_penugasan;
				$soal[$index]['id_materi'] = $tmp_soal->id_materi;
				$soal[$index]['id_dosen'] = $tmp_soal->id_dosen;
				$soal[$index]['tingkat_kesulitan'] = $tmp_soal->tingkat_kesulitan;
				$soal[$index]['soal'] = $tmp_soal->soal;
				$soal[$index]['opsi'] = $tmp_soal->opsi;
				$soal[$index]['tanggal_buat'] = $tmp_soal->tanggal_buat;
				$estimasi_waktu[$index] = $tmp_soal->estimasi_pengerjaan_soal;
				$index++;
			}
		}

		//print_r($soal);
		$waktu_pengerjaan = array_sum($estimasi_waktu)/60;
		$data['nama_matkul'] = $nama_matkul;
    	$data['waktu_pengerjaan'] = $waktu_pengerjaan;
    	$data['soal'] = $soal;
    	$data['dosen'] = array();
		foreach ($data['soal'] as $soal) {
			$where = array('id_dosen'=>$soal['id_dosen']);
			$dosen = $this->m_dosen->get_dosen($where);
			array_push($data['dosen'], $dosen->nama_dosen);
		}
    	return $this->load->view("v_review_soal",$data,true);


		// 
		// $this->generate_soal($soal,'A',$nama_matkul,$waktu_pengerjaan);
		// shuffle($soal);
		// for ($i=0; $i <count($soal) ; $i++) { 
		// 	$opsiSoalB = unserialize($soal[$i]['opsi']);
		// 	//print_r($opsiSoalB);
		// 	shuffle($opsiSoalB);
		// 	$soal[$i]['opsi'] = serialize($opsiSoalB);
		// }
		// $this->generate_soal($soal,'B',$nama_matkul,$waktu_pengerjaan);
	}
	public function view_review_soal_pilih($id_soal, $nama_matkul){
		//print_r($id_soal);
		$soal = array();
		$estimasi_waktu = array();

		for ($j=0; $j <count($id_soal) ; $j++) {
			$tmp_soal = $this->m_soal->get_soal(array('id_soal'=>$id_soal[$j]));

			$soal[$j]['id_soal'] = $tmp_soal->id_soal;
			$soal[$j]['id_penugasan'] = $tmp_soal->id_penugasan;
			$soal[$j]['id_materi'] = $tmp_soal->id_materi;
			$soal[$j]['id_dosen'] = $tmp_soal->id_dosen;
			$soal[$j]['tingkat_kesulitan'] = $tmp_soal->tingkat_kesulitan;
			$soal[$j]['soal'] = $tmp_soal->soal;
			$soal[$j]['opsi'] = $tmp_soal->opsi;
			$soal[$j]['tanggal_buat'] = $tmp_soal->tanggal_buat;
			$estimasi_waktu[$j] = $tmp_soal->estimasi_pengerjaan_soal;
		}
		$waktu_pengerjaan = array_sum($estimasi_waktu)/60;
		$data['nama_matkul'] = $nama_matkul;
    	$data['waktu_pengerjaan'] = $waktu_pengerjaan;
    	$data['soal'] = $soal;
    	$data['dosen'] = array();
		foreach ($data['soal'] as $soal) {
			$where = array('id_dosen'=>$soal['id_dosen']);
			$dosen = $this->m_dosen->get_dosen($where);
			array_push($data['dosen'], $dosen->nama_dosen);
		}
    	return $this->load->view("v_review_soal",$data,true);
	}
    //proses
    public function proses_tambah_penugasan(){
		$judul_tugas = $_POST['judul_tugas'];
		$materi = $_POST['materi'];
		$mudah = $_POST['mudah'];
		$sedang = $_POST['sedang'];
		$sulit = $_POST['sulit'];
		$mulai_penugasan = $_POST['batas_pengambilan'];
		$batas = $_POST['batas_penugasan'];
		$kuota_ambil = $_POST['kuota'];

		$tingkat_kesulitan = array();
		for ($i=0; $i < count($materi); $i++) {
			$tingkat_kesulitan[$i] = array($mudah[$i],$sedang[$i],$sulit[$i]);
		}
		$id_penugasan = array();
		$status_penugasan_anggota = array();
		for ($i=0; $i < count($materi) ; $i++) { 
			for ($j=0; $j < $kuota_ambil[$i] ; $j++) { 
				$id_penugasan[$i][$j] = 0;
				$status_penugasan_anggota[$i][$j] = 0;
			}
		}
		print_r($materi);
		$ser_tingkat_kesulitan = serialize($tingkat_kesulitan);
		$ser_materi = serialize($materi);
		$ser_kuota_ambil = serialize($kuota_ambil);
		$ser_id_penugasan = serialize($id_penugasan);
		$ser_status_penugasan_anggota = serialize($status_penugasan_anggota);
		if (isset($_POST['team_teaching'])) {
			$id_team_teaching = $_POST['team_teaching'];
		}else{
			$where = array('id_dosen'=>$this->session->userdata('id'));
			$id_tt = $this->m_team_teaching->get_team_teaching($where);
			$id_team_teaching = $id_tt->id_tt;
		}
		//print_r($kuota_ambil);

		$data_insert = array(
			'nama_penugasan' => $judul_tugas,
			'id_tt' => $id_team_teaching,
			'materi_penugasan' => $ser_materi,
			'tingkat_kesulitan' => $ser_tingkat_kesulitan,
			'kuota_ambil_penugasan' => $ser_kuota_ambil,
			'batas_pengambilan' => $mulai_penugasan,
			'batas_penugasan' => $batas,
			'id_ambil_penugasan' => $ser_id_penugasan,
			'status_penugasan_anggota' => $ser_status_penugasan_anggota,
			'status_penugasan' => 0,
		);
		$res = $this->m_penugasan->input_penugasan($data_insert);
		if($res>=1){
			$this->session->set_flashdata('input_msg', 'success');
		}else{
			$this->session->set_flashdata('input_msg', 'failed');
		}
		redirect(base_url()."atur-penugasan");
	}
	public function proses_edit_penugasan($id){
		$judul_tugas = $_POST['judul_tugas'];
		$materi = $_POST['materi'];
		$form_mudah = $_POST['mudah'];
		$form_sedang = $_POST['sedang'];
		$form_sulit = $_POST['sulit'];
		$mulai_penugasan = $_POST['batas_pengambilan'];
		$batas = $_POST['batas_penugasan'];
		$kuota_ambil = $_POST['kuota'];
		$status = $_POST['status'];

		$where = array('id_penugasan'=>$id);
		$penugasan = $this->m_penugasan->get_row_penugasan($where);
		$tmp_id_penugasan = unserialize($penugasan->id_ambil_penugasan);
		$tmp_status_penugasan_anggota = unserialize($penugasan->status_penugasan_anggota);
		$tingkat_kesulitan = unserialize($penugasan->tingkat_kesulitan);


		$id_penugasan = array();
		$status_penugasan_anggota = array();
		for ($i=0; $i < count($materi) ; $i++) { 
			for ($j=0; $j < $kuota_ambil[$i] ; $j++) { 
				if ($status[$i]=="lama") {
					$id_penugasan[$i][$j] = $tmp_id_penugasan[$i][$j];
					$status_penugasan_anggota[$i][$j] = $tmp_status_penugasan_anggota[$i][$j];
				}else{
					$id_penugasan[$i][$j] = 0;
					$status_penugasan_anggota[$i][$j] = 0;
				}
			}
		}

		$tingkat_kesulitan = array();
		for ($i=0; $i < count($materi); $i++) {
			$tingkat_kesulitan[$i] = array($form_mudah[$i],$form_sedang[$i],$form_sulit[$i]);
			for ($j=0; $j <count($id_penugasan[$i]) ; $j++) { 
				if ($id_penugasan[$i][$j]!=null || $id_penugasan[$i][$j]!='') {
					$where = array('soal.id_penugasan'=>$id,'soal.id_materi'=>$materi[$i],'id_dosen'=>$id_penugasan[$i][$j]);
					//echo $materi[$i].",".$id_penugasan[$i][$j]."|";
					$soal = $this->m_soal->get_daftar_soal($where,'soal.tingkat_kesulitan');
					//echo "<br> ".count($soal);
					if (count($soal)>0) {
						$mudah = 0;
						$sedang = 0;
						$sulit = 0;
						for ($k=0; $k <count($soal) ; $k++) { 
							if ($soal[$k]['tingkat_kesulitan'] == 0) {
								$mudah++;
							}elseif ($soal[$k]['tingkat_kesulitan'] == 1) {
								$sedang++;
							}elseif ($soal[$k]['tingkat_kesulitan'] == 2) {
								$sulit++;
							}
						}
						echo $mudah.",".$sedang.",".$sulit."<br>";
						echo $tingkat_kesulitan[$i][0].",".$tingkat_kesulitan[$i][1].",".$tingkat_kesulitan[$i][2]."<br><br>";
						if ($tingkat_kesulitan[$i][0] != $mudah) {
							if ($tingkat_kesulitan[$i][0] > $mudah) {
								for ($k=0; $k <$tingkat_kesulitan[$i][0]-$mudah ; $k++) { 
									$opsi = array("","","","");
									$ser_opsi = serialize($opsi);
									$data_insert = array(
										'id_penugasan' => $id,
										'id_materi' => $materi[$i],
										'id_dosen' => $this->session->userdata('id'),
										'tingkat_kesulitan' => 0,
										'soal' => "",
										'opsi' => $ser_opsi,
										'jawaban' => 0,
										'estimasi_pengerjaan_soal' => 60
									);
									$res = $this->m_soal->input_soal($data_insert);
								}
							}else{
								for ($k=0; $k <$mudah-$tingkat_kesulitan[$i][0] ; $k++) {
									$id_soal;
									// print_r($soal);
									// echo count($soal)."<br>";
									for ($l=0; $l <count($soal); $l++) { 
										echo $soal[$l]['tingkat_kesulitan']."<br>";
										if ($soal[$l]['tingkat_kesulitan'] == 0) {
											$id_soal = $soal[$l]['id_soal'];
				 						}
				 						if ($soal[$l]['tingkat_kesulitan'] > 0) {
				 							break;
				 						}
									}
									$where = array('id_soal'=>$id_soal);
									$this->m_soal->delete_soal($where);
									$where = array('soal.id_penugasan'=>$id,'soal.id_materi'=>$materi[$i],'id_dosen'=>$this->session->userdata('id'));
									$soal = $this->m_soal->get_daftar_soal($where,'soal.tingkat_kesulitan');
								}
							}
						}
						if ($tingkat_kesulitan[$i][1] != $sedang) {
							if ($tingkat_kesulitan[$i][1] > $sedang) {
								for ($k=0; $k <$tingkat_kesulitan[$i][1]-$sedang ; $k++) { 
									$opsi = array("","","","");
									$ser_opsi = serialize($opsi);
									$data_insert = array(
										'id_penugasan' => $id,
										'id_materi' => $materi[$i],
										'id_dosen' => $this->session->userdata('id'),
										'tingkat_kesulitan' => 1,
										'soal' => "",
										'opsi' => $ser_opsi,
										'jawaban' => 0,
										'estimasi_pengerjaan_soal' => 60
									);
									$res = $this->m_soal->input_soal($data_insert);
								}
							}else{
								for ($k=0; $k <$sedang-$tingkat_kesulitan[$i][1] ; $k++) {
									$id_soal;
									for ($l=0; $l <count($soal) ; $l++) { 
										if ($soal[$l]['tingkat_kesulitan'] == 1) {
											$id_soal = $soal[$l]['id_soal'];
				 						}
				 						if ($soal[$l]['tingkat_kesulitan'] > 1) {
				 							break;
				 						}
									}
									$where = array('id_soal'=>$id_soal);
									$this->m_soal->delete_soal($where);
									$where = array('soal.id_penugasan'=>$id,'soal.id_materi'=>$materi[$i],'id_dosen'=>$this->session->userdata('id'));
									$soal = $this->m_soal->get_daftar_soal($where,'soal.tingkat_kesulitan');
								}
							}
						}
						if ($tingkat_kesulitan[$i][2] != $sulit) {
							if ($tingkat_kesulitan[$i][2] > $sulit) {
								for ($k=0; $k <$tingkat_kesulitan[$i][2]-$sulit ; $k++) { 
									$opsi = array("","","","");
									$ser_opsi = serialize($opsi);
									$data_insert = array(
										'id_penugasan' => $id,
										'id_materi' => $materi[$i],
										'id_dosen' => $this->session->userdata('id'),
										'tingkat_kesulitan' => 2,
										'soal' => "",
										'opsi' => $ser_opsi,
										'jawaban' => 0,
										'estimasi_pengerjaan_soal' => 60
									);
									$res = $this->m_soal->input_soal($data_insert);
								}
							}else{
								for ($k=0; $k <$sulit-$tingkat_kesulitan[$i][2] ; $k++) {
									$id_soal = 0;
									for ($l=0; $l <count($soal) ; $l++) { 
										if ($soal[$l]['tingkat_kesulitan'] == 2) {
											$id_soal = $soal[$l]['id_soal'];
				 						}
				 						if ($soal[$l]['tingkat_kesulitan'] > 2) {
				 							break;
				 						}
									}
									$where = array('id_soal'=>$id_soal);
									$this->m_soal->delete_soal($where);
									$where = array('soal.id_penugasan'=>$id,'soal.id_materi'=>$materi[$i],'id_dosen'=>$this->session->userdata('id'));
									$soal = $this->m_soal->get_daftar_soal($where,'soal.tingkat_kesulitan');
								}
							}
						}
					}
				}
			}
		}

		//print_r($tingkat_kesulitan);
		$ser_tingkat_kesulitan = serialize($tingkat_kesulitan);
		$ser_materi = serialize($materi);
		$ser_kuota_ambil = serialize($kuota_ambil);
		$ser_id_penugasan = serialize($id_penugasan);
		$ser_status_penugasan_anggota = serialize($status_penugasan_anggota);
		$where = array('id_dosen'=>$this->session->userdata('id'));
		$id_tt = $this->m_team_teaching->get_team_teaching($where);


		$data_update = array(
			'nama_penugasan' => $judul_tugas,
			'materi_penugasan' => $ser_materi,
			'tingkat_kesulitan' => $ser_tingkat_kesulitan,
			'kuota_ambil_penugasan' => $ser_kuota_ambil,
			'id_ambil_penugasan' => $ser_id_penugasan,
			'status_penugasan_anggota' => $ser_status_penugasan_anggota,
			'batas_pengambilan' => $mulai_penugasan,
			'batas_penugasan' => $batas,
		);
		$where = array('id_penugasan'=>$id);
		$res = $this->m_penugasan->update_penugasan($data_update,$where);
		if($res>=1){
			$this->session->set_flashdata('edit_msg', 'success');
		}else{
			$this->session->set_flashdata('edit_msg', 'failed');
		}
		redirect(base_url()."edit-penugasan/".$id);
	}
	public function proses_hapus_penugasan($id){
		$where = array('id_penugasan'=>$id);
		$res= $this->m_penugasan->delete_penugasan($where);
		if($res>=1){
			$this->session->set_flashdata('delete_msg', 'success');
		}else{
			$this->session->set_flashdata('delete_msg', 'failed');
		}
		redirect(base_url('atur-penugasan'));
	}
	public function proses_gabung_penugasan($id,$index){
		$penugasan = $this->m_penugasan->get_penugasan(array("id_penugasan"=>$id));
		$id_ambil_penugasan = unserialize($penugasan->id_ambil_penugasan);
		$id_dosen = $_POST['id_dosen'];
		if (!in_array($id_dosen, $id_ambil_penugasan[$index])) {
			$key = array_search(0, $id_ambil_penugasan[$index]);
			if ($key>=0) {
				$id_ambil_penugasan[$index][$key] = $id_dosen;
				$ser_id_ambil = serialize($id_ambil_penugasan);

				$data_update = array(
					'id_ambil_penugasan' => $ser_id_ambil,
				);
				$where = array('id_penugasan'=>$id);
				$res = $this->m_penugasan->update_penugasan($data_update,$where);
				$this->session->set_flashdata('gabung_msg', 'success');
			}else{
				$this->session->set_flashdata('gabung_msg', 'failed');
			}
		}else{
			$this->session->set_flashdata('gabung_msg', 'already');
		}
		redirect(base_url()."detail-penugasan/".$id);
	}
	public function proses_keluar_penugasan($id,$index){
		$penugasan = $this->m_penugasan->get_penugasan(array("id_penugasan"=>$id));
		$id_ambil_penugasan = unserialize($penugasan->id_ambil_penugasan);
		$id_dosen = $_POST['id_dosen'];
		if (in_array($id_dosen, $id_ambil_penugasan[$index])) {
			for ($i=0; $i < count($id_ambil_penugasan[$index]) ; $i++) { 
				if ($id_ambil_penugasan[$index][$i] == $id_dosen) {
					$id_ambil_penugasan[$index][$i] = 0;
					break;
				}
			}
			$ser_id_ambil = serialize($id_ambil_penugasan);


			$data_update = array(
				'id_ambil_penugasan' => $ser_id_ambil,
			);
			$where = array('id_penugasan'=>$id);
			$res = $this->m_penugasan->update_penugasan($data_update,$where);
			if($res>=1){
				$this->session->set_flashdata('keluar_msg', 'success');
			}else{
				$this->session->set_flashdata('keluar_msg', 'failed');
			}
		}
		redirect(base_url()."detail-penugasan/".$id);
	}
	public function proses_buat_soal(){
		$soal = $_POST['soal'];
		$pgBenar = $_POST['pgBenar'];
		$pgA = $_POST['pgA'];
		$pgB = $_POST['pgB'];
		$pgC = $_POST['pgC'];
		$pgD = $_POST['pgD'];
		$estimasi_waktu = $_POST['estimasi_waktu'];
		$tingkat_kesulitan = $_POST['tingkat_kesulitan'];
		$id_penugasan = $_POST['id_penugasan'];
		$id_materi = $_POST['id_materi'];

		for ($i=0; $i < count($soal) ; $i++) {
			$opsi = array($pgA[$i],$pgB[$i],$pgC[$i],$pgD[$i]);
			$ser_opsi = serialize($opsi);
			$data_insert = array(
				'id_penugasan' => $id_penugasan,
				'id_materi' => $id_materi,
				'id_dosen' => $this->session->userdata('id'),
				'tingkat_kesulitan' => $tingkat_kesulitan[$i],
				'soal' => $soal[$i],
				'opsi' => $ser_opsi,
				'jawaban' => $pgBenar[$i],
				'estimasi_pengerjaan_soal' => $estimasi_waktu[$i]
			);
			$res = $this->m_soal->input_soal($data_insert);
			$this->session->set_flashdata('input_msg', 'success');
		}

		redirect(base_url('detail-penugasan/'.$id_penugasan));
	}
	public function proses_edit_soal(){
		$soal = $_POST['soal'];
		$pgBenar = $_POST['pgBenar'];
		$pgA = $_POST['pgA'];
		$pgB = $_POST['pgB'];
		$pgC = $_POST['pgC'];
		$pgD = $_POST['pgD'];
		$estimasi_waktu = $_POST['estimasi_waktu'];
		$id_soal = $_POST['id_soal'];
		$status = $_POST['status_edit'];
		$status_edit = false;

		if ($status == 'evaluasi') {
			$id_penugasan = $_POST['id_penugasan'];
			$status_soal = $_POST['status_soal'];
			for ($i=0; $i < count($soal) ; $i++) {
				$opsi = array($pgA[$i],$pgB[$i],$pgC[$i],$pgD[$i]);
				$ser_opsi = serialize($opsi);
				$data_update = array(
					'soal' => $soal[$i],
					'opsi' => $ser_opsi,
					'jawaban' => $pgBenar[$i],
					'estimasi_pengerjaan_soal' => $estimasi_waktu[$i],
					'status_soal' => $status_soal[$i]
				);
				$where = array('id_soal'=>$id_soal[$i]);
				$res = $this->m_soal->update_soal($data_update,$where);
				if ($res>=1) {
					$status_edit = true;
				}
			}
		}elseif ($status == 'evaluasiBankSoal') {
			$id_tt = $_POST['id_tt'];
			$status_soal = $_POST['status_soal'];
			for ($i=0; $i < count($soal) ; $i++) {
				$opsi = array($pgA[$i],$pgB[$i],$pgC[$i],$pgD[$i]);
				$ser_opsi = serialize($opsi);
				$data_update = array(
					'soal' => $soal[$i],
					'opsi' => $ser_opsi,
					'jawaban' => $pgBenar[$i],
					'estimasi_pengerjaan_soal' => $estimasi_waktu[$i],
					'status_soal' => $status_soal[$i]
				);
				$where = array('id_soal'=>$id_soal[$i]);
				$res = $this->m_soal->update_soal($data_update,$where);
				if ($res>=1) {
					$status_edit = true;
				}
			}
		}else{
			$id_penugasan = $_POST['id_penugasan'];
			for ($i=0; $i < count($soal) ; $i++) {
				$opsi = array($pgA[$i],$pgB[$i],$pgC[$i],$pgD[$i]);
				$ser_opsi = serialize($opsi);
				$data_update = array(
					'soal' => $soal[$i],
					'opsi' => $ser_opsi,
					'jawaban' => $pgBenar[$i],
					'estimasi_pengerjaan_soal' => $estimasi_waktu[$i]
				);
				$where = array('id_soal'=>$id_soal[$i]);
				$res = $this->m_soal->update_soal($data_update,$where);
				if ($res>=1) {
					$status_edit = true;
				}
				
			}
		}
		if($status_edit){
			$this->session->set_flashdata('edit_msg', 'success');
		}else{
			$this->session->set_flashdata('edit_msg', 'failed');
		}
		if ($status == 'evaluasi') {
			redirect(base_url('edit-soal-evaluasi/'.$id_penugasan));
		}elseif ($status == 'evaluasiBankSoal') {
			redirect(base_url('evaluasi-bank-soal/'.$id_tt));
		}else{
			redirect(base_url('detail-penugasan/'.$id_penugasan));
		}
	}
	public function proses_submit_materi($id,$index){
		$penugasan = $this->m_penugasan->get_penugasan(array("id_penugasan"=>$id));
		$id_ambil_penugasan = unserialize($penugasan->id_ambil_penugasan);
		$status_penugasan_anggota = unserialize($penugasan->status_penugasan_anggota);
		$index_dosen = array_search($this->session->userdata('id'), $id_ambil_penugasan[$index]);
		$status_penugasan_anggota[$index][$index_dosen] = 1;

		$ser_status_penugasan_anggota = serialize($status_penugasan_anggota);


		$data_update = array('status_penugasan_anggota' => $ser_status_penugasan_anggota);
		$where = array('id_penugasan'=>$id);
		$res = $this->m_penugasan->update_penugasan($data_update,$where);
		$this->session->set_flashdata('submit_msg', 'success');

		redirect(base_url()."detail-penugasan/".$id);
	}
	public function proses_tambah_komentar($id){

		$kategori= $_POST['kategori'];
		$komentar= $_POST['komentar'];

		$data_insert = array(
			'id_soal' => $id,
			'id_dosen' => $this->session->userdata('id'),
			'kategori_komentar' => $kategori,
			'isi_komentar' => $komentar,
			'tanggal_komentar' => date("Y-m-d")
		);
		$res = $this->m_komentar->input_komentar($data_insert);
		if($res>=1){
			$this->session->set_flashdata('input_msg', 'success');
		}else{
			$this->session->set_flashdata('input_msg', 'failed');
		}
		//redirect(base_url()."tambah_kategori");
	}

	public function proses_hapus_komentar($id,$id_penugasan){
		$where = array('id_komentar'=>$id);
		$res= $this->m_komentar->delete_komentar($where);
		if($res>=1){
			$this->session->set_flashdata('delete_kmntr', 'success');
		}else{
			$this->session->set_flashdata('delete_kmntr', 'failed');
		}
		redirect(base_url('evaluasi-penugasan/'.$id_penugasan));
		//redirect(base_url()."tambah_kategori");
	}

	private function get_dosen_penugasan($dosen){
		$dosen_penugasan = array();
		for ($i=0; $i < count($dosen); $i++) { 
			for ($j=0; $j < count($dosen[$i]); $j++) { 
				if (!in_array($dosen[$i][$j], $dosen_penugasan) && $dosen[$i][$j]!=0) {
					array_push($dosen_penugasan,$dosen[$i][$j]); 
				}
			}
		}
		return $dosen_penugasan;
	}

	private function get_pesan_notifikasi($penugasan, $dosen_penugasan){
		$id_penugasan = $penugasan->id_penugasan;
		$dosen = unserialize($penugasan->id_ambil_penugasan);
		$materi = unserialize($penugasan->materi_penugasan);
		$soal = unserialize($penugasan->tingkat_kesulitan);

		$notifikasi = array();
		for ($i=0; $i < count($dosen_penugasan); $i++) {
			$counter_notif = 0;
			for ($j=0; $j < count($materi); $j++) { 
				if (in_array($dosen_penugasan[$i], $dosen[$j])) {
					$jum_soal = 0;
					for ($k=0; $k < count($soal[$j]); $k++) { 
						$jum_soal = $jum_soal + (int)$soal[$j][$k];
					}
					$id_materi = $this->m_materi->get_materi(array('id_materi'=>$materi[$j]))->id_materi;
					$where = array('soal.id_penugasan'=>$id_penugasan, 'soal.id_materi'=>$id_materi, 'id_dosen'=>$dosen_penugasan[$i]);
					$cek_soal = $this->m_soal->get_daftar_soal($where,'id_soal');
					$count_soal_kosong = 0;
					foreach ($cek_soal as $cs) {
						if ($cs['soal']=='') {
							$count_soal_kosong++;
						}
					}
					$judul_materi = $this->m_materi->get_materi(array('id_materi'=>$materi[$j]));
					if ($count_soal_kosong>0) {
						$notifikasi[$i][$counter_notif] = $judul_materi->nama_materi." : ".$count_soal_kosong." soal";
						$counter_notif++;
					}else if(count($cek_soal)==0){
						$notifikasi[$i][$counter_notif] = $judul_materi->nama_materi." : ".$jum_soal." soal";
						$counter_notif++;
					}
				}
			}
		}

		$message = array();
		for ($i=0; $i < count($dosen_penugasan); $i++) {
			$where = array('id_dosen'=>$dosen_penugasan[$i]);
			$data_dosen_penugasan = $this->m_dosen->get_dosen($where);
			$message_notif = "<ul>";
			if (isset($notifikasi[$i])) {
				for ($j=0; $j < count($notifikasi[$i]); $j++) { 
					$message_notif = $message_notif."<li>".$notifikasi[$i][$j]."</li><br>";
				}
				$message_notif = $message_notif."</ul>";
				$message[$i] = '
				<table cellpadding="0" cellspacing="0" style="background-image: url(http://binamulia.org/assets/images/works/banner.jpg);">
				    <tr>
				        <td class="pattern" width="450">
				            <table cellpadding="0" cellspacing="0">
				                <tr>
				                    <td class="hero">
				                        <img src="http://binamulia.org/assets/images/works/logo2-mini.png" alt="" style="display: block; border: 0; margin-bottom: 45px;margin-top: 10px;margin-left: 10px;" />
				                    </td>
				                </tr>
				                <tr>
				                    <td align="center" style="font-family: arial,sans-serif; color: #333;">
				                        <h1>Reminder! <br></h1>
				                    </td>
				                </tr>
				                <tr>
				                    <td align="left" style="font-weight: normal; line-height: 20px !important; color: #666; padding-bottom: 20px;text-align: justify;font-family: monospace;color:#000;font-size: 12px;">
				                    	<singleline>Halo '.$data_dosen_penugasan->nama_dosen.', mengingatkan tentang penugasan <strong>'.$penugasan->nama_penugasan.'</strong> mata kuliah <strong>'.$penugasan->nama_matkul.'</strong> pada Team Teaching Apps, anda memiliki tanggungan berupa :<br /><br />
				                    	</singleline>
				                    	<singleline>
				                    		'.$message_notif.'
				                    	</singleline>
				                    	<singleline>Dimohon untuk segera menyelesaikan tanggungan sebelum '.$penugasan->batas_penugasan.'.</singleline>
				                    </td>
				                </tr>
				                <tr>
				                    <td align="left">
				                        <a href="#"><img src="http://binamulia.org/assets/images/works/logo2-text2.png" alt="CTA" style="display: block; border: 0;height: 30px;margin-left: 300px;" /></a>
				                    </td>
				                </tr>
				            </table>
				        </td>
				    </tr>
				</table>';
			}
		}
		return $message;
	}

	public function proses_kirim_reminder($id_penugasan){
		$where = array('id_penugasan'=>$id_penugasan);
		$penugasan = $this->m_penugasan->get_row_penugasan($where);
		$dosen = unserialize($penugasan->id_ambil_penugasan);
		$materi = unserialize($penugasan->materi_penugasan);
		$soal = unserialize($penugasan->tingkat_kesulitan);

		$dosen_penugasan = $this->get_dosen_penugasan($dosen);
		print_r($dosen_penugasan);
		$notifikasi = $this->get_pesan_notifikasi($penugasan,$dosen_penugasan);
		print_r($notifikasi);
		$count_email = 0;
		for ($i=0; $i < count($dosen_penugasan); $i++) {
			if (isset($notifikasi[$i])) {
				$where = array('id_dosen'=>$dosen_penugasan[$i]);
				$data_dosen_penugasan = $this->m_dosen->get_dosen($where);
				$this->email_send($data_dosen_penugasan->email_dosen,$notifikasi[$i]);
				$count_email++;
			}
		}
		$this->session->set_flashdata('kirim_msg', "success");
		$this->session->set_flashdata('hitung_msg', $count_email);
		redirect(base_url()."progres-penugasan/".$id_penugasan);
	}
	function email_send($email,$message) {
		$ci = get_instance();
		$ci->load->library('email');
		$config['protocol'] = "smtp";
		$config['smtp_host'] = "smtp.gmail.com";
		$config['smtp_port'] = "587";
		$config['smtp_crypto'] = 'tls';
		$config['smtp_timeout'] = '600';
		$config['smtp_user'] = "teamteachingapps@gmail.com"; 
		$config['smtp_pass'] = "tt_apps14";
		$config['charset'] = "utf-8";
		$config['mailtype'] = "html";
		$config['newline'] = "\r\n";

		$ci->email->initialize($config);
		$ci->email->from('teamteachingapps@gmail.com', 'TEAM TEACHING APPS');
		$list = array($email);
		$ci->email->to($list);
		$ci->email->reply_to('teamteachingapps@gmail.com', '');
		$ci->email->subject('Reminder Penugasan!');
		$ci->email->message($message);
		$ci->email->send();
	}

	public function proses_tutup_evaluasi($id){
		$data_update = array(
			'status_penugasan' => 1,
		);
		$where = array('id_penugasan'=>$id);
		$res = $this->m_penugasan->update_penugasan($data_update,$where);
		if($res>=1){
			$this->session->set_flashdata('tutup_msg', 'success');
		}else{
			$this->session->set_flashdata('tutup_msg', 'failed');
		}

		redirect(base_url('atur-penugasan'));
	}

	public function proses_percepat_evaluasi($id){
		$today = date("Y-m-d");
		$data_update = array(
			'batas_penugasan' => $today,
		);
		$where = array('id_penugasan'=>$id);
		$res = $this->m_penugasan->update_penugasan($data_update,$where);
		if($res>=1){
			$this->session->set_flashdata('percepat_msg', 'success');
		}else{
			$this->session->set_flashdata('percepat_msg', 'failed');
		}

		redirect(base_url('progres-penugasan/'.$id));
	}

	public function proses_cetak_soal(){
		$soal = array();
		$array_kode_soal = array('A','B','C','D','E','F','G','H','I','J');

		$tahun_ajaran = $_POST['tahun_ajaran'];
		$nama_matkul = $_POST['nama_matkul'];
		$dosen = $_POST['dosen'];
		$kode_soal = $_POST['kode_soal'];
		$waktu_pengerjaan = $_POST['waktu'];
		$sifat_ujian = $_POST['sifat_ujian'];
		$jenis_font = $_POST['jenis_font'];
		$ukuran_font = $_POST['ukuran_font'];
		$id_soal = $_POST['id_soal'];
		
		for ($i=0; $i < count($id_soal); $i++) { 
			$tmp_soal = $this->m_soal->get_soal(array('id_soal'=>$id_soal[$i]));
			$id_penugasan = $tmp_soal->id_penugasan;
			$soal[$i]['id_soal'] = $tmp_soal->id_soal;
			$soal[$i]['id_penugasan'] = $tmp_soal->id_penugasan;
			$soal[$i]['id_materi'] = $tmp_soal->id_materi;
			$soal[$i]['id_dosen'] = $tmp_soal->id_dosen;
			$soal[$i]['tingkat_kesulitan'] = $tmp_soal->tingkat_kesulitan;
			$soal[$i]['soal'] = $tmp_soal->soal;
			$soal[$i]['opsi'] = $tmp_soal->opsi;
		}

		
		$id_matkul = $this->m_penugasan->get_row_penugasan(array('id_penugasan'=>$id_penugasan))->id_matkul;
		

		for ($i=0; $i < $kode_soal; $i++) { 
			$cetak_soal = $this->m_cetak_soal->get_cetak_soal_terakhir('id_cetak');
			print_r($cetak_soal);
			if (count($cetak_soal)==0) {
				//insert cetak soal
				$nama_file = $nama_matkul.'-'.date("d.m.Y").'-'.$array_kode_soal[$i];
				$data_insert = array(
					'id_matkul' => $id_matkul,
					'id_dosen' => $this->session->userdata('id'),
					'kode_soal' => $kode_soal,
					'nama_file_cetak' => $nama_file,
				);
				$this->m_cetak_soal->input_cetak_soal($data_insert);
				//end insert cetak soal
				$cetak_soal = $this->m_cetak_soal->get_cetak_soal_terakhir('id_cetak');
				$nama_file = $cetak_soal[0]['id_cetak'].'-'.$nama_matkul.'-'.date("d.m.Y").'-'.$array_kode_soal[$i];
				$data_update = array(
					'nama_file_cetak' => $nama_file,
				);
				$where = array('id_cetak'=>$cetak_soal[0]['id_cetak']);
				$this->m_cetak_soal->update_cetak_soal($data_update,$where);

				$this->generate_soal($cetak_soal[0]['id_cetak'],$soal,$array_kode_soal[$i],$nama_matkul,$waktu_pengerjaan,$tahun_ajaran,$dosen,$sifat_ujian,$jenis_font,$ukuran_font);
			}else{
				//insert cetak soal
				$id_cetak_soal = $cetak_soal[0]['id_cetak']+1;
				$nama_file = $id_cetak_soal.'-'.$nama_matkul.'-'.date("d.m.Y").'-'.$array_kode_soal[$i];
				$data_insert = array(
					'id_matkul' => $id_matkul,
					'id_dosen' => $this->session->userdata('id'),
					'kode_soal' => $kode_soal,
					'nama_file_cetak' => $nama_file,
				);
				$this->m_cetak_soal->input_cetak_soal($data_insert);
				//end insert cetak soal

				$this->generate_soal($id_cetak_soal,$soal,$array_kode_soal[$i],$nama_matkul,$waktu_pengerjaan,$tahun_ajaran,$dosen,$sifat_ujian,$jenis_font,$ukuran_font);
			}			
			shuffle($soal);
			for ($j=0; $j <count($soal) ; $j++) { 
				$opsiSoalB = unserialize($soal[$j]['opsi']);
			//print_r($opsiSoalB);
				shuffle($opsiSoalB);
				$soal[$j]['opsi'] = serialize($opsiSoalB);
			}
		}
		redirect(base_url('riwayat-cetak-soal'));
	}

	public function generate_soal($id_cetak,$soal,$kode,$nama_matkul,$waktu_pengerjaan,$tahun_ajaran,$dosen,$sifat_ujian,$jenis_font,$ukuran_font){
		require_once (APPPATH.'third_party/phpword/autoload.php');
		// $where = array();
		// $soal = $this->m_soal->get_daftar_soal($where,'id_soal');
		// print_r($soal);
		
		$phpWord = new \PhpOffice\PhpWord\PhpWord();

		$phpWord->addParagraphStyle('header_text', array('align'=>'center','spaceAfter'=>15));
		$phpWord->addParagraphStyle('header_text2', array('align'=>'left'));
		$tableStyle = array('borderSize' => 6, 'borderColor' => '999999');
		$tableStyle = array();
		$phpWord->addFontStyle(
		    'header1',
		    array('name' => 'Calibri (Body)', 'size' => 14, 'color' => '000000', 'bold' => true)
		);
		$phpWord->addFontStyle(
		    'headerBody1',
		    array('name' => 'Calibri (Body)', 'size' => 11, 'color' => '000000', 'bold' => true)
		);
		$phpWord->addFontStyle(
		    'headerBody2',
		    array('name' => 'Calibri (Body)', 'size' => 11, 'color' => '000000', 'bold' => false)
		);
		$phpWord->addFontStyle(
		    'bodySoal',
		    array('name' => 'Calibri', 'size' => 11, 'color' => '000000')
		);
		$multilevelNumberingStyleName = 'multilevel';
		$phpWord->addNumberingStyle(
		    $multilevelNumberingStyleName,
		    array(
		        'type'   => 'multilevel',
		        'levels' => array(
		            array('format' => 'decimal', 'text' => '%1.', 'left' => 360, 'hanging' => 360, 'tabPos' => 360),
		            array('format' => 'lowerLetter', 'text' => '%2.', 'left' => 720, 'hanging' => 360, 'tabPos' => 720),
		        ),
		    )
		);
		/* Note: any element you append to a document must reside inside of a Section. */
		/*
		 * Note: it's possible to customize font style of the Text element you add in three ways:
		 * - inline;
		 * - using named font style (new font style object will be implicitly created);
		 * - using explicitly created font style object.
		 */

		// Adding Text element with font customized inline..

		//header
		// Add first page header
		$sectionHeader = $phpWord->addSection(
			array(
				'paperSize' => 'Letter',
				'marginLeft'   => 642.8571428571429,
			    'marginRight'  => 714.2857142857143,
			    'marginTop'    => 1428.571428571429,
			    'marginBottom' => 1428.571428571429,
			)
		);
		$header = $sectionHeader->addHeader();
		$header->firstPage();

		$firstRowStyle = array();
		$phpWord->addTableStyle('myTable', $tableStyle, $firstRowStyle);

		$table = $header->addTable('myTable');
		$table->addRow(0);
		$table->addCell(9000);
		$table->addRow(1550,array('exactHeight'=>true));
		$table->addCell(9000)->addImage(
		    base_url().'assets/image/header_soal.png',
		    array('width' => 542, 'height' => 76, 'align' => 'left')
		);
		$table->addRow();
		$table->addCell(9000)->addText($tahun_ajaran,'header1','header_text');


		$fancyTableStyle = array('borderSize' => 6, 'borderColor' => '999999');
		$cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
		$cellRowContinue = array('vMerge' => 'continue');
		$cellColSpan = array('gridSpan' => 2, 'valign' => 'center');
		$cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
		$cellVCentered = array('valign' => 'center');
		$spanTableStyleName = 'Colspan Rowspan';
		$phpWord->addTableStyle($spanTableStyleName, $tableStyle);

		$table = $header->addTable($spanTableStyleName);
		$table->addRow(300,array('exactHeight'=>true));
		$table->addCell(50, $cellRowSpan)->addText('');
		$table->addCell(1600, $cellRowSpan)->addText('Mata Kuliah', 'headerBody1', 'header_text2');
		$table->addCell(300, $cellColSpan)->addText(':', 'headerBody1', 'header_text2');
		$table->addCell(3500, $cellRowSpan)->addText($nama_matkul, 'headerBody2','header_text2');
		$table->addCell(500, $cellRowSpan)->addText('');
		$table->addCell(1600, $cellRowSpan)->addText('Hari, Tanggal', 'headerBody1', 'header_text2');
		$table->addCell(300, $cellColSpan)->addText(':', 'headerBody1', 'header_text2');
		$table->addCell(3790, $cellRowSpan)->addText('', 'headerBody2','header_text2');
		$table->addRow(300,array('exactHeight'=>true));
		$table->addCell(50, $cellRowSpan)->addText('');
		$table->addCell(1600, $cellRowSpan)->addText('Dosen', 'headerBody1', 'header_text2');
		$table->addCell(300, $cellColSpan)->addText(':', 'headerBody1', 'header_text2');
		$table->addCell(3500, $cellRowSpan)->addText($dosen, 'headerBody2','header_text2');
		$table->addCell(500, $cellRowSpan)->addText('');
		$table->addCell(1600, $cellRowSpan)->addText('Waktu', 'headerBody1', 'header_text2');
		$table->addCell(300, $cellColSpan)->addText(':', 'headerBody1', 'header_text2');
		$table->addCell(3790, $cellRowSpan)->addText($waktu_pengerjaan, 'headerBody2','header_text2');
		$table->addRow(300,array('exactHeight'=>true));
		$table->addCell(50, $cellRowSpan)->addText('');
		$table->addCell(1600, $cellRowSpan)->addText('');
		$table->addCell(500, $cellColSpan)->addText('');
		$table->addCell(3500, $cellRowSpan)->addText('');
		$table->addCell(500, $cellRowSpan)->addText('');
		$table->addCell(1600, $cellRowSpan)->addText('Sifat Ujian', 'headerBody1', 'header_text2');
		$table->addCell(300, $cellColSpan)->addText(':', 'headerBody1', 'header_text2');
		$table->addCell(3790, $cellRowSpan)->addText($sifat_ujian, 'headerBody2','header_text2');
		$table->addRow(300,array('exactHeight'=>true));
		$table->addCell(50, $cellRowSpan)->addText('');
		$table->addCell(1600, $cellRowSpan)->addText('Kode Soal', 'headerBody1', 'header_text2');
		$table->addCell(300, $cellColSpan)->addText(':', 'headerBody1', 'header_text2');
		$table->addCell(3500, $cellRowSpan)->addText($kode, 'headerBody2','header_text2');
		$table->addCell(500, $cellRowSpan)->addText('');
		$table->addCell(1600, $cellRowSpan)->addText('Jumlah Soal', 'headerBody1', 'header_text2');
		$table->addCell(300, $cellColSpan)->addText(':', 'headerBody1', 'header_text2');
		$table->addCell(3790, $cellRowSpan)->addText(count($soal).' Soal', 'headerBody2','header_text2');

		$table = $header->addTable('myTable');
		$table->addRow(200,array('exactHeight'=>true));
		$table->addCell(9000)->addImage(
		    base_url().'assets/image/header_soalCloseLine.png',
		    array('width' => 542, 'height' => 5.5, 'align' => 'left')
		);

		
		// $cell = $table->addCell(8500);
		// $textrun = $cell->addTextRun('header_text');
		// $textrun->addText('KEMENTRIAN PENDIDIKAN DAN KEBUDAYAAN',array('size'=>12),'header_text');
		// $textrun = $cell->addTextRun('header_text');
		// $textrun->addText('UNIVERSITAS BRAWIJAYA',array('bold' => true,'size'=>18),'header_text');
		// $textrun = $cell->addTextRun('header_text');
		// $textrun->addText('FAKULTAS ILMU KOMPUTER',array('bold' => true,'size'=>14),'header_text');
		//end header
		$section = $phpWord->addSection(
		    array(
		    	'paperSize' => 'Letter',
				'marginLeft'   => 642.8571428571429,
			    'marginRight'  => 714.2857142857143,
			    'marginTop'    => 1428.571428571429,
			    'marginBottom' => 1428.571428571429,
		        'colsNum'   => 2,
		        'colsSpace' => 500,
		        'breakType' => 'continuous',
		    )
		);
		$phpWord->setDefaultFontSize($ukuran_font);
		$phpWord->setDefaultFontName($jenis_font);
		
		$phpWord->addParagraphStyle('p1', array('align'=>'both', 'spaceAfter'=>0,'spaceBefore' => 0,'space' => array('line' => 240)));
		for ($i=0; $i < count($soal) ; $i++) {
			$cekSoal = array('<strong>','<em>', '<u>', '<s>', '<sup>','<ol>');
			$srcSoal = $soal[$i]["soal"];
			$srcOpsi = $soal[$i]["opsi"];
			$srcSoal = str_replace("<p>","<p>",$srcSoal);
			$srcSoal = str_replace("</p>"," </p> ",$srcSoal);
			$srcSoal = str_replace("<br />","<br> ",$srcSoal);
			$srcSoal = str_replace("&nbsp;"," ",$srcSoal);
			$exSoal = explode(" ",$srcSoal);
			$unserSrcOpsi = unserialize($srcOpsi);
			$listItemRun = $section->addListItemRun(0, $multilevelNumberingStyleName, 'p1');
			$style = array('name' => $jenis_font, 'size'=>$ukuran_font);

			for ($j=0; $j < count($exSoal); $j++) {
				if (strpos($exSoal[$j], '<img') !== FALSE) {
					$img = "";
					for ($j=$j; $j < count($exSoal); $j++) { 
						$img = $img." ".$exSoal[$j];
						if (strpos($exSoal[$j], '/>') !== FALSE) {
							$xpath = new DOMXPath(@DOMDocument::loadHTML($img));
							$src = $xpath->evaluate("string(//img/@src)");
							$src = str_replace("/team_teaching/","",$src);
							$style = $xpath->evaluate("string(//img/@style)");
							$height = $this->get_string_between($style, 'height:', 'px;');
							$width = $this->get_string_between($style, 'width:', 'px;');
							$listItemRun->addTextBreak();
							$listItemRun->addImage(base_url().$src,
								array('width' => $width, 'height' => $height));
							break;
						}
					}
					continue;
				}
				if (strpos($exSoal[$j], '<strong>') !== FALSE){
					$style['bold'] = true;
				}
				if (strpos($exSoal[$j], '<em>') !== FALSE){
					$style['italic'] = true;
				}
				if (strpos($exSoal[$j], '<u>') !== FALSE){
					$style['underline'] = 'single';
				}
				if (strpos($exSoal[$j], '<s>') !== FALSE){
					$style['strikethrough'] = true;
				}
				if (strpos($exSoal[$j], '&ldquo;') !== FALSE || strpos($exSoal[$j], '&rdquo;') !== FALSE) {
					$exSoal[$j] = str_replace("&ldquo;",'"',$exSoal[$j]);
					$exSoal[$j] = str_replace("&rdquo;",'"',$exSoal[$j]);
				}else if (strpos($exSoal[$j], '&#39;') !== FALSE || strpos($exSoal[$j], '&rsquo;') !== FALSE) {
					$exSoal[$j] = str_replace("&#39;","'",$exSoal[$j]);
					$exSoal[$j] = str_replace("&rsquo;","'",$exSoal[$j]);
				}else if (strpos($exSoal[$j], '&quot') !== FALSE) {
					$exSoal[$j] = str_replace("&quot;",'"',$exSoal[$j]);
				}
				//print_r($style);
				//echo strip_tags($exSoal[$j])."<br>";
				$listItemRun->addText(ltrim(htmlspecialchars(strip_tags($exSoal[$j]).' ', ENT_COMPAT, 'UTF-8')), $style);
				

				if (strpos($exSoal[$j], '</strong>') !== FALSE){
					unset($style['bold']);
				}
				if (strpos($exSoal[$j], '</em>') !== FALSE){
					unset($style['italic']);
				}
				if (strpos($exSoal[$j], '</u>') !== FALSE){
					unset($style['underline']);
				}
				if (strpos($exSoal[$j], '</s>') !== FALSE){
					unset($style['strikethrough']);
				}
				if ((strpos($exSoal[$j], '</p>') !== FALSE && $j!=count($exSoal)-2) || strpos($exSoal[$j], '<br>') !== FALSE){
					//echo strip_tags($exSoal[$j])."<br>";
					$listItemRun->addTextBreak();
				}

			}
			for ($j=0; $j < count($unserSrcOpsi); $j++) {
				$unserSrcOpsi[$j] = str_replace("<p>","<p>",$unserSrcOpsi[$j]);
				$unserSrcOpsi[$j] = str_replace("</p>"," </p> ",$unserSrcOpsi[$j]);
				$unserSrcOpsi[$j] = str_replace("<br />","<br> ",$unserSrcOpsi[$j]);
				$unserSrcOpsi[$j] = str_replace("&nbsp;","",$unserSrcOpsi[$j]);
				//echo $unserSrcOpsi[$j];
				$exOpsi = explode(" ",$unserSrcOpsi[$j]);
				$listItemRun = $section->addListItemRun(1, $multilevelNumberingStyleName, 'p1');
				$style = array('name' => $jenis_font, 'size'=>$ukuran_font);
				for ($k=0; $k < count($exOpsi); $k++) { 
					//echo "-".$exOpsi[$k]."|";
					if (strpos($exOpsi[$k], '<img') !== FALSE) {
						$img = "";
						for ($k=$k; $k < count($exSoal); $k++) { 
							$img = $img." ".$exOpsi[$k];
							if (strpos($exOpsi[$k], '/>') !== FALSE) {
								$xpath = new DOMXPath(@DOMDocument::loadHTML($img));
								$src = $xpath->evaluate("string(//img/@src)");
								$src = str_replace("/team_teaching/","",$src);
								$style = $xpath->evaluate("string(//img/@style)");
								$height = $this->get_string_between($style, 'height:', 'px;');
								$width = $this->get_string_between($style, 'width:', 'px;');
								$listItemRun->addTextBreak();
								$listItemRun->addImage(base_url().$src,
									array('width' => $width, 'height' => $height));
								break;
							}
						}
						continue;
					}
					if (strpos($exOpsi[$k], '<strong>') !== FALSE){
						$style['bold'] = true;
					}
					if (strpos($exOpsi[$k], '<em>') !== FALSE){
						$style['italic'] = true;
					}
					if (strpos($exOpsi[$k], '<u>') !== FALSE){
						$style['underline'] = 'single';
					}
					if (strpos($exOpsi[$k], '<s>') !== FALSE){
						$style['strikethrough'] = true;
					}
					if (strpos($exOpsi[$k], '&ldquo;') !== FALSE || strpos($exOpsi[$k], '&rdquo;') !== FALSE) {
						$exOpsi[$k] = str_replace("&ldquo;",'"',$exOpsi[$k]);
						$exOpsi[$k] = str_replace("&rdquo;",'"',$exOpsi[$k]);
					}else if (strpos($exOpsi[$k], '&#39;') !== FALSE) {
						$exOpsi[$k] = str_replace("&#39;","'",$exOpsi[$k]);
					}else if (strpos($exOpsi[$k], '&quot') !== FALSE) {
						$exOpsi[$k] = str_replace("&quot;",'"',$exOpsi[$k]);
					}
					//echo htmlspecialchars(strip_tags($exOpsi[$k]).' ', ENT_COMPAT, 'UTF-8').'<br>';
					$listItemRun->addText(ltrim(htmlspecialchars(strip_tags($exOpsi[$k]).' ', ENT_COMPAT, 'UTF-8')), $style);
					if (strpos($exOpsi[$k], '</strong>') !== FALSE){
						unset($style['bold']);
					}
					if (strpos($exOpsi[$k], '</em>') !== FALSE){
						unset($style['italic']);
					}
					if (strpos($exOpsi[$k], '</u>') !== FALSE){
						unset($style['underline']);
					}
					if (strpos($exOpsi[$k], '</s>') !== FALSE){
						unset($style['strikethrough']);
					}
					if ((strpos($exOpsi[$k], '</p>') !== FALSE && $k!=count($exOpsi)-2) || strpos($exOpsi[$k], '<br>') !== FALSE){
						//echo "<break>";
						$listItemRun->addTextBreak();
					}
				}
			}
		}

		// Saving the document as OOXML file...
		$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
		$objWriter->save('assets/cetak_soal/'.$id_cetak.'-'.$nama_matkul.'-'.date("d.m.Y").'-'.$kode.'.docx');
	}
	function get_string_between($string, $start, $end){
	    $string = ' ' . $string;
	    $ini = strpos($string, $start);
	    if ($ini == 0) return '';
	    $ini += strlen($start);
	    $len = strpos($string, $end, $ini) - $ini;
	    return substr($string, $ini, $len);
	}
}
