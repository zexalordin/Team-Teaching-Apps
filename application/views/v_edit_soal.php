<link href="<?=base_url('assets/css/')?>buat-soal.css" rel="stylesheet">
<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-12 align-self-center">
                    <?php 
                        $materi = unserialize($penugasan->materi_penugasan);
                    ?>
                    <h3 class="color-white">EDIT SOAL - <?php echo strtoupper($penugasan->nama_matkul) ?> - <?php echo strtoupper($materi_penugasan->nama_materi) ?></h3> 
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <?php 
                    if($this->session->flashdata('input_msg')=="terpakai"){
                        echo '<div class="alert alert-warning" role="alert">Maaf kode mata kuliah telah digunakan.</div>';
                    }
                ?>
                <!-- Start Page Content -->
                <div class="row">
                    <div class="col-xs-0 col-sm-2 col-lg-2"></div>
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="horizontal-form">
                                    <form class="form-horizontal" action="<?php echo base_url('proses-edit-soal') ?>" method="post" onsubmit="return confirm('Apakah anda akan menyimpan perubahan ini?');">
                                    <?php 
                                        $warna = array("#337ab7","#ffb22b","#bd2130");
                                        $tingkat_kesulitan = unserialize($penugasan->tingkat_kesulitan);
                                        $number = 1;
                                        $indexForm = 0;

                                        foreach ($soal as $s) {
                                        if ($s['tingkat_kesulitan'] == 0) {
                                            $status_kesulitan = 'mudah';
                                        }elseif ($s['tingkat_kesulitan'] == 1) {
                                            $status_kesulitan = 'sedang';
                                        }else{
                                            $status_kesulitan = 'sulit';
                                        }
                                        ?>
                                        <div class="form-group">
                                          <label for="comment">Soal <?php echo $number ?>: [<?php echo $status_kesulitan; ?>]</label>
                                          <textarea id="editorC" name="soal[<?php echo $indexForm; ?>]"><?php echo $s['soal']; ?></textarea>
                                        </div>
                                        <div class="form-group" id="dynamic_field">
                                          <div class="row">
                                            <div class="col-sm-6">
                                                <?php 
                                                    $opsi = unserialize($s['opsi']);
                                                    if ($s['jawaban']==0) {
                                                        echo '<label><input type="radio" name="pgBenar['.$indexForm.']" checked value="0">A</label>';
                                                    }else{
                                                        echo '<label><input type="radio" name="pgBenar['.$indexForm.']" value="0">A</label>';
                                                    }
                                                ?>
                                                <textarea name="pgA[<?php echo $indexForm; ?>]" id="opsi"><?php echo $opsi[0] ?></textarea>
                                            </div>
                                            <div class="col-sm-6">
                                                <?php 
                                                    if ($s['jawaban']==2) {
                                                        echo '<label><input type="radio" name="pgBenar['.$indexForm.']" checked value="2">C</label>';
                                                    }else{
                                                        echo '<label><input type="radio" name="pgBenar['.$indexForm.']" value="2">C</label>';
                                                    }
                                                ?>
                                                <textarea name="pgC[<?php echo $indexForm; ?>]" id="opsi"><?php echo $opsi[2] ?></textarea>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="form-group" id="dynamic_field">
                                          <div class="row">
                                            <div class="col-sm-6">
                                                <?php 
                                                    if ($s['jawaban']==1) {
                                                        echo '<label><input type="radio" name="pgBenar['.$indexForm.']" checked value="1">B</label>';
                                                    }else{
                                                        echo '<label><input type="radio" name="pgBenar['.$indexForm.']" value="1">B</label>';
                                                    }
                                                ?>
                                                <textarea name="pgB[<?php echo $indexForm; ?>]" id="opsi"><?php echo $opsi[1] ?></textarea>
                                            </div>
                                            <div class="col-sm-6">
                                                <?php 
                                                    if ($s['jawaban']==3) {
                                                        echo '<label><input type="radio" name="pgBenar['.$indexForm.']" checked value="3">D</label>';
                                                    }else{
                                                        echo '<label><input type="radio" name="pgBenar['.$indexForm.']" value="3">D</label>';
                                                    }
                                                ?>
                                                <textarea name="pgD[<?php echo $indexForm; ?>]" id="opsi"><?php echo $opsi[3] ?></textarea>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Estimasi waktu pengerjaan : </label>
                                            <select class="selectpicker" name="estimasi_waktu[<?php echo $indexForm; ?>]">
                                            <?php $pilihan_waktu = array(60,90,120,150,180,210,240,270,300);
                                                for ($i=0; $i < count($pilihan_waktu) ; $i++) { 
                                                    $menit = $pilihan_waktu[$i]/60;
                                                    if ($s['estimasi_pengerjaan_soal'] == $pilihan_waktu[$i]) {
                                                        echo '<option value="'.$pilihan_waktu[$i].'" selected>'.$menit.' menit</option>';
                                                    }else{
                                                        echo '<option value="'.$pilihan_waktu[$i].'">'.$menit.' menit</option>';
                                                    }
                                                    
                                                }
                                            ?>
                                            </select>
                                        </div>
                                        <input type="hidden" name="id_soal[<?php echo $indexForm; ?>]" value="<?php echo $s['id_soal'] ?>">
                                        <input type="hidden" name="id_penugasan" value="<?php echo $penugasan->id_penugasan ?>">
                                        <input type="hidden" name="status_edit" value="penugasan">
                                    <?php 
                                    $number++;
                                    $indexForm++;
                                    } ?>
                                        <div class="form-group">
                                            <div class="col-sm-12" style="text-align: right;">
                                                <button type="submit" class="btn btn-default">Simpan</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
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
        