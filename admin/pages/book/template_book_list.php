<div class="wrap">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-primary">
				  <div class="panel-heading" style="display: flex;justify-content: space-between;align-items: center;">
				  		<h3>Book List</h3>
				  		<a href="admin.php?page=create_book" class="btn btn-success">Add Book</a>
					</div>
				  <div class="panel-body">
				    <table id="bookTable" class="display">
				    	<thead>
				    		<tr>
				    			<th>SL</th>
				    			<th>Book Image</th>
				    			<th>Name</th>
				    			<th>Price</th>
				    			<th>Publication</th>
				    			<th>Language</th>
				    			<th>Shelf Name</th>
				    			<th>Shelf Location</th>
				    			<th>Status</th>
				    			<th>Action</th>
				    		</tr>
				    	</thead>
				    	<tbody>
				    		<?php
				    		if(count($book_tables) > 0){
				    			foreach($book_tables as $key=>$value){
				    				?>
				    				<tr>
				    					<td><?php echo ($key+1) ?></td>
				    					<td><img width="50px" height="80px" src="<?php echo $value->book_image; ?>" /></td>
				    					<td><?php echo $value->name; ?></td>
				    					<td><?php echo $value->amount; ?></td>
				    					<td><?php echo $value->publication; ?></td>
				    					<td><?php echo $value->language; ?></td>
			    						<?php
			    						$book_shelfs = $wpdb->get_results(
											"SELECT * FROM {$wpdb->prefix}book_shelf_table WHERE id={$value->shelf_id}"
										);
										foreach ($book_shelfs as $shelf_key=>$shelf_value) {
											echo "<td>".$shelf_value->shelf_name."</td>";
											echo "<td>".$shelf_value->shelf_location."</td>";
										}
			    						?>
				    					<td>
				    						<?php
				    						if($value->status == 1){
				    							echo "Active";
				    						}elseif($value->status == 0){
				    							echo "Inactive";
				    						}
				    						?>
				    					</td>
				    					<td>
				    						<a href="<?php echo admin_url('admin.php?page=book_list&action=edit&id='.$value->id); ?>" class="btn btn-info">Edit</a>
				    						<a href="<?php echo admin_url('admin.php?page=book_list&action=delete&id='.$value->id); ?>" onclick="return confirm('Are you sure to delete it?');" class="btn btn-danger">Delete</a>
				    					</td>
				    				</tr>
				    				<?php
				    			}
				    		}
				    		?>
				    	</tbody>
				    	<tfoot>
				    		<tr>
				    			<th>SL</th>
				    			<th>Book Image</th>
				    			<th>Name</th>
				    			<th>Price</th>
				    			<th>Publication</th>
				    			<th>Language</th>
				    			<th>Shelf Name</th>
				    			<th>Shelf Location</th>
				    			<th>Status</th>
				    			<th>Action</th>
				    		</tr>
				    	</tfoot>
				    </table>
				  </div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	let table = new DataTable('#bookTable');
</script>