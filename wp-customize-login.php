<?php
/**
 * Plugin Name: WP Customize Login Page
 * Plugin URI: http://bit-bytetech.com
 * Description: Customize Login Page for Wordpress
 * Author: Nurul Amin
 * Author URI:  http://bit-bytetech.com
 * Version: 1.0
 * License: GPL2
 */

/**
 *
 */
class WP_Loginpage_Customize {

	protected static $_instance = null;

	function __construct() {

		// call action hooks
		add_action('admin_menu', array($this, 'admin_menu'));

	}

	function install() {

	}

	public static function instance() {
		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	static function admin_scripts() {

		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		//	wp_enqueue_script('bbt_cpl_script', plugins_url('assets/js/cpl.js', __FILE__), array('jquery', 'jquery'));

		wp_localize_script('bbt_cpl_admin', 'BBT_Vars', array(
				'ajaxurl'  => admin_url('admin-ajax.php'),
				'nonce'    => wp_create_nonce('bbt_nonce'),
				'is_admin' => is_admin()?'yes':'no',
				'message'  => bbt_message(),
			));
		//
		//	wp_enqueue_style('jquery-ui', plugins_url('assets/css/jquery-ui-1.9.1.custom.css', __FILE__));
		//	wp_enqueue_style('bbt_cpl_style', plugins_url('assets/css/style.css', __FILE__));

		do_action('bbt_cpl_script');

	}

	function admin_menu() {
		$capability = 'read';//minimum level: subscriber

		add_options_page("WP CLP Settings", "WP CLP Settings", $capability, 'clp_settings', $this->admin_page_handler());

	}

	function admin_page_handler() {

		$file = plugin_dir_path(__FILE__).'/views/settings.php';
		require_once $file;
	}

}

function bbt_clp() {
	return WP_Loginpage_Customize::instance();
}

//cpm instance.
$bbt_clp = bbt_clp();
