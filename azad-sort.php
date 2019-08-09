<?php
/*
Plugin Name: Azad Sort
Description: Azad sort is a normal sorting plugin
Plugin URI: gittechs.com/plugin/
Author: Md. Abul Kalam Azad
Author URI: gittechs.com/author
Author Email: webdevazad@gmail.com
Version: 0.0.0.1
Text Domain: azad-sort
License: GPLv2 or later
*/
define('CPTPATH',   plugin_dir_path(__FILE__));
define('CPTURL',    plugins_url('', __FILE__));

include_once(CPTPATH . '/include/class.cpto.php');
include_once(CPTPATH . '/include/class.functions.php');

function cpto_class_load(){
    global $CPTO;
    $CPTO   =   new CPTO();
}
add_action( 'plugins_loaded', 'cpto_class_load');     

add_action( 'plugins_loaded', 'cpto_load_textdomain'); 
function cpto_load_textdomain() {
    load_plugin_textdomain('post-types-order', FALSE, dirname( plugin_basename( __FILE__ ) ) . '/languages');
}

add_action('wp_loaded', 'initCPTO' ); 	
function initCPTO(){
    global $CPTO;
    $options = $CPTO->functions->get_options();
    if (is_admin()){
         if(isset($options['capability']) && !empty($options['capability'])){
             if( current_user_can($options['capability']) )
             $CPTO->init(); 
        }else if (is_numeric($options['level'])){
            if ( $CPTO->functions->userdata_get_user_level(true) >= $options['level'] )
            $CPTO->init();
        }else{
            $CPTO->init();
         }
    }        
}