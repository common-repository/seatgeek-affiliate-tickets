<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.wisersteps.com
 * @since      1.0.0
 *
 * @package    Seatgeek_Affiliate_Tickets
 * @subpackage Seatgeek_Affiliate_Tickets/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Seatgeek_Affiliate_Tickets
 * @subpackage Seatgeek_Affiliate_Tickets/admin
 * @author     Omar Kasem <omar.kasem207@gmail.com>
 */
class Seatgeek_Affiliate_Tickets_Admin {

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
		 * defined in Seatgeek_Affiliate_Tickets_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Seatgeek_Affiliate_Tickets_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name.'select2', plugin_dir_url( __FILE__ ) . 'css/select2.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Seatgeek_Affiliate_Tickets_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Seatgeek_Affiliate_Tickets_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name.'select2', plugin_dir_url( __FILE__ ) . 'js/select2.min.js', array( 'jquery' ), $this->version, true );

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/seatgeek-affiliate-tickets-admin.js', array( 'jquery' ), $this->version, true );

	}



	public function option_page($test) {
		$titan = TitanFramework::getInstance( $this->plugin_name );


		$adminPanel = $titan->createAdminPanel( array(
		'name' => 'Seatgeek Tickets',
		// 'desc'=>'<h1>Seatgeek Affiliate Tickets</h1>',
		) );

//-------------------------------------------------------

		// General
		$generalTab = $adminPanel->createTab( array(
		'name' => 'General',
		));


		$generalTab->createOption( array(
		'name' => 'Client ID',
		'id' => 'client_id',
		'type' => 'text',
		'desc' => 'You can get it from <a target="_blank" href="https://seatgeek.com/account/develop">Here</a>',
		) );


		$generalTab->createOption( array(
		'name' => 'Partner Affiliate ID',
		'id' => 'aff_id',
		'type' => 'text',
		'desc' => 'You can get it from <a target="_blank" href="https://seatgeek.com/partners/dashboard">Here</a>',
		) );




		$generalTab->createOption( array(
		'name' => 'Main Color Theme',
		'id' => 'main_color',
		'type' => 'color',
		'default'=>'#1673E6',
		) );

		$generalTab->createOption( array(
		'type' => 'save'
		) );


//-------------------------------------------------------

		// Shortcodes
		$shortcodeTab = $adminPanel->createTab( array(
		'name' => 'Shortcodes',
		));

		$shortcodeTab->createOption( array(
		'name' => 'Shortcodes',
		'id' => 'shortcodess',
		'type' => 'custom',
		'custom' => $this->shortcode_div(),
		) );



//-------------------------------------------------------

		// Status
		$statusTab = $adminPanel->createTab( array(
		'name' => 'Server Status',
		));

		$statusTab->createOption( array(
		'name' => 'The Plugin',
		'id' => 'php_veree',
		'type' => 'custom',
		'custom' => 'So the plugin can work one of <b>CURL</b> or <b>File Get Contents</b> has to be enabled.',
		) );


		$statusTab->createOption( array(
		'name' => 'PHP Version',
		'id' => 'php_ver',
		'type' => 'custom',
		'custom' => phpversion(),
		) );


		$statusTab->createOption( array(
		'name' => 'CURL',
		'id' => 'php_curl',
		'type' => 'custom',
		'custom' => $this->check_curl(),
		) );


		$statusTab->createOption( array(
		'name' => 'File Get Contents',
		'id' => 'php_fgc',
		'type' => 'custom',
		'custom' => $this->check_file_get_contents(),
		) );


	}



	function insert_admin_footer_style(){
		echo '<style>
			.sg_shortcodes ul{
				background: #ebebeb;
			    color: #000;
			    padding: 10px 15px;
			}
			.sg_shortcodes ul li{
			    font-size: 15px;
			    border-bottom: 1px solid #d2d2d2;
			    padding: 15px 0;
			}
			.sg_shortcodes ul li input{
				width:80%;
			    height: 40px;
			    margin: 0;
			    font-weight: bold;
			    padding: 0 10px;
			}
			.sg_shortcodes ul li .sg_copy{
			    background: #c20000;
			    border: none;
			    height: 40px;
			    cursor: pointer;
			    color: #fff;
			    padding: 0 15px;
			}
			.sg_shortcodes .select2-container{
				width:50%!important;
			}

		</style>'; 
	}

	private function check_curl(){
		if(function_exists('curl_version')){
			return 'Enabled';
		}
		return 'Not Working';
	}

	private function check_file_get_contents(){
		if(ini_get('allow_url_fopen')){
			return 'Enabled';
		}
		return 'Not Working';
	}
	

	function shortcode_div(){
		$titan = TitanFramework::getInstance( $this->plugin_name );
		$client_id = sanitize_text_field($titan->getOption('client_id'));
		if($client_id == ''){
			return 'Please fill the client id first in the option page.';
		}

		$output = '<div class="sg_shortcodes">';
		$output .='
			<select name="sg_performer_id" id="sg_performer_id">
		    	<option value="">Search for a performer</option>
		    </select>';
		    $output .= '<input type="hidden" class="sg_client_id" value="'.$client_id.'">';
		    $output .= '<button class="sg_generate button button-primary">Generate</button>';
		    $output .='<ul></ul>';
		$output .= '</div>';

		return $output;
	}




}
