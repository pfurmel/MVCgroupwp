<?php
        /*
        * Plugin Name: PitchPrint
        * Plugin URI: http://www.pitchprint.com
        * Description: Plugin for integrating PitchPrint design app into WooCommerce
        * Author: PitchPrint
        * Version: 7.3.0
        * Author URI: http://www.pitchprint.com
		* Requires at least: 3.8
		* Tested up to: 4.2
		* 
		* @package PitchPrint
		* @category Core
		* @author PitchPrint
        */
		
	if (!session_id()) session_start();

	load_plugin_textdomain('PitchPrint', false, basename( dirname( __FILE__ ) ) . '/languages/' );
	
	include('system/settings.php');

    define('SERVER_URLPATH', 'https://pitchprint.net');
    define('SERVER_RSCBASE', '//s3.amazonaws.com/pitchprint.rsc/');
	define('SERVER_RSCCDN', '//dta8vnpq1ae34.cloudfront.net/');

    define('PP_MIN_CDN_PATH', '//dta8vnpq1ae34.cloudfront.net/javascripts/pitchprint.min.js');
    define('PP_WP_CDN_PATH', '//dta8vnpq1ae34.cloudfront.net/javascripts/pp.js');
    define('PPA_WP_CDN_PATH', '//dta8vnpq1ae34.cloudfront.net/javascripts/pp.wp.a.js');

	add_filter('woocommerce_add_cart_item_data', 'pp_add_cart_item_data', 10, 2);
	add_filter('woocommerce_add_order_item_meta', 'pp_add_order_item_meta', 10, 2);
	add_filter('woocommerce_get_cart_item_from_session', 'pp_get_cart_item_from_session', 10, 2);
	add_filter('woocommerce_get_item_data', 'pp_get_cart_mod', 10, 2);
	add_filter('woocommerce_cart_item_thumbnail', 'pp_cart_thumbnail', 10, 2);
	add_filter('woocommerce_before_my_account', 'pp_my_recent_order');
		
	
    add_action('woocommerce_after_cart', 'pp_get_cart_action');
    add_action('admin_menu', 'ppa_actions');
    add_action('wp_head', 'pp_header_files');
	add_action('admin_head', 'ppa_header_files');
	add_action('woocommerce_product_options_pricing', 'ppa_add_tab');
	add_action('woocommerce_process_product_meta', 'ppa_write_panel_save');
	add_action('woocommerce_before_add_to_cart_button', 'add_pp_edit_button');
	add_action('woocommerce_after_shop_loop_item', 'pp_remove_add_to_cart_buttons', 1);
  
    
//Client ------------------------------------------------------------------------------------------------

    function pp_header_files() {
		global $post, $product;
		$pp_set_option = get_post_meta($post->ID, '_w2p_set_option', true);
		if (!empty($pp_set_option)) {
			wp_enqueue_script('jquery-ui-core');
			wp_enqueue_script('jquery-ui-draggable');
			wp_enqueue_script('jquery-ui-droppable');
			wp_enqueue_script('jquery-ui-selectable');
			wp_enqueue_script('pitchprint_editor', PP_MIN_CDN_PATH);
			wp_enqueue_script('pitchprint_class', PP_WP_CDN_PATH);
		}
		if (defined('PITCH_JSCRIPT')) wc_enqueue_js(stripslashes(PITCH_JSCRIPT));
	}

	function pp_add_cart_item_data($cart_item_meta, $product_id) {
		if (isset($_SESSION['pp_projects'])) {
			if (isset($_SESSION['pp_projects'][$product_id])) {
				$cart_item_meta['_w2p_set_option'] = $_SESSION['pp_projects'][$product_id];
				unset($_SESSION['pp_projects'][$product_id]);
			}
		}
		return $cart_item_meta;
	}
	function pp_add_order_item_meta($item_id, $cart_item) {
		global $woocommerce;
		if (!empty($cart_item['_w2p_set_option'])) woocommerce_add_order_item_meta($item_id, '_w2p_set_option', $cart_item['_w2p_set_option']);
	}
	function pp_get_cart_item_from_session($cart_item, $values) {
		if (!empty($values['_w2p_set_option'])) $cart_item['_w2p_set_option'] = $values['_w2p_set_option'];
		return $cart_item;
	}
    function pp_cart_thumbnail($img, $val) {
        if (!empty($val['_w2p_set_option'])) {
            $itm = $val['_w2p_set_option'];
            $itm = json_decode(rawurldecode($itm), true);
            if ($itm['type'] == 'p') {
                $img = '<img style="width:90px" src="' . SERVER_RSCBASE . 'images/previews/' . $itm['projectID'] . '_1.jpg" >';
            } else {
				$img = '<img width="90" src="' . SERVER_RSCBASE . 'images/previews/' . $itm[2] . '_1.jpg" >';
			}
        }
        return $img;
    }

	function pp_my_recent_order() {
        global $post, $woocommerce;
        wp_enqueue_script('pitchprint_class', PP_WP_CDN_PATH);
        wp_enqueue_script('prettyPhoto', $woocommerce->plugin_url() . '/assets/js/prettyPhoto/jquery.prettyPhoto.min.js', array( 'jquery' ), $woocommerce->version, true );
        wp_enqueue_script('prettyPhoto-init', $woocommerce->plugin_url() . '/assets/js/prettyPhoto/jquery.prettyPhoto.init.min.js', array( 'jquery' ), $woocommerce->version, true );
        wp_enqueue_style('woocommerce_prettyPhoto_css', $woocommerce->plugin_url() . '/assets/css/prettyPhoto.css' );
        
        echo '<div id="pp-mydesigns-div"></div>';
        wc_enqueue_js(" pp_client = 'wp'; pp_baseUrl = '" . SERVER_URLPATH . "'; pp_appUrl = '" . SERVER_URLPATH . "/app/'; pp_runtimePath = '" . SERVER_URLPATH . "/runtime/'; pp_rscCdn = '" . SERVER_RSCCDN . "'; pp_rscBase = '" . SERVER_RSCBASE . "'; pp_pluginRoot='".plugins_url('/', __FILE__)."'; pp_apiKey='".PITCH_APIKEY."'; pp_languageID='" . substr(get_bloginfo('language'), 0, 2) . "'; pp_userID='" . get_current_user_id() . "'; jQuery(document).ready(function () { PPrint.validate(PPrint.fetchUserDesigns); }) ");
    }

    function pp_get_cart_action() {
        global $post, $woocommerce;
        wp_enqueue_script('pitchprint_class', PP_WP_CDN_PATH);
        wc_enqueue_js(" pp_client = 'wp'; pp_baseUrl = '" . SERVER_URLPATH . "'; pp_appUrl = '" . SERVER_URLPATH . "/app/'; pp_runtimePath = '" . SERVER_URLPATH . "/runtime/'; pp_rscCdn = '" . SERVER_RSCCDN . "'; pp_rscBase = '" . SERVER_RSCBASE . "'; pp_pluginRoot = '" . plugins_url('/', __FILE__) . "'; pp_apiKey='".PITCH_APIKEY."'; pp_languageID='" . substr(get_bloginfo('language'), 0, 2) . "'; pp_userID='" . get_current_user_id() . "';
            jQuery(document).ready(function () { PPrint.validate(); PPrint.setBtnPref(); }) ");
    }
	function pp_get_cart_mod( $item_data, $cart_item ) {
		if (!empty($cart_item['_w2p_set_option'])) {
            $val = $cart_item['_w2p_set_option'];
            $itm = json_decode(rawurldecode($val), true);
			$item_data[] = array(
				'name'    => '<span id="pp-data-'.($itm['type']=='u'?'file_upload':'design').'">' . ($itm['type'] === 'u' ? __("File Upload", "PitchPrint") : __("Custom Design", "PitchPrint")) . '</span> &nbsp;&nbsp; <img style="width:14px; height:14px" src="'.plugins_url('/', __FILE__).'images/ok.png" border="0" >',
				'display' => ($itm['type']=='u' ? '' : '<a class="button pp-duplicate-design-btn" href="'.$cart_item['_w2p_set_option'].'" >' . __("Copy Design", "PitchPrint") . '</a>')
			);
        }
		return $item_data;
	}
	function pp_remove_add_to_cart_buttons() {
		//Function to hide add to cart button on the shop page...
		global $product;
		global $woocommerce;
		$pp_set_option = get_post_meta($product->id, '_w2p_set_option', true);
		if ($pp_set_option != '') {
			$handler = apply_filters('woocommerce_add_to_cart_handler', $product->product_type, $product);
			if ($handler != 'variable' && $handler != 'grouped' && $handler != 'external') {
				if ($product->is_purchasable()) {
					wc_enqueue_js("change_addtocart_button('{$product->id}', '{$product->get_sku()}', '" . apply_filters( 'not_purchasable_url', get_permalink($product->id) ) . "', '" . apply_filters( 'not_purchasable_text', __( 'Read More', 'woocommerce' ) ) . "');");
				}
			}
		}
	}
	function add_pp_edit_button() {
		global $post;
		global $woocommerce;
		$pp_mode = 'new';
		$pp_set_option = get_post_meta( $post->ID, '_w2p_set_option', true );
        if (strpos($pp_set_option, ':') === false) $pp_set_option = $pp_set_option . ':0';
        $pp_set_option = explode(':', $pp_set_option);
        if (count($pp_set_option) === 2) $pp_set_option[2] = 0;
		$pp_project_id = 'undefined';
		$pp_uid = get_current_user_id();
		$pp_now_value = '';
		$pp_previews = '';
        $pp_upload_ready = false;
		
		if (!isset($_SESSION)) session_start();
		if (isset($_SESSION['pp_projects'])) {
			if (isset($_SESSION['pp_projects'][$post->ID])) {
				$pp_now_value = $_SESSION['pp_projects'][$post->ID];
				$opt_ = json_decode(rawurldecode($_SESSION['pp_projects'][$post->ID]), true);
                if ($opt_['type'] === 'u') {
                    $pp_upload_ready = true;
					$pp_mode = 'upload';
                } else if ($opt_['type'] === 'p') {
                    $pp_mode = 'edit';
                    $pp_project_id = '"' . $opt_['projectID'] . '"';
                    $pp_previews = $opt_['numPages'];
                }
			}
		}
		
		wc_enqueue_js( " pp_currentValues = '" . $pp_now_value . "'; pp_client = 'wp'; pp_uploadURL='". plugins_url('uploader/', __FILE__) ."'; pp_baseUrl = '" . SERVER_URLPATH . "'; pp_appUrl = '" . SERVER_URLPATH . "/app/'; pp_runtimePath = '" . SERVER_URLPATH . "/runtime/'; pp_rscCdn = '" . SERVER_RSCCDN . "'; pp_rscBase = '" . SERVER_RSCBASE . "'; pp_pluginRoot='".plugins_url('/', __FILE__)."'; pp_uploadURL = '". plugins_url('uploader/', __FILE__) ."'; pp_mode = '{$pp_mode}';  pp_languageID = '" . substr(get_bloginfo('language'), 0, 2) . "'; pp_hideCartButton = " . $pp_set_option[2] . ";  pp_enableUpload = " . $pp_set_option[1] . ";   pp_designID = '" . $pp_set_option[0] . "';  pp_apiKey = '" . PITCH_APIKEY . "';  pp_product = { id:'" . $post->ID . "', name:'" . $post->post_name . "'};  pp_projectID = {$pp_project_id}; pp_userID = '{$pp_uid}'; pp_previews = '{$pp_previews}';" );
				
        echo '<style>
				.pp-main-ui {
					margin-bottom: 15px !important;
					margin-right: 15px !important;
					display: block;
				}
			</style>
			<input type="hidden" id="_w2p_set_option" name="_w2p_set_option" value="' . $pp_now_value . '" />
			<div id="pp-main-btn-sec" > </div>';
		
		if (is_user_logged_in()) {
			global $current_user;
			get_currentuserinfo();
			wc_enqueue_js("pp_userData = {email:'" . $current_user->user_email . "', name:'" . $current_user->display_name . "'};");
		}
		wc_enqueue_js(" PPrint.start();");
		
	}


	//Admin.. ------------------------------------------------------------------------------------------------
	function ppa_actions() {
		add_menu_page( 'PitchPrint', 'PitchPrint', 'manage_options', 'w2p', 'show_ppa_admin');
    }
	function ppa_header_files() {
		wp_enqueue_script('pitchprint_admin', PPA_WP_CDN_PATH);
		$timestamp = time();
		$signature = md5(PITCH_APIKEY . PITCH_SECRETKEY . $timestamp);
		wc_enqueue_js("ppa_rscCdn = '" . SERVER_RSCCDN . "'; ppa_rscBase = '" . SERVER_RSCBASE . "'; ppa_runtimePath = '" . SERVER_URLPATH . "/runtime/'; ppa_adminPath = '" . SERVER_URLPATH . "/admin/'; ppa_credentials = {timestamp:'" . $timestamp . "', apiKey:'" . PITCH_APIKEY . "', signature:'" . $signature . "'};");
	}
	function ppa_add_tab() {
		global $post, $woocommerce;
        echo '</div><div class="options_group show_if_simple show_if_variable"><input type="hidden" value="' . get_post_meta( $post->ID, '_w2p_set_option', true ) . '" id="ppa_values" name="ppa_values" >';
		
        $ppa_upload_selected_option = '';
        $ppa_hide_Cart_btn_option = '';
		$ppa_selected_option = get_post_meta( $post->ID, '_w2p_set_option', true );
        $ppa_selected_option = explode(':', $ppa_selected_option);
        if (count($ppa_selected_option) > 1) $ppa_upload_selected_option = ($ppa_selected_option[1] === '1' ? 'checked' : '');
        if (count($ppa_selected_option) > 2) $ppa_hide_Cart_btn_option = ($ppa_selected_option[2] === '1' ? 'checked' : '');
        
		woocommerce_wp_select( array(
				'id'            => 'ppa_pick',
				'value'			=>	$ppa_selected_option[0],
				'wrapper_class' => '',
				'options'       => array('' => 'None'),
				'label'         => 'PitchPrint Design',
				'desc_tip'    	=> true,
				'description' 	=> __("Visit the PitchPrint Admin Panel to create and edit designs", 'PitchPrint')
			) );
        woocommerce_wp_checkbox( array(
				'id'            => 'ppa_pick_hide_cart_btn',
				'value'		    => $ppa_hide_Cart_btn_option,
                'label'         => '',
                'cbvalue'		=> 'checked',
                'description' 	=> '&#8678; ' . __("Check this to hide \"Add to Cart\" button until customer customizes or uploads their designs.", 'PitchPrint')
			) );
        
        woocommerce_wp_checkbox( array(
				'id'            => 'ppa_pick_upload',
				'value'		    => $ppa_upload_selected_option,
                'label'         => '',
                'cbvalue'		=> 'checked',
                'description' 	=> '&#8678; ' . __("Check this to enable clients to upload their files", 'PitchPrint')
			) );
		wc_enqueue_js("ppa_selectedOption = '" . $ppa_selected_option[0] . "';	PPrintA.fetchDesigns();");
	}
	function ppa_write_panel_save( $post_id ) {
		$ppa_set_option = $_POST['ppa_values'];
		update_post_meta( $post_id, '_w2p_set_option', $ppa_set_option );
	}
    function show_ppa_admin() {
		$issues = '';
		$PITCH_APIKEY = defined('PITCH_APIKEY') ? PITCH_APIKEY : '';
		$PITCH_SECRETKEY = defined('PITCH_SECRETKEY') ? PITCH_SECRETKEY : '';
		$PITCH_JSCRIPT = defined('PITCH_JSCRIPT') ? PITCH_JSCRIPT : '';
		
		if (!is_writable(plugin_dir_path(__FILE__) . 'system/settings.php')) {
			$issues .= '<br/><br/>' . __("Sorry, the file", 'PitchPrint') . ' "' . plugin_dir_path(__FILE__) . 'system/settings.php" ' . __("is not writable.", 'PitchPrint');
		}
		
		if (isset($_POST['ppa_inpt_apiKey']) && isset($_POST['ppa_inpt_secretKey']) && $issues === '') {
			if (!empty($_POST['ppa_inpt_apiKey']) && !empty($_POST['ppa_inpt_secretKey'])) {
				$jscr = addslashes($_POST['ppa_inpt_jscript']);
				$jscr = str_replace('\"', '"', $jscr);
				$str = "<?php define('PITCH_APIKEY', '{$_POST['ppa_inpt_apiKey']}');     define('PITCH_SECRETKEY', '{$_POST['ppa_inpt_secretKey']}'); define(PITCH_JSCRIPT, '" . $jscr ."'); ?>";
				$handle = fopen(plugin_dir_path(__FILE__)."system/settings.php", "wb");
				fwrite($handle, $str);
				fclose($handle);
				$PITCH_APIKEY = $_POST['ppa_inpt_apiKey'];
				$PITCH_SECRETKEY = $_POST['ppa_inpt_secretKey'];
				$PITCH_JSCRIPT = $_POST['ppa_inpt_jscript'];
			}
		}
		if ($issues !== '') {
			echo '<div class="wrap" style="color:#F00">' . $issues . '</div>';
			exit();
		}
		
		echo '<div class="wrap">
				<div style="margin-top:20px; font-size:16px"><br/><b>PITCHPRINT ' . __("SETTINGS", "PitchPrint") . ':</b><br/></div><div style="margin:20px;">
				<form method="post" action="">
					<label style="display:inline-block; width:120px">API KEY:</label> <input style="width:280px" name="ppa_inpt_apiKey" type="text" value="' . $PITCH_APIKEY . '" /><br/>
					<label style="display:inline-block; width:120px">SECRET KEY:</label> <input style="width:280px" name="ppa_inpt_secretKey" type="text" value="' . $PITCH_SECRETKEY . '" /><br/><br/>
					<label style="display:inline-block; width:120px; vertical-align: top;">Custom Js-Script:</label> <textarea rows="20" style="width:800px; font-family: monospace;" name="ppa_inpt_jscript" >' . stripslashes($PITCH_JSCRIPT) . '</textarea><br/>
					<label style="display:inline-block; width:120px"></label> <input style="width:120px" class="button action" type="submit" value="' . __("Update", "PitchPrint") . '.." /><br/>
				</form></div></div>
				
				<div class="wrap">
					<div class="frm-section-inner-noline" style="padding-left: 140px; margin-top:40px;" >
						<span style="font-size:10px; font-style:italic">' . __("To generate keys, manage designs, pitcures, templates etc, please login to the admin panel", "PitchPrint") . '</span><br/><br/>
						<a href="' . SERVER_URLPATH . '/admin/domains" target="_blank"><input type="submit" class="button action" value="' . __("LAUNCH PITCHPRINT ADMIN PANEL", "PitchPrint") . '" /></a>
					</div>
				</div>';
	}
	
?>