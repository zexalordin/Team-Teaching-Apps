
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
                    }else if($this->session->flashdata('edit_msg')=="nama_dipakai"){
                        echo '<div class="alert alert-danger" role="alert">Gagal mengubah data, nama KJFD telah digunakan</div>';
                    } ?>
                <!-- Start Page Content -->
                <div class="row">
                    <div class="col-xs-0 col-sm-3 col-lg-3"></div>
                    <div class="col-xs-12 col-sm-6 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="horizontal-form">
                                    <form class="form-horizontal" action="<?php echo base_url('index.php/c_kjfd/proses_edit_kjfd/'.$kjfd->id_kjfd.'/'.$kjfd->id_dosen) ?>" method="post">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">Nama KJFD</label>
                                            <div class="col-sm-10">
                                                 <input type="text" class="form-control" name="nama_kjfd" value="<?php echo $kjfd->nama_kjfd ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">DOSEN</label>
                                            <select class="selectpicker" data-show-subtext="true" data-live-search="true" name="dosen">
                                                <?php foreach ($dosen as $d) {?>
                                                    <?php $role = unserialize($d['role']);?>
                                                        <?php if ($kjfd->id_dosen == $d['id_dosen']): ?>
                                                            <option value="<?php echo $d['id_dosen']?>" selected><?php echo $d['nama_dosen'] ?></option>
                                                        <?php elseif((array_search(1, $role) === false) && (array_search(2, $role) === false)): ?>
                                                            <option value="<?php echo $d['id_dosen']?>"><?php echo $d['nama_dosen'] ?></option>
                                                        <?php endif ?>
                                                    
                                                <?php } ?>
                                                
                                            </select>
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