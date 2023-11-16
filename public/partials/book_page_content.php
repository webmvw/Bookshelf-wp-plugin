<div class="container" style="padding:50px 0px">
	<div class="row">
		<h2 style="text-align: center;
    font-weight: bold;
    color: purple;
    border-bottom: 1px solid purple;
    padding-bottom: 15px;
    margin: 20px 0px;">Book List</h2>
		<?php
		global $wpdb;
		$book_tables = $wpdb->get_results(
			"SELECT * FROM {$wpdb->prefix}book_table ORDER BY id DESC"
		);
		if(count($book_tables) > 0){
			foreach($book_tables as $key=>$value){
				?>
				<div class="col-md-3">
					<div class="panel panel-primary">
						<div class="panel-body" style="text-align: center;background:#f4f4f4">
							<img src="<?php echo $value->book_image; ?>" alt="<?php echo $value->name; ?>" style="width:200px !important;height:250px !important"/>
							<hr>
							<h4 style="color:purple;font-weight:bold">Book: <?php echo $value->name ?></h4>
							<p>Price: <b><?php echo $value->amount; ?>tk</b></p>
							<p>Publication: <?php echo $value->publication; ?></p>
							<p>Language: <?php echo $value->language; ?></p>
						</div>
					</div>
				</div>
				<?php
			}
		}	
		?>
		
	</div>
</div>