<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://webmkit.com
 * @since      1.0.0
 *
 * @package    Smart_Coder
 * @subpackage Smart_Coder/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Smart_Coder
 * @subpackage Smart_Coder/admin
 * @author     webmk <masudrana.bbpi@gmail.com>
 */
class Smart_Coder_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Smart_Coder_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Smart_Coder_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$valid_page = array('smart_coder', 'create_shelf', 'shelf_list','create_book', 'book_list',);
		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '';

		if( in_array($page, $valid_page)){
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/smart-coder-admin.css', array(), $this->version, 'all' );
			// wp_enqueue_style( 'Bootstrap', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), $this->version, 'all' );
			wp_enqueue_style( 'Bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css', array(), $this->version, 'all' );
			wp_enqueue_style( "dataTables", plugin_dir_url( __FILE__ ) . 'css/jquery.dataTables.min.css', array(), $this->version, 'all' );
			wp_enqueue_style( "sweetalert", plugin_dir_url( __FILE__ ) . 'css/sweetalert.min.css', array(), $this->version, 'all' );
		}
		

	}

	/**
	 * Register the JavaScript for the admin area.za
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Smart_Coder_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Smart_Coder_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		$valid_page = array('smart_coder', 'create_shelf', 'shelf_list','create_book', 'book_list',);
		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '';

		if( in_array($page, $valid_page)){
			wp_enqueue_script('jquery');
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/smart-coder-admin.js', array( 'jquery' ), $this->version, false );
			// wp_enqueue_script( "bootstrap", plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array( 'jquery' ), $this->version, false );
			// wp_enqueue_script( "bootstrap-bundle", plugin_dir_url( __FILE__ ) . 'js/bootstrap.bundle.min.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( "bootstrap-bundle", 'https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( "dataTables", plugin_dir_url( __FILE__ ) . 'js/jquery.dataTables.min.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( "sweetalert", plugin_dir_url( __FILE__ ) . 'js/sweetalert.min.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( "validation", plugin_dir_url( __FILE__ ) . 'js/jquery.validate.min.js', array('jquery'), $this->version, false );
		}
		

	}



	/**
	 * Register admin menu for this plugin
	 */
	public function smart_coder_menu(){
		add_menu_page( "Smart Coder", "Smart Coder", "manage_options", "smart_coder", array($this, 'book_management_dashboard') );
		add_submenu_page( "smart_coder", "Book Management", "Book Management", "manage_options", "smart_coder", array($this, 'book_management_dashboard') );
		add_submenu_page( "smart_coder", "Create Shelf", "Create Shelf", "manage_options", "create_shelf", array($this, 'callback_create_shelf') );
		add_submenu_page( "smart_coder", "Shelf List", "Shelf List", "manage_options", "shelf_list", array($this, 'callback_shelf_list') );
		add_submenu_page( "smart_coder", "Create Book", "Create Book", "manage_options", "create_book", array($this, 'callback_create_book') );
		add_submenu_page( "smart_coder", "Book List", "Book List", "manage_options", "book_list", array($this, 'callback_book_list') );
		
	}

	public function book_management_dashboard(){
		echo "<h2>Smart Coder Admin Menu</h2>";
	} 

	public function callback_create_shelf(){
		ob_start();
		require_once plugin_dir_path( __FILE__ ) . 'pages/bookshelf/template_bookshelf_create.php';
		$template = ob_get_contents();
		ob_end_clean();
		echo $template;
	}

	public function callback_shelf_list(){
		global $wpdb;
		$book_shelfs = $wpdb->get_results(
			"SELECT * FROM {$wpdb->prefix}book_shelf_table ORDER BY id DESC"
		);

		$action = isset($_GET['action']) ? $_GET['action'] : 'list';
        switch($action){
        	case 'edit':
                $template = plugin_dir_path( __FILE__ ). 'pages/bookshelf/template_bookshelf_edit.php';
                break;

            case 'delete':
                $template = plugin_dir_path( __FILE__ ). 'pages/bookshelf/template_bookshelf_delete.php';
                break;

            default:
                $template = plugin_dir_path( __FILE__ ) . 'pages/bookshelf/template_bookshelf_list.php';
                break;
        }

        if(file_exists($template)){
            include $template;
        }
	}


	public function callback_create_book(){
		ob_start();
		require_once plugin_dir_path( __FILE__ ) . 'pages/book/template_book_create.php';
		$template = ob_get_contents();
		ob_end_clean();
		echo $template;
	}

	public function callback_book_list(){

		global $wpdb;
		$book_tables = $wpdb->get_results(
			"SELECT * FROM {$wpdb->prefix}book_table ORDER BY id DESC"
		);

		$action = isset($_GET['action']) ? $_GET['action'] : 'list';
		switch($action){
			case 'edit':
				$template = plugin_dir_path(__FILE__). 'pages/book/template_book_edit.php';
				break;

			case 'delete':
				$template = plugin_dir_path( __FILE__ ). 'pages/book/template_book_delete.php';
				break;

			default:
				$template = plugin_dir_path( __FILE__ ). 'pages/book/template_book_list.php';
				break;
		}

		if(file_exists($template)){
			include $template;
		}	
	}

}
