<?php
	$data['title'] = "Edit Employee";
	$this->load->view('includes/header',$data);
?>

<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="form-cover2">
				<h3>EDIT EMPLOYEE</h3>
				<form action="" method="post">
					<div class="form-group">
					    <label for="name">Full Name</label>
					    <input type="name" value="<?= $employee[0]['name'] ?>" name="name" class="form-control" id="name">
				  	</div>
				  <div class="form-group">
				    <label for="email">Email Address:</label>
				    <input type="email" name="email" value="<?= $employee[0]['email'] ?>" class="form-control" id="email">
				  </div>
				  <div class="form-group">
				    <label>Category</label>
				    <select name="category" class="form-control">
				    	<option value="">-- Select Category --</option>
				    	<?php if(!empty($category)) : ?>
				    		<?php foreach($category as $value) : ?>
				    			<option value="<?= $value['id'] ?>" <?= $value['id'] == $employee[0]['category_id'] ? 'selected' : '' ?>><?= $value['name'] ?></option>
				    		<?php endforeach; ?>
				    	<?php endif; ?>
				    </select>
				  </div>
				  <div class="form-group">
				  	<label>Phone Number</label>
				  	<input type="number" value="<?= $employee[0]['phone'] ?>" name="phone" class="form-control">
				  </div>		 
				  <input type="hidden" name="id" value="<?= $employee[0]['id'] ?>">
				  <button type="submit" class="btn btn-primary btn-block">Update Employee</button>
				  
				</form>
			</div>
		</div>
	</div>
</div>


<?php
	$this->load->view('includes/footer');
?>