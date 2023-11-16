<div class="wrap">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6">
				<?php
			  	if(isset($_GET['action']) && $_GET['action']== 'edit' && isset($_GET['id'])){
			  		$edit_id = $_GET['id'];

			  		global $wpdb;

			  		$get_book = $wpdb->get_row(
						"SELECT * FROM {$wpdb->prefix}book_table WHERE id={$edit_id} ORDER BY id DESC"
					);
			  	}
			  	?>
				<div class="panel panel-primary">
				  <div class="panel-heading" style="display: flex;justify-content: space-between;align-items: center;">
				  		<h3>Edit Book - <?php echo $get_book->name; ?></h3>
				  		<a href="admin.php?page=book_list" class="btn btn-success">Book List</a>
					</div>
				  <div class="panel-body">
				    <form method="post">
				    	<div class="form-group">
				    		<label for="name">Name</label>
				    		<input type="text" class="form-control" id="name" name="name" value="<?php echo $get_book->name; ?>" required />
				    	</div>
				    	<div class="form-group">
				    		<label for="amount">Amount</label>
				    		<input type="number" class="form-control" id="amount" name="amount" value="<?php echo $get_book->amount; ?>" required >
				    	</div>
				    	<div class="form-group">
				    		<label for="publication">Publication</label>
				    		<input type="text" class="form-control" id="publication" name="publication" value="<?php echo $get_book->publication ?>" required >
				    	</div>
				    	<div class="form-group">
				    		<label for="description">Description</label>
				    		<textarea class="form-control" id="description" name="description" required ><?php echo $get_book->description; ?></textarea>
				    	</div>
				    	<div class="row">
				    		<div class="col-md-6">
				    			<div class="form-group">
						    		<label for="language">Language</label>
						    		<select name="language" class="form-control" id="language" required=>
						    			<option value="Bangla" <?php echo $selected = ($get_book->language == 'Bangla')?'selected':''; ?> >Bangla</option>
						    			<option value="English" <?php echo $selected = ($get_book->language == 'English')?'selected':''; ?>>English</option>
						    		</select>
						    	</div>
				    		</div>
				    		<div class="col-md-6">
				    			<div class="form-group">
						    		<label for="status">Status</label>
						    		<select name="status" class="form-control" id="status" required >
						    			<option value="1" <?php echo $selected = ($get_book->status == '1')?'selected':''; ?> >Active</option>
						    			<option value="0" <?php echo $selected = ($get_book->status == '0')?'selected':''; ?> >Inactive</option>
						    		</select>
						    	</div>
				    		</div>
				    	</div>
				    	<div class="form-group">
				    		<label for="shelf_id">Select Shelf</label>
				    		<select name="shelf_id" class="form-control" id="shelf_id" required >
				    			<?php
				    			global $wpdb;
								$book_shelfs = $wpdb->get_results(
									"SELECT * FROM {$wpdb->prefix}book_shelf_table ORDER BY id DESC"
								);
								foreach($book_shelfs as $key=>$value){
									$selected = ($value->id == $get_book->shelf_id)?"selected":"";
									echo '<option value="'.$value->id.'"'.$selected.'>'.$value->shelf_name.'</option>';
								}
				    			?>
				    		</select>
				    	</div>
				    	<div class="form-group">
				    		<label for="book_image">Book Image</label>
				    		<span class="btn btn-primary" id="txt_image">Select Image</span><br><br>
				    		<img width="150px" height="150px" id="book_cover_image" src="<?php echo $get_book->book_image; ?>" />
				    		<input type="hidden" name="book_image" id="book_image" value="<?php echo $get_book->book_image; ?>">
				    	</div>
				    	<?php wp_nonce_field('update_book'); ?>
					  <button type="submit" class="btn btn-primary" name="update_book">Update</button>
					</form>

				

				  </div>
				</div>
			</div>
			<div class="col-md-6"></div>
		</div>
	</div>
</div>

<script type="text/javascript">
	jQuery(document).on("click", "#txt_image", function(){
		var image = wp.media({
			title:"Upload Book Image",
			multiple: false
		}).open().on("select", function(e){
			var upload_image = image.state().get("selection").first();
			var imagejson = upload_image.toJSON();
			jQuery("#book_cover_image").attr("src", imagejson.url);
			jQuery("#book_image").val(imagejson.url);
		})
	});
</script>


	<?php
	/** 
	 * submit post
	 */
	if(! isset($_POST['update_book'])){
        return;
    }

    if(! wp_verify_nonce($_POST['_wpnonce'], 'update_book')){
        wp_die('<div class="alert alert-warning" role="alert">Are you cheating?</div>');
    }

    if(! current_user_can('manage_options')){
        wp_die('<div class="alert alert-warning" role="alert">Are you cheating?</div>');
    }
	if(isset($_POST['update_book'])){

		$data['name'] = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
        $data['amount'] = isset($_POST['amount']) ? sanitize_textarea_field($_POST['amount']) : '';
        $data['publication'] = isset($_POST['publication']) ? sanitize_text_field($_POST['publication']) : '';
        $data['description'] = isset($_POST['description']) ? sanitize_text_field($_POST['description']) : '';
        $data['book_image'] = isset($_POST['book_image']) ? sanitize_text_field($_POST['book_image']) : '';
        $data['language'] = isset($_POST['language']) ? sanitize_text_field($_POST['language']) : '';
        $data['shelf_id'] = isset($_POST['shelf_id']) ? sanitize_text_field($_POST['shelf_id']) : '';
        $data['status'] = isset($_POST['status']) ? sanitize_text_field($_POST['status']) : '';
        
		global $wpdb;

		$book_updated = $wpdb->update( 
			"{$wpdb->prefix}book_table",
			array('name'=>$data['name'], 'amount'=>$data['amount'], 'publication'=>$data['publication'], 'description'=>$data['description'], 'book_image'=>$data['book_image'], 'language'=>$data['language'], 'shelf_id'=>$data['shelf_id'], 'status'=> $data['status']),
			array( 'ID' => $edit_id ) 
		);

		if($book_updated){
			echo '<div class="alert alert-success" role="alert">Data Update Success</div>';
		}else{
			echo '<div class="alert alert-danger" role="alert">Data Not Update</div>';
		}
	}
	?>