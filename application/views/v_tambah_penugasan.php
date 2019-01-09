<link href="<?=base_url('assets/css/')?>penugasan.css" rel="stylesheet">
<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-muted">TAMBAH PENUGASAN</h3> 
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row">
                    <div class="col-xs-0 col-sm-2 col-lg-2"></div>
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="horizontal-form">
                                    <form class="form-horizontal" action="<?php echo base_url('proses-tambah-penugasan') ?>" method="post">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">Judul Penugasan</label>
                                            <div class="col-sm-10">
                                                 <input type="text" class="form-control" name="judul_tugas">
                                            </div>
                                        </div>
                                        <div class="form-group" id="dynamic_field">
                                            <!-- <div class="row" style="padding-left: 15px;font-size: 14px;">
                                                <label class="col-sm-4 control-label" style="padding-right: 0px;">Materi</label>
                                                <label class="col-sm-2 control-label" style="padding-right: 30px;">Mudah</label>
                                                <label class="col-sm-2 control-label" style="padding-right: 30px;">Sedang</label>
                                                <label class="col-sm-2 control-label" style="padding-right: 30px;">Sulit</label>
                                            </div> -->
                                            <div class="row" style="padding-left: 15px;">
                                                <div class="col-sm-4" style="padding-right: 0px;">
                                                     <label>Materi</label>
                                                     <select class="form-control name_list" name="materi[]">
                                                          <?php for ($i=0; $i < count($team_teaching); $i++) { ?>
                                                              <option disabled style="font-weight: 600;font-size: 11px;"><?php echo $team_teaching[$i]['nama_matkul'] ?></option>
                                                          <?php foreach ($materi[$i] as $p) { ?>
                                                              <option value="<?php echo $p['id_materi'] ?>"><?php echo $p['nama_materi'] ?></option>
                                                            <?php } ?>
                                                          <?php } ?>
                                                      </select>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label>Kuota</label>
                                                     <input type="number" min="1" name="kuota[]" value="1" class="form-control name_list" />
                                                </div>
                                                <div class="col-sm-2">
                                                    <label>Mudah</label>
                                                     <input type="number" min="0" name="mudah[]" value="0" class="form-control name_list" />
                                                </div>
                                                <div class="col-sm-2">
                                                    <label>Sedang</label>
                                                     <input type="number" min="0" name="sedang[]" value="0" class="form-control name_list" />
                                                </div>
                                                <div class="col-sm-2">
                                                    <label>Sulit</label>
                                                     <input type="number" min="0" name="sulit[]" value="0" class="form-control name_list" />
                                                </div>
                                                <div class="col-sm-2">
                                                     <button type="button" name="add" id="add" class="btn btn-success" style="margin-top: 35px;">Add More</button>
                                                </div>
                                            </div>
                                        </div>
                                      <?php if (count($team_teaching) > 1) {?>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Team teaching : </label>
                                            <select class="selectpicker" name="team_teaching">
                                                <?php for ($i=0; $i < count($team_teaching); $i++) { ?>
                                                  <option value="<?php echo $team_teaching[$i]['id_tt'] ?>"><?php echo $team_teaching[$i]['nama_matkul'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                      <?php } ?>
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">Batas Pengambilan</label>
                                            <div class="col-sm-10">
                                                 <input name="batas_pengambilan" type="text" class="form-control" placeholder="klik untuk membuka kalender"  id="example1">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">Batas Penugasan</label>
                                            <div class="col-sm-10">
                                                 <input name="batas_penugasan" type="text" class="form-control" placeholder="klik untuk membuka kalender"  id="example2">
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
              var i=1;  
              $('#add').click(function(){  
                   i++;  
                   $('#dynamic_field').append('<div id="row'+i+'" class="row" style="padding-left: 15px;margin-top: 10px;"><div class="col-sm-4" style="padding-right: 0px;"><select class="form-control name_list selectpicker" name="materi[]"><?php for ($i=0; $i < count($team_teaching); $i++) { ?><option disabled style="font-weight: 600;font-size: 11px;"><?php echo $team_teaching[$i]["nama_matkul"] ?></option><?php foreach ($materi[$i] as $p) { ?><option value="<?php echo $p["id_materi"] ?>"><?php echo $p["nama_materi"] ?></option><?php } ?><?php } ?></select></div><div class="col-sm-2"><input type="number" min="1" name="kuota[]" value="1" class="form-control name_list" /></div><div class="col-sm-2"><input type="number" min="0" name="mudah[]" value="0" class="form-control name_list" /></div><div class="col-sm-2"><input type="number" min="0" name="sedang[]" value="0" class="form-control name_list" /></div><div class="col-sm-2"><input type="number" min="0" name="sulit[]" value="0" class="form-control name_list" /></div><div class="col-sm-2"><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></div></div>'); 
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