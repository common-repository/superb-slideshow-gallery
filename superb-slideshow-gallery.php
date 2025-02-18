<?php
/*
Plugin Name: Superb slideshow gallery
Plugin URI: http://www.gopiplus.com/work/2010/10/10/superb-slideshow-gallery/
Description: Superb slideshow gallery is a strong cross browser fade in slideshow script that incorporates some of your most requested features all rolled into one. Each instance of a fade in slideshow on the page is completely independent of the other, with support for different features selectively enabled for each slide show.  
Author: Gopi Ramasamy
Version: 13.2
Author URI: http://www.gopiplus.com/work/2010/10/10/superb-slideshow-gallery/
Donate link: http://www.gopiplus.com/work/2010/10/10/superb-slideshow-gallery/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: superb-slideshow-gallery
Domain Path: /languages
*/

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

global $wpdb, $wp_version;
define("WP_ssg_TABLE", $wpdb->prefix . "ssg_superb_gallery");
define('WP_SSG_FAV', 'http://www.gopiplus.com/work/2010/10/10/superb-slideshow-gallery/');

if ( ! defined( 'WP_SSG_BASENAME' ) )
	define( 'WP_SSG_BASENAME', plugin_basename( __FILE__ ) );
	
if ( ! defined( 'WP_SSG_PLUGIN_NAME' ) )
	define( 'WP_SSG_PLUGIN_NAME', trim( dirname( WP_SSG_BASENAME ), '/' ) );
	
if ( ! defined( 'WP_SSG_PLUGIN_URL' ) )
	define( 'WP_SSG_PLUGIN_URL', plugins_url() . '/' . WP_SSG_PLUGIN_NAME );
	
if ( ! defined( 'WP_SSG_ADMIN_URL' ) )
	define( 'WP_SSG_ADMIN_URL', admin_url() . 'options-general.php?page=superb-slideshow-gallery' );

function ssg_show() 
{
	global $wpdb;
	$ssg_package = "";
	$ssg_width = get_option('ssg_width');
	$ssg_height = get_option('ssg_height');
	$ssg_pause = get_option('ssg_pause');
	$ssg_fadeduration = get_option('ssg_fadeduration');
	$ssg_descreveal = get_option('ssg_descreveal');
	$ssg_cycles = get_option('ssg_cycles');
	$ssg_random = get_option('ssg_random');
	$ssg_type = get_option('ssg_type');
	
	if(!is_numeric($ssg_width)) {	$ssg_width = 250;	} 
	if(!is_numeric($ssg_height)) {	$ssg_height = 200;	}
	if(!is_numeric($ssg_pause)) {	$ssg_pause = 2500;	}
	if(!is_numeric($ssg_fadeduration)) { $ssg_fadeduration = 500; }
	if(!is_numeric($ssg_cycles)) {	$ssg_cycles = 0;	}
	
	$sSql = "select ssg_path,ssg_link,ssg_target,ssg_title from ".WP_ssg_TABLE." where 1=1";
	$sSql = $sSql . " and ssg_type = %s ";
	if($ssg_random == "YES"){ $sSql = $sSql . " ORDER BY RAND()"; }else{ $sSql = $sSql . " ORDER BY ssg_order"; }
	
	$sSql = $wpdb->prepare($sSql, $ssg_type);
	
	$data = $wpdb->get_results($sSql);
	
	if ( ! empty($data) ) 
	{
		foreach ( $data as $data ) 
		{
			$ssg_package = $ssg_package .'["'.$data->ssg_path.'", "'.$data->ssg_link.'", "'.$data->ssg_target.'", "'.$data->ssg_title.'"],';
		}
		$ssg_package = substr($ssg_package,0,(strlen($ssg_package)-1));
		?>
		<script type="text/javascript">
		var mygallery=new SuperbSlideshowGallery ({
		wrapperid: "fadeshow1",
		dimensions: [<?php echo $ssg_width; ?>, <?php echo $ssg_height; ?>],
		imagearray: [ <?php echo $ssg_package; ?> ],
		displaymode: {type:'auto', pause:<?php echo $ssg_pause; ?>, cycles:<?php echo $ssg_cycles; ?>, wraparound:false},
		persist: false,
		fadeduration: <?php echo $ssg_fadeduration; ?>,
		descreveal: "<?php echo $ssg_descreveal; ?>",
		togglerid: ""
		})
		</script>
		<div id="fadeshow1" style="max-width:100%"></div>
		<?php
	}
	else
	{
		_e('No records available for the type', 'superb-slideshow-gallery') . $ssg_type;
	}
}

add_shortcode( 'ssg-superb-slideshow', 'ssg_shortcode' );

function ssg_shortcode($atts) 
{
	global $wpdb;

	// New short code
	//[ssg-superb-slideshow type="widget" width="250" height="165" pause="2500" fade="500" cycles="0" rand="YES"]
	if ( ! is_array( $atts ) )
	{
		return '';
	}
	$ssg_type = $atts['type'];
	$ssg_width = $atts['width'];
	$ssg_height = $atts['height'];
	$ssg_pause = $atts['pause'];
	$ssg_fadeduration = $atts['fade'];
	$ssg_cycles = $atts['cycles'];
	$ssg_random = $atts['rand'];
	
	$ssg_xml = "";
	$ssg_package = "";
	//list($ssg_type, $ssg_width, $ssg_height, $ssg_pause, $ssg_fadeduration, $ssg_cycles, $ssg_random) = split('[=.-]', $var);
	
	if($ssg_type==""){$ssg_type = "widget";}
	if(!is_numeric($ssg_width)) {	$ssg_width = 250;	} 
	if(!is_numeric($ssg_height)) {	$ssg_height = 200;	}
	if(!is_numeric($ssg_pause)) {	$ssg_pause = 2500;	}
	if(!is_numeric($ssg_fadeduration)) { $ssg_fadeduration = 500; }
	if(!is_numeric($ssg_cycles)) {	$ssg_cycles = 0; }
	
	$ssg_descreveal = get_option('ssg_descreveal1');
	if( $ssg_descreveal == "")
	{
		$ssg_descreveal = "peek-a-boo";
	}
	
	$sSql = "select ssg_path,ssg_link,ssg_target,ssg_title from ".WP_ssg_TABLE." where 1=1";
	$sSql = $sSql . " and ssg_type = %s ";
	if($ssg_random == "YES"){ $sSql = $sSql . " ORDER BY RAND()"; }else{ $sSql = $sSql . " ORDER BY ssg_order"; }
	
	$sSql = $wpdb->prepare($sSql, $ssg_type);
	
	$data = $wpdb->get_results($sSql);

	if ( ! empty($data) ) 
	{
		foreach ( $data as $data ) 
		{
			$ssg_package = $ssg_package .'["'.$data->ssg_path.'", "'.$data->ssg_link.'", "'.$data->ssg_target.'", "'.$data->ssg_title.'"],';
		}
		$ssg_package = substr($ssg_package,0,(strlen($ssg_package)-1));
		$newwrapperid = $ssg_type;
		$type = "auto";		
		$ssg_xml = $ssg_xml .'<script type="text/javascript">';
		$ssg_xml = $ssg_xml .'var mygallery=new SuperbSlideshowGallery({wrapperid: "'.$newwrapperid.'", dimensions: ['.$ssg_width.', '.$ssg_height.'], imagearray: [ '.$ssg_package.' ],displaymode: {type:"'.$type.'", pause:'.$ssg_pause.', cycles:'.$ssg_cycles.', wraparound:false},	persist: false, fadeduration: '.$ssg_fadeduration.', descreveal: "'.$ssg_descreveal.'",togglerid: ""})';
		$ssg_xml = $ssg_xml .'</script>';
		$ssg_xml = $ssg_xml .'<div id="'.$newwrapperid.'" style="max-width:100%"></div>';
	}
	else
	{
		$ssg_xml = __( 'No records found, please check your short code' , 'superb-slideshow-gallery');
	}
	return $ssg_xml;
}

function ssg_install() 
{
	global $wpdb;
	if($wpdb->get_var("show tables like '". WP_ssg_TABLE . "'") != WP_ssg_TABLE) 
	{
		$sSql = "CREATE TABLE IF NOT EXISTS `". WP_ssg_TABLE . "` (";
		$sSql = $sSql . "`ssg_id` INT NOT NULL AUTO_INCREMENT ,";
		$sSql = $sSql . "`ssg_path` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,";
		$sSql = $sSql . "`ssg_link` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,";
		$sSql = $sSql . "`ssg_target` VARCHAR( 50 ) NOT NULL ,";
		$sSql = $sSql . "`ssg_title` VARCHAR( 1024 ) NOT NULL ,";
		$sSql = $sSql . "`ssg_order` INT NOT NULL ,";
		$sSql = $sSql . "`ssg_status` VARCHAR( 10 ) NOT NULL ,";
		$sSql = $sSql . "`ssg_type` VARCHAR( 100 ) NOT NULL ,";
		$sSql = $sSql . "`ssg_date` INT NOT NULL ,";
		$sSql = $sSql . "PRIMARY KEY ( `ssg_id` )";
		$sSql = $sSql . ") ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
		$wpdb->query($sSql);
		$sSql = "INSERT INTO `". WP_ssg_TABLE . "` (ssg_path, ssg_link, ssg_target, ssg_title, ssg_order, ssg_status, ssg_type, ssg_date)"; 
		$sSql = $sSql . "VALUES ('".WP_SSG_PLUGIN_URL."/images/250x167_1.jpg','#','_parent','No title','1', 'YES', 'SAMPLE', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		$sSql = "INSERT INTO `". WP_ssg_TABLE . "` (ssg_path, ssg_link, ssg_target, ssg_title, ssg_order, ssg_status, ssg_type, ssg_date)"; 
		$sSql = $sSql . "VALUES ('".WP_SSG_PLUGIN_URL."/images/250x167_2.jpg','#','_parent','No title','2', 'YES', 'SAMPLE', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		$sSql = "INSERT INTO `". WP_ssg_TABLE . "` (ssg_path, ssg_link, ssg_target, ssg_title, ssg_order, ssg_status, ssg_type, ssg_date)"; 
		$sSql = $sSql . "VALUES ('".WP_SSG_PLUGIN_URL."/images/250x167_3.jpg','#','_parent','No title','3', 'YES', 'WIDGET', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		$sSql = "INSERT INTO `". WP_ssg_TABLE . "` (ssg_path, ssg_link, ssg_target, ssg_title, ssg_order, ssg_status, ssg_type, ssg_date)"; 
		$sSql = $sSql . "VALUES ('".WP_SSG_PLUGIN_URL."/images/250x167_4.jpg','#','_parent','No title','4', 'YES', 'WIDGET', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
	}
	add_option('ssg_title', "superb gallery");
	add_option('ssg_width', "250");
	add_option('ssg_height', "167");
	add_option('ssg_pause', "2500");
	add_option('ssg_fadeduration', "500");
	add_option('ssg_descreveal', "always");
	add_option('ssg_cycles', "0");
	add_option('ssg_random', "YES");
	add_option('ssg_type', "WIDGET");
	add_option('ssg_descreveal1', "peek-a-boo");
}

function ssg_widget($args) 
{
	extract($args);
	if(get_option('ssg_title') <> "")
	{
		echo $before_widget . $before_title;
		echo get_option('ssg_title');
		echo $after_title;
	}
	ssg_show();
	if(get_option('ssg_title') <> "")
	{
		echo $after_widget;
	}
}

function ssg_admin_option() 
{
	global $wpdb;
	$current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
	switch($current_page)
	{
		case 'edit':
			include('pages/image-management-edit.php');
			break;
		case 'add':
			include('pages/image-management-add.php');
			break;
		case 'set':
			include('pages/image-setting.php');
			break;
		default:
			include('pages/image-management-show.php');
			break;
	}
}

function ssg_control()
{
	echo '<p><b>';
	 _e('Superb slideshow gallery', 'superb-slideshow-gallery');
	echo '.</b> ';
	_e('Check official website for more information', 'superb-slideshow-gallery');
	?> <a target="_blank" href="<?php echo WP_SSG_FAV; ?>"><?php _e('click here', 'superb-slideshow-gallery'); ?></a></p><?php
}

function ssg_widget_init() 
{
	if(function_exists('wp_register_sidebar_widget')) 	
	{
		wp_register_sidebar_widget('superb-slideshow-gallery', __('Superb slideshow gallery', 'superb-slideshow-gallery'), 'ssg_widget');
	}
	
	if(function_exists('wp_register_widget_control')) 	
	{
		wp_register_widget_control('superb-slideshow-gallery', array(__('Superb slideshow gallery', 'superb-slideshow-gallery'), 'widgets'), 'ssg_control');
	} 
}

function ssg_deactivation() 
{
	// No action required.
}

function ssg_add_to_menu() 
{
	if (is_admin()) 
	{
		add_options_page(__('Superb slideshow gallery', 'superb-slideshow-gallery'),
							__('Superb slideshow gallery', 'superb-slideshow-gallery'),'manage_options',
								'superb-slideshow-gallery','ssg_admin_option');  
	}
}

function ssg_add_javascript_files() 
{
	if (!is_admin())
	{
		wp_enqueue_script('jquery');
		wp_enqueue_script( 'superb-slideshow-gallery', WP_SSG_PLUGIN_URL.'/inc/superb-slideshow-gallery.js');
	}
}    

function ssg_textdomain() 
{
	  load_plugin_textdomain( 'superb-slideshow-gallery', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

function ssg_adminscripts() 
{
	if( !empty( $_GET['page'] ) ) 
	{
		switch ( $_GET['page'] ) 
		{
			case 'superb-slideshow-gallery':
				wp_register_script( 'ssg-adminscripts', plugins_url( 'pages/setting.js', __FILE__ ), '', '', true );
				wp_enqueue_script( 'ssg-adminscripts' );
				$ssg_select_params = array(
					'ssg_path'   	=> __( 'Please enter the image path.', 'ssg-select', 'superb-slideshow-gallery' ),
					'ssg_link'   	=> __( 'Please enter the target link.', 'ssg-select', 'superb-slideshow-gallery' ),
					'ssg_target' 	=> __( 'Please select the target option.', 'ssg-select', 'superb-slideshow-gallery' ),
					'ssg_title' 	=> __( 'Please enter the image title.', 'ssg-select', 'superb-slideshow-gallery' ),
					'ssg_order'  	=> __( 'Please enter the display order, only number.', 'ssg-select', 'superb-slideshow-gallery' ),
					'ssg_status' 	=> __( 'Please select the display status.', 'ssg-select', 'superb-slideshow-gallery' ),
					'ssg_type'  	=> __( 'Please select the gallery type.', 'ssg-select', 'superb-slideshow-gallery' ),
					'ssg_delete'	=> __( 'Do you want to delete this record?', 'ssg-select', 'superb-slideshow-gallery' ),
				);
				wp_localize_script( 'ssg-adminscripts', 'ssg_adminscripts', $ssg_select_params );
				break;
		}
	}
}

add_action('plugins_loaded', 'ssg_textdomain');
add_action('wp_enqueue_scripts', 'ssg_add_javascript_files');
add_action('admin_menu', 'ssg_add_to_menu');
add_action("plugins_loaded", "ssg_widget_init");
register_activation_hook(__FILE__, 'ssg_install');
register_deactivation_hook(__FILE__, 'ssg_deactivation');
add_action('init', 'ssg_widget_init');
add_action( 'admin_enqueue_scripts', 'ssg_adminscripts' );
?>