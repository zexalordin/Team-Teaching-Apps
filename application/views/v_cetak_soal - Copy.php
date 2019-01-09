
<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-muted">MATERI</h3> 
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
                    <form action="<?php echo base_url('cetak-soal') ?>" method="GET">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Jumlah soal</label>
                            <div class="row" style="margin-left: 5px;">
                                <div class="col-sm-1">
                                    <?php 
                                        $jum_soal = 50;
                                        if (isset($_GET['jum_soal'])) {
                                            $jum_soal = $_GET['jum_soal'];
                                        }
                                    ?>
                                    <input type="number" min="0" class="form-control" name="jum_soal" value="<?php echo $jum_soal ?>">
                                </div>
                                <div class="col-sm-2">
                                    <button style="background-color: #e98227;color: white;" type="submit" class="btn btn-default">Ubah</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php for ($i=0; $i < count($team_teaching) ; $i++) { ?>
                    <form action="<?php echo base_url('review-soal') ?>" method="post">
                        <input type="hidden" name="status_review" value="acak">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-title">
                                    <h4 style="margin-left: 10px;margin-top: 25px;float: left;">Materi - <?php echo $materi[$i][0]['nama_matkul']; ?></h4> 
                                    <div class="border-head" style="text-align: right;">
                                        <a href="<?php echo base_url('pilih-cetak-soal/'.$team_teaching[$i]['id_tt']) ?>"><button type="button" class="btn btn-theme" style="background-color: #e98227;color: white;"><i class="fa fa-pencil"></i> Pilih Soal</button></a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover ">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nama Materi</th>
                                                    <th>Soal Tersedia</th>
                                                    <th>Mudah</th>
                                                    <th>Sedang</th>
                                                    <th style="text-align: left;">Sulit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                            for ($j=0; $j < count($materi[$i]); $j++) { ?>
                                                <tr>
                                                    <th scope="row"><?php echo $j+1 ?></th>
                                                    <td><?php echo $materi[$i][$j]['nama_materi']?></td>
                                                    <?php $persen_soal = (count($soal[$i][$j])/$jum_soal)*100; ?>
                                                    <td><?php echo count($soal[$i][$j])."(".number_format($persen_soal,2)."%)" ?></td>
                                                    <td>
                                                        <?php 
                                                        $sulit = 0;
                                                        $sedang = 0;
                                                        $mudah = 0;
                                                        for ($k=0; $k <count($soal[$i][$j]) ; $k++) { 
                                                            if($soal[$i][$j][$k]['soal'] != ''){
                                                                if ($soal[$i][$j][$k]['tingkat_kesulitan'] == 0)
                                                                    $mudah++;
                                                                else if($soal[$i][$j][$k]['tingkat_kesulitan'] == 1)
                                                                    $sedang++;
                                                                else
                                                                    $sulit++;
                                                            }
                                                        } ?>
                                                        <select id="selectSoal<?php echo $i.''.$j?>_mudah" class="form-control name_list" name="jum_soal_mudah[]" onchange="hitungSoal(<?php echo $i.','.count($materi[$i])?>)">
                                                        <?php for ($k=0; $k <=$mudah ; $k++) { 
                                                            $persen_soal = ($k/$jum_soal)*100; ?>
                                                            <option value="<?php echo $k ?>"><?php echo number_format($persen_soal,2) ?></option>
                                                        <?php } ?>
                                                        </select>
                                                        <?php echo "max : ".$mudah." (".number_format($persen_soal,2)."%)" ?>
                                                    </td>
                                                    <td>
                                                        <select id="selectSoal<?php echo $i.''.$j?>_sedang" class="form-control name_list" name="jum_soal_sedang[]" onchange="hitungSoal(<?php echo $i.','.count($materi[$i])?>)">
                                                        <?php for ($k=0; $k <=$sedang ; $k++) { 
                                                            $persen_soal = ($k/$jum_soal)*100; ?>
                                                            <option value="<?php echo $k ?>"><?php echo number_format($persen_soal,2) ?></option>
                                                        <?php } ?>
                                                        </select>
                                                         <?php echo "max : ".$sedang." (".number_format($persen_soal,2)."%)" ?>
                                                    </td>
                                                    <td>
                                                       <select id="selectSoal<?php echo $i.''.$j?>_sulit" class="form-control name_list" name="jum_soal_sulit[]" onchange="hitungSoal(<?php echo $i.','.count($materi[$i])?>)">
                                                        <?php for ($k=0; $k <=$sulit ; $k++) { 
                                                            $persen_soal = ($k/$jum_soal)*100; ?>
                                                            <option value="<?php echo $k ?>"><?php echo number_format($persen_soal,2) ?></option>
                                                        <?php } ?>
                                                        </select>
                                                        <?php echo "max : ".$sulit." (".number_format($persen_soal,2)."%)" ?>
                                                        <input type="hidden" name="id_materi[]" value="<?php echo $materi[$i][$j]['id_materi'] ?>">
                                                        <input type="hidden" name="nama_matkul" value="<?php echo $materi[$i][0]['nama_matkul'] ?>">
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                                <tr>
                                                    <th></th>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <div>
                                                            <button disabled id="review" style="background-color: #e98227;color: white;" type="submit" class="btn btn-default">Review</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- /# card -->
                        </div>
                    </form>
                    <?php } ?>
                    </div>  
                </div>
                <!-- End PAge Content -->
            </div>
            <div class="count-checkboxes-wrapper" style="z-index: 1000;position: fixed;right: 15px;bottom: 15px;">
                <div style="font-size: 25px;padding-top: 15px;width: 80px;height: 50px;background-color: #e98227;text-align: center;" id="count-checked-checkboxes">0</div>
                <div style="width: 80px;height: 20px;background-color: #e98227;text-align: center;font-weight: 600;">PERSEN</div>
            </div>
            <!-- End Container fluid  -->
            <!-- footer -->
            <footer class="footer"> © 2018 All rights reserved. Template designed by Colorlib</footer>
            <!-- End footer -->
        </div>

        <script type="text/javascript">
            function hapus(id) {
                var url="<?php echo base_url().'index.php/c_materi/proses_hapus_materi/'?>";
                var r=confirm("Apakah anda yakin akan menghapus data ini!");
                
                if (r==true){
                    window.location.href = url+id;
                }
                return false;
            }
            function hitungSoal(i,materi) {
                var jum_soal = <?php echo $jum_soal ?>;
                var input = 0;
                //console.log("materi : "+materi);
                for (var j = 0; j < materi; j++) {
                    var x = document.getElementById("selectSoal"+i+""+j+"_mudah").value;
                    var y = document.getElementById("selectSoal"+i+""+j+"_sedang").value;
                    var z = document.getElementById("selectSoal"+i+""+j+"_sulit").value;
                    console.log("x-"+x);
                    console.log("y-"+y);
                    console.log("z-"+z);
                    input = parseInt(input)+parseInt(x)+parseInt(y)+parseInt(z);
                }
                var persen = (input/jum_soal)*100;
                if (persen!=100) {
                    document.getElementById("review").disabled = true;
                }else{
                    document.getElementById("review").disabled = false;
                }
                $('#count-checked-checkboxes').text(persen.toFixed(2));
            }
        </script>
        <!-- End Page wrapper  -->

