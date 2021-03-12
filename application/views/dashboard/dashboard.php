<?php
	$data['title'] = "Dashboard";
	$this->load->view('includes/header',$data);
?>

    <div class="container">
        <div class="row">

        	<div class="col-md-12">
        		<div class="add-header">
        			<a href="<?= base_url() ?>add-employee" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Add Employee</a>
        		
        			<a href="<?= base_url() ?>add-category" class="btn btn-info"><i class="glyphicon glyphicon-plus"></i> Add Category</a>
        		</div>
        	</div>
                       
            <div class="col-md-12">
                <div class="table-responsive" style="margin-top: 5rem;">
                    <table class="table table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th>S No.</th>
                                <th>Name</th>
                                <th>Email Address</th>
                                <th>Category</th>
                                <th>Phone Number</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($employees as $employee) : ?>
                            	<tr>
                            		<td><?= $employee['id'] ?></td>
                            		<td><?= $employee['name'] ?></td>
                            		<td><?= $employee['email'] ?></td>
                            		<td><?= $this->DatabaseModel->getField('name','category',$employee['category_id']) ?></td>
                            		<td><?= $employee['phone'] ?></td>
                            		<td><?= $employee['created'] ?></td>
                            		<td>
                            			<a href="<?= base_url() ?>edit-employee/<?= $employee['id'] ?>" class="btn btn-primary" title="Edit">
                            				<span class="glyphicon glyphicon-pencil"></span>
                            			</a>
                            			<a href="<?= base_url() ?>delete-employee/<?= $employee['id'] ?>" onclick="return confirm('Are you sure you want to delete this emplyee?');" class="btn btn-danger" title="Delete">
                            				<span class="glyphicon glyphicon-trash"></span>
                            			</a>
                            		</td>
                            	</tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

<?php
	$this->load->view('includes/footer');
?>
