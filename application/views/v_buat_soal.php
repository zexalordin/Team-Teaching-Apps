<link href="<?=base_url('assets/css/')?>buat-soal.css" rel="stylesheet">
<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-12 align-self-center">
                    <h3 class="color-white">BUAT SOAL - <?php echo strtoupper($penugasan->nama_matkul) ?> - <?php echo strtoupper($materi_penugasan->nama_materi) ?></h3> 
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
                                    <form class="form-horizontal" action="<?php echo base_url('proses-buat-soal') ?>" method="post" onsubmit="return confirm('Apakah anda akan menyimpan soal ini?');">
                                      <?php 
                                        $materi = unserialize($penugasan->materi_penugasan);
                                        $warna = array("#337ab7","#ffb22b","#bd2130");
                                        $tingkat_kesulitan = unserialize($penugasan->tingkat_kesulitan);
                                        $number = 1;
                                        $indexForm = 0;
                                        for ($i=0; $i <count($tingkat_kesulitan[$index]) ; $i++) { 
                                          if ($i == 0) {
                                          	$status_kesulitan = 'mudah';
                                          }elseif ($i == 1) {
                                          	$status_kesulitan = 'sedang';
                                          }else{
                                          	$status_kesulitan = 'sulit';
                                          }
                                          for ($j=0; $j <$tingkat_kesulitan[$index][$i] ; $j++) {?>
                                        <div class="form-group">
                                          <label for="comment">Soal <?php echo $number ?>: [<?php echo $status_kesulitan; ?>]</label>
                                          <textarea id="editorC" name="soal[<?php echo $indexForm; ?>]"></textarea>
                                        </div>
                                        <div class="form-group" id="dynamic_field">
                                          <div class="row">
                                            <div class="col-sm-6">
                                                <label><input type="radio" name="pgBenar[<?php echo $indexForm; ?>]" checked value="0">A</label>
                                                <textarea name="pgA[<?php echo $indexForm; ?>]" id="opsi"></textarea>
                                            </div>
                                            <div class="col-sm-6">
                                                <label><input type="radio" name="pgBenar[<?php echo $indexForm; ?>]" value="3">C</label>
                                                <textarea name="pgC[<?php echo $indexForm; ?>]" id="opsi"></textarea>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="form-group" id="dynamic_field">
                                          <div class="row">
                                            <div class="col-sm-6">
                                                <label><input type="radio" name="pgBenar[<?php echo $indexForm; ?>]" value="2">B</label>
                                                <textarea name="pgB[<?php echo $indexForm; ?>]" id="opsi"></textarea>
                                            </div>
                                            <div class="col-sm-6">
                                                <label><input type="radio" name="pgBenar[<?php echo $indexForm; ?>]" value="4">D</label>
                                                <textarea name="pgD[<?php echo $indexForm; ?>]" id="opsi"></textarea>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Estimasi waktu pengerjaan : </label>
                                            <select class="selectpicker" name="estimasi_waktu[<?php echo $indexForm; ?>]">
                                                <option value="60">1 menit</option>
                                                <option value="90">1.5 menit</option>
                                                <option value="120">2 menit</option>
                                                <option value="150">2.5 menit</option>
                                                <option value="180">3 menit</option>
                                                <option value="210">3.5 menit</option>
                                                <option value="240">4 menit</option>
                                                <option value="270">4.5 menit</option>
                                                <option value="300">5 menit</option>
                                            </select>
                                        </div>
                                        <input type="hidden" name="tingkat_kesulitan[<?php echo $indexForm; ?>]" value="<?php echo $i ?>">
                                        <input type="hidden" name="id_penugasan" value="<?php echo $penugasan->id_penugasan ?>">
                                        <input type="hidden" name="id_materi" value="<?php echo $materi_penugasan->id_materi ?>">
                                      <?php 
                                      $indexForm++;
                                      $number++;}
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
        <script type="text/javascript">
            // $("textarea").each(function () {
            //        CKEDITOR.inline( 'opsi' );
            // });
        </script>
        <!-- End Page wrapper  -->