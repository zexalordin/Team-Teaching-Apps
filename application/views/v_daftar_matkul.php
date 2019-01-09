
<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-muted">DAFTAR MATA KULIAH</h3> 
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <?php 
                if($this->session->flashdata('delete_msg')=="success"){
                    echo '<div class="alert alert-success" role="alert">Sukses menghapus data</div>';
                }else if($this->session->flashdata('delete_msg')=="failed"){
                    echo '<div class="alert alert-danger" role="alert">Gagal menghapus data</div>';
                }
                if($this->session->flashdata('input_msg')=="success"){
                    echo '<div class="alert alert-success" role="alert">Sukses menambah data</div>';
                }else if($this->session->flashdata('input_msg')=="failed"){
                    echo '<div class="alert alert-danger" role="alert">Gagal menambah data</div>';
                } ?>
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row">
                    <div class="col-lg-12 main-chart">
                        <div class="border-head" style="margin-bottom: 25px;text-align: right;">
                            <a href="<?php echo base_url('tambah-matkul') ?>"><button type="button" class="btn btn-theme" style="background-color: #e98227;color: white;"><i class="fa fa-pencil"></i> Tambah</button></a>
                        </div>
                        
                        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%" >
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Kuliah</th>
                                    <th>Mata Kuliah</th>
                                    <th>KJFD</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Kuliah</th>
                                    <th>Mata Kuliah</th>
                                    <th>KJFD</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                            <?php $i=1;
                                foreach ($matkul as $m) {?>
                                <tr>
                                    <td><?php echo $i?></td>
                                    <td><?php echo $m['kode_matkul'] ?></td>
                                    <td><?php echo $m['nama_matkul'] ?></td>
                                    <td><?php echo $m['nama_kjfd'] ?></td>
                                    <td>
                                        <a href="<?php echo base_url('edit-matkul/'.$m['id_matkul']) ?>"><button type="button" class="btn btn-theme" style="background-color: #e98227;color: white;"><i class="fa fa-pencil-square-o"></i> Edit</button></a>
                                        <button onclick="return hapus(<?php echo $m['id_matkul'] ?>)" type="button" class="btn btn-theme" style="background-color: #e98227;color: white;margin-left: 15px;"><i class="fa fa-eraser"></i> Hapus</button>
                                    </td>
                                </tr>
                            <?php $i++; } ?>
                            </tbody>
                        </table>
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
            function hapus(id) {
                var url="<?php echo base_url().'index.php/c_matkul/proses_hapus_matkul/'?>";
                var r=confirm("Apakah anda yakin akan menghapus data ini!");
                
                if (r==true){
                    window.location.href = url+id;
                }
                return false;
            }
        </script>
        <!-- End Page wrapper  -->