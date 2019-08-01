<?php
/**
 * Plugin Name: SandBox User Force Create
 * Description: This plugin is linked with WP Ninja Demo which create demo site for plugin. and this plugin hooks and create 2 extra users
 * Author: Varun Sridharan
 * Version: 1.0
 */

/**
 * @uses \vs_add_custom_user()
 * @uses \vs_delete_custom_user()
 * @uses \vs_delete_custom_tables()
 */
add_action( 'nd_create_sandbox', 'vs_add_custom_user' );
add_action( 'nd_delete_sandbox', 'vs_delete_custom_user' );
add_filter( 'wpmu_drop_tables', 'vs_delete_custom_tables' );

/**
 * @param $blog_id
 */
function vs_add_custom_user( $blog_id ) {
	add_user_to_blog( $blog_id, 34, 'shop_manager' );
	add_user_to_blog( $blog_id, 33, 'customer' );
	add_user_to_blog( $blog_id, 35, 'subscriber' );
}

/**
 * @param $blog_id
 */
function vs_delete_custom_user( $blog_id ) {
	remove_user_from_blog( 33, $blog_id );
	remove_user_from_blog( 34, $blog_id );
	remove_user_from_blog( 35, $blog_id );
}

/**
 * @param $tables
 *
 * @return array
 */
function vs_delete_custom_tables( $tables ) {
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
