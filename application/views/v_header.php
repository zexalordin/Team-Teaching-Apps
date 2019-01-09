<!-- header header  -->
        <div class="header">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- Logo -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="<?=base_url('dashboard')?>">
                        <!-- Logo icon -->
                        <b><img src="<?=base_url('assets/image/')?>logo2-mini-orange.png" alt="homepage" class="dark-logo" /></b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span><img src="<?=base_url('assets/image/')?>logo2-text2-orange.png" alt="homepage" class="dark-logo" /></span>
                    </a>
                </div>
                <!-- End Logo -->
                <div class="navbar-collapse">
                    <!-- toggle and nav items -->
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted  " href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                        <li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted  " href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                    </ul>
                    <!-- User profile and search -->
                    <ul class="navbar-nav my-lg-0">
                        <!-- Messages -->
                        <li class="nav-item dropdown">
                            <?php 
                                $count_notif = 0;
                                for ($i=0; $i <count($notifikasi) ; $i++) {
                                    for ($j=0; $j <count($notifikasi[$i]) ; $j++) { 
                                        $count_notif++;
                                    }
                                }
                            ?>
                            <a class="nav-link dropdown-toggle text-muted  " href="#" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-envelope"></i>
                            <?php if ($count_notif>0) {
                                echo '<div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>';
                            } ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox animated zoomIn" aria-labelledby="2">
                                <ul>
                                    <li>
                                        <div class="drop-title">Anda memiliki <?php echo $count_notif; ?> notifikasi</div>
                                    </li>
                                    <li>
                                        <div class="message-center">
                                        <?php
                                            for ($i=0; $i <count($notifikasi) ; $i++) {
                                                for ($j=0; $j <count($notifikasi[$i]); $j++) { 
                                        ?>
                                            <!-- Message -->
                                            <a href=" <?php echo $link_notif[$i][$j];?> ">
                                                <div class="mail-contnet">
                                                    <h5><?php echo $header_notif[$i];?></h5> 
                                                    <span class="mail-desc"></span><?php echo $notifikasi[$i][$j];?>
                                                </div>
                                            </a>
                                        <?php
                                                }
                                            }
                                        ?>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- End Messages -->
                        <li class="nav-item dropdown">
                            <a class="nav-link text-muted" aria-haspopup="true" aria-expanded="false" style="font-size: 13px;padding-left: 0.6rem;padding-right: 0.5rem;"> 
                                <?php echo strtoupper($this->session->userdata('nama')) ?>
                            </a>
                        </li>
                        <!-- Profile -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <canvas id="user-icon-mini" width="40" height="40" style="border-radius: 100%;"></canvas>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right animated zoomIn">
                                <ul class="dropdown-user">
                                    <li><a href="<?php echo base_url()."index.php/c_dosen/logout" ?>"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- End header header -->