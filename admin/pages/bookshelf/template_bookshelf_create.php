<div class="wrap">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-primary">
				  	<div class="panel-heading" style="display: flex;justify-content: space-between;align-items: center;">
				  		<h3>Create Book Shelf</h3>
				  		<a href="admin.php?page=shelf_list" class="btn btn-success">BookShelf List</a>
					</div>
				  <div class="panel-body">
				    <form method="post" id="quickForm">
				    	<div class="form-group">
				    		<label for="shelf_name">Shelf Name</label>
				    		<input type="text" class="form-control" id="shelf_name" name="shelf_name" required />
				    	</div>
				    	<div class="form-group">
				    		<label for="capacity">Capacity</label>
				    		<input type="number" class="form-control" id="capacity" name="capacity" required >
				    	</div>
				    	<div class="form-group">
				    		<label for="shelf_location">Shelf Location</label>
				    		<input type="text" class="form-control" id="shelf_location" name="shelf_location" required>
				    	</div>
				    	<div class="form-group">
				    		<label for="status">Status</label>
				    		<select name="status" class="form-control" id="status" required>
				    			<option value="1">Active</option>
				    			<option value="0">Inactive</option>
				    		</select>
				    	</div>
				    	<?php wp_nonce_field('new_book_shelf'); ?>
					  <button type="submit" class="btn btn-primary" name="create_book_shelf">Submit</button>
					</form>

					<?php
					if(! isset($_POST['create_book_shelf'])){
			            return;
			        }

			        if(! wp_verify_nonce($_POST['_wpnonce'], 'new_book_shelf')){
			            wp_die('<div class="alert alert-warning" role="alert">Are you cheating?</div>');
			        }

			        if(! current_user_can('manage_options')){
			            wp_die('<div class="alert alert-warning" role="alert">Are you cheating?</div>');
			        }
					if(isset($_POST['create_book_shelf'])){

						$data['shelf_name'] = isset($_POST['shelf_name']) ? sanitize_text_field($_POST['shelf_name']) : '';
				        $data['capacity'] = isset($_POST['capacity']) ? sanitize_textarea_field($_POST['capacity']) : '';
				        $data['shelf_location'] = isset($_POST['shelf_location']) ? sanitize_text_field($_POST['shelf_location']) : '';
				        $data['status'] = isset($_POST['status']) ? sanitize_text_field($_POST['status']) : '';

						global $wpdb;

						$inserted = $wpdb->insert(
							"{$wpdb->prefix}book_shelf_table",
							$data,
							[
								'%s','%d','%s','%d'
							]
						);

						if($inserted){
							echo '<div class="alert alert-success" role="alert">Data Insert Success</div>';
						}else{
							echo '<div class="alert alert-danger" role="alert">Data Not Insert</div>';
						}
					}
					?>
				  </div>
				</div>
			</div>
			<div class="col-md-6"></div>
		</div>
	</div>
</div>


<script>
$(function () {
  $('#quickForm').validate({
    rules: {
      shelf_name: {
        required: true,
        maxlength:60,
      },
      capacity:{
        required: true,
        number:true,
        maxlength:8,
      },
      shelf_location:{
      	required: true,
      	maxlength: 60
      },
      status:{
      	required:true
      }
    },
    messages: {
      shelf_name: {
        required: "Please enter shelf name",
        maxlength: "Your shelf name must be at least 60 characters long"
      },
      capacity:{
        required: "Please enter shelf capacity",
        number: "Invalid capacity",
        maxlength: "Your capacity must be at least 8 digit long"
      },
      shelf_location: {
        required: "Please enter shelf location",
        maxlength: "Your shelf location must be at least 60 characters long"
      },
      status:{
      	required: "Please select status",
      }
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});
</script>