
<style type="text/css">
	
/*  bhoechie tab */
a {
    color: #e98227;
}
a:hover, a:focus {
	color: #e98227;
}
.list-group-item.active {
	border-color: #f79f51;
}
div.bhoechie-tab-container{
  z-index: 10;
  background-color: #ffffff;
  padding: 0 !important;
  border-radius: 4px;
  -moz-border-radius: 4px;
  border:1px solid #ddd;
  margin-top: 20px;
  margin-left: 50px;
  -webkit-box-shadow: 0 6px 12px rgba(0,0,0,.175);
  box-shadow: 0 6px 12px rgba(0,0,0,.175);
  -moz-box-shadow: 0 6px 12px rgba(0,0,0,.175);
  background-clip: padding-box;
  opacity: 0.97;
  filter: alpha(opacity=97);
}
div.bhoechie-tab-menu{
  padding-right: 0;
  padding-left: 0;
  padding-bottom: 0;
}
div.bhoechie-tab-menu div.list-group{
  margin-bottom: 0;
}
div.bhoechie-tab-menu div.list-group>a{
  margin-bottom: 0;
}
div.bhoechie-tab-menu div.list-group>a .glyphicon,
div.bhoechie-tab-menu div.list-group>a .fa {
  color: #e98227;
}
div.bhoechie-tab-menu div.list-group>a:first-child{
  border-top-right-radius: 0;
  -moz-border-top-right-radius: 0;
}
div.bhoechie-tab-menu div.list-group>a:last-child{
  border-bottom-right-radius: 0;
  -moz-border-bottom-right-radius: 0;
}
div.bhoechie-tab-menu div.list-group>a.active,
div.bhoechie-tab-menu div.list-group>a.active .glyphicon,
div.bhoechie-tab-menu div.list-group>a.active .fa{
  background-color: #e98227;
  background-image: #e98227;
  color: #ffffff;
}
div.bhoechie-tab-menu div.list-group>a.active:after{
  content: '';
  position: absolute;
  left: 100%;
  top: 50%;
  margin-top: -13px;
  border-left: 0;
  border-bottom: 13px solid transparent;
  border-top: 13px solid transparent;
  border-left: 10px solid #e98227;
}

div.bhoechie-tab-content{
  background-color: #ffffff;
  /* border: 1px solid #eeeeee; */
  padding-left: 20px;
  padding-top: 10px;
}

div.bhoechie-tab div.bhoechie-tab-content:not(.active){
  display: none;
}

.card {
	border: 2px solid #e98227
}
#checkboxes input[type=checkbox]{
    border: 2px solid #e98227
}

#checkboxes input[type=checkbox]:checked + .card{
    border: 2px solid #1eacbe;
}
</style>

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
                <form action="<?php echo base_url('review-soal') ?>" method="post" id="form_pilih_soal">
                <div class="row">
                	<div class="col-lg-11 col-md-10 col-sm-8 col-xs-9">
                		<input type="hidden" name="nama_matkul" value="<?php echo $materi[0]['nama_matkul'] ?>">
                    <input type="hidden" name="status_review" value="pilih">
                		<button style="background-color: #e98227;color: white;float: right;" type="submit" class="btn btn-default">Review</button>
                	</div>
                </div>
                <div class="row">
                    <div class="col-lg-11 col-md-10 col-sm-8 col-xs-9 bhoechie-tab-container">
			            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-2 bhoechie-tab-menu" style="float: left;">
			              <div class="list-group">
			              	<?php for ($i=0; $i < count($materi) ; $i++) { 
			              	if ($i == 0) {
			            		echo '<a href="#" class="list-group-item active text-center">';
			            	}else{
			            		echo '<a href="#" class="list-group-item text-center">';
			            	}?>
			                  <h4 class="glyphicon glyphicon-book"></h4><br/><?php echo $materi[$i]['nama_materi']?>
			                </a>
			            	<?php } ?>
			              </div>
			            </div>
			            
			            <div class="col-lg-8 col-md-7 col-sm-7 col-xs-7 bhoechie-tab" style="float: left;">
			            <?php $r=0;
			            for ($i=0; $i < count($materi) ; $i++) { 
			            	if ($i == 0) {
			            		echo '<div id="checkboxes" class="bhoechie-tab-content active">';
			            	}else{
			            		echo '<div id="checkboxes" class="bhoechie-tab-content">';
			            	}?>
			          <?php for ($j=0; $j < count($soal[$i]) ; $j++) { 
                        if ($soal[$i][$j]['soal']!='') {?>
			                	<input type="checkbox" name="id_soal[]" value="<?php echo $soal[$i][$j]['id_soal'] ?>" id="r<?php echo $r?>" hidden/>
			                    <label class="card" for="r<?php echo $r?>">
                            		<?php 
                            			echo $soal[$i][$j]['soal']; 
                            			$opsi = unserialize($soal[$i][$j]['opsi']);
                            		?>
                            		<div class="row">
		                            <?php 
		                                echo '<div class="col-sm-6 opsi">A. '.$opsi[0].'</div>';
		                                echo '<div class="col-sm-6 opsi">C. '.$opsi[2].'</div>';
		                            ?>
		                            </div>
		                            <div class="row">
		                            <?php 
		                                echo '<div class="col-sm-6 opsi">B. '.$opsi[1].'</div>';
		                                echo '<div class="col-sm-6 opsi">D. '.$opsi[3].'</div>';
		                            ?>
		                            </div>
		                            <div class="row">
		                            	<div style="height: fit-content;border-radius: 7px;border: 1px solid #ccc!important;margin: 0px 0px 0px 5px;text-align: right;color: #adadad;padding: 5px;"><?php echo $dosen[$i][$j];?></div>
		                            	 <div style="height: fit-content;border-radius: 7px;border: 1px solid #ccc!important;margin: 0px 60px 0px 5px;text-align: right;color: #adadad;padding: 5px;"><?php 
                                                $tanggal_soal = new DateTime($soal[$i][$j]['tanggal_buat']);
                                                echo $tanggal_soal->format('d-m-Y');?></div>
		                           		 </div>
                                </label>
                      <?php $r++;}
                      } ?>
			                </div>
			            <?php } ?>
			            </div>
			        </div>
                </div>
            	</form>
                <!-- End PAge Content -->
            </div>
            <div class="count-checkboxes-wrapper" style="z-index: 1000;position: fixed;right: 15px;bottom: 15px;">
                <div style="font-size: 60px;padding-top: 15px;width: 80px;height: 50px;background-color: #e98227;text-align: center;" id="count-checked-checkboxes">0</div>
                <div style="width: 80px;height: 20px;background-color: #e98227;text-align: center;font-weight: 600;">CHECKED</div>
            </div>
            <!-- End Container fluid  -->
            <!-- footer -->
            <footer class="footer"> © 2018 All rights reserved. Template designed by Colorlib</footer>
            <!-- End footer -->
        </div>
        <!-- End Page wrapper  -->
        <!-- multipage form -->
		<script type="text/javascript">
			$(document).ready(function() {
			    $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
			        e.preventDefault();
			        $(this).siblings('a.active').removeClass("active");
			        $(this).addClass("active");
			        var index = $(this).index();
			        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
			        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
			    });
			});
      $(document).ready(function(){

          var $checkboxes = $('#form_pilih_soal input[type="checkbox"]');
              
          $checkboxes.change(function(){
              var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
              $('#count-checked-checkboxes').text(countCheckedCheckboxes);
          });

      });
		</script>