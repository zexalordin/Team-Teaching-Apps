<style type="text/css">
    pre {
      margin: 20px 0;
      padding: 20px;
      background: #fafafa;
    }

    .round { border-radius: 50%; }
    table .collapse.in {
        display:table-row;
    }
</style>
<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-muted">PENUGASAN <?php echo $penugasan->nama_penugasan; ?></h3> 
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <?php 
                if($this->session->flashdata('kirim_msg')=="success"){
                    if ($this->session->flashdata('hitung_msg') == 0) {
                        echo '<div class="alert alert-danger" role="alert">Tidak ada email yang dikirim</div>';
                    }else{
                        echo '<div class="alert alert-success" role="alert">Sukses mengirim '.$this->session->flashdata('hitung_msg').' email</div>';
                    }
                }
                if ($this->session->flashdata('percepat_msg') == "success") {
                    echo '<div class="alert alert-success" role="alert">Sukses mempercepat evaluasi</div>';
                }elseif($this->session->flashdata('percepat_msg') == "failed"){
                    echo '<div class="alert alert-danger" role="alert">Evaluasi sedang berlangsung</div>';
                }
                ?>
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row">
                    <div class="col-lg-12 main-chart">
                        <div class="border-head" style="margin-bottom: 25px;text-align: right;">
                        <?php 
                            $cek_status_materi_diambil = true;
                            for ($i=0; $i < count($status_materi_diambil); $i++) { 
                                for ($j=0; $j < count($status_materi_diambil[$i]); $j++) { 
                                    //echo $status_materi_diambil[$i][$j].'-';
                                    if ($status_materi_diambil[$i][$j] === 0){
                                        $cek_status_materi_diambil = false;
                                        break;
                                    }
                                }
                                if (!$cek_status_materi_diambil) {
                                    break;
                                }
                            }
                            date_default_timezone_set("Asia/Jakarta");
                            $now = new DateTime();
                            $today = new DateTime($now->format('Y-m-d'));
                            $otherDate = new DateTime($penugasan->batas_penugasan);
                            $interval = date_diff($today, $otherDate);
                            if($interval->format('%R%a')>0){ 
                                if ($cek_status_materi_diambil) {
                                    echo '<button onclick="return percepat_evaluasi('.$penugasan->id_penugasan.')" type="button" class="btn btn-theme" style="background-color: #e98227;color: white;margin-left: 15px;"><i class="fa fa-eraser"></i> Evaluasi sekarang</button>';
                                }else{
                                    echo '<button onclick="return kirim_reminder('.$penugasan->id_penugasan.')" type="button" class="btn btn-theme" style="background-color: #e98227;color: white;margin-left: 15px;"><i class="fa fa-eraser"></i> Kirim reminder</button>';
                                }
                            }
                        ?>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-title">
                                    <h4>Penugasan</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nama Dosen</th>
                                                    <th>Ambil Materi</th>
                                                    <th style="text-align: left;">Soal Dikerjakan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php for ($i=0; $i < count($nama_anggota_tt); $i++) { ?>
                                                <tr class="clickable" data-toggle="collapse" data-target=".row<?php echo $i ?>">
                                                    <td><i class="glyphicon glyphicon-plus"></i></td>
                                                    <td><?php echo $nama_anggota_tt[$i]->nama_dosen ?></td>
                                                    <td>
                                                        <?php 
                                                            $count_materi_diambil = 0;
                                                            for ($j=0; $j < count($materi_diambil[$i]); $j++) { 
                                                                if ($materi_diambil[$i][$j] != null) {
                                                                    $count_materi_diambil++;
                                                                }
                                                            }
                                                            echo $count_materi_diambil;
                                                        ?>
                                                    </td>
                                                    <?php
                                                    if (count($materi_diambil[$i])>0) {
                                                        $hitung_soal_dibuat = array_sum($soal_dibuat[$i]);
                                                        $hitung_soal_dibutuhkan = array_sum($kebutuhan_soal_anggota[$i]);
                                                        echo "<td>".$hitung_soal_dibuat."/".$hitung_soal_dibutuhkan."</td>";
                                                    }else{
                                                        echo "<td>-</td>";
                                                    }
                                                    ?>
                                                </tr>
                                                <tr class="collapse row<?php echo $i ?>" style="font-weight: 700;">
                                                    <td>-</td>
                                                    <td>Nama Materi</td>
                                                    <td>Soal Dikerjakan</td>  
                                                    <td>Status Pengerjaaan</td>
                                                </tr>
                                                <?php for ($j=0; $j <count($materi_diambil[$i]) ; $j++) { 
                                                    if ($materi_diambil[$i][$j]!=null) {?>
                                                        <tr class="collapse row<?php echo $i ?>">
                                                            <td>-</td>
                                                            <td><?php echo $materi_diambil[$i][$j]->nama_materi; ?></td>
                                                            <td><?php echo $soal_dibuat[$i][$j]."/".$kebutuhan_soal[$j]; ?></td> 
                                                            <td>
                                                                <?php 
                                                                    if ($status_materi_diambil[$i][$j] == 0) {
                                                                        echo "Proses Pengerjaan";
                                                                    }else{
                                                                        echo "Selesai";
                                                                    }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- /# card -->
                        </div>
                    </div>  
                </div>
                <!-- End PAge Content -->
            </div>
            <!-- End Container fluid  -->
            <!-- footer -->
            <footer class="footer"> © 2018 All rights reserved. Template designed by Colorlib</footer>
            <!-- End footer -->
        </div>
        <!-- End Page wrapper  -->
        <script type="text/javascript">
            function percepat_evaluasi(id) {
                var url="<?php echo base_url().'percepat-evaluasi/'?>";
                var r=confirm("Apakah anda yakin ingin mempercepat evaluasi penugasan ini?");
                
                if (r==true){
                    window.location.href = url+id;
                }
                return false;
            }
            function kirim_reminder(id) {
                var url="<?php echo base_url().'kirim-reminder/'?>";
                var r=confirm("Apakah anda yakin akan mengirim reminder kepada anggota penugasan?");
                
                if (r==true){
                    window.location.href = url+id;
                }
                return false;
            }
        </script>