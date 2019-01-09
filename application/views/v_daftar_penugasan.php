
<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-muted">PENUGASAN</h3> 
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
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-title">
                                    <h4>Penugasan</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover ">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Team Teaching</th>
                                                    <th>Judul</th>
                                                    <th>Materi</th>
                                                    <th>Batas Pengambilan</th>
                                                    <th>Batas Pengerjaan</th>
                                                    <th style="    text-align: left;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                            $i = 1;
                                            foreach ($penugasan as $p) { ?>
                                                <tr>
                                                    <th scope="row"><?php echo $i ?></th>
                                                    <td><?php echo $p['nama_matkul']?></td>
                                                    <td><?php echo $p['nama_penugasan']?></td>
                                                    <td><?php 
                                                        $materi = unserialize($p['materi_penugasan']);
                                                        echo count($materi);
                                                    ?></td>
                                                    <td><?php echo $p['batas_pengambilan'] ?></td>
                                                    <td><?php echo $p['batas_penugasan'] ?></td>
                                                    <td>
                                                        <a href="<?php echo base_url('detail-penugasan/'.$p['id_penugasan']) ?>"><button type="button" class="btn btn-theme" style="background-color: #e98227;color: white;"><i class="fa fa-pencil-square-o"></i> Detail</button></a>
                                                        <?php 
                                                            date_default_timezone_set("Asia/Jakarta");
                                                            $now = new DateTime();
                                                            $today = new DateTime($now->format('Y-m-d'));
                                                            $otherDate = new DateTime($p['batas_penugasan']);
                                                            $interval = date_diff($today, $otherDate);
                                                            if ($interval->format('%R%a')<=0) {?>
                                                                <a href="<?php echo base_url('evaluasi-penugasan/'.$p['id_penugasan']) ?>"><button type="button" class="btn btn-theme" style="background-color: #e98227;color: white;"><i class="fa fa-pencil-square-o"></i> Evaluasi</button></a>
                                                            <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php $i++;} ?>
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
            function hapus(id) {
                var url="<?php echo base_url().'index.php/c_matkul/hapus_matkul/'?>";
                var r=confirm("Apakah anda yakin akan menghapus data ini!");
                
                if (r==true){
                    window.location.href = url+id;
                }
                return false;
            }
        </script>
        <!-- End Page wrapper  -->