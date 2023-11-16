<?php

/**
 * Fired during plugin activation
 *
 * @link       https://webmkit.com
 * @since      1.0.0
 *
 * @package    Smart_Coder
 * @subpackage Smart_Coder/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Smart_Coder
 * @subpackage Smart_Coder/includes
 * @author     webmk <masudrana.bbpi@gmail.com>
 */
class Smart_Coder_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();

		if( ! function_exists('dbDelta') ){
			require_once(ABSPATH. 'wp-admin/includes/upgrade.php');
		}

		$book_table_query = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}book_table`(
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`name` varchar(200) DEFAULT NULL,
			`amount` int(11) DEFAULT NULL,
			`publication` varchar(255) DEFAULT NULL,
			`description` text DEFAULT NULL,
			`book_image` varchar(250) DEFAULT NULL,
			`language` varchar(200) DEFAULT NULL,
			`shelf_id` int(11) DEFAULT NULL,
			`status` int(11) NOT NULL DEFAULT 1,
			`created_at` timestamp NOT NULL DEFAULT current_timestamp(),
			PRIMARY KEY (`id`)
		) $charset_collate";
		
		dbDelta( $book_table_query );

		$shelf_table_query = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}book_shelf_table`(
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`shelf_name` varchar(200) NOT NULL,
			`capacity` int(11) NOT NULL,
			`shelf_location` varchar(200) NOT NULL,
			`status` int(11) NOT NULL DEFAULT 1,
			`created_at` timestamp NOT NULL DEFAULT current_timestamp(),
			PRIMARY KEY (`id`)
		) $charset_collate";

		dbDelta( $shelf_table_query );

		$insert_book_shelf_query = "INSERT INTO {$wpdb->prefix}book_shelf_table(shelf_name, capacity, shelf_location, status) VALUES ('shelf-1', 230, 'corner', 1)";
		$wpdb->query($insert_book_shelf_query);



		/**
		 * Create page when plugin active
		 *
		 */
		$post_arr_data = array(
			'post_title' => 'Smart Coder',
			'post_name' => 'book_page',
			'post_content' => '',
			'post_status' => 'publish',
			'post_author' => 1,
			'post_type' => 'page'
		);
		wp_insert_post( $post_arr_data );


	}

}
