<?php
	$data['title'] = "Add Category";
	$this->load->view('includes/header',$data);
?>

<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="form-cover2">
				<h3>ADD CATEGORY</h3>
				<form action="" method="post">
					<div class="form-group">
					    <label for="name">Category Name</label>
					    <input type="name" name="name" class="form-control" id="name">
				  	</div>				 
				  <button type="submit" class="btn btn-primary btn-block">Add Category</button>
				  
				</form>
			</div>
		</div>
	</div>

	<div class="row">
		    <div class="col-md-12">
                <div class="table-responsive" style="margin-top: 5rem;">
                    <table class="table table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th>S No.</th>
                                <th>Name</th>                               
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($category)) : ?>
                            	<?php foreach($category as $value) : ?>
                            		<tr>
                            			<td><?= $value['id'] ?></td>
                            			<td><?= $value['name'] ?></td>
                            			<td><?= $value['created'] ?></td>
                            			<td>
                            				<a href="<?= base_url() ?>edit-category/<?= $value['id'] ?>" class="btn btn-primary" title="Edit">
                            				<span class="glyphicon glyphicon-pencil"></span>
	                            			</a>
	                            			<a href="<?= base_url() ?>delete-category/<?= $value['id'] ?>" onclick="return confirm('Are you sure you want to delete this category?');" class="btn btn-danger" title="Delete">
	                            				<span class="glyphicon glyphicon-trash"></span>
	                            			</a>
                            			</td>
                            		</tr>
                            	<?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
	</div>

</div>


<?php
	$this->load->view('includes/footer');
?>