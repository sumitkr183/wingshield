<?php
	$data['title'] = "Verify Email";
	$this->load->view('includes/header',$data);
?>

<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="form-cover">
				<h3>VERIFY EMAIL</h3>
				<form action="" method="post">				  
				  <div class="form-group">
				    <label for="email">Email Address:</label>
				    <input type="email" class="form-control" name="email">
				  </div>			 
				  <button type="submit" class="btn btn-primary btn-block">Verify Email</button>
				  <div class="form-group text-center mg-5">
				  	<a href="<?= base_url() ?>">back</a>
				  </div>
				</form>
			</div>
		</div>
	</div>
</div>


<?php
	$this->load->view('includes/footer');
?>