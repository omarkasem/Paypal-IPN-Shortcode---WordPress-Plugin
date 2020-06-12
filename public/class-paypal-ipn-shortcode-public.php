<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.elnooronline.com
 * @since      1.0.0
 *
 * @package    Paypal_Ipn_Shortcode
 * @subpackage Paypal_Ipn_Shortcode/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Paypal_Ipn_Shortcode
 * @subpackage Paypal_Ipn_Shortcode/public
 * @author     Omar Kasem <omar.kasem207@gmail.com>
 */
class Paypal_Ipn_Shortcode_Public {

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
		 * defined in Paypal_Ipn_Shortcode_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Paypal_Ipn_Shortcode_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/paypal-ipn-shortcode-public.css', array(), $this->version, 'all' );

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
		 * defined in Paypal_Ipn_Shortcode_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Paypal_Ipn_Shortcode_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/paypal-ipn-shortcode-public.js', array( 'jquery' ), $this->version, false );

	}

	public function paypal_ipn_shortcode($atts){
		$atts = shortcode_atts( array(
				'name'=>'',
				'email' => '',
				'price'=>'',
				'mode'=>'sandbox',
				'currency'=>'USD',
				'submit_class'=>'',
				'submit_value'=>'',
				'return'=>'',
				'notify_url'=>'/?paypal_ipn_shortcode=1',
				'custom'=>'',
			), $atts);

		if($atts['mode'] === 'sandbox'){
			$action = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
		}else{
			$action = 'https://www.paypal.com/cgi-bin/webscr';
		}
		$errors = array();
		if($atts['price'] === ''){
			$errors[] = 'Price attribute is required.';
		}
		if($atts['email'] === ''){
			$errors[] = 'Email attribute is required.';
		}

		if($atts['mode'] === ''){
			$errors[] = 'Mode attribute is required.';
		}
		$output = '';
		if(empty($errors)){
			if($atts['custom'] !== ''){
				$user_id = get_current_user_id();
				$atts['custom'] = str_replace('user_id',intval($user_id),$atts['custom']);
				$atts['custom'] = str_replace('post_id',get_the_ID(),$atts['custom']);
			}
			$output .='
	            <form method="post" action="'.$action.'" target="_top">
	                <input type="hidden" name="item_name" value="'.$atts['name'].'">
	                <input type="hidden" name="amount" value="'.$atts['price'].'">
	                <input type="hidden" name="custom" value="'.$atts['custom'].'">
	                <input type="hidden" name="notify_url" value="'.home_url().$atts['notify_url'].'&mode='.$atts['mode'].'">
	                <input type="hidden" name="currency_code" value="'.$atts['currency'].'">
	                <input type="hidden" name="cmd" value="_xclick">
	                <input type="hidden" name="business" value="'.$atts['email'].'">
	                <input type="hidden" name="return" value="'.$atts['return'].'">
	                <input type="hidden" name="charset" value="utf-8">
	                <input type="submit" value="'.$atts['submit_value'].'" class="'.$atts['submit_class'].'">
	            </form>
			';
		}else{
			$output .= '<ul>';
			foreach($errors as $error){
				$output .= '<li>'.$error.'</li>';
			}
			$output .= '</ul>';
		}
		return $output;
	}

	public function verify_payment(){
		if(isset($_GET['paypal_ipn_shortcode']) && $_GET['paypal_ipn_shortcode'] == 1){
	        $ipn = new PaypalIPN();
	        if($_GET['mode'] === 'sandbox'){
	            $ipn->useSandbox();
	        }
	        $verified = $ipn->verifyIPN();
	        if($verified) {
	        	do_action('verify_paypal_payment_ipn_shortcode',$_POST);
	        	$post_id = wp_insert_post(array(
	        		'post_type'=>'paypal_ipn_payments',
	        		'post_title'=>$_POST['txn_id'],
	        		'post_status'=>'publish',
	        	));
	        	$paypal_atts = $this->paypal_atts($_POST,$post_id);
	        	update_post_meta($post_id,'paypal_ipn_shortcode_info',$paypal_atts);
			}
		}
	}


	public function paypal_atts($post,$post_id){
		$paypal_atts = '
			mc_gross&protection_eligibility&address_status&payer_id&address_street&payment_date&payment_status&charset&address_zip&first_name&mc_fee&address_country_code&custom&payer_status&business&address_country&address_city&quantity&payer_email&payment_type&last_name&address_state&receiver_email&payment_fee&receiver_id&txn_type&item_name&mc_currency&item_number&residence_country&ipn_track_id
		';
		$paypal_atts = explode('&', trim($paypal_atts));
		$final = [];
		foreach ($paypal_atts as $paypal_att) {
			$final[$paypal_att] = $post[$paypal_att];
		}
		return $final;
	}





}
