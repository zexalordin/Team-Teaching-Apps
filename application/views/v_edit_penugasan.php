<link href="<?=base_url('assets/css/')?>penugasan.css" rel="stylesheet">
<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-muted">EDIT PENUGASAN</h3> 
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
              <?php 
                    $anggota_tt = unserialize($team_teaching[0]['anggota_tt']);
                    if($this->session->flashdata('edit_msg')=="success"){
                        echo '<div class="alert alert-success" role="alert">Sukses mengubah data</div>';
                    }else if($this->session->flashdata('edit_msg')=="failed"){
                        echo '<div class="alert alert-danger" role="alert">Gagal mengubah data</div>';
                    } ?>
                <!-- Start Page Content -->
                <div class="row">
                    <div class="col-xs-0 col-sm-2 col-lg-2"></div>
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="horizontal-form">
                                    <form class="form-horizontal" action="<?php echo base_url('proses-edit-penugasan/'.$penugasan->id_penugasan) ?>" method="post">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">Judul Penugasan</label>
                                            <div class="col-sm-10">
                                                 <input type="text" class="form-control" name="judul_tugas" value="<?php echo $penugasan->nama_penugasan ?>">
                                            </div>
                                        </div>
                                        <div class="row" style="padding-left: 15px;">
                                            <div class="col-sm-4" style="padding-right: 0px;">
                                               <label>Materi</label>
                                            </div>
                                            <div class="col-sm-2">
                                                <label>Kuota</label>
                                            </div>
                                            <div class="col-sm-2">
                                                <label>Mudah</label>
                                            </div>
                                            <div class="col-sm-2">
                                                <label>Sedang</label>
                                            </div>
                                            <div class="col-sm-2">
                                                <label>Sulit</label>
                                            </div>
                                        </div>
                                        <div class="form-group" id="dynamic_field">
                                      <?php 
                                        $materi_penugasan = unserialize($penugasan->materi_penugasan);
                                        $tingkat_kesulitan = unserialize($penugasan->tingkat_kesulitan);
                                        $kuota_penugasan = unserialize($penugasan->kuota_ambil_penugasan);
                                        for ($i=0; $i <count($materi_penugasan) ; $i++) { 
                                      ?>
                                            <div id="row<?php echo $i+1 ?>" class="row" style="padding-left: 15px;margin-top: 10px;">
                                                <div class="col-sm-4" style="padding-right: 0px;">
                                                    <select class="form-control name_list" name="materi[]">
                                                      <?php for ($j=0; $j < count($team_teaching); $j++) { ?>
                                                          <?php foreach ($materi[$j] as $p) { 
                                                            if ($p['id_materi'] == $materi_penugasan[$i]) {?>
                                                              <option value="<?php echo $p['id_materi'] ?>" selected><?php echo $p['nama_materi'] ?></option>
                                                            <?php }else{ ?>
                                                              <option value="<?php echo $p['id_materi'] ?>"><?php echo $p['nama_materi'] ?></option>
                                                          <?php }
                                                          } ?>
                                                      <?php } ?>
                                                      </select>
                                                </div>
                                                <div class="col-sm-2">
                                                     <input type="number" min="0" max="<?php echo count($anggota_tt) ?>" name="kuota[]" value="<?php echo $kuota_penugasan[$i] ?>" class="form-control name_list"  />
                                                </div>
                                                <div class="col-sm-2">
                                                     <input type="number" min="0" name="mudah[]" value="<?php echo $tingkat_kesulitan[$i][0] ?>"" class="form-control name_list" />
                                                </div>
                                                <div class="col-sm-2">
                                                     <input type="number" min="0" name="sedang[]" value="<?php echo $tingkat_kesulitan[$i][1] ?>" class="form-control name_list" />
                                                </div>
                                                <div class="col-sm-2">
                                                     <input type="number" min="0" name="sulit[]" value="<?php echo $tingkat_kesulitan[$i][2] ?>" class="form-control name_list" />
                                                </div>
                                                <?php 
                                                  if ($i==0) {
                                                ?>
                                                    <div class="col-sm-2">
                                                         <button type="button" name="add" id="add" class="btn btn-success" >Add More</button>
                                                    </div>
                                                <?php }else{ ?>
                                                    <div class="col-sm-2">
                                                      <button type="button" name="remove" id="<?php echo $i+1 ?>" class="btn btn-danger btn_remove">X</button>
                                                    </div>
                                                <?php } ?>
                                                <input type="hidden" name="status[]" value="lama" >
                                            </div>
                                      <?php } ?>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">Tanggal Mulai Pengerjaan</label>
                                            <div class="col-sm-10">
                                                 <input name="batas_pengambilan" type="text" class="form-control" placeholder="klik untuk membuka kalender"  id="example1" value="<?php echo $penugasan->batas_pengambilan ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">Batas Penugasan</label>
                                            <div class="col-sm-10">
                                                 <input name="batas_penugasan" type="text" class="form-control" placeholder="klik untuk membuka kalender"  id="example2" value="<?php echo $penugasan->batas_penugasan ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10" style="text-align: right;">
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
        <script>  
         $(document).ready(function(){  
              var i=<?php echo count($materi_penugasan);  ?>;
              $('#add').click(function(){  
                   i++;  
                   $('#dynamic_field').append('<div id="row'+i+'" class="row" style="padding-left: 15px;margin-top: 10px;"><div class="col-sm-4" style="padding-right: 0px;"><select class="form-control name_list selectpicker" name="materi[]"><?php for ($i=0; $i < count($team_teaching); $i++) { ?><?php foreach ($materi[$i] as $p) { ?><option value="<?php echo $p["id_materi"] ?>"><?php echo $p["nama_materi"] ?></option><?php } ?><?php } ?></select></div><div class="col-sm-2"><input type="number" min="0" max="<?php echo count($anggota_tt) ?>" name="kuota[]" value="0" class="form-control name_list" /></div><div class="col-sm-2"><input type="number" min="0" name="mudah[]" value="0" class="form-control name_list" /></div><div class="col-sm-2"><input type="number" min="0" name="sedang[]" value="0" class="form-control name_list" /></div><div class="col-sm-2"><input type="number" min="0" name="sulit[]" value="0" class="form-control name_list" /></div><div class="col-sm-2"><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></div><input type="hidden" name="status[]" value="baru" ></div>'); 
                   // $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
              });  
              $(document).on('click', '.btn_remove', function(){  
                   var button_id = $(this).attr("id");   
                   $('#row'+button_id+'').remove();  
              });

              $('#example1').datepicker({
                    format: "yyyy-mm-dd"
              });
              $('#example2').datepicker({
                    format: "yyyy-mm-dd"
              }); 
         });
         </script>