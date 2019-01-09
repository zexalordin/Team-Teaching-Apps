<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unit_testing extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library("unit_test");
	}

	public function proses_gabung_penugasan($id,$index){
		//$penugasan = $this->m_penugasan->get_penugasan(array("id_penugasan"=>$id));
		//input kosong = a:1:{i:0;a:2:{i:0;i:0;i:1;i:0;}}
		//input penuh = a:1:{i:0;a:2:{i:0;s:1:"1";i:1;s:2:"11";}}
		//input sudah masuk = a:1:{i:0;a:2:{i:0;i:10;i:1;i:11;}
		$set_model_penugasan = 'a:1:{i:0;a:2:{i:0;i:0;i:1;i:0;}}';
		$id_ambil_penugasan = unserialize($set_model_penugasan);
		$id_dosen = 10;
		if (!in_array($id_dosen, $id_ambil_penugasan[$index])) {
			$key = array_search(0, $id_ambil_penugasan[$index]);
			if ($key !== false) {
				$id_ambil_penugasan[$index][$key] = $id_dosen;
				$ser_id_ambil = serialize($id_ambil_penugasan);

				$data_update = array(
					'id_ambil_penugasan' => $ser_id_ambil,
				);
				$where = array('id_penugasan'=>$id);
				//$res = $this->m_penugasan->update_penugasan($data_update,$where);
				return "success";
			}else{
				return "failed";
			}
		}else{
			return "already";
		}
	}

	public function proses_kirim_reminder($id_penugasan){
		// $where = array('id_penugasan'=>$id_penugasan);
		// $penugasan = $this->m_penugasan->get_row_penugasan($where);
		// $dosen = unserialize($set_id_ambil_penugasan);
		//$materi = unserialize($penugasan->materi_penugasan);
		//$soal = unserialize($penugasan->tingkat_kesulitan);

		$dosen_penugasan = Array (10, 11);
		$dosen_penugasan = Array();
		//$notifikasi = Array ("notifikasi 1", "notifikasi 2");
		//$notifikasi = Array ("notifikasi 1");
		
		$count_email = 0;
		for ($i=0; $i < count($dosen_penugasan); $i++) {
			if (isset($notifikasi[$i])) {
				//$where = array('id_dosen'=>$dosen_penugasan[$i]);
				///$data_dosen_penugasan = $this->m_dosen->get_dosen($where);
				//$this->email_send($data_dosen_penugasan->email_dosen,$notifikasi[$i]);
				$count_email++;
			}
		}
		return $count_email;
		// $this->session->set_flashdata('kirim_msg', "success");
		// $this->session->set_flashdata('hitung_msg', $count_email);
		// redirect(base_url()."progres-penugasan/".$id_penugasan);
	}

	public function proses_buat_soal(){
		$soal = Array("soal 1", "soal 2");
		//$soal = Array();
		$pgBenar = Array (0, 0);
		$pgA = Array ("opsi soal 1 A", "opsi soal 2 A");
		$pgB = Array ("opsi soal 1 B", "opsi soal 2 B");
		$pgC = Array ("opsi soal 1 C", "opsi soal 2 C");
		$pgD = Array ("opsi soal 1 D", "opsi soal 2 D");
		$estimasi_waktu = Array (60, 60);
		$tingkat_kesulitan = Array (0, 1 ) ;
		$id_penugasan = 35;
		$id_materi = 12;

		$count_loop = 0;
		for ($i=0; $i < count($soal) ; $i++) {
			$count_loop++;
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
			//$res = $this->m_soal->input_soal($data_insert);
			//$this->session->set_flashdata('input_msg', 'success');
		}
		return $count_loop;
		//redirect(base_url('detail-penugasan/'.$id_penugasan));
	}

	public function index(){
		$test = $this->proses_gabung_penugasan(34,0);
		$expected_result = "success";
		$testname = "Test proses_gabung_penugasan";
		echo $this->unit->run($test, $expected_result, $testname);
		echo "<br>";

		$test = $this->proses_kirim_reminder(35);
		$expected_result = 0;
		$testname = "Test proses_kirim_reminder";
		echo $this->unit->run($test, $expected_result, $testname);
		echo "<br>";

		$test = $this->proses_buat_soal();
		$expected_result = 2;
		$testname = "Test proses_buat_soal";
		echo $this->unit->run($test, $expected_result, $testname);
	}

}