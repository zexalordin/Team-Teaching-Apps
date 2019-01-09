<style type="text/css">
    .detailBox {
        width:320px;
        border:1px solid #bbb;
        margin:50px;
    }
    .titleBox {
        background-color:#fdfdfd;
        padding:10px;
    }
    .titleBox label{
      color:#444;
      margin:0;
      display:inline-block;
    }

    .commentBox {
        padding:10px;
        border-top:1px dotted #bbb;
    }
    .commentBox .form-group:first-child, .actionBox .form-group:first-child {
        width:80%;
    }
    .commentBox .form-group:nth-child(2), .actionBox .form-group:nth-child(2) {
        width:18%;
    }
    .actionBox .form-group * {
        width:100%;
    }
    .taskDescription {
        margin-top:10px 0;
    }
    .commentList {
        padding:0;
        list-style:none;
        max-height:200px;
        overflow:auto;
    }
    .commentList li {
        margin:0;
        margin-top:10px;
    }
    .commentList li > div {
        display:table-cell;
    }
    .commenterImage {
        width:30px;
        margin-right:5px;
        height:100%;
        float:left;
    }
    .commenterImage img {
        width:100%;
        border-radius:50%;
    }
    .commentText p {
        margin:0;
    }
    .sub-text {
        color:#aaa;
        font-family:verdana;
        font-size:11px;
    }
    .actionBox {
        border-top:1px dotted #bbb;
        padding:10px;
    }
    .opsi p{
        display: inline-block;
        color: #67757c;
        margin-bottom: 5px;
    }
</style>
<link href="<?=base_url('assets/css/')?>buat-soal.css" rel="stylesheet">

<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-12 align-self-center">
                    <h3 class="color-white">EVALUASI BANK SOAL - <?php echo strtoupper($team_teaching->nama_matkul) ?></h3> 
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <?php 
                    if($this->session->flashdata('edit_msg')=="success"){
                        echo '<div class="alert alert-success" role="alert">Sukses mengubah data</div>';
                    }else if($this->session->flashdata('edit_msg')=="failed"){
                        echo '<div class="alert alert-danger" role="alert">Gagal mengubah data</div>';
                    }
                ?>
                <!-- Start Page Content -->
                <div class="row">
                    <div class="col-lg-12 main-chart">
                        <form action="<?php echo base_url('evaluasi-bank-soal/'.$team_teaching->id_tt) ?>" method="GET">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Filter soal</label>
                                <div class="row" style="margin-left: 5px;">
                                    <div class="col-sm-3">
                                        <select class="selectpicker" name="filterMateri">
                                        <?php 
                                            echo '<option value="semua" selected>Semua</option>';
                                            for ($i=0; $i < count($materi) ; $i++) {
                                                if (isset($_GET['filterMateri'])) {
                                                    if ($materi[$i]['nama_materi'] == $_GET['filterMateri']) {
                                                        echo '<option value="'.$materi[$i]['nama_materi'].'" selected>'.$materi[$i]['nama_materi'].'</option>';
                                                        $filterMateri = $materi[$i]['nama_materi'];
                                                    }else{
                                                        echo '<option value="'.$materi[$i]['nama_materi'].'">'.$materi[$i]['nama_materi'].'</option>';
                                                    }   
                                                }else{
                                                    echo '<option value="'.$materi[$i]['nama_materi'].'">'.$materi[$i]['nama_materi'].'</option>';
                                                }
                                                                                 
                                            }
                                        ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <button style="background-color: #e98227;color: white;" type="submit" class="btn btn-default">Ubah</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-xs-0 col-sm-2 col-lg-2"></div>
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                    <form class="form-horizontal" action="<?php echo base_url('proses-edit-soal') ?>" method="post">
                    <?php 
                        $number = 1;
                        $indexForm = 0;
                    ?>
              <?php foreach ($soal as $s) {
                        if (isset($_GET['filterMateri']) && isset($_GET['filterMateri'])!="semua") {
                            if ($data_materi[$indexForm]==$_GET['filterMateri']) {?>
                                <div class="card">
                                    <div class="card-body">
                                        <?php
                                            if ($s['tingkat_kesulitan']==0) {
                                                $tingkat_kesulitan = "mudah";
                                            }elseif ($s['tingkat_kesulitan']==1) {
                                                $tingkat_kesulitan = "sedang";
                                            }else{
                                                $tingkat_kesulitan = "sulit";
                                            }
                                        ?>
                                        <p><?php echo $number.". [".$tingkat_kesulitan."][".$data_materi[$indexForm]."]"?></p>
                                        <textarea id="editorC" name="soal[<?php echo $indexForm; ?>]"><?php echo $s['soal']; ?></textarea>
                                        <?php $opsi = unserialize($s['opsi']); ?>
                                        <div class="row" style="margin-top: 15px;">
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
                                        <div class="row" style="margin-top: 15px;">
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
                                        <div class="row" style="margin-top: 15px;">
                                                <label class="col-sm-3 control-label">Estimasi waktu pengerjaan : </label>
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
                                                <label class="col-sm-3 control-label">Status soal : </label>
                                                <select class="selectpicker" name="status_soal[<?php echo $indexForm; ?>]">
                                                <?php
                                                    if ($s['status_soal'] == 0) {
                                                        echo '<option value="0" selected>Digunakan</option>';
                                                    }else{
                                                        echo '<option value="0">Digunakan</option>';
                                                    }
                                                    if ($s['status_soal'] == 1) {
                                                        echo '<option value="1" selected>Tidak Digunakan</option>';
                                                    }else{
                                                        echo '<option value="1">Tidak Digunakan</option>';
                                                    }
                                                ?>
                                                </select>
                                            <input type="hidden" name="id_soal[<?php echo $indexForm; ?>]" value="<?php echo $s['id_soal'] ?>">
                                            <input type="hidden" name="id_tt" value="<?php echo $team_teaching->id_tt ?>">
                                            <input type="hidden" name="status_edit" value="evaluasiBankSoal">
                                        </div>
                                        <div class="row" style="margin-top: 15px;">
                                            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseComment<?php echo $number ?>" aria-expanded="false" aria-controls="collapseExample" style="margin-left: 15px;padding: 4px 6px;">Komentar</button>
                                            
                                            <div style="height: fit-content;border-radius: 7px;border: 1px solid #ccc!important;margin: 0px 0px 0px auto;text-align: right;color: #adadad;padding: 5px;"><?php echo $dosen[$indexForm];?></div>

                                            <div style="height: fit-content;border-radius: 7px;border: 1px solid #ccc!important;margin: 0px 60px 0px 5px;text-align: right;color: #adadad;padding: 5px;"><?php 
                                                $tanggal_soal = new DateTime($s['tanggal_buat']);
                                                echo $tanggal_soal->format('d-m-Y');?></div>

                                            <div class="collapse col-sm-12" id="collapseComment<?php echo $number ?>">
                                              <div class="card card-body">
                                                <div class="titleBox">
                                                      <label>Kolom Komentar</label>
                                                </div>
                                                <div class="actionBox">
                                                    <ul class="commentList">
                                                    <?php 
                                                    $where = array('id_soal'=>$s['id_soal']);
                                                    $komentar = $this->m_komentar->get_komentar($where,"id_komentar");?>
                                                    <?php for ($i=0; $i < count($komentar) ; $i++) {?>
                                                        <li>
                                                            <div class="commenterImage">
                                                                <?php echo '<img class="round" width="30" height="30" avatar="'.$komentar[$i]['nama_dosen'].'" title="'.$komentar[$i]['nama_dosen'].'">' ?>
                                                            </div>
                                                            <div class="commentText">
                                                                <p class=""><?php echo $komentar[$i]['isi_komentar']?></p> 
                                                                <span class="date sub-text" style="line-height: 1;"><b><?php echo $komentar[$i]['nama_dosen']?></b> on <?php $tanggal_komentar = new DateTime($komentar[$i]['tanggal_komentar']); echo $tanggal_komentar->format('M jS,Y'); ?></span>
                                                            </div>
                                                        </li>
                                                    <?php } ?>
                                                    </ul>
                                                </div>
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                  <?php     $number++;}
                        }else{?>
                            <div class="card">
                                <div class="card-body">
                                    <?php
                                        if ($s['tingkat_kesulitan']==0) {
                                            $tingkat_kesulitan = "mudah";
                                        }elseif ($s['tingkat_kesulitan']==1) {
                                            $tingkat_kesulitan = "sedang";
                                        }else{
                                            $tingkat_kesulitan = "sulit";
                                        }
                                    ?>
                                    <p><?php echo $number.". [".$tingkat_kesulitan."][".$data_materi[$indexForm]."]"?></p>
                                    <textarea id="editorC" name="soal[<?php echo $indexForm; ?>]"><?php echo $s['soal']; ?></textarea>
                                    <?php $opsi = unserialize($s['opsi']); ?>
                                    <div class="row" style="margin-top: 15px;">
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
                                    <div class="row" style="margin-top: 15px;">
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
                                    <div class="row" style="margin-top: 15px;">
                                            <label class="col-sm-3 control-label">Estimasi waktu pengerjaan : </label>
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
                                            <label class="col-sm-3 control-label">Status soal : </label>
                                            <select class="selectpicker" name="status_soal[<?php echo $indexForm; ?>]">
                                            <?php
                                                if ($s['status_soal'] == 0) {
                                                    echo '<option value="0" selected>Digunakan</option>';
                                                }else{
                                                    echo '<option value="0">Digunakan</option>';
                                                }
                                                if ($s['status_soal'] == 1) {
                                                    echo '<option value="1" selected>Tidak Digunakan</option>';
                                                }else{
                                                    echo '<option value="1">Tidak Digunakan</option>';
                                                }
                                            ?>
                                            </select>
                                        <input type="hidden" name="id_soal[<?php echo $indexForm; ?>]" value="<?php echo $s['id_soal'] ?>">
                                        <input type="hidden" name="id_tt" value="<?php echo $team_teaching->id_tt ?>">
                                        <input type="hidden" name="status_edit" value="evaluasiBankSoal">
                                    </div>
                                    <div class="row" style="margin-top: 15px;">
                                        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseComment<?php echo $number ?>" aria-expanded="false" aria-controls="collapseExample" style="margin-left: 15px;padding: 4px 6px;">Komentar</button>
                                        
                                        <div style="height: fit-content;border-radius: 7px;border: 1px solid #ccc!important;margin: 0px 0px 0px auto;text-align: right;color: #adadad;padding: 5px;"><?php echo $dosen[$indexForm];?></div>

                                        <div style="height: fit-content;border-radius: 7px;border: 1px solid #ccc!important;margin: 0px 10px 0px 5px;text-align: right;color: #adadad;padding: 5px;"><?php 
                                                $tanggal_soal = new DateTime($s['tanggal_buat']);
                                                echo $tanggal_soal->format('d-m-Y');?></div>

                                        <div class="collapse col-sm-12" id="collapseComment<?php echo $number ?>">
                                          <div class="card card-body">
                                            <div class="titleBox">
                                                  <label>Kolom Komentar</label>
                                            </div>
                                            <div class="actionBox">
                                                <ul class="commentList">
                                                <?php 
                                                $where = array('id_soal'=>$s['id_soal']);
                                                $komentar = $this->m_komentar->get_komentar($where,"id_komentar");?>
                                                <?php for ($i=0; $i < count($komentar) ; $i++) {?>
                                                    <li>
                                                        <div class="commenterImage">
                                                            <?php echo '<img class="round" width="30" height="30" avatar="'.$komentar[$i]['nama_dosen'].'" title="'.$komentar[$i]['nama_dosen'].'">' ?>
                                                        </div>
                                                        <div class="commentText">
                                                            <p class=""><?php echo $komentar[$i]['isi_komentar']?></p> 
                                                            <span class="date sub-text" style="line-height: 1;"><b><?php echo $komentar[$i]['nama_dosen']?></b> on <?php $tanggal_komentar = new DateTime($komentar[$i]['tanggal_komentar']); echo $tanggal_komentar->format('M jS,Y'); ?></span>
                                                        </div>
                                                    </li>
                                                <?php } ?>
                                                </ul>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                  <?php $number++;}
                    $indexForm++;} ?>
                        <div class="form-group">
                            <div class="col-sm-12" style="text-align: right;">
                                <button type="submit" class="btn btn-default">Simpan</button>
                            </div>
                        </div>
                    </form>
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
            function kategori_komentar(index) {
                if (document.getElementById("kategori_komentar"+index).value == "soal"){
                    $('#isi_komentar'+index).find('option').remove().end();
                    $('#isi_komentar'+index).append('<option value="Soal kurang detail">Soal kurang detail</option>');
                    $('#isi_komentar'+index).append('<option value="Soal kurang detail">Soal kurang detail</option>');
                    $('#isi_komentar'+index).append('<option value="Soal kurang detail">Soal kurang detail</option>');
                    $('#isi_komentar'+index).append('<option value="Soal kurang detail">Soal kurang detail</option>');
                    $('#isi_komentar'+index).append('<option value="lainnya">Lainnya</option>');
                }else if(document.getElementById("kategori_komentar"+index).value == "opsi"){
                    $('#isi_komentar'+index).find('option').remove().end();
                    $('#isi_komentar'+index).append('<option value="opsi kurang detail">Opsi kurang detail</option>');
                    $('#isi_komentar'+index).append('<option value="opsi kurang detail">Opsi kurang detail</option>');
                    $('#isi_komentar'+index).append('<option value="lainnya">Lainnya</option>');
                }else if(document.getElementById("kategori_komentar"+index).value == "tingkat kesulitan"){
                    $('#isi_komentar'+index).find('option').remove().end();
                    $('#isi_komentar'+index).append('<option value="opsi kurang detail">tingkat kesulitan kurang detail</option>');
                    $('#isi_komentar'+index).append('<option value="opsi kurang detail">Opsi kurang detail</option>');
                    $('#isi_komentar'+index).append('<option value="lainnya">Lainnya</option>');
                }else if(document.getElementById("kategori_komentar"+index).value == "estimasi waktu"){
                    $('#isi_komentar'+index).find('option').remove().end();
                    $('#isi_komentar'+index).append('<option value="opsi kurang detail">estimasi waktu kurang detail</option>');
                    $('#isi_komentar'+index).append('<option value="lainnya">Lainnya</option>');
                }else if(document.getElementById("kategori_komentar"+index).value == "kategori"){
                    $('#isi_komentar'+index).find('option').remove().end().append('<option>Komentar</option>');
                }
                document.getElementById('komentar_custom'+index).type = 'hidden';
            }
            function isi_komentar(index) {
                if (document.getElementById("isi_komentar"+index).value == "lainnya"){
                    document.getElementById('komentar_custom'+index).type = 'text';
                }else{
                    document.getElementById('komentar_custom'+index).type = 'hidden';
                }
            }
            function input_komentar(id,index){
                if(document.getElementById("kategori_komentar"+index).value == "kategori"){
                    swal("Pilih Kategori!", "Pilih kategori dan berikan komentar", "error");
                }else{
                    var post_data;
                    if (document.getElementById("isi_komentar"+index).value == "lainnya"){
                        var post_data = {
                            'kategori': $("#kategori_komentar"+index).val(),
                            'komentar': $("#komentar_custom"+index).val(),
                        };
                    }else{
                        var post_data = {
                            'kategori': $("#kategori_komentar"+index).val(),
                            'komentar': $("#isi_komentar"+index).val(),
                        };
                    }
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>index.php/c_penugasan/proses_tambah_komentar/"+id,
                        data: post_data,
                        success: function (data) {
                            swal("Berhasil!", "Komentar anda telah ditambahkan!", "success");
                        }
                    });
                }
            }

            (function(w, d){


                function LetterAvatar (name, size) {

                    name  = name || '';
                    size  = size || 60;

                    var colours = [
                            "#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#34495e", "#16a085", "#27ae60", "#2980b9", "#8e44ad", "#2c3e50", 
                            "#f1c40f", "#e67e22", "#e74c3c", "#ecf0f1", "#95a5a6", "#f39c12", "#d35400", "#c0392b", "#bdc3c7", "#7f8c8d"
                        ],

                        nameSplit = String(name).toUpperCase().split(' '),
                        initials, charIndex, colourIndex, canvas, context, dataURI;


                    if (nameSplit.length == 1) {
                        initials = nameSplit[0] ? nameSplit[0].charAt(0):'?';
                    } else {
                        initials = nameSplit[0].charAt(0) + nameSplit[1].charAt(0);
                    }

                    if (w.devicePixelRatio) {
                        size = (size * w.devicePixelRatio);
                    }
                        
                    charIndex     = (initials == '?' ? 72 : initials.charCodeAt(0)) - 64;
                    colourIndex   = charIndex % 20;
                    canvas        = d.createElement('canvas');
                    canvas.width  = size;
                    canvas.height = size;
                    context       = canvas.getContext("2d");
                     
                    context.fillStyle = colours[colourIndex - 1];
                    context.fillRect (0, 0, canvas.width, canvas.height);
                    context.font = Math.round(canvas.width/2)+"px Arial";
                    context.textAlign = "center";
                    context.fillStyle = "#FFF";
                    context.fillText(initials, size / 2, size / 1.5);

                    dataURI = canvas.toDataURL();
                    canvas  = null;

                    return dataURI;
                }

                LetterAvatar.transform = function() {

                    Array.prototype.forEach.call(d.querySelectorAll('img[avatar]'), function(img, name) {
                        name = img.getAttribute('avatar');
                        img.src = LetterAvatar(name, img.getAttribute('width'));
                        img.removeAttribute('avatar');
                        img.setAttribute('alt', name);
                    });
                };


                // AMD support
                if (typeof define === 'function' && define.amd) {
                    
                    define(function () { return LetterAvatar; });
                
                // CommonJS and Node.js module support.
                } else if (typeof exports !== 'undefined') {
                    
                    // Support Node.js specific `module.exports` (which can be a function)
                    if (typeof module != 'undefined' && module.exports) {
                        exports = module.exports = LetterAvatar;
                    }

                    // But always support CommonJS module 1.1.1 spec (`exports` cannot be a function)
                    exports.LetterAvatar = LetterAvatar;

                } else {
                    
                    window.LetterAvatar = LetterAvatar;

                    d.addEventListener('DOMContentLoaded', function(event) {
                        LetterAvatar.transform();
                    });
                }

            })(window, document);
        </script>