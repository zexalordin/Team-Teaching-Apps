
<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-muted">TEAM TEACHING</h3> </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row">
                    <div class="col-lg-12 main-chart">
                        <table id="example" class="table table-striped table-bordered table-hover table-expandable table-striped" cellspacing="0" width="100%" >
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Mata Kuliah</th>
                                    <th>Ketua Team Teaching</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Mata Kuliah</th>
                                    <th>Ketua Team Teaching</th>
                                    <th>Action</th>
                                    <th>Anggota</th>
                                </tr>
                            </tfoot>
                            <tbody>
                            <?php $i=1;
                                foreach ($team_teaching as $tt) {?>
                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><?php echo $tt['nama_matkul'] ?></td>
                                    <td>
                                    <?php
                                        if ($tt['id_dosen']==0) {
                                            echo "Ketua tim belum dipilih";
                                        }else{
                                            echo $tt['nama_dosen'];
                                        }
                                    ?>    
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url('edit-team-teaching/'.$tt['id_tt'])?>"><button type="button" class="btn btn-theme" style="background-color: #e98227;color: white;"><i class="fa fa-pencil-square-o"></i> Edit</button></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" style="text-align: left;"><h4>Anggota Team Teaching <?php echo $tt['nama_matkul'] ?></h4>
                                    <ul>
                                    <?php 
                                    $nm_dosen = array();
                                    $anggota = unserialize($tt['anggota_tt']);
                                    for($j=0;$j<count($anggota);$j++) {
                                        foreach($dosen as $key => $product){
                                          if ( $product['id_dosen'] === $anggota[$j] )
                                             array_push($nm_dosen,$dosen[$key]['nama_dosen']);
                                        }
                                     } 
                                    ?>
                                    <?php 
                                        sort($nm_dosen);
                                        foreach ($nm_dosen as $d) {?>
                                            <li><?php echo "- ".$d ?></li>
                                    <?php }?>
                                     </ul>
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
        <!-- End Page wrapper  -->