<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_kjfd extends CI_Controller {

	function __construct(){
		parent::__construct();		
        $this->load->model('m_dosen');
        $this->load->model('m_kjfd');
        $this->load->model('m_soal');
        $this->load->model('m_penugasan');
        $this->load->model('m_materi');
        $this->load->model('m_team_teaching');
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
    public function daftar_kjfd() {
		$this->is_login();
		$this->is_kajur();
		$comp = array(
			"title" => "Daftar KJFD",
			"sidebar" => $this->sidebar(),
			"header" => $this->header(),
			"content" => $this ->view_daftar_kjfd(),
		);
		$this->load->view('v_template',$comp);
	}
	public function view_daftar_kjfd() {
		$where = array();
		$data['kjfd'] = $this->m_kjfd->get_daftar_kjfdxdosen($where);
		return $this->load->view("v_daftar_kjfd",$data,true);
	}
	public function tambah_kjfd() {
		$this->is_login();
		$this->is_kajur();
		$comp = array(
			"title" => "Tambah KJFD",
			"sidebar" => $this->sidebar(),
			"header" => $this->header(),
			"content" => $this ->view_tambah_kjfd(),
		);
		$this->load->view('v_template',$comp);
	}
	public function view_tambah_kjfd() {
		$data['dosen'] = $this->m_dosen->get_daftar_dosen(array(),"nama_dosen");
		return $this->load->view("v_tambah_kjfd",$data,true);
	}
	public function edit_kjfd($id) {
		$this->is_login();
		$this->is_kajur();
		$comp = array(
			"title" => "Edit KJFD",
			"sidebar" => $this->sidebar(),
			"header" => $this->header(),
			"content" => $this ->view_edit_kjfd($id),
		);
		$this->load->view('v_template',$comp);
	}
	public function view_edit_kjfd($id){
		$where = array('id_kjfd'=>$id);
        $data['kjfd'] = $this->m_kjfd->get_kjfd($where);
        $data['dosen'] = $this->m_dosen->get_daftar_dosen(array(),"nama_dosen");
		return $this->load->view('v_edit_kjfd',$data,true);
    }
    
    //proses
    public function proses_tambah_kjfd(){
		$nama= $_POST['nama_kjfd'];
		$where = array('nama_kjfd'=>$nama);
		if ($this->m_kjfd->count_kjfd_where($where) > 0) {
			$this->session->set_flashdata('input_msg', 'nama_dipakai');
		}else{
			$id_dosen = $_POST['dosen'];
			$data_insert = array(
				'nama_kjfd' => $nama,
				'id_dosen' => $id_dosen,
			);
			$res = $this->m_kjfd->input_kjfd($data_insert);

	        //update role
	        $where = array('id_dosen'=>$id_dosen);
	        $dosen = $this->m_dosen->get_dosen($where);
			$role = unserialize($dosen->role);
			array_push($role,2);
			$ser_role = serialize($role);
			$data_update = array(
				'role' => $ser_role,
			);
			$where = array('id_dosen'=>$id_dosen);
			$this->m_dosen->update_dosen($data_update,$where);
			//end update role
			if($res>=1){
				$this->session->set_flashdata('input_msg', 'success');
			}else{
				$this->session->set_flashdata('input_msg', 'failed');
			}
		}
		redirect(base_url('kjfd'));
	}
	public function proses_edit_kjfd($id,$id_dosen1){
		$nama= $_POST['nama_kjfd'];
		$id_dosen = $_POST['dosen'];
		$where = array(
			'nama_kjfd'=>$nama,
			'id_kjfd!='=>$id
		);
		if ($this->m_kjfd->count_kjfd_where($where) > 0) {
			$this->session->set_flashdata('edit_msg', 'nama_dipakai');
		}else{
			//update kjfd
			$data_update = array(
				'nama_kjfd' => $nama,
				'id_dosen' => $id_dosen,
			);
			$where = array('id_kjfd'=>$id);
			$res = $this->m_kjfd->update_kjfd($data_update,$where);
			//end
			if($id_dosen1 != $id_dosen){
			//update role
				$dosen = $this->m_dosen->get_dosen(array('id_dosen'=>$id_dosen1));
				$role = unserialize($dosen->role);
				if (($key = array_search(2, $role)) !== false) {
				    unset($role[$key]);
				}
				$ser_role = serialize($role);
				$data_update = array(
					'role' => $ser_role,
				);
				$where = array('id_dosen'=>$id_dosen1);
				$this->m_dosen->update_dosen($data_update,$where);
				//koordinator kjfd baru
				$dosen = $this->m_dosen->get_dosen(array('id_dosen'=>$id_dosen));
				$role = unserialize($dosen->role);
				array_push($role,2);
				$ser_role = serialize($role);
				$data_update = array(
					'role' => $ser_role,
				);
				$where = array('id_dosen'=>$id_dosen);
				$this->m_dosen->update_dosen($data_update,$where);
			//end update role
			}
			if($res>=1){
				$this->session->set_flashdata('edit_msg', 'success');
			}else{
				$this->session->set_flashdata('edit_msg', 'failed');
			}
		}
		redirect(base_url()."edit-kjfd/".$id);
	}
	public function proses_hapus_kjfd($id,$id_dosen){
		$where = array('id_kjfd'=>$id);
		$res= $this->m_kjfd->delete_kjfd($where);
		if($res>=1){
			//update role dari kjfd sebelumnya menjadi dosen
			$dosen = $this->m_dosen->get_dosen(array('id_dosen'=>$id_dosen));
			$role = unserialize($dosen->role);
			if (($key = array_search(2, $role)) !== false) {
			    unset($role[$key]);
			}
			$ser_role = serialize($role);
			$data_update = array(
				'role' => $ser_role,
			);
			$where = array('id_dosen'=>$id_dosen);
			$this->m_dosen->update_dosen($data_update,$where);
			//end
			$this->session->set_flashdata('delete_msg', 'success');
		}else{
			$this->session->set_flashdata('delete_msg', 'failed');
		}
		redirect(base_url('kjfd'));
	}
	
}
