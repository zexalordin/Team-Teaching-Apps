<style type="text/css">
    pre {
      margin: 20px 0;
      padding: 20px;
      background: #fafafa;
    }

    .round { border-radius: 50%; }
</style>
<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-muted">PENUGASAN - <?php echo strtoupper($penugasan->nama_penugasan); ?></h3> 
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <?php 
                if($this->session->flashdata('gabung_msg')=="success"){
                    echo '<div class="alert alert-success" role="alert">Sukses bergabung</div>';
                }else if($this->session->flashdata('gabung_msg')=="failed"){
                    echo '<div class="alert alert-danger" role="alert">Gagal bergabung</div>';
                }else if($this->session->flashdata('gabung_msg')=="already"){
                    echo '<div class="alert alert-danger" role="alert">Sudah tergabung pada materi tersebut</div>';
                }

                if($this->session->flashdata('submit_msg')=="success"){
                    echo '<div class="alert alert-success" role="alert">Sukses submit</div>';
                }else if($this->session->flashdata('submit_msg')=="failed"){
                    echo '<div class="alert alert-danger" role="alert">Gagal submit</div>';
                }

                if($this->session->flashdata('keluar_msg')=="success"){
                    echo '<div class="alert alert-success" role="alert">Sukses batal bergabung</div>';
                }else if($this->session->flashdata('keluar_msg')=="failed"){
                    echo '<div class="alert alert-danger" role="alert">Gagal batal bergabung</div>';
                }
                if($this->session->flashdata('input_msg')=="success"){
                    echo '<div class="alert alert-success" role="alert">Sukses memasukkan soal</div>';
                }else if($this->session->flashdata('input_msg')=="failed"){
                    echo '<div class="alert alert-danger" role="alert">Gagal memasukkan soal</div>';
                } 
                if($this->session->flashdata('edit_msg')=="success"){
                    echo '<div class="alert alert-success" role="alert">Sukses mengedit soal</div>';
                }else if($this->session->flashdata('edit_msg')=="failed"){
                    echo '<div class="alert alert-danger" role="alert">Gagal mengedit soal</div>';
                } 
                ?>
            <?php 
                $ketua_tim = false;
                if ($id_ketua_tim == $this->session->userdata('id')) {
                    $ketua_tim = true;
                }
                $tingkat_kesulitan = unserialize($penugasan->tingkat_kesulitan);
                $kuota_ambil = unserialize($penugasan->kuota_ambil_penugasan);
                $id_penugasan = unserialize($penugasan->id_ambil_penugasan);
                $status_penugasan_anggota = unserialize($penugasan->status_penugasan_anggota);
                $jum_materi = count($materi);

            ?>
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row">
                    <div class="col-lg-12 main-chart">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-title" style="margin-bottom: .0rem;">
                                    <h4>Keterangan</h4>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group">
                                      <li class="list-group-item" style="padding: .35rem 1.25rem;">
                                        <span class="label label-success">Gabung</span>
                                          Untuk mengambil materi yang diinginkan
                                      </li>
                                      <li class="list-group-item" style="padding: .35rem 1.25rem;">
                                        <span class="label label-danger">Keluar</span>
                                          Untuk batal ambil materi yang telah diambil sebelumnya
                                      </li>
                                      <li class="list-group-item" style="padding: .35rem 1.25rem;">
                                          <span class="label label-info">Penuh</span>
                                          Status materi telah memenuhi kuota pengambilan
                                      </li>
                                      <li class="list-group-item" style="padding: .35rem 1.25rem;">
                                          <span class="label label-info" style="background-color:#e98227;">Submitted</span>
                                          Status materi telah selesai proses pengerjaan dan telah disubmit
                                      </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- /# card -->
                        </div>
                    </div>  
                </div>

                <div class="row">
                    <div class="col-lg-12 main-chart">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-title">
                                    <h4>MATERI PENUGASAN</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover ">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Materi</th>
                                                    <th>Tingkat Kesulitan</th>
                                                    <th>Kuota</th>
                                                    <th>Detail</th>
                                                    <th style="text-align: left;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                            for ($i=0; $i < count($materi) ; $i++) {?>
                                                <tr>
                                                    <th scope="row"><?php echo $i+1 ?></th>
                                                    <td><?php echo $materi[$i]->nama_materi ?></td>
                                                    <td>
                                                        <span class="label label-success" style="margin-right: 20px;font-size: 14px;padding: 12px 18px;">
                                                            Mudah
                                                            <span class="badge badge-light" style="margin-left: 7px;font-size: 12px;"><?php echo $tingkat_kesulitan[$i][0] ?></span>
                                                        </span>
                                                        <span class="label label-warning" style="margin-right: 20px;font-size: 14px;padding: 12px 18px;">
                                                            Sedang
                                                            <span class="badge badge-light" style="margin-left: 7px;font-size: 12px;"><?php echo $tingkat_kesulitan[$i][1] ?></span>
                                                        </span>
                                                        <span class="label label-danger" style="margin-right: 20px;font-size: 14px;padding: 12px 18px;">
                                                            Sulit
                                                            <span class="badge badge-light" style="margin-left: 7px;font-size: 12px;"><?php echo $tingkat_kesulitan[$i][2] ?></span>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            $count_ambil = 0;
                                                            for ($j=0; $j < count($id_penugasan[$i]) ; $j++) {
                                                                if ($id_penugasan[$i][$j]!=0) {
                                                                    $count_ambil++;
                                                                }
                                                            }
                                                            echo $count_ambil."/".$kuota_ambil[$i];
                                                        ?>
                                                    </td>
                                                    <td class="color-primary">
                                                        <?php $checkAmbil = false;
                                                        if ($count_ambil == 0) {
                                                            echo "-";
                                                        }else{
                                                            for ($j=0; $j < count($id_penugasan[$i]); $j++) {
                                                                if ($id_penugasan[$i][$j]!=0) {
                                                                    if ($id_penugasan[$i][$j] == $this->session->userdata('id')) {
                                                                        $checkAmbil = true;
                                                                    }
                                                                    $dosen_materi = $this->m_dosen->get_dosen(array('id_dosen'=>$id_penugasan[$i][$j]));
                                                                    echo '<img class="round" width="30" height="30" avatar="'.$dosen_materi->nama_dosen.'" title="'.$dosen_materi->nama_dosen.'">';
                                                                }
                                                            }?>
                                                  <?php } ?>
                                                    </td>
                                                    <td class="color-primary">
<?php
    date_default_timezone_set("Asia/Jakarta");
    $now = new DateTime();
    $today = new DateTime($now->format('Y-m-d'));
    $otherDate = new DateTime($penugasan->batas_penugasan);
    $batas_pengambilan = new DateTime($penugasan->batas_pengambilan);
    $role = unserialize($this->session->userdata('role'));
    $interval = date_diff($today, $otherDate);
    $interval_batas_pengambilan = date_diff($today, $batas_pengambilan);
    $soal_materi = $tingkat_kesulitan[$i][0]+$tingkat_kesulitan[$i][1]+$tingkat_kesulitan[$i][2];
    if ($interval->format('%R%a')>0) { 
        if ($interval_batas_pengambilan->format('%R%a')<=0){
            $submit_status = false;
            $index_dosen = array_search($this->session->userdata('id'),$id_penugasan[$i]);
            if ($status_penugasan_anggota[$i][$index_dosen] == 1) {
                $submit_status = true;
            }
            if ($checkAmbil){
                $where = array(
                    'soal.id_penugasan'=>$penugasan->id_penugasan,
                    'soal.id_materi'=>$materi[$i]->id_materi,
                    'id_dosen'=>$this->session->userdata('id')
                );
                $cek_soal = $this->m_soal->get_daftar_soal($where,'id_soal');
                if (count($cek_soal)>0) {
                    if (!$submit_status) {?>
                        <a href="<?php echo base_url('edit-soal/'.$penugasan->id_penugasan.'/'.$i) ?>"><button type="button" class="btn btn-primary">Edit</button></a>
                        <?php if (count($cek_soal) == $soal_materi) {?>
                            <a href="<?php echo base_url('submit-materi/'.$penugasan->id_penugasan.'/'.$i) ?>" onclick="return confirm('Apakah anda yakin untuk mensubmit soal pada materi ini?\n\nCATATAN : setelah mensubmit anda tidak bisa melakukan perubahan apapun pada soal yang telah dibuat!');"><button type="button" class="btn btn-primary">Submit</button></a>
                        <?php }
                    }else{
                        echo "<h5>SUBMITTED</h5>";
                    }
                }else{ ?>
                    <a href="<?php echo base_url('buat-soal/'.$penugasan->id_penugasan.'/'.$i) ?>"><button type="button" class="btn btn-primary">Kerjakan</button></a>
                <?php }
            }else{
                echo "-";
            } ?>
        <?php }elseif($interval_batas_pengambilan->format('%R%a')>0){ 
                if($count_ambil==$kuota_ambil[$i]){
                    echo "<h4>PENUH</h4>";
                }else{
                    if (!$checkAmbil && !$ketua_tim) {?>
                        <form action="<?php echo base_url().'index.php/c_penugasan/proses_gabung_penugasan/'.$penugasan->id_penugasan.'/'.$i ?>" method="POST" onsubmit="return confirm('Apakah anda yakin untuk bergabung penugasan ini?');">
                            <select hidden class="form-control name_list" name="id_dosen">
                                <option value="<?php echo $this->session->userdata('id');?>"><?php echo $this->session->userdata('nama');?></option>
                            </select>
                            <button type="submit" class="btn btn-success">Gabung</button>
                        </form>
                    <?php }
                    if ($ketua_tim) { ?>
                        <form action="<?php echo base_url().'index.php/c_penugasan/proses_gabung_penugasan/'.$penugasan->id_penugasan.'/'.$i ?>" method="POST" onsubmit="return confirm('Apakah anda yakin memilih dosen untuk bergabung penugasan ini?');">
                            <select class="form-control name_list" name="id_dosen">
                                <?php foreach ($team_teaching_anggota as $tt) { 
                                    if ($tt['id_tt'] == $penugasan->id_tt) {
                                        $nm_dosen = array();
                                        $id_dosen = array();
                                        $anggota = unserialize($tt['anggota_tt']);
                                        for($j=0;$j<count($anggota);$j++) {
                                            foreach($dosen as $key => $product){
                                                if ($product['id_dosen'] == $anggota[$j] && !in_array($dosen[$key]['id_dosen'], $id_penugasan[$i])){
                                                    array_push($nm_dosen,$dosen[$key]['nama_dosen']);
                                                    array_push($id_dosen,$dosen[$key]['id_dosen']);
                                                    break;
                                                }
                                            }
                                        }
                                        for ($j=0; $j < count($nm_dosen) ; $j++) {
                                            echo "<option value=".$id_dosen[$j].">".$nm_dosen[$j]."</option>";
                                        } 
                                    }
                                }?>
                            </select>
                            <button type="submit" class="btn btn-success">Gabung</button>
                        </form>
                    <?php }
                }
                if ($checkAmbil && !$ketua_tim) {?>
                    <form action="<?php echo base_url().'index.php/c_penugasan/proses_keluar_penugasan/'.$penugasan->id_penugasan.'/'.$i ?>" method="POST" onsubmit="return confirm('Apakah anda yakin keluar untuk bergabung penugasan ini?');">
                        <select hidden class="form-control name_list" name="id_dosen">
                            <option value="<?php echo $this->session->userdata('id');?>"><?php echo $this->session->userdata('nama');?></option>
                        </select>
                        <button type="submit" class="btn btn-danger">Keluar</button>
                    </form> 
                <?php }
                if ($count_ambil != 0 && $ketua_tim) {?>
                    <form action="<?php echo base_url().'index.php/c_penugasan/proses_keluar_penugasan/'.$penugasan->id_penugasan.'/'.$i ?>" method="POST" onsubmit="return confirm('Apakah anda yakin memilih dosen untuk dikeluarkan penugasan ini?');">
                        <select class="form-control name_list" name="id_dosen">
                      <?php for ($j=0; $j < count($id_penugasan[$i]); $j++) {
                                if ($id_penugasan[$i][$j]!=0) {
                                    $dosen_materi = $this->m_dosen->get_dosen(array('id_dosen'=>$id_penugasan[$i][$j]));
                                    echo "<option value=".$dosen_materi->id_dosen.">".$dosen_materi->nama_dosen."</option>";
                                }
                            }?>
                        </select>
                        <button type="submit" class="btn btn-danger">Keluar</button>
                    </form>
                <?php }
        } ?>
    <?php }else{ 
        echo "-";
    } ?>
                                                    </td>
                                                </tr>
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

        <script type="text/javascript">
            function keluar(id,index) {
                var url="<?php echo base_url().'index.php/c_penugasan/proses_keluar_penugasan/'?>";
                var r=confirm("Apakah anda yakin akan batal mengambil materi ini!");
                
                if (r==true){
                    window.location.href = url+id+"/"+index;
                }
                return false;
            }
            function gabung(id,index) {
                var url="<?php echo base_url().'index.php/c_penugasan/proses_gabung_penugasan/'?>";
                var r=confirm("Apakah anda yakin akan mengambil materi ini!");
                
                if (r==true){
                    window.location.href = url+id+"/"+index;
                }
                return false;
            }
            /*
             * LetterAvatar
             * 
             * Artur Heinze
             * Create Letter avatar based on Initials
             * based on https://gist.github.com/leecrossley/6027780
             */
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
        <!-- End Page wrapper  -->