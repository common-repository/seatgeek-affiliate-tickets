<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.wisersteps.com
 * @since      1.0.0
 *
 * @package    Seatgeek_Affiliate_Tickets
 * @subpackage Seatgeek_Affiliate_Tickets/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Seatgeek_Affiliate_Tickets
 * @subpackage Seatgeek_Affiliate_Tickets/public
 * @author     Omar Kasem <omar.kasem207@gmail.com>
 */
class Seatgeek_Affiliate_Tickets_Public {

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
		 * defined in Seatgeek_Affiliate_Tickets_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Seatgeek_Affiliate_Tickets_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name.'bootstrap', plugin_dir_url( __FILE__ ) . 'css/wisersteps-bootstrap.css', array(), $this->version, 'all' );

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/seatgeek-affiliate-tickets-public.css', array(), $this->version, 'all' );


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
		 * defined in Seatgeek_Affiliate_Tickets_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Seatgeek_Affiliate_Tickets_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/seatgeek-affiliate-tickets-public.js', array( 'jquery' ), $this->version, false );

		wp_localize_script( $this->plugin_name, 'sg_object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' )) );
	}


	private function get_events($offset=0,$performer_id=0){
		$titan = TitanFramework::getInstance( $this->plugin_name );
		$client_id = sanitize_text_field($titan->getOption('client_id'));
		if($client_id == ''){
			return 'Please fill the client id first in the option page.';
		}
		
		if($performer_id === 0){
			return 'Please choose the performer.';
		}


		$aff_id = intval($titan->getOption('aff_id'));

		$url_args = array(
		    'performers.id' => $performer_id,
		    'client_id' => $client_id,
		    'aid' => $aff_id,
		);
		if($offset !== 0){
			$offset = intval($offset);
			$page = $offset / 10;
			$page++;
			$url_args['page'] = $page;
		}
		$url = add_query_arg($url_args, 'https://api.seatgeek.com/2/events');

		$response = wp_remote_get($url);
		$events = json_decode(wp_remote_retrieve_body($response));

		if($events->meta->total === 0){
			return 'No events were found for that performer.';
		}

		return $events;
	}

	function get_one_event($event){
		$output = '';
		$date = strtotime($event->datetime_local);
		$date1 = date('M d',$date);
		$date_day = date('D',$date);
		$date_time = date('h i a',$date);
		$venue_name = $event->venue->name;
		$venue_city = $event->venue->display_location;

		if($event->stats->lowest_price == null){
			$button_text = 'Find Tickets';
		}else{
			$button_text = 'From $'.$event->stats->lowest_price;
		}


		$output .= '
		<li class="col-md-12">
			<a class="sg_link row" target="_blank" href="'.$event->url.'">
				<div class="sg_date col-md-3 col-xs-12">
					<span class="sg_month">'.$date1.'</span>
					<span class="sg_time">'.$date_day.' · '.$date_time.'</span>
				</div>

				<div class="sg_title col-md-6 col-xs-12">
					<h3>'.$event->short_title.'</h3>
					<h4>'.$venue_name.' · '.$venue_city.'</h4>
				</div>

				<div class="sg_button col-md-3 col-xs-12">
					<span>'.$button_text.'</span>
				</div>
			</a>

		</li>';
		return $output;
	}

	function get_html($events){
		$output = '';
		if(!empty($events)){
			$output .='<ul class="row">';
			foreach($events as $event){
				$output .= $this->get_one_event($event);
			}
			$output .='</ul>';

			$output .= '
				<div class="col-md-12" id="sg_load_more">

					<button>LOAD MORE<img src="'.admin_url('images/spinner.gif').'" alt=""></button>
				</div>
			';

		}
		return $output;
	}

	function shortcode( $atts ) {
		$performer_id = intval($atts['id']);
		if($performer_id === 0){
			return 'Please choose a performer.';
		}
		$events = $this->get_events(0,$performer_id)->events;
		$titan = TitanFramework::getInstance( $this->plugin_name );
		$main_color = sanitize_text_field($titan->getOption('main_color'));

		$output = '<div class="sg_events" id="wp_wisersteps_bootstrap" total_ev="'.$this->get_events()->meta->total.'" performer_id="'.$performer_id.'">';

		$output .= $this->get_html($events);

		$output .='</div>';

		// Color Theme
		$output .='
			<style>
				.sg_events .sg_button span,.sg_events #sg_load_more button{
					background-color:'.$main_color.';
				}

				.sg_events .sg_link:hover .sg_month,.sg_events .sg_link:hover h3{
					color:'.$main_color.';
				}
			</style>
		';

		return $output;
	}
	

	public function load_more(){
		$count = intval($_GET['count']);
		$performer_id = intval($_GET['performer_id']);
		$output = '';
		if($count !== 0 && $performer_id !== 0){
			$events = $this->get_events($count,$performer_id)->events;
			if(!empty($events)){
				foreach($events as $event){
					$output .= $this->get_one_event($event);
				}
			}
		}
		echo $output;
		wp_die();
	}

}
