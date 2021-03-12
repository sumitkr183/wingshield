<?php
	$data['title'] = "Verify OTP";
	$this->load->view('includes/header',$data);
?>

<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="form-cover">
				<h3>VERIFY OTP</h3>
				<form action="" method="post">				  
				  <div class="form-group">
				    <label for="otp">Enter OTP:</label>
				    <input type="number" class="form-control" name="otp">
				  </div>			 
				  <button type="submit" class="btn btn-primary btn-block">Verify OTP</button>
				  <div class="form-group text-center mg-5">
				  	<a href="<?= base_url() ?>verify-email">verify email ?</a>
				  </div>
				</form>
			</div>
		</div>
	</div>
</div>


<?php
	$this->load->view('includes/footer');
?>