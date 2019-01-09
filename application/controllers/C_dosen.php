<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_dosen extends CI_Controller {

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
    public function index(){
		if($this->session->userdata('status')){
			redirect(base_url('dashboard'));
		}
		$this->load->view('v_login');
	}
	public function register(){
		$nama= $_POST['nama'];
		$nip= $_POST['nip'];
		$email= $_POST['email'];
		$username= $_POST['username'];
		$password= $_POST['password'];
		$role = array(0);
		$ser_role = serialize($role);
		$where = array(
			'username' => $username,
			);
		$cek_username = $this->m_dosen->cek_dosen($where)->num_rows();
		$where = array(
			'email_dosen' => $email,
			);
		$cek_email = $this->m_dosen->cek_dosen($where)->num_rows();
		if ($cek_username==0 && $cek_email==0) {
			$data_insert = array(
				'nama_dosen' => $nama,
				'nip_dosen' => $nip,
				'email_dosen' => $email,
				'username' => $username,
				'password' => md5($password),
				'role' => $ser_role,
			);
			$res = $this->m_dosen->register($data_insert);
			if($res>=1){
				$this->session->set_flashdata('register_msg', 'success');
			}else{
				$this->session->set_flashdata('register_msg', 'failed');
			}
		}else{
			if($cek_email>0) {
				$this->session->set_flashdata('register_msg', 'email_dipakai');
			}elseif ($cek_username>0) {
				$this->session->set_flashdata('register_msg', 'username_dipakai');
			}
		}
		
		redirect(base_url());
	}
	function validasi() { 
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$where = array(
			'username' => $username,
			'password' => md5($password)
			);
		$cek = $this->m_dosen->cek_dosen($where,'username')->num_rows();
		if($cek > 0){
			$data_dosen = $this->m_dosen->get_dosen($where);
			$role = unserialize($data_dosen->role);
			if (($key = array_search(0, $role)) !== false) {
				$this->session->set_flashdata('login_msg', 'tidakaktif');
				redirect(base_url());
			}else{
				$data_session = array(
					'username' => $username,
					'status' => true,
					'id' => $data_dosen->id_dosen,
					'nama' => $data_dosen->nama_dosen,
					'role' => $data_dosen->role
				);
				$this->session->set_userdata($data_session);
				redirect(base_url()."dashboard");
			}
		}else{
			$this->session->set_flashdata('login_msg', 'tidakterdaftar');
			redirect(base_url());
		}
	}
	public function logout(){
		$this->session->sess_destroy();
		redirect(base_url());
	}
	public function proses_aktivasi($id){
		$mayor = $_POST['mayor'];
		$minor = $_POST['minor'];
		$ser_minor = serialize($minor);
		$role = array(4);
		$ser_role = serialize($role);
		$data_update = array(
			'role' => $ser_role,
			'keminatan_mayor' => $mayor,
			'keminatan_minor' => $ser_minor
		);
		$where = array('id_dosen'=>$id);
		$res = $this->m_dosen->aktivasi($data_update,$where);
		if($res>=1){
			$this->session->set_flashdata('aktif_msg', 'success');
		}else{
			$this->session->set_flashdata('aktif_msg', 'failed');
		}
		redirect(base_url('daftar-dosen'));
	}
	public function proses_edit_dosen($id_dosen){
		$mayor = $_POST['mayor'];
		$minor = $_POST['minor'];
		$ser_minor = serialize($minor);

		$where = array(
			'username' => $_POST['username'],
			'id_dosen!=' => $id_dosen,
		);
		$cek_username = $this->m_dosen->cek_dosen($where)->num_rows();
		$where = array(
			'email_dosen' => $_POST['email'],
			'id_dosen!=' => $id_dosen,
		);
		$cek_email = $this->m_dosen->cek_dosen($where)->num_rows();
		if ($cek_email==1) {
			$this->session->set_flashdata('edit_msg', 'email_dipakai');
		}elseif ($cek_username==1) {
			$this->session->set_flashdata('edit_msg', 'username_dipakai');
		}else {
			$data_update = array(
				'nama_dosen' => $_POST['nama'],
				'nip_dosen' => $_POST['nip'],
				'email_dosen' => $_POST['email'],
				'username' => $_POST['username'],
				'keminatan_mayor' => $mayor,
				'keminatan_minor' => $ser_minor
			);
			$where = array('id_dosen'=>$id_dosen);
			$res = $this->m_dosen->update_dosen($data_update,$where);
			if($res>=1){
				$this->session->set_flashdata('edit_msg', 'success');
			}else{
				$this->session->set_flashdata('edit_msg', 'failed');
			}
		}
		
		redirect(base_url()."edit-dosen/".$id_dosen);
	}
	public function proses_hapus_dosen($id_dosen){
		$where = array('id_dosen'=>$id_dosen);
		$res= $this->m_dosen->delete_dosen($where);
		if($res>=1){
			$this->session->set_flashdata('delete_msg', 'success');
		}else{
			$this->session->set_flashdata('delete_msg', 'failed');
		}
		redirect(base_url('daftar-dosen'));
	}

	public function daftar_dosen() {
		$this->is_login();
		$this->is_kajur();
		$comp = array(
			"title" => "Daftar dosen",
			"sidebar" => $this->sidebar(),
			"header" => $this->header(),
			"content" => $this ->view_daftar_dosen(),
		);
		$this->load->view('v_template',$comp);
	}
	public function view_daftar_dosen() {
		$data['dosen'] = $this->m_dosen->get_daftar_dosen(array(),"nama_dosen");
		return $this->load->view("v_daftar_dosen",$data,true);
	}
	public function edit_dosen($id_dosen) {
		$this->is_login();
		$this->is_kajur();
		$comp = array(
			"title" => "Edit dosen",
			"sidebar" => $this->sidebar(),
			"header" => $this->header(),
			"content" => $this ->view_edit_dosen($id_dosen),
		);
		$this->load->view('v_template',$comp);
	}
	public function view_edit_dosen($id_dosen){
		$table = "dosen";
		$where = array('id_dosen'=>$id_dosen);
        $data['dosen'] = $this->m_dosen->get_dosen($where);
        $data['kjfd'] = $this->m_kjfd->get_daftar_kjfd(array(),'nama_kjfd');
		return $this->load->view('v_edit_dosen',$data,true);
	}
	public function aktivasi($id_dosen) {
		$this->is_login();
		$this->is_kajur();
		$comp = array(
			"title" => "Aktivasi dosen",
			"sidebar" => $this->sidebar(),
			"header" => $this->header(),
			"content" => $this ->view_aktivasi($id_dosen),
		);
		$this->load->view('v_template',$comp);
	}
	public function view_aktivasi($id_dosen){
		$where = array('id_dosen'=>$id_dosen);
        $data['dosen'] = $this->m_dosen->get_dosen($where);
        $data['kjfd'] = $this->m_kjfd->get_daftar_kjfd(array(),'nama_kjfd');
		return $this->load->view('v_aktivasi',$data,true);
	}

}
