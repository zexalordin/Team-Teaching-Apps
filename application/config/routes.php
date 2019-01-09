<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'C_dosen';
$route['dashboard'] = 'C_dashboard/dashboard';

$route['daftar-dosen'] = 'C_dosen/daftar_dosen';
$route["edit-dosen/(.*)"] = 'C_dosen/edit_dosen/$1';
$route["aktifkan/(.*)"] = 'C_dosen/aktivasi/$1';
$route["proses-edit-dosen/(.*)"] = 'C_dosen/proses_edit_dosen/$1';

$route['kjfd'] = 'C_kjfd/daftar_kjfd';
$route['tambah-kjfd'] = 'C_kjfd/tambah_kjfd';
$route["edit-kjfd/(.*)"] = 'C_kjfd/edit_kjfd/$1';
$route['proses-tambah-kjfd'] = 'C_kjfd/proses_tambah_kjfd';

$route['mata-kuliah'] = 'C_matkul/daftar_matkul';
$route['tambah-matkul'] = 'C_matkul/tambah_matkul';
$route["edit-matkul/(.*)"] = 'C_matkul/edit_matkul/$1';
$route['proses-tambah-matkul'] = 'C_matkul/proses_tambah_matkul';
$route["proses-edit-matkul/(.*)"] = 'C_matkul/proses_edit_matkul/$1';

$route['team-teaching'] = 'C_team_teaching/team_teaching';
$route["edit-team-teaching/(.*)"] = 'C_team_teaching/edit_team_teaching/$1';
$route["proses-edit-team-teaching/(.*)"] = 'C_team_teaching/proses_edit_team_teaching/$1';

$route['proses-tambah-penugasan'] = 'C_penugasan/proses_tambah_penugasan';
$route['proses-buat-soal'] = 'C_penugasan/proses_buat_soal';
$route['proses-edit-soal'] = 'C_penugasan/proses_edit_soal';

$route['atur-materi'] = 'C_materi/atur_materi';
$route['tambah-materi'] = 'C_materi/tambah_materi';
$route['proses-tambah-materi'] = 'C_materi/proses_tambah_materi';
$route['edit-materi/(.*)'] = 'C_materi/edit_materi/$1';
$route['proses-edit-materi/(.*)'] = 'C_materi/proses_edit_materi/$1';

$route['riwayat-cetak-soal'] = 'C_penugasan/riwayat_cetak_soal';
$route['cetak-soal'] = 'C_penugasan/cetak_soal';
$route['pilih-cetak-soal/(.*)'] = 'C_penugasan/pilih_cetak_soal/$1';
$route['review-soal'] = 'C_penugasan/review_soal';
$route['proses-cetak-soal'] = 'C_penugasan/proses_cetak_soal';
$route['proses-pilih-cetak-soal'] = 'C_penugasan/proses_pilih_cetak_soal';

$route['atur-penugasan'] = 'C_penugasan/atur_penugasan';
$route['edit-penugasan/(.*)'] = 'C_penugasan/edit_penugasan/$1';
$route['proses-edit-penugasan/(.*)'] = 'C_penugasan/proses_edit_penugasan/$1';
$route['tambah-penugasan'] = 'C_penugasan/tambah_penugasan';
$route['kirim-reminder/(.*)'] = 'C_penugasan/proses_kirim_reminder/$1';
$route['percepat-evaluasi/(.*)'] = 'C_penugasan/proses_percepat_evaluasi/$1';
$route['tutup-evaluasi/(.*)'] = 'C_penugasan/proses_tutup_evaluasi/$1';
$route['edit-soal-evaluasi/(.*)'] = 'C_penugasan/evaluasi_penugasan_ketua/$1';
$route['progres-penugasan/(.*)'] = 'C_penugasan/progres_penugasan/$1';
$route['evaluasi-bank-soal/(.*)'] = 'C_penugasan/evaluasi_bank_soal/$1';

$route['hapus-komentar/(.*)/(.*)'] = 'C_penugasan/proses_hapus_komentar/$1/$2';

//dosen
$route['penugasan'] = 'C_penugasan/penugasan';
$route['detail-penugasan/(.*)'] = 'C_penugasan/detail_penugasan/$1';
$route['buat-soal/(.*)/(.*)'] = 'C_penugasan/buat_soal/$1/$2';
$route['edit-soal/(.*)/(.*)'] = 'C_penugasan/edit_soal/$1/$2';
$route['submit-materi/(.*)/(.*)'] = 'C_penugasan/proses_submit_materi/$1/$2';
$route['evaluasi-penugasan/(.*)'] = 'C_penugasan/evaluasi_penugasan/$1';


$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;
