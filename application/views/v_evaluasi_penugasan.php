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
<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-9 align-self-center">
                    <h3 class="color-white">EVALUASI PENUGASAN - <?php echo strtoupper($penugasan->nama_penugasan) ?></h3> 
                </div>
                <div class="col-md-3 align-self-center">
                    <a href="<?php echo base_url('edit-soal-evaluasi/'.$penugasan->id_penugasan) ?>"><button type="button" class="btn btn-theme" style="background-color: #e98227;color: white;border-color: white;float: right;"><i class="fa fa-pencil-square-o"></i> Edit evaluasi</button></a> 
                </div>
            </div>
            <?php 
                if($this->session->flashdata('delete_kmntr')=="success"){
                    echo '<div class="alert alert-success" role="alert">Sukses menghapus komentar</div>';
                }else if($this->session->flashdata('delete_kmntr')=="failed"){
                    echo '<div class="alert alert-danger" role="alert">Gagal menghapus komentar</div>';
                }
            ?>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row">
                    <div class="col-xs-0 col-sm-2 col-lg-2"></div>
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                    <?php $number = 1;
                        $indexForm = 0;
                    ?>
                    <?php foreach ($soal as $s) {
                        if ($s['tingkat_kesulitan'] == 0) {
                            $status_kesulitan = 'mudah';
                        }elseif ($s['tingkat_kesulitan'] == 1) {
                            $status_kesulitan = 'sedang';
                        }else{
                            $status_kesulitan = 'sulit';
                        }
                        ?>
                        <div class="card">
                            <div class="card-body">
                                <p><?php echo $number.". [".$s['nama_materi']."] [".$status_kesulitan."]".$s['soal'] ?></p>
                                <?php $opsi = unserialize($s['opsi']); ?>
                                <div class="row">
                                    <?php if ($s['jawaban'] == 0) {
                                        echo '<div class="col-sm-6 opsi"><b>A. '.$opsi[0].'</b></div>';
                                    }else{
                                        echo '<div class="col-sm-6 opsi">A. '.$opsi[0].'</div>';
                                    }?>
                                    <?php if ($s['jawaban'] == 2) {
                                        echo '<div class="col-sm-6 opsi"><b>C. '.$opsi[2].'</b></div>';
                                    }else{
                                        echo '<div class="col-sm-6 opsi">C. '.$opsi[2].'</div>';
                                    }?>
                                </div>
                                <div class="row">
                                    <?php if ($s['jawaban'] == 1) {
                                        echo '<div class="col-sm-6 opsi"><b>B. '.$opsi[1].'</b></div>';
                                    }else{
                                        echo '<div class="col-sm-6 opsi">B. '.$opsi[1].'</div>';
                                    }?>
                                    <?php if ($s['jawaban'] == 3) {
                                        echo '<div class="col-sm-6 opsi"><b>D. '.$opsi[3].'</b></div>';
                                    }else{
                                        echo '<div class="col-sm-6 opsi">D. '.$opsi[3].'</div>';
                                    }?>
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
                                            <form class="form" role="form" action="" accept-charset="utf-8">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <select class="form-control" id="kategori_komentar<?php echo $indexForm; ?>" name="kategori_komentar<?php echo $indexForm; ?>"  onChange="kategori_komentar(<?php echo $indexForm; ?>)">
                                                            <option value="kategori">Kategori</option>
                                                            <option value="soal">Soal</option>
                                                            <option value="opsi">Opsi</option>
                                                            <option value="tingkat kesulitan">Tingkat Kesulitan</option>
                                                            <option value="estimasi waktu">Estimasi Waktu</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <select class="form-control" id="isi_komentar<?php echo $indexForm; ?>" name="si_komentar<?php echo $indexForm; ?>" onChange="isi_komentar(<?php echo $indexForm; ?>)">
                                                            <option>Komentar</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6" style="margin-top: 10px">
                                                            <input class="form-control" id="komentar_custom<?php echo $indexForm; ?>" type="hidden" placeholder="Your comments" />
                                                    </div>
                                                    <div class="col-sm-6">
                                                            <button class="btn btn-default" onclick="input_komentar(<?php echo $s['id_soal'].",".$indexForm ?>)" type="button" style="float: right;margin-top: 10px;">Tambah</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <ul class="commentList">
                                            <?php 
                                            $where = array('id_soal'=>$s['id_soal']);
                                            $komentar = $this->m_komentar->get_komentar($where,"id_komentar");?>
                                            <?php for ($i=0; $i < count($komentar) ; $i++) {?>
                                                <li style="border-bottom: 1px solid #ccc!important;">
                                                    <div class="commenterImage">
                                                        <?php echo '<img class="round" width="30" height="30" avatar="'.$komentar[$i]['nama_dosen'].'" title="'.$komentar[$i]['nama_dosen'].'">' ?>
                                                    </div>
                                                    <div class="commentText" style="width: 100%;">
                                                        <p style="color:#4d4e4f;"><?php echo $komentar[$i]['isi_komentar']?></p> 
                                                        <span class="date sub-text" style="line-height: 1;"><b><?php echo $komentar[$i]['nama_dosen']?></b> on <?php $tanggal_komentar = new DateTime($komentar[$i]['tanggal_komentar']); echo $tanggal_komentar->format('M jS,Y'); ?></span>
                                                    </div>
                                            <?php if($this->session->userdata('id') == $komentar[$i]['id_dosen'] || $this->session->userdata('id') == $team_teaching->id_dosen){ ?>
                                                    <div class="deleteCommentText">
                                                        <a href="<?php echo base_url('hapus-komentar/'.$komentar[$i]['id_komentar'].'/'.$penugasan->id_penugasan) ?>" onclick="return confirm('Apakah anda yakin untuk menghapus komentar ini?');"><span><b>X</b></span></a>
                                                    </div>
                                            <?php  } ?>
                                                </li>
                                            <?php } ?>
                                            </ul>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php $number++;$indexForm++;} ?>
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
                    $('#isi_komentar'+index).append('<option value="Sebaiknya soal memakai kalimat pertanyaan">Sebaiknya soal memakai kalimat pertanyaan</option>');
                    $('#isi_komentar'+index).append('<option value="Tata bahasa pada soal kurang baik">Tata bahasa pada soal kurang baik</option>');
                    $('#isi_komentar'+index).append('<option value="Soal terlalu banyak memberi petunjuk jawaban">Soal terlalu banyak memberi petunjuk jawaban</option>');
                    $('#isi_komentar'+index).append('<option value="Instruksi pada soal kurang jelas">Instruksi pada soal kurang jelas</option>');
                    $('#isi_komentar'+index).append('<option value="Penjelasan masalah pada soal kurang jelas">Instruksi pada soal kurang jelas</option>');
                    $('#isi_komentar'+index).append('<option value="lainnya">Lainnya</option>');
                }else if(document.getElementById("kategori_komentar"+index).value == "opsi"){
                    $('#isi_komentar'+index).find('option').remove().end();
                    $('#isi_komentar'+index).append('<option value="Opsi kurang mengecoh">Opsi kurang mengecoh</option>');
                    $('#isi_komentar'+index).append('<option value="Jawaban perlu diletakkan diopsi lain">Jawaban perlu diletakkan diopsi lain</option>');
                    $('#isi_komentar'+index).append('<option value="Tata bahasa pada opsi kurang baik">Tata bahasa pada opsi kurang baik</option>');
                    $('#isi_komentar'+index).append('<option value="Terdapat jawaban lebih dari satu">Terdapat jawaban lebih dari satu</option>');
                    $('#isi_komentar'+index).append('<option value="Tidak terdapat jawaban benar">Tidak terdapat jawaban benar</option>');
                    $('#isi_komentar'+index).append('<option value="Hindari opsi jawaban semua benar atau tidak ada jawaban benar">Hindari opsi jawaban semua benar atau tidak ada jawaban benar</option>');
                    $('#isi_komentar'+index).append('<option value="lainnya">Lainnya</option>');
                }else if(document.getElementById("kategori_komentar"+index).value == "tingkat kesulitan"){
                    $('#isi_komentar'+index).find('option').remove().end();
                    $('#isi_komentar'+index).append('<option value="Tingkat kesulitan tidak sesuai, seharusnya sulit">tingkat kesulitan tidak sesuai, seharusnya sulit</option>');
                    $('#isi_komentar'+index).append('<option value="ingkat kesulitan tidak sesuai, seharusnya sedang">ingkat kesulitan tidak sesuai, seharusnya sedang</option>');
                    $('#isi_komentar'+index).append('<option value="ingkat kesulitan tidak sesuai, seharusnya mudah">ingkat kesulitan tidak sesuai, seharusnya mudah</option>');
                    $('#isi_komentar'+index).append('<option value="lainnya">Lainnya</option>');
                }else if(document.getElementById("kategori_komentar"+index).value == "estimasi waktu"){
                    $('#isi_komentar'+index).find('option').remove().end();
                    $('#isi_komentar'+index).append('<option value="Estimasi waktu terlalu lama">Estimasi waktu terlalu lama</option>');
                    $('#isi_komentar'+index).append('<option value="Estimasi waktu kurang">Estimasi waktu kurang</option>');
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
                            swal("Berhasil!", "Komentar anda telah ditambahkan!\nPerlu me-refresh halaman untuk melihat komentar", "success");
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