
<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-muted">AKTIVASI DOSEN</h3> 
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
                                    <form class="form-horizontal" action="<?php echo base_url('index.php/c_dosen/proses_aktivasi/'.$dosen->id_dosen) ?>" method="post">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">Nama</label>
                                            <div class="col-sm-10">
                                                 <input type="text" class="form-control" value="<?php echo $dosen->nama_dosen ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Keminatan Mayor</label>
                                            <select class="selectpicker" data-show-subtext="true" data-live-search="true" name="mayor">
                                                <?php foreach ($kjfd as $k) {?>
                                                    <option value="<?php echo $k['id_kjfd']?>"><?php echo $k['nama_kjfd'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">Keminatan Minor</label>
                                            <select id="team_teaching" name="minor[]" multiple class="form-control" >
                                                <?php foreach ($kjfd as $k) {?>
                                                    <option value="<?php echo $k['id_kjfd']?>"><?php echo $k['nama_kjfd'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10" style="text-align: right;">
                                                <button type="submit" class="btn btn-default">Aktifkan</button>
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
              nonSelectedText: 'Pilih Minor',
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