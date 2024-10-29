<?php
/**
 * Plugin Name: Colombia
 * Plugin URI: https://colombiaonline.com
 * Description: Colombia is one of the largest publisher-owned ad network platforms in APAC.It recommends sponsored content on its own marquee properties and on other premium publisher networks.
 * Version: 1.0.0
 * Author: Colombia
 */
include_once('widget.php');
if (!class_exists('ColombiaWP')) {
    class ColombiaWP
    {
		public $getsettings = '';	
        function __construct()
        {
			define('CLMB_PLUGIN_NAME','colombia');
			define( 'CLMB_PLUGIN_URL', plugins_url(CLMB_PLUGIN_NAME));
			if (is_admin()) {
				//add colombia menu in dashboard
				add_action('admin_menu', array(&$this,'add_dashboard_to_menu'));
				add_filter('plugin_action_links', array(&$this, 'plugin_action_links'), 10, 2 );
				register_deactivation_hook(  __FILE__, array($this,'colombia_uninstall_init'))	;
			}else {
				add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ));
				add_filter('script_loader_tag', array($this,'add_async_attribute'), 10, 2);
			}			
			$this->getsettings = unserialize(get_option('clmb_settings'));
			if(!empty($this->getsettings) && sanitize_text_field($this->getsettings['baticle_is_enabled']) == 'on'){
				add_filter('the_content', array(&$this, 'colombia_ads_after'));
			}
		}
		function plugin_action_links($links, $file) {
            static $this_plugin;

            if (!$this_plugin) {
                $this_plugin = plugin_basename(__FILE__);
            }

            if ($file == $this_plugin) {
                $settings_link = '<a href="' .admin_url().'?page=colombia">Settings</a>';
                array_unshift($links, $settings_link);
            }

            return $links;
        }
			// Add colombia menu in left navigation	 
		function add_dashboard_to_menu() {
			add_menu_page('Colombia', 'Colombia', 'manage_options', 'colombia', array(&$this, 'settings'), CLMB_PLUGIN_URL.'/img/colombia.png', 110);
		}
		function settings(){	
			$errors = array();
			$setsettings = array();
				if($_SERVER['REQUEST_METHOD'] == 'POST'){
					$isarticleval = sanitize_text_field($this->getsettings['baticle_is_enabled']);
					$postarticleval = sanitize_text_field($_POST['below_article_enabled']);
					$issetslotid = sanitize_text_field($this->getsettings['baticle_slt_id']);
					$postslotid = sanitize_text_field($_POST['below_article_slot_id']);
					if(empty($isarticleval) && $postarticleval == '')
					{
						$errors[] = "Please checked a 'Below Article' checkbox to apply changes.";
					}
					if(empty($issetslotid) && trim($postslotid) == '')
					{
						$errors[] = "Please add a 'Adslot ID' in order to apply changes.";
					}
					if(count($errors) == 0){
						$setsettings['baticle_is_enabled'] = $postarticleval;
						$setsettings['baticle_slt_id'] =  $postslotid;
						if(!empty($this->getsettings)){
							update_option('clmb_settings',serialize($setsettings));
						}else {
							add_option('clmb_settings',serialize($setsettings));
						}
					}
					// For updated result when submit form
					$this->getsettings = unserialize(get_option('clmb_settings'));
					require_once('msg.php');
				}
			  include_once('colombia_settings.php');
		}
		// colombia Ad display on article page
		function colombia_ads_after($content){ 
		   $pagType = $this->get_page_type();
		   $slotid = sanitize_text_field($this->getsettings['baticle_slt_id']);
			if(!empty($slotid) && $pagType == 'article'){
				$cat = get_the_category();
				$section = $cat[0]->name ? $cat[0]->name : 0;
				$coldiv = '<div class="colombia" style="min-width:1px; min-height:1px;margin-top:10px" data-slot="'.$slotid.'" data-position="1" data-section="'.$section.'" id="clmb_'.$slotid.'_1"></div>';
				$content = $content.$coldiv;
			}
			return $content;
		}
		
		// check page type
		function get_page_type(){

            $page_type='article';
            if (is_front_page()){
            $page_type='home';
            }else if (is_category() || is_archive() || is_search()){
                $page_type='category';
            }
            return $page_type;
        }	
		// add colombia js in header page;
		function register_assets() {
			wp_enqueue_script('colombia-js3','https://static.clmbtech.com/ad/commons/js/colombia_v2.js' ,null,'1.0.0', 'screen');
		 }
		
		function add_async_attribute($tag, $handle) {
		   // add script handles to the array below
		   $scripts_to_async = array('colombia-js3');
		   foreach($scripts_to_async as $async_script) {
			  if ($async_script === $handle) {
				 return str_replace(' src', ' async src', $tag);
			  }
		   }
		   return $tag;
		}		
		 
		 
		function colombia_uninstall_init(){ 
		delete_option('clmb_settings');
	}	

	}        
}

global $colombiaWP;
$colombiaWP = new ColombiaWP();