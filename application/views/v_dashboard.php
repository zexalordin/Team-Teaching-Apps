        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-muted">Dashboard</h3>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-title" style="text-align: center;">
                                <canvas id="user-icon" width="150" height="150" style="border-radius: 100%;"></canvas>
                                <br><br>
                                <h4>SELAMAT DATANG <p style="font-weight: 600;color: #455a64;"><?php echo strtoupper($this->session->userdata('nama')) ?></p></h4>
                            </div>
                        </div>
                        <!-- /# card -->
                    </div>
                </div>
                <?php 
                $role = unserialize($this->session->userdata('role'));
                if (($key = array_search(1, $role)) !== false) { ?>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card bg-pink p-20">
                            <div class="media widget-ten">
                                <div class="media-left meida media-middle">
                                    <span><i class="ti-user f-s-40"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                    <h2 class="color-white"><?php echo $dosen ?></h2>
                                    <p class="m-b-0">Dosen</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-primary p-20">
                            <div class="media widget-ten">
                                <div class="media-left meida media-middle">
                                    <span><i class="ti-crown f-s-40"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                    <h2 class="color-white"><?php echo $kjfd ?></h2>
                                    <p class="m-b-0">KJFD</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success p-20">
                            <div class="media widget-ten">
                                <div class="media-left meida media-middle">
                                    <span><i class="ti-book f-s-40"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                    <h2 class="color-white"><?php echo $mk ?></h2>
                                    <p class="m-b-0">Mata Kuliah</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ketua team teaching -->
                <?php }if(($key = array_search(3, $role)) !== false){ 
                    for ($i=0; $i < count($tt); $i++) {?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-title">
                                        <h4 style="margin-left: 10px;margin-top: 25px;float: left;"><?php echo $tt[$i]['nama_matkul']; ?></h4> 
                                        <div class="border-head" style="text-align: right;">
                                            <a href="<?php echo base_url('evaluasi-bank-soal/'.$tt[$i]['id_tt']) ?>"><button type="button" class="btn btn-theme" style="background-color: #e98227;color: white;"><i class="fa fa-pencil"></i> Evaluasi</button></a>
                                        </div>
                                    </div>
                                    <div id="chartContainer<?php echo $i ?>" style="height: 360px; width: 100%;"></div>
                                </div>
                            </div>
                        </div>
                <!-- KJFD -->
              <?php }
                }if(($key = array_search(2, $role)) !== false){ ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card bg-primary p-20">
                            <div class="media widget-ten">
                                <div class="media-left meida media-middle">
                                    <span><i class="ti-crown f-s-40"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                    <h2 class="color-white"><?php echo $team_teaching ?></h2>
                                    <p class="m-b-0">Team</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Dosen -->
                <?php }if(($key = array_search(4, $role)) !== false){ ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card bg-primary p-20">
                            <div class="media widget-ten">
                                <div class="media-left meida media-middle">
                                    <span><i class="ti-crown f-s-40"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                    <h2 class="color-white"><?php echo $counter_penugasan ?></h2>
                                    <p class="m-b-0">Penugasan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>



                <!-- End PAge Content -->
            </div>
            <!-- End Container fluid  -->
            <!-- footer -->
            <footer class="footer"> © 2018 All rights reserved. Template designed by Colorlib</footer>
            <!-- End footer -->
        </div>
        <!-- End Page wrapper -->
        <script type="text/javascript">
        <?php for ($i=0; $i < count($tt); $i++) { ?>
            var chart = new CanvasJS.Chart("chartContainer<?php echo $i; ?>",
            {
              data: [
              {
                type: "bar",
                cursor:"pointer",
                click: onClick,          
                dataPoints: [
                <?php 
                    for ($j=count($materi[$i])-1; $j>=0  ; $j--) {
                        echo '{ label: "'.$materi[$i][$j]['nama_materi'].'", y: '.$countSoal[$i][$j].', link:"'.base_url('evaluasi-bank-soal/'.$tt[$i]['id_tt']).'?filterMateri='.$materi[$i][$j]['nama_materi'].'" },';
                    } 
                ?> 
                ]
              }
              ]
            });

            chart.render();
        <?php } ?>


            function onClick(e){ 
                    window.open(e.dataPoint.link,'_blank');  
            };
        </script>