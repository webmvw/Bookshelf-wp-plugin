<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://webmkit.com
 * @since      1.0.0
 *
 * @package    Smart_Coder
 * @subpackage Smart_Coder/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Smart_Coder
 * @subpackage Smart_Coder/public
 * @author     webmk <masudrana.bbpi@gmail.com>
 */
class Smart_Coder_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/smart-coder-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'Bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( "dataTables", plugin_dir_url( __FILE__ ) . 'css/jquery.dataTables.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( "sweetalert", plugin_dir_url( __FILE__ ) . 'css/sweetalert.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/smart-coder-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( "bootstrap-bundle", 'https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( "dataTables", plugin_dir_url( __FILE__ ) . 'js/jquery.dataTables.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( "sweetalert", plugin_dir_url( __FILE__ ) . 'js/sweetalert.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( "validation", plugin_dir_url( __FILE__ ) . 'js/jquery.validate.min.js', array('jquery'), $this->version, false );

	}


	public function our_own_custom_page_template(){

		global $post;

		if($post->post_name == 'book_page'){
			$page_template = plugin_dir_path( __FILE__ ). 'partials/book_page_layout.php';
			return $page_template;
		}

	}

	public function load_book_page_content(){
		ob_start();
		include_once plugin_dir_path( __FILE__ ).'partials/book_page_content.php';
		$template = ob_get_contents();
		ob_end_clean();
		echo $template;
	}


}
