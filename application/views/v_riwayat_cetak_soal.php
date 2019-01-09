
<!-- Page wrapper  -->
        <div class="page-wrapper" style="zoom: 95%;">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-muted">DAFTAR RIWAYAT CETAK SOAL</h3> 
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row">
                    <div class="col-lg-12 main-chart">
                        
                        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%" >
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Mata Kuliah</th>
                                    <th>Pencetak</th>
                                    <th>Tanggal Cetak</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Mata Kuliah</th>
                                    <th>Pencetak</th>
                                    <th>Tanggal Cetak</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                            <?php 
                                for ($i=0;$i<count($riwayat_cetak_soal);$i++) {?>
                                <tr>
                                    <td><?php echo $i+1 ?></td>
                                    <td><?php echo $riwayat_cetak_soal[$i]['nama_file_cetak'] ?></td>
                                    <td><?php echo $nama_matkul[$i] ?></td>
                                    <td><?php echo $nama_dosen[$i] ?></td>
                                    <td><?php echo date("m/d/Y", strtotime($riwayat_cetak_soal[$i]['tanggal_cetak'])); ?></td>
                                    <td><a href="<?php echo base_url('assets/cetak_soal/'.$riwayat_cetak_soal[$i]['nama_file_cetak'].'.docx') ?>"><button type="button" class="btn btn-theme" style="background-color: #e98227;color: white;"><i class="fa fa-pencil-square-o"></i> Download</button></a></td>
                                </tr>
                            <?php } ?>
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