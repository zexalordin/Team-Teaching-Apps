<link href="<?=base_url('assets/css/')?>penugasan.css" rel="stylesheet">
<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-muted">TAMBAH MATERI</h3> 
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
                                    <form class="form-horizontal" action="<?php echo base_url('proses-tambah-materi') ?>" method="post">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">Nama Materi</label>
                                            <div class="col-sm-10">
                                                 <input type="text" class="form-control" name="nama_materi">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">Bab Materi</label>
                                            <div class="col-sm-10">
                                                 <input type="number" class="form-control" name="bab_materi" min="1" max="20" value="1">
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