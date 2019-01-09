
<!-- Page wrapper  -->
        <div class="page-wrapper" style="zoom: 95%;">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-muted">DAFTAR DOSEN</h3> 
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
                if($this->session->flashdata('aktif_msg')=="success"){
                    echo '<div class="alert alert-success" role="alert">Sukses mengaktifkan akun dosen</div>';
                }else if($this->session->flashdata('aktif_msg')=="failed"){
                    echo '<div class="alert alert-danger" role="alert">Gagal mengaktifkan akun dosen</div>';
                } 
                ?>
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row">
                    <div class="col-lg-12 main-chart">
                        
                        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%" >
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Username</th>
                                    <th>Mayor</th>
                                    <th>Minor</th>
                                    <th>Jabatan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Username</th>
                                    <th>Mayor</th>
                                    <th>Minor</th>
                                    <th>Jabatan</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                            <?php $i=1;
                                foreach ($dosen as $p) {
                                    $aktif = true;?>
                                <tr>
                                    <td><?php echo $i?></td>
                                    <td><?php echo $p['nip_dosen'] ?></td>
                                    <td><?php echo $p['nama_dosen'] ?></td>
                                    <td><?php echo $p['email_dosen'] ?></td>
                                    <td><?php echo $p['username'] ?></td>
                                    <td><?php $role = unserialize($p['role']);
                                    if (!in_array(0, $role)) {
                                        $kjfd = $this->m_kjfd->get_kjfd(array('id_kjfd'=>$p['keminatan_mayor']));
                                        if (isset($kjfd->nama_kjfd)) {
                                            echo $kjfd->nama_kjfd; 
                                        }else{
                                            echo '-';
                                        }
                                    }else{
                                        echo '-';
                                    }
                                    ?>
                                    </td>
                                    <td>
                                        <?php
                                        if (!in_array(0, $role)) {
                                            $minor = unserialize($p['keminatan_minor']);
                                            for ($j=0; $j <count($minor) ; $j++) { 
                                                $kjfd = $this->m_kjfd->get_kjfd(array('id_kjfd'=>$minor[$j]));
                                                if (isset($kjfd->nama_kjfd)) {
                                                    if ($j==count($minor)-1) {
                                                        echo $kjfd->nama_kjfd;
                                                    }else{
                                                        echo $kjfd->nama_kjfd.",";
                                                    }
                                                }else{
                                                    echo '-';
                                                }
                                                
                                            }
                                        }else{
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            
                                            for ($j=0; $j <count($role) ; $j++) { 
                                                if ($role[$j] == 0) {
                                                    echo "Belum Aktif";
                                                    $aktif = false;
                                                }
                                                if ($role[$j] == 1) {
                                                    echo "Kajur";
                                                }
                                                if ($role[$j] == 2) {
                                                    echo "Koordinator KJFD";
                                                }
                                                if ($role[$j] == 3) {
                                                    echo "Ketua Team Teaching";
                                                }
                                                if ($role[$j] == 4) {
                                                    echo "Dosen";
                                                }
                                                if ($j<(count($role)-1)) {
                                                    echo ", ";
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php if(!$aktif){?>
                                            <a href="<?php echo base_url('aktifkan/'.$p['id_dosen']) ?>"><button type="button" class="btn btn-theme" style="background-color: #e98227;color: white;"><i class="fa fa-pencil-square-o"></i> Aktifkan</button></a>
                                        <?php }else{ ?>
                                        <a href="<?php echo base_url('edit-dosen/'.$p['id_dosen']) ?>"><button type="button" class="btn btn-theme" style="background-color: #e98227;color: white;"><i class="fa fa-pencil-square-o"></i> Edit</button></a>
                                        <?php } ?>
                                        <button onclick="return hapus(<?php echo $p['id_dosen'] ?>)" type="button" class="btn btn-theme" style="background-color: #e98227;color: white;"><i class="fa fa-eraser"></i> Hapus</button>
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
                var url="<?php echo base_url().'index.php/c_dosen/proses_hapus_dosen/'?>";
                var r=confirm("Apakah anda yakin akan menghapus data ini!");
                
                if (r==true){
                    window.location.href = url+id;
                }
                return false;
            }
        </script>
        <!-- End Page wrapper  -->