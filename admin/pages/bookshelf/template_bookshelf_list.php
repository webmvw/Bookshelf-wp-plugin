<div class="wrap">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-primary">
				  	<div class="panel-heading" style="display: flex;justify-content: space-between;align-items: center;">
				  		<h3>Book Shelf List</h3>
				  		<a href="admin.php?page=create_shelf" class="btn btn-success">Create BookShelf</a>
					</div>
				  <div class="panel-body">
				    <table id="bookshelf_Table" class="display">
				    	<thead>
				    		<tr>
				    			<th>SL</th>
				    			<th>Shelf Name</th>
				    			<th>Capacity</th>
				    			<th>Shelf Location</th>
				    			<th>Status</th>
				    			<th>Action</th>
				    		</tr>
				    	</thead>
				    	<tbody>
				    		<?php
				    		if(count($book_shelfs) > 0){
				    			foreach($book_shelfs as $key=>$value){
				    				?>
				    				<tr>
				    					<td><?php echo ($key+1) ?></td>
				    					<td><?php echo $value->shelf_name; ?></td>
				    					<td><?php echo $value->capacity; ?></td>
				    					<td><?php echo $value->shelf_location ?></td>
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
				    						<a href="<?php echo admin_url('admin.php?page=shelf_list&action=edit&id='.$value->id); ?>" class="btn btn-info">Edit</a>
				    						<a href="<?php echo admin_url('admin.php?page=shelf_list&action=delete&id='.$value->id); ?>" onclick="return confirm('Are you sure to delete it?');" class="btn btn-danger">Delete</a>
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
				    			<th>Shelf Name</th>
				    			<th>Capacity</th>
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
	let table = new DataTable('#bookshelf_Table');
</script>