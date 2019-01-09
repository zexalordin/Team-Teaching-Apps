
<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-muted">EDIT KJFD</h3> 
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
                    } ?>
                <!-- Start Page Content -->
                <div class="row">
                    <div class="col-xs-0 col-sm-3 col-lg-3"></div>
                    <div class="col-xs-12 col-sm-6 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="horizontal-form">
                                    <form id="team_teaching_form" class="form-horizontal" method="post" action="<?php echo base_url('proses-edit-team-teaching/'.$team_teaching->id_tt) ?>">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">Mata Kuliah</label>
                                            <div class="col-sm-10">
                                                 <input type="text" class="form-control" name="nama_kjfd" value="<?php echo $team_teaching->nama_matkul ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">Ketua Team Teaching</label>
                                            <select class="selectpicker" data-show-subtext="true" data-live-search="true" name="ketua_tt">
                                <?php foreach ($dosen as $d) {
                                      $minor = unserialize($d['keminatan_minor']);
                                        if ($d['keminatan_mayor'] == $team_teaching->id_kjfd || in_array($team_teaching->id_kjfd,$minor)){
                                              if ($team_teaching->id_dosen == $d['id_dosen']): ?>
                                                <option disabled value="<?php echo $d['id_dosen']?>" selected><?php echo $d['nama_dosen'] ?></option>
                                        <?php else: ?>
                                                <option value="<?php echo $d['id_dosen']?>"><?php echo $d['nama_dosen'] ?></option>
                                        <?php endif; 
                                        } 
                                      }?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">Anggota Team Teaching</label>
                                            <select id="team_teaching" name="team_teaching[]" multiple class="form-control" >
                                <?php foreach ($dosen as $d) {
                                      $minor = unserialize($d['keminatan_minor']);
                                        if ($d['keminatan_mayor'] == $team_teaching->id_kjfd || in_array($team_teaching->id_kjfd,$minor)){
                                          $anggota_tt = unserialize($team_teaching->anggota_tt);
                                            if (in_array($d['id_dosen'],$anggota_tt) || $d['id_dosen'] == $team_teaching->id_dosen) :?>
                                              <option value="<?php echo $d['id_dosen']?>" selected><?php echo $d['nama_dosen'] ?></option>
                                      <?php else : ?>
                                              <option value="<?php echo $d['id_dosen']?>"><?php echo $d['nama_dosen'] ?></option>
                                                  <?php 
                                            endif;
                                        } 
                                      } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10" style="text-align: right;">
                                                <button type="submit" class="btn btn-default" name="submit" value="Submit">Simpan</button>
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
        <script>
            $(document).ready(function(){
             $('#team_teaching').multiselect({
              nonSelectedText: 'Pilih Anggota',
              enableFiltering: true,
              enableCaseInsensitiveFiltering: true,
              buttonWidth:'290px',
             });
             
             // $('#team_teaching_form').on('submit', function(event){
             //  event.preventDefault();
             //  var form_data = $(this).serialize();
             //  $.ajax({
             //   url:"<?php //echo base_url('proses-edit-team-teaching/'.$team_teaching->id_tt) ?>",
             //   method:"POST",
             //   data:form_data,
             //   success:function(data)
             //   {
             //    location.reload();
             //   }
             //  });
             // });
            });
        </script>
        <!-- End Page wrapper  -->