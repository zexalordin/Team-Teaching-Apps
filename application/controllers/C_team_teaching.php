<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_team_teaching extends CI_Controller {

	function __construct(){
		parent::__construct();		
        $this->load->model('m_dosen');
        $this->load->model('m_team_teaching');
        $this->load->model('m_soal');
        $this->load->model('m_penugasan');
        $this->load->model('m_materi');
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
    public function team_teaching() {
		$this->is_login();
		$comp = array(
			"title" => "Team Teaching",
			"sidebar" => $this->sidebar(),
			"header" => $this->header(),
			"content" => $this ->view_team_teaching(),
		);
		$this->load->view('v_template',$comp);
	}
	public function view_team_teaching() {
		$data['team_teaching'] = $this->m_team_teaching->get_data_team_teaching($this->session->userdata('id'));
		$data['dosen'] = $this->m_dosen->get_daftar_dosen(array(),"id_dosen");
		return $this->load->view("v_team_teaching",$data,true);
	}
	public function edit_team_teaching($id) {
		$this->is_login();
		$comp = array(
			"title" => "Edit Team Teaching",
			"sidebar" => $this->sidebar(),
			"header" => $this->header(),
			"content" => $this ->view_edit_team_teaching($id),
		);
		$this->load->view('v_template',$comp);
	}
	public function view_edit_team_teaching($id){
		$data['team_teaching'] = $this->m_team_teaching->get_row_team_teaching($id);
        $data['dosen'] = $this->m_dosen->get_daftar_dosen(array(),"nama_dosen");
		return $this->load->view('v_edit_team_teaching',$data,true);
    }
    //proses
    public function proses_edit_team_teaching($id){
		$team_teaching = $this->m_team_teaching->get_team_teaching(array('id_tt'=>$id));
		$ketua_tt = $_POST['ketua_tt'];
		$tt = $_POST['team_teaching'];
		$ser_tt = serialize($tt);
		print_r($tt);
		$data_update = array(
			'id_dosen' => $ketua_tt,
			'anggota_tt' => $ser_tt
		);
		$where = array('id_tt'=>$id);
		$res = $this->m_team_teaching->update_team_teaching($data_update,$where);

		
		if($res>=1){

			//update role
			if ($team_teaching->id_dosen != $ketua_tt) {
				$dosen = $this->m_dosen->get_dosen(array('id_dosen'=>$team_teaching->id_dosen));
				$daftar_tt = $this->m_team_teaching->get_daftar_team_teaching(array('id_dosen'=>$team_teaching->id_dosen),'id_tt');
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
					$this->m_dosen->update_dosen($data_update,array('id_dosen'=>$team_teaching->id_dosen));
				}


				$dosen = $this->m_dosen->get_dosen(array('id_dosen'=>$ketua_tt));
				$role = unserialize($dosen->role);
				if (!in_array(3, $role)){
					array_push($role,3);
					$ser_role = serialize($role);
					$data_update = array(
						'role' => $ser_role,
					);
					$where = array('id_dosen'=>$ketua_tt);
					$this->m_dosen->update_dosen($data_update,$where);
				}
			}
			//end update role
			$where = array('id_dosen'=>$this->session->userdata('id'));
			$data_dosen = $this->m_dosen->get_dosen($where);
			$data_session = array(
				'username' => $username,
				'status' => true,
				'id' => $data_dosen->id_dosen,
				'nama' => $data_dosen->nama_dosen,
				'role' => $data_dosen->role
			);
			$this->session->set_userdata($data_session);
			$this->session->set_flashdata('edit_msg', 'success');
		}else{
			$this->session->set_flashdata('edit_msg', 'failed');
		}
		redirect(base_url()."edit-team-teaching/".$id);
	}
}
