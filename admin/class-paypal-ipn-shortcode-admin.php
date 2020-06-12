<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.elnooronline.com
 * @since      1.0.0
 *
 * @package    Paypal_Ipn_Shortcode
 * @subpackage Paypal_Ipn_Shortcode/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Paypal_Ipn_Shortcode
 * @subpackage Paypal_Ipn_Shortcode/admin
 * @author     Omar Kasem <omar.kasem207@gmail.com>
 */
class Paypal_Ipn_Shortcode_Admin {

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
		 * defined in Paypal_Ipn_Shortcode_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Paypal_Ipn_Shortcode_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name.'fancybox', plugin_dir_url( __FILE__ ) . 'css/jquery.fancybox.min.css', array(), $this->version, 'all' );

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/paypal-ipn-shortcode-admin.css', array(), $this->version, 'all' );

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
		 * defined in Paypal_Ipn_Shortcode_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Paypal_Ipn_Shortcode_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name.'fancybox', plugin_dir_url( __FILE__ ) . 'js/jquery.fancybox.min.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/paypal-ipn-shortcode-admin.js', array( 'jquery' ), $this->version, false );

	}


    public function add_my_media_button() {
        echo '<a href="javascript:;" data-fancybox data-src="#paypal-ipn-modal-content" class="button paypal_ipn_add_button">Add Paypal IPN Shortcode</a>';
    }


    public function modal_html(){ ?>
        <form style="display:none;" id="paypal-ipn-modal-content">
        <table class="form-table">
            <tbody>

                <tr>
                    <th scope="row"><label for="paypal_mode">Mode</label></th>
                <td>
                    <select class="paypal_mode">
                    	<option value="sandbox">Sandbox</option>
                    	<option value="live">Live</option>
                    </select>
                </td>
                </tr>

                <tr>
                    <th scope="row"><label for="paypal_item_name">Item Name</label></th>
                <td>
                    <input type="text" id="paypal_item_name" class="paypal_item_name regular-text">
                </td>
                </tr>

                <tr>
                    <th scope="row"><label for="paypal_price">Price</label></th>
                <td>
                    <input type="text" id="paypal_price" required class="paypal_price regular-text">
                </td>
                </tr>


                <tr>
                    <th scope="row"><label for="paypal_email">Email</label></th>
                <td>
                    <input type="email" id="paypal_email" required class="paypal_email regular-text">
                </td>
                </tr>

                <tr>
                    <th scope="row"><label for="paypal_currency">currency</label></th>
                <td>
                    <input type="text" id="paypal_currency" required class="paypal_currency regular-text" value="USD">
                </td>
                </tr>

                <tr>
                    <th scope="row"><label for="paypal_submit_class">Submit Class</label></th>
                <td>
                    <input type="text" id="paypal_submit_class" class="paypal_submit_class regular-text">
                </td>
                </tr>

                <tr>
                    <th scope="row"><label for="paypal_submit_value">Submit Value</label></th>
                <td>
                    <input type="text" id="paypal_submit_value" class="paypal_submit_value regular-text">
                </td>
                </tr>

                <tr>
                    <th scope="row"><label for="paypal_return_url">Return URL</label></th>
                <td>
                    <input type="text" id="paypal_return_url" class="paypal_return_url regular-text">
                </td>
                </tr>

                <tr>
                    <th scope="row"><label for="paypal_custom">Custom (if multiple will be divided by ,)</label></th>
                <td>
                    <select multiple class="paypal_custom" id="paypal_custom">
                    	<option value="user_id">Current User ID</option>
                    	<option value="post_id">Current Post ID</option>
                    </select>
                </td>
                </tr>

            </tbody>



        </table>
        <button id="blurb_insert" type="button" class="button media-button button-primary button-large" >Insert into post</button>
        </form>
    <?php }




    public function post_type() {
        $labels = array(
            'name'               => 'Paypal Payments',
        );

        $args = array(
            'labels'             => $labels,
            'public'             => false,
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_icon'          => 'dashicons-money',
            'query_var'          => false,
            'rewrite'            => array( 'slug' => 'paypal_ipn_payments' ),
            'capability_type'    => 'post',
            'has_archive'        => false,
            'hierarchical'       => false,
            'menu_position'      => 5,
            'supports'           => array('title'),
        );
        register_post_type( 'paypal_ipn_payments', $args );
    }


    public function register_meta_box() {
        add_meta_box( 'paypal-ipn-shortcode-metabox', __( 'Paypal IPN Payment Information', $this->plugin_name ), array($this,'meta_box_callback'), 'paypal_ipn_payments','normal','high' );
    }

    public function meta_box_callback($meta_id){
        $output ='<table class="form-table" border="1" style="border-color: #cecece;direction: ltr;"><tbody>';
        $paypal_atts = get_post_meta($meta_id->ID,'paypal_ipn_shortcode_info',true);

        if(!empty($paypal_atts) && is_array($paypal_atts)){
            foreach($paypal_atts as $paypal_key => $paypal_value){
                $output .= '
                    <tr>
                    <th style="padding: 10px;text-align: left;" scope="row"><label for="'.$paypal_key.'">'.$paypal_key.'</label></th>
                    <td>'.$paypal_value.'</td>
                    </tr>
                ';
           }
        }
        $output .='</tbody></table>';
        echo $output;
    }



    
    function set_custom_edit_paypal_ipn_payments_columns($columns) {
        unset($columns['title']);
        unset($columns['date']);
        unset($columns['wp-statistics']);
        $columns['title'] = 'Transaction ID';
        $columns['payment_date'] = 'Payment Date';
        $columns['item_name'] = 'Item Name';
        $columns['payer_name'] = 'Payer Name';
        $columns['item_amount'] = 'Amount';
        $columns['trans_type'] = 'Transaction Type';
        $columns['payment_status'] = 'Payment Status';
        return $columns;
    }


    
    function custom_paypal_ipn_payments_column( $column, $post_id ) {
        $paypal_atts = get_post_meta($post_id,'paypal_ipn_shortcode_info',true);
        switch ( $column ) {
            case 'title' :
                echo 'dg';
                break;
            case 'payment_date':
                echo date('Y-m-d H:i', strtotime($paypal_atts['payment_date']));
                break;
            case 'item_name':
                echo $paypal_atts['item_name'];
                break;
            case 'payer_name':
                echo $paypal_atts['first_name'].' '.$paypal_atts['last_name'];
                break;
            case 'item_amount':
                echo $paypal_atts['mc_gross'];
                break;
            case 'trans_type':
                echo $paypal_atts['payment_type'];
                break;
            case 'payment_status':
                echo $paypal_atts['payment_status'];
                break;
        }
    }






}
