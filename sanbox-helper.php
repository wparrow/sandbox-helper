<?php
/**
 * Plugin Name: WPArrow Sandbox Helper
 * Description: Custom Helper Plugin For MotoPress Demo Builder
 * Author: Varun Sridharan
 * Version: 1.0
 */

/**
 * Class WPArrow_Sandbox_Helper
 *
 * @author Varun Sridharan <varunsridharan23@gmail.com>
 */
class WPArrow_Sandbox_Helper {
	/**
	 * @var bool
	 * @access
	 */
	private $products = array();

	/**
	 * WPArrow_Sandbox_Helper constructor.
	 */
	public function __construct() {
		//$this->fetch_products_json();

		/**
		 * @uses add_custom_user()
		 * @uses delete_custom_user()
		 * @uses delete_custom_tables()
		 * @uses add_custom_style()
		 */
		add_action( 'nd_create_sandbox', array( &$this, 'add_custom_user' ) );
		add_action( 'nd_delete_sandbox', array( &$this, 'delete_custom_user' ) );
		add_filter( 'wpmu_drop_tables', array( &$this, 'delete_custom_tables' ) );
		add_action( 'wp_head', array( &$this, 'add_custom_style' ) );
		add_action( 'widgets_init', array( &$this, 'unregister_default_widgets' ), 11 );
	}

	/**
	 * Removes Default Widgets
	 */
	public function unregister_default_widgets() {
		unregister_widget( 'WP_Widget_Pages' );
		unregister_widget( 'WP_Widget_Calendar' );
		unregister_widget( 'WP_Widget_Archives' );
		unregister_widget( 'WP_Widget_Links' );
		unregister_widget( 'WP_Widget_Meta' );
		unregister_widget( 'WP_Widget_Search' );
		unregister_widget( 'WP_Widget_Text' );
		unregister_widget( 'WP_Widget_Categories' );
		unregister_widget( 'WP_Widget_Recent_Posts' );
		unregister_widget( 'WP_Widget_Recent_Comments' );
		unregister_widget( 'WP_Widget_RSS' );
		unregister_widget( 'WP_Widget_Tag_Cloud' );
		unregister_widget( 'WP_Nav_Menu_Widget' );
		unregister_widget( 'Twenty_Eleven_Ephemera_Widget' );
		unregister_widget( 'motopress_demo\classes\widgets\Try_Demo_Widget' );
		unregister_widget( 'motopress_demo\classes\widgets\Try_Demo_Popup_Widget' );
		unregister_widget( 'WP_Widget_Media_Audio' );
		unregister_widget( 'WP_Widget_Media_Image' );
		unregister_widget( 'WP_Widget_Media_Gallery' );
		unregister_widget( 'WP_Widget_Media_Video' );
		unregister_widget( 'WP_Widget_Custom_HTML' );
	}

	/**
	 * Fetches Product Info.
	 */
	private function fetch_products_json() {
		$data = get_transient( '_wparrow_sandbox_products' );
		if ( empty( $data ) ) {
			$data = file_get_contents( 'https://static.cdn.wparrow.com/product-info.json' );
			set_transient( '_wparrow_sandbox_products', $data, HOUR_IN_SECONDS * 5 );
		}
		$this->products = $data;
	}

	/**
	 * @param $blog_id
	 */
	public function add_custom_user( $blog_id ) {
		add_user_to_blog( $blog_id, 34, 'shop_manager' );
		add_user_to_blog( $blog_id, 33, 'customer' );
		add_user_to_blog( $blog_id, 35, 'subscriber' );
	}

	/**
	 * @param $blog_id
	 */
	public function delete_custom_user( $blog_id ) {
		remove_user_from_blog( 33, $blog_id );
		remove_user_from_blog( 34, $blog_id );
		remove_user_from_blog( 35, $blog_id );
	}

	/**
	 * @param $tables
	 *
	 * @return array
	 */
	public function delete_custom_tables( $tables ) {
		global $wpdb;
		$tables[] = $wpdb->prefix . 'blogmeta';
		$tables[] = $wpdb->prefix . 'wc_download_log';
		$tables[] = $wpdb->prefix . 'wc_product_meta_lookup';
		$tables[] = $wpdb->prefix . 'wc_webhooks';
		$tables[] = $wpdb->prefix . 'woocommerce_api_keys';
		$tables[] = $wpdb->prefix . 'woocommerce_attribute_taxonomies';
		$tables[] = $wpdb->prefix . 'woocommerce_downloadable_product_permissions';
		$tables[] = $wpdb->prefix . 'woocommerce_log';
		$tables[] = $wpdb->prefix . 'woocommerce_order_itemmeta';
		$tables[] = $wpdb->prefix . 'woocommerce_order_items';
		$tables[] = $wpdb->prefix . 'woocommerce_payment_tokenmeta';
		$tables[] = $wpdb->prefix . 'woocommerce_payment_tokens';
		$tables[] = $wpdb->prefix . 'woocommerce_sessions';
		$tables[] = $wpdb->prefix . 'woocommerce_shipping_zones';
		$tables[] = $wpdb->prefix . 'woocommerce_shipping_zone_locations';
		$tables[] = $wpdb->prefix . 'woocommerce_shipping_zone_methods';
		$tables[] = $wpdb->prefix . 'woocommerce_tax_rates';
		$tables[] = $wpdb->prefix . 'woocommerce_tax_rate_locations';
		return $tables;
	}

	/**
	 * Adds Custom Frontend Style.
	 */
	public function add_custom_style() {
		echo <<<HTML
	<style>
	li.wparrowdemo-buynow{background: green;}
	li.wparrowdemo-buynow a{color:white !important;}
	li.wparrowdemo-buynow:hover{background: transparent;}
	li.wparrowdemo-buynow:hover a{color:green !important;}
	</style>
HTML;

	}
}


new WPArrow_Sandbox_Helper();
