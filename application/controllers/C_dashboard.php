<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_dashboard extends CI_Controller {

	function __construct(){
		parent::__construct();		
		$this->load->model('m_kjfd');
		$this->load->model('m_matkul');
        $this->load->model('m_penugasan');
        $this->load->model('m_dosen');
        $this->load->model('m_team_teaching');
        $this->load->model('m_soal');
        $this->load->model('m_materi');
		date_default_timezone_set("Asia/Jakarta");
	}
	public function tes(){
		echo "tes";
		return "ok";
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
	public function dashboard() {
		$this->is_login();
		$comp = array(
			"title" => "Dashboard",
			"sidebar" => $this->sidebar(),
			"header" => $this->header(),
			"content" => $this ->view_dashboard(),
		);
		$this->load->view('v_template',$comp);
	}
	public function view_dashboard() {
		$role = unserialize($this->session->userdata('role'));
        if (($key = array_search(1, $role)) !== false){
			$data['kjfd'] = $this->m_kjfd->count_kjfd();
			$data['dosen'] = $this->m_dosen->count_dosen();
			$data['mk'] = $this->m_matkul->count_matkul();
		}if (($key = array_search(2, $role)) !== false){
			$where = array('id_dosen'=>$this->session->userdata('id'));
			$kjfd = $this->m_kjfd->get_kjfd($where);
			$where = array('id_kjfd'=>$kjfd->id_kjfd);
			$data['team_teaching'] = $this->m_matkul->count_matkul_where($where);
		}if (($key = array_search(3, $role)) !== false){
			$where = array('id_dosen'=>$this->session->userdata('id'));
			$team_teaching = $this->m_team_teaching->get_daftar_team_teachingXmata_kuliah($where,'nama_matkul');
			$materi = array();
			$countSoal = array();
			for ($i=0; $i <count($team_teaching) ; $i++) { 
				$where = array('materi.id_tt'=>$team_teaching[$i]['id_tt']);
				$materi[$i] = $this->m_materi->get_rows_materi($where,'nama_materi');
				$countSoal[$i] = array();
				for ($j=0; $j < count($materi[$i]); $j++) { 
					$where = array('soal.id_materi'=>$materi[$i][$j]['id_materi'],'status_penugasan'=>1);
					$soal = $this->m_soal->get_daftar_soal($where,'id_soal');
					$countSoal[$i][$j] = count($soal);
				}
			}
			$data['tt'] = $team_teaching;
			$data['materi'] = $materi;
			$data['countSoal'] = $countSoal;
		}if (($key = array_search(4, $role)) !== false){
			$tt = $this->m_team_teaching->get_data_partOfTeam("anggota_tt",'"'.$this->session->userdata('id').'"',array());
			$penugasan = $this->m_penugasan->get_daftar_penugasan(array(),"batas_penugasan");
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
		}
		return $this->load->view("v_dashboard",$data,true);
	}
}
