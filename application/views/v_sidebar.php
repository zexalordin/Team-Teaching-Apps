<!-- Left Sidebar  -->
        <div class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-devider"></li>
                        <li class="nav-label"></li>
                            <li> 
                                <a href="<?php echo base_url('dashboard') ?>" aria-expanded="false"><i class="fa fa-tachometer"></i><span>Dashboard</span></a>
                            </li>
                        <?php
                            $role = unserialize($this->session->userdata('role'));
                            if (($key = array_search(1, $role)) !== false) : ?>
                            <li> 
                               <span style="font-weight: 700;margin-left: 20px;font-size: 12px;">Ketua Jurusan</span>
                               <hr style="margin: 0px;">
                            </li>
                            <li> 
                                <a href="<?php echo base_url('daftar-dosen') ?>" aria-expanded="false"><i class="fa fa-check-square"></i><span>Pengaturan Dosen</span></a>
                            </li>
                            <li> 
                                <a href="<?php echo base_url('kjfd') ?>" aria-expanded="false"><i class="fa fa-book"></i><span>KJFD</span></a>
                            </li>
                            <li> 
                                <a href="<?php echo base_url('mata-kuliah') ?>" aria-expanded="false"><i class="fa fa-book"></i><span>Mata Kuliah</span></a>
                            </li>
                        <?php endif;
                            if(($key = array_search(2, $role)) !== false): ?>
                            <li> 
                               <span style="font-weight: 700;margin-left: 20px;font-size: 12px;">Ketua KJFD</span>
                               <hr style="margin: 0px;">
                            </li>
                            <li> 
                                <a href="<?php echo base_url('team-teaching') ?>" aria-expanded="false"><i class="fa fa-check-square"></i><span>Team Teaching</span></a>
                            </li>
                        <?php endif;
                            if(($key = array_search(3, $role)) !== false): ?>
                            <li> 
                               <span style="font-weight: 700;margin-left: 20px;font-size: 12px;">Ketua Team Teaching</span>
                               <hr style="margin: 0px;">
                            </li>
                            <li> 
                                <a href="<?php echo base_url('atur-materi') ?>" aria-expanded="false"><i class="fa fa-check-square"></i><span>Atur Materi</span></a>
                            </li>
                            <li> 
                                <a href="<?php echo base_url('atur-penugasan') ?>" aria-expanded="false"><i class="fa fa-check-square"></i><span>Atur Penugasan</span></a>
                            </li>
                            <li> 
                                <a href="<?php echo base_url('riwayat-cetak-soal') ?>" aria-expanded="false"><i class="fa fa-check-square"></i><span>Riwayat Cetak Soal</span></a>
                            </li>
                            <li> 
                                <a href="<?php echo base_url('cetak-soal') ?>" aria-expanded="false"><i class="fa fa-check-square"></i><span>Cetak Soal</span></a>
                            </li>
                        <?php endif;
                            if(($key = array_search(4, $role)) !== false): ?>
                            <li> 
                               <span style="font-weight: 700;margin-left: 20px;font-size: 12px;">Dosen</span>
                               <hr style="margin: 0px;">
                            </li>
                                <li> 
                                    <a href="<?php echo base_url('penugasan') ?>" aria-expanded="false"><i class="fa fa-check-square"></i><span>Penugasan</span><span class="badge badge-light" style="float: right;font-size: 14px;color: #ffffff;background-color: #e98227;"><?php echo $counter_penugasan; ?></span></a>
                                </li>
                            <?php endif;?>
<!-- 
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-tachometer"></i><span class="hide-menu">Dashboard <span class="label label-rouded label-primary pull-right">2</span></span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="index.html">Ecommerce </a></li>
                                <li><a href="index1.html">Analytics </a></li>
                            </ul>
                        </li> -->
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </div>
        <!-- End Left Sidebar  -->