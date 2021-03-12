<?php
    $data['title'] = "Edit Category";
    $this->load->view('includes/header',$data);
?>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="form-cover2">
                <h3>Edit CATEGORY</h3>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="name">Category Name</label>
                        <input type="name" name="name" value="<?= $category[0]['name'] ?>" class="form-control" id="name">
                    </div>               
                    <input type="hidden" name="id" value="<?= $category[0]['id'] ?>">
                  <button type="submit" class="btn btn-primary btn-block">Edit Category</button>
                  
                </form>
            </div>
        </div>
    </div>

</div>


<?php
    $this->load->view('includes/footer');
?>