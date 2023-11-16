<?php

if(isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])){

	$delete_id = $_GET['id'];

	global $wpdb;

	$deleted = $wpdb->delete(
		"{$wpdb->prefix}book_table",
		array( 'ID' => $delete_id )
		);

	if($deleted){
		echo '<div class="alert alert-success" role="alert">Data Delete Success</div>';
		$redirected_to = admin_url('admin.php?page=book_list');
		wp_redirect($redirected_to);
	}else{
		echo '<div class="alert alert-danger" role="alert">Data Not Delete</div>';
	}

}