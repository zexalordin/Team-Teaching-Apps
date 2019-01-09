
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
                if($this->session->flashdata('tutup_msg')=="success"){
                    echo '<div class="alert alert-success" role="alert">Sukses menutup evaluasi</div>';
                }else if($this->session->flashdata('tutup_msg')=="failed"){
                    echo '<div class="alert alert-danger" role="alert">Gagal menutup evaluasi</div>';
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
                            <a href="<?php echo base_url('tambah-penugasan') ?>"><button type="button" class="btn btn-theme" style="background-color: #e98227;color: white;"><i class="fa fa-pencil"></i> Tambah</button></a>
                        </div>
                    <?php for ($i=0; $i < count($team_teaching) ; $i++) {
                        if(count($penugasan[$i])>0){?>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-title">
                                    <h4>Penugasan <?php echo $penugasan[$i][0]['nama_matkul']; ?></h4> 
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover ">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Judul</th>
                                                    <th>Materi</th>
                                                    <th>Batas Pengambilan</th>
                                                    <th>Batas Pengerjaan</th>
                                                    <th style="text-align: left;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                            $j = 1;
                                            foreach ($penugasan[$i] as $p) { ?>
                                                <tr>
                                                    <th scope="row"><?php echo $j ?></th>
                                                    <td><?php echo $p['nama_penugasan']?></td>
                                                    <td><?php 
                                                        $materi = unserialize($p['materi_penugasan']);
                                                        echo count($materi);
                                                    ?></td>
                                                    <td><?php echo $p['batas_pengambilan'] ?></td>
                                                    <td><?php echo $p['batas_penugasan'] ?></td>
                                                    <?php if ($p['status_penugasan'] == 0) { ?>
                                                    <td>
                                                        <?php
                                                            date_default_timezone_set("Asia/Jakarta");
                                                            $now = new DateTime();
                                                            $today = new DateTime($now->format('Y-m-d'));
                                                            $otherDate = new DateTime($p['batas_penugasan'] );
                                                            $interval = date_diff($today, $otherDate);
                                                        if($interval->format('%R%a')<=0){ ?>
                                                            <a href="<?php echo base_url('tutup-evaluasi/'.$p['id_penugasan']) ?>" onclick="return confirm('Apakah anda yakin untuk menutup evaluasi penugasan ini?');"><button type="button" class="btn btn-theme" style="background-color: #e98227;color: white;"><i class="fa fa-pencil-square-o"></i> Tutup evaluasi</button></a>
                                                    <?php } ?>

                                                        <a href="<?php echo base_url('progres-penugasan/'.$p['id_penugasan']) ?>"><button type="button" class="btn btn-theme" style="background-color: #e98227;color: white;"><i class="fa fa-pencil-square-o"></i> Lihat Progres</button></a>

                                                        <a href="<?php echo base_url('edit-penugasan/'.$p['id_penugasan']) ?>"><button type="button" class="btn btn-theme" style="background-color: #e98227;color: white;"><i class="fa fa-pencil-square-o"></i> Edit</button></a>
                                                    <?php if($interval->format('%R%a')>0){ ?>
                                                        <button onclick="return hapus(<?php echo $p['id_penugasan'] ?>)" type="button" class="btn btn-theme" style="background-color: #e98227;color: white;margin-left: 15px;"><i class="fa fa-eraser"></i> Hapus</button>
                                                    <?php } ?>
                                                    </td>
                                                    <?php } ?>
                                                </tr>
                                            <?php $j++;} ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- /# card -->
                        </div>
                    <?php }else{
                        echo '
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-title">
                                    <h4>Belum ada penugasan yang dibuat untuk team teaching '.$team_teaching[$i]['nama_matkul'].'</h4> 
                                </div>
                            </div>
                        </div>';
                    }
                } ?>
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
                var url="<?php echo base_url().'index.php/c_penugasan/proses_hapus_penugasan/'?>";
                var r=confirm("Apakah anda yakin akan menghapus data ini!");
                
                if (r==true){
                    window.location.href = url+id;
                }
                return false;
            }
        </script>
        <!-- End Page wrapper  -->