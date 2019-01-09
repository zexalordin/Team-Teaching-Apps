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
    .im-centered{margin: auto; max-width: 300px;}
</style>
<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-9 align-self-center">
                    <h3 class="color-white">EVALUASI PENUGASAN - </h3> 
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
            <form action="<?php echo base_url('proses-cetak-soal')?>" method="POST">
                <div class="border-head" style="margin-bottom: 25px;text-align: right;">
                    <button style="background-color: #e98227;color: white;" type="submit" class="btn btn-default">Cetak</button>
                </div>
                <!-- Start Page Content -->
                <div class="row">
                    <div class="col-xs-0 col-sm-2 col-lg-2"></div>
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 col-xs-12 col-centered">
                                        <img src="<?php echo base_url()."assets/image/header_soal.png" ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-3 control-label">Tahun ajaran</label>
                                    <div class="col-md-12 col-xs-12 col-centered">
                                        <input style="text-align: center;font-size:20px;width: 100%;" type="text" class="form-control" name="tahun_ajaran" value="UJIAN TENGAH SEMESTER GENAP TAHUN AKADEMIK 2016 / 2017">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-xs-6">
                                        <div class="row">
                                            <label class="col-sm-3 control-label">Mata Kuliah</label>
                                            <div class="col-md-6 col-xs-6">
                                                <input style="" type="text" class="form-control" name="nama_matkul" value="<?php echo $nama_matkul ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-3 control-label">Dosen</label>
                                            <div class="col-md-6 col-xs-6">
                                                <input style="" type="text" class="form-control" name="dosen" value="Tim Dosen">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-3 control-label">Kode Soal</label>
                                            <div class="col-md-6 col-xs-6">
                                                <input style="" type="number" class="form-control" name="kode_soal" min="1" max="10" value="1">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-3 control-label">Jenis font soal</label>
                                            <div class="col-md-6 col-xs-6">
                                                <select class="form-control name_list" name="jenis_font">
                                                   <option value="Times New Roman" selected>Times new roman</option>
                                                   <option value="Arial Narrow">Arial narrow</option>
                                                   <option value="Calibri">Calibri</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-6">
                                        <div class="row">
                                            <label class="col-sm-3 control-label">Waktu</label>
                                            <div class="col-md-6 col-xs-6">
                                                <input style="" type="text" class="form-control" name="waktu" value="<?php echo $waktu_pengerjaan ?> menit">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-3 control-label">Sifat ujian</label>
                                            <div class="col-md-6 col-xs-6">
                                                <input style="" type="text" class="form-control" name="sifat_ujian" value="Tertutup">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-3 control-label">Jumlah Soal</label>
                                            <div class="col-md-6 col-xs-6">
                                                <input style="" type="number" class="form-control" name="jum_soal" value="<?php echo count($soal) ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-3 control-label">Ukuran font soal</label>
                                            <div class="col-md-6 col-xs-6">
                                                <select class="form-control name_list" name="ukuran_font">
                                                   <option value="10">10</option>
                                                   <option value="11" selected>11</option>
                                                   <option value="12">12</option>
                                                   <option value="13">13</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-0 col-sm-2 col-lg-2"></div>
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <?php $number = 1;
                        
                        foreach ($soal as $s) {
                            echo '<input type="hidden" name="id_soal[]" value="'.$s['id_soal']. '">';?>
                            <div class="card">
                                <div class="card-body">
                                    <p><?php echo $number.". ".$s['soal'] ?></p>
                                    <?php $opsi = unserialize($s['opsi']); ?>
                                    <div class="row">
                                        <?php echo '<div class="col-sm-6 opsi">A. '.$opsi[0].'</div>';?>
                                        <?php echo '<div class="col-sm-6 opsi">C. '.$opsi[2].'</div>';?>
                                    </div>
                                    <div class="row">
                                        <?php echo '<div class="col-sm-6 opsi">B. '.$opsi[1].'</div>';?>
                                        <?php echo '<div class="col-sm-6 opsi">D. '.$opsi[3].'</div>';?>
                                    </div>
                                    <div class="row">
                                        <div style="height: fit-content;border-radius: 7px;border: 1px solid #ccc!important;margin: 0px 0px 0px auto;text-align: right;color: #adadad;padding: 5px;"><?php echo $dosen[$number-1];?></div>
                                        <div style="height: fit-content;border-radius: 7px;border: 1px solid #ccc!important;margin: 0px 10px 0px 5px;text-align: right;color: #adadad;padding: 5px;"><?php 
                                                $tanggal_soal = new DateTime($s['tanggal_buat']);
                                                echo $tanggal_soal->format('d-m-Y');?></div>
                                    </div>
                                </div>
                            </div>
                        <?php $number++;} ?>
                    </div>
                </div>
                <!-- End PAge Content -->
            </form>
            </div>
            <!-- End Container fluid  -->
            <!-- footer -->
            <footer class="footer"> © 2018 All rights reserved. Template designed by Colorlib</footer>
            <!-- End footer -->
        </div>
        <!-- End Page wrapper  -->
        <script type="text/javascript">
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