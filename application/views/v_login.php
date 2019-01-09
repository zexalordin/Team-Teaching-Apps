<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="utf-8">
		<title>Team Teaching APPS</title>
		<!-- Bootstrap  -->
		
		<link rel="stylesheet" href="<?=base_url('assets/css/')?>login.css">
		<link href="<?=base_url('assets/css/')?>material-bootstrap-wizard.css" rel="stylesheet">
	</head>

	<body>
		<div class="am-signin-wrapper">
			<div class="am-signin-box">
				<div class="row no-gutters">
					<div class="col-lg-5">
						<div>
							<img class="img-responsive img-responsive-center wd-200 mg-b-10" src="<?=base_url('assets/image/')?>logo-orange.png">
							<!--<p class="tx-light">'A new year, a new start and a new way to go!' </p>-->

							<hr>
							<p>Don't have an account?
								<br>
								<a href="#" id="btn-reg">Register</a>
							</p>
						</div>
					</div>
					<div class="col-lg-7">
						<div class="login">
							<form action="<?php echo base_url()."index.php/c_dosen/validasi" ?>" method="post">
								<h5 class="tx-gray-800 mg-b-25">Signin to Your Account</h5>
								<?php 
								if($this->session->flashdata('login_msg')=="tidakterdaftar"){
				                    echo '<div class="alert alert-danger" role="alert">Maaf, Username atau Password anda salah, Silahkan diisi dengan tepat.</div>';
				                }else if($this->session->flashdata('login_msg')=="tidakaktif"){
				                    echo '<div class="alert alert-warning" role="alert">akun anda tidak aktif, silahkan hubungi ketua jurusan.</div>';
				                }
								if($this->session->flashdata('register_msg')=="username_dipakai"){
				                    echo '<div class="alert alert-danger" role="alert">Maaf username yang anda masukkan telah dipakai.</div>';
				                }else if($this->session->flashdata('register_msg')=="email_dipakai"){
				                    echo '<div class="alert alert-danger" role="alert">Maaf email yang anda masukkan telah dipakai.</div>';
				                }else if($this->session->flashdata('register_msg')=="success"){
				                	echo '<div class="alert alert-success" role="alert">Pendaftaran berhasil, mohon menunggu aktivasi untuk dapat login ke sistem</div>';
				                }
				                ?>
								<div class="form-group">
									<label class="form-control-label">Username:</label>
									<input type="text" name="username" class="form-control" placeholder="Enter your username" required>
								</div>
								<!-- form-group -->

								<div class="form-group">
									<label class="form-control-label">Password:</label>
									<input type="password" name="password" class="form-control" placeholder="Enter your password" required>
								</div>
								<!-- form-group -->

								<button type="submit" class="btn btn-block">Sign In</button>
							</form>
						</div>
						<div class="register" style="display:none">
							<form method="post" action="<?php echo base_url()."index.php/c_dosen/register" ?>">
								<h5 class="tx-gray-800 mg-b-25">Sign up your account</h5>
								
								<div class="form-group">
									<input type="text" name="nama" class="form-control" placeholder="Enter your name" required>
								</div>
								<div class="form-group">
									<input type="number" name="nip" class="form-control" placeholder="Enter your NIP" required>
								</div>
								<div class="form-group">
									<label class="sr-only" for="exampleInputEmail2">Email</label>
									<input type="email" name="email" class="form-control" placeholder="Email" id="Enter your email" required>
								</div>
								<div class="form-group">
									<input type="text" name="username" class="form-control" placeholder="Enter your username" required>
								</div>
								<!-- form-group -->

								<div class="form-group">
									<input type="password" name="password" class="form-control" placeholder="Enter your password" required>
								</div>
								<div class="form-group mg-b-20">
									<a href="#" class="btn-login">Sign in</a>
								</div>
								<button class="btn btn-default btn-block" name="b_reg" type="submit">Register</button>
							</form>
						</div>
					</div>
					<!-- col-7 -->

				</div>
				<!-- row -->
			</div>
			<!-- signin-box -->
		</div>
		<!-- am-signin-wrapper -->
		<!-- jQuery -->
		<script src="<?php echo base_url()."assets/js/"?>jquery-3.2.1.js"></script>
		<!-- Bootstrap -->
		<script src="<?php echo base_url()."assets/js/"?>bootstrap.min.js"></script>
		<script>
		$(".btn-login").on("click",function(){$(".register").hide();$(".reset").hide();$(".login").show();});
		$("#btn-reg").on("click",function(){$(".login").hide();$(".reset").hide();$(".register").show();});
		</script>
	</body>

	</html>
