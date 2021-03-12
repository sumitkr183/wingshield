<?php
	$data['title'] = "Register";
	$this->load->view('includes/header',$data);
?>

<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="form-cover">
				<h3>SIGN UP</h3>
				<form action="" method="post">
					<div class="form-group">
					    <label for="name">Full Name</label>
					    <input type="name" name="name" class="form-control" id="name">
				  	</div>
				  <div class="form-group">
				    <label for="email">Email Address:</label>
				    <input type="email" name="email" class="form-control" id="email">
				  </div>
				  <div class="form-group">
				    <label for="pwd">Password:</label>
				    <input type="password" name="password" class="form-control" id="pwd">
				  </div>			 
				  <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
				  <div class="form-group text-center mg-5">
				  	<a href="<?= base_url() ?>">Already have an account ?</a>
				  </div>
				</form>
			</div>
		</div>
	</div>
</div>


<?php
	$this->load->view('includes/footer');
?>