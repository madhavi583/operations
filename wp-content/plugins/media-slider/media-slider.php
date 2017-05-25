<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
@package Media Slider
Plugin Name: Media Slider
Plugin URI: http://awplife.com/
Description: Media Slider plugin with preview for Wordpress
Version: 0.1.9
Author: A WP Life
Author URI: http://awplife.com/
Text Domain: MSP_TXTDM
Domain Path: /languages
*/

if ( ! class_exists ( 'Awl_Media_Slider' ) ) {
	
	class Awl_Media_Slider {
		
		public function __construct() {
			$this->_constants();
			$this->_hooks();
		}
		
		protected function _constants() {
			
			//Plugin Version
			define( 'MS_PLUGIN_VER', '0.0.8' );
			
			//Plugin Text Domain
			define("MSP_TXTDM","awl_media_slider");
			
			//Plugin Name
			define( 'MS_PLUGIN_NAME', __( 'Media Slider', MSP_TXTDM ) );
			
			//Plugin Slug
			define( 'MS_PLUGIN_SLUG', 'media_slider');
			
			//Plugin Directory Path
			define( 'MS_PLUGIN_DIR', plugin_dir_path(__FILE__) );
			
			//Plugin Driectory URL
			define( 'MS_PLUGIN_URL', plugin_dir_url(__FILE__) );
			
			/**
			 * Create a key for the .htaccess secure download link.
			 * @uses    NONCE_KEY     Defined in the WP root config.php
			 */
			define( 'MSP_SECURE_KEY', md5( NONCE_KEY ) );
			
		} // end of constructor function
		
		/**
		 * Setup the default filters and actions
		 */
		protected function _hooks() {
			
			//Load Text Domain
			add_action( 'plugins_loaded', array( $this , '_load_textdomain' ) );
			
			//Add Slider Menu Item
			add_action( 'admin_menu', array( $this, '_srgallery_menu') );
			
			//Create Media Slider Pro Custom Post
			add_action( 'init', array( $this, '_Media_Slider') );
			
			//Add Meta Box To Custom Post
			add_action( 'add_meta_boxes', array( $this, '_ms_admin_add_meta_box') );
			
			add_action( 'wp_ajax_media_slider_js', array(&$this, 'ajax_media_slider') );
			
			add_action( 'save_post', array( &$this, '_ms_save_settings') );
			
			//Shortcode Compatibility in Text Widegts
			add_filter( 'widget_text', 'do_shortcode');
			
		} // end of hook function
		
		public function _load_textdomain() {
			load_plugin_textdomain( MSP_TXTDM, false, dirname( plugin_basename(__FILE__) ) .'/languages' );			
		}
		
		public function _srgallery_menu() {
			$help_menu = add_submenu_page( 'edit.php?post_type='.MS_PLUGIN_SLUG, __( 'Docs', MSP_TXTDM ), __( 'Docs', MSP_TXTDM ), 'administrator', 'sr-doc-page', array( $this, '_ms_doc_page') );
			$ms_featured_plugin_menu = add_submenu_page( 'edit.php?post_type='.MS_PLUGIN_SLUG, __( 'Featured-Plugin', MSP_TXTDM ), __( 'Featured Plugin', MSP_TXTDM ), 'administrator', 'sr-featured-plugin-page', array( $this, '_ms_featured_plugin_page') );
		}
		
		/**
		 * Media Slider Pro Custom Post
		 * Create slider post type in admin dashboard.
		*/
		public function _Media_Slider() {
			$labels = array(
				'name'                => _x( 'Media Slider', 'post type general name', MSP_TXTDM ),
				'singular_name'       => _x( 'Media Slider', 'post type singular name', MSP_TXTDM ),
				'menu_name'           => __( 'Media Slider', MSP_TXTDM ),
				'name_admin_bar'      => __( 'Media Slider', MSP_TXTDM ),
				'parent_item_colon'   => __( 'Parent Item:', MSP_TXTDM ),
				'all_items'           => __( 'All Media Slider', MSP_TXTDM ),
				'add_new_item'        => __( 'Add Media Slider', MSP_TXTDM ),
				'add_new'             => __( 'Add Media Slider', MSP_TXTDM ),
				'new_item'            => __( 'Media Slider', MSP_TXTDM ),
				'edit_item'           => __( 'Edit Media Slider', MSP_TXTDM ),
				'update_item'         => __( 'Update Media Slider', MSP_TXTDM ),
				'search_items'        => __( 'Search Media Slider', MSP_TXTDM ),
				'not_found'           => __( 'Media Slider Not found', MSP_TXTDM ),
				'not_found_in_trash'  => __( 'Media Slider Not found in Trash', MSP_TXTDM ),
			);

			$args = array(
				'label'               => __( 'Media Slider', MSP_TXTDM ),
				'description'         => __( 'Custom Post Type For Media Slider', MSP_TXTDM ),
				'labels'              => $labels,
				'supports'            => array( 'title'),
				'taxonomies'          => array(),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_position'       => 65,
				'menu_icon'           => 'dashicons-images-alt2',
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => true,
				'can_export'          => true,
				'has_archive'         => true,		
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'page',
			);

			register_post_type( 'media_slider', $args );
		}//end of post type function
		
		/**
		 * Adds Meta Boxes
		*/
		public function _ms_admin_add_meta_box() {
			// Syntax: add_meta_box( $id, $title, $callback, $screen, $context, $priority, $callback_args );
			add_meta_box( '', __('Add Image/Poster', MSP_TXTDM), array(&$this, 'ms_upload_multiple_images'), 'media_slider', 'normal', 'default' );
		}
		
		public function ms_upload_multiple_images($post) {
				wp_enqueue_script('media-upload');
				wp_enqueue_script('awl-ms-uploader.js', MS_PLUGIN_URL . 'js/awl-ms-uploader.js', array('jquery'));
				wp_enqueue_style('awl-ms-uploader-css', MS_PLUGIN_URL . 'css/awl-ms-uploader.css');
				wp_enqueue_style('style-css', MS_PLUGIN_URL . 'css/style.css');
				wp_enqueue_style('awl-em-pe-icon-7-stroke-css', MS_PLUGIN_URL . 'css/pe-icon-7-stroke.css');
				wp_enqueue_media();
				?>
				<div id="media-slider-gallery">
					<input type="button" id="remove-all-media-slides" name="remove-all-media-slides" class="button button-large remove-all-media-slides" rel="" value="<?php _e('Delete All Images', MSP_TXTDM); ?>">
					<ul id="remove-media-slides" class="mediabox">
					<?php
					$allimagesetting = unserialize(base64_decode(get_post_meta( $post->ID, 'awl_ms_settings_'.$post->ID, true)));
					if(isset($allimagesetting['media-slide-ids'])) {
						$count = 0;
					foreach($allimagesetting['media-slide-ids'] as $id) {
						$thumbnail = wp_get_attachment_image_src($id, 'medium', true);
						$attachment = get_post( $id );
						$slide_link =  $allimagesetting['media-slide-link'][$count];
						$slide_type =  $allimagesetting['media-slide-type'][$count];
						?>
						<li class="media-slide">
							<img class="new-media-slide" src="<?php echo $thumbnail[0]; ?>" alt="<?php echo get_the_title($id); ?>" style="height: 150px; width: 98%; border-radius: 8px;">
							<input type="hidden" id="media-slide-ids[]" name="media-slide-ids[]" value="<?php echo $id; ?>" />
							<!-- Image Title, Caption, Alt Text-->
							<select id="media-slide-type[]" name="media-slide-type[]" class="form-control" style="width: 100%;" value="<?php echo $slide_type; ?>" >
								<option value="i" <?php if($slide_type == "i") echo "selected=selected"; ?>>Image</option>
								<option value="v" <?php if($slide_type == "v") echo "selected=selected"; ?>>Video</option>
							</select>
							<input type="text" name="media-slide-link[]" id="media-slide-link[]" style="width: 100%;" placeholder="Enter URL / ID" value="<?php echo $slide_link; ?>">
							<input type="text" name="media-slide-title[]" id="media-slide-title[]" style="width: 100%;" placeholder="Title Here" value="<?php echo get_the_title($id); ?>">
							<textarea name="media-slide-desc[]" id="media-slide-desc[]" style="width: 100%;" placeholder="Enter Description"><?php echo $attachment->post_content; ?></textarea>
							<input type="button" name="remove-media-slide" id="remove-media-slide" class="button remove-single-media-slide button-danger" style="width: 100%;" value="Delete">
						</li>
					<?php $count++; } // end of foreach
					} //end of if
					?>
					</ul>
				</div>
				
				<!--Add New Image/Video Button-->
				<div name="add-new-media-slider" id="add-new-media-slider" class="new-media-slider" style="height: 145px; width: 150px; border-radius: 20px;">
					<img src="<?php echo MS_PLUGIN_URL ?>/css/new-slide.png" height="100px" width="100px;"/>
				</div><br><br>
				<span class="add-text"><?php _e('Add Image / Poster', MSP_TXTDM); ?></span>
				<div style="clear:left;"></div>
				<br>
				<h1 style="font-family:Geneva; margin-bottom:-10px;"><?php _e('Copy Media Slider Shortcode', MSP_TXTDM); ?></h1>
				<hr>
				<p class="input-text-wrap">
					<p><?php _e('Copy & Embed shotcode into any Page/ Post / Text Widget to display your media slider on site.', MSP_TXTDM); ?><br></p>
					<input type="text" name="shortcode" id="shortcode" value="<?php echo "[MDSL id=".$post->ID."]"; ?>" readonly style="height: 60px; text-align: center; font-size: 24px; width: 25%; border: 2px dashed;" onmouseover="return pulseOff();" onmouseout="return pulseStart();">
				</p>
				<br>
				<hr>				
				<br>
				<h1 style="font-family:Geneva;"><?php _e('Media Slider Setting', MSP_TXTDM); ?></h1>
				<hr>
				<?php
				require_once('media-slider-settings.php');
		}
		
		public function _ms_ajax_callback_function($id) {
			//wp_get_attachment_image_src ( int $attachment_id, string|array $size = 'thumbnail', bool $icon = false )
			//thumb, thumbnail, medium, large, post-thumbnail
			$thumbnail = wp_get_attachment_image_src($id, 'medium', true);
			$attachment = get_post( $id ); // $id = attachment id
			?>
			<li class="media-slide">
				<img class="new-media-slide" src="<?php echo $thumbnail[0]; ?>" alt="<?php echo get_the_title($id); ?>" style="height: 150px; width: 98%; border-radius: 8px;">
				<input type="hidden" id="media-slide-ids[]" name="media-slide-ids[]" value="<?php echo $id; ?>" />
				<select id="media-slide-type[]" name="media-slide-type[]" class="form-control" style="width: 100%;" placeholder="Image Title" value="<?php echo $slide_type; ?>" >
					<option value="i" <?php if($slide_type == "i") echo "selected=selected"; ?>>Image</option>
					<option value="v" <?php if($slide_type == "v") echo "selected=selected"; ?>>Video</option>
				</select>
				<input type="text" name="media-slide-link[]" id="media-slide-link[]" style="width: 100%;" placeholder="Enter Image / Video URL">
				<input type="text" name="media-slide-title[]" id="media-slide-title[]" style="width: 100%;" placeholder="Title Here" value="<?php echo get_the_title($id); ?>">
				<textarea name="media-slide-desc[]" id="media-slide-desc[]" style="width: 100%;" placeholder="Enter Description"><?php echo $attachment->post_content; ?></textarea>
				<input type="button" name="remove-media-slide" id="remove-media-slide" style="width: 100%;" class="button" value="Delete">
			</li>
			<?php
		}
		
		public function ajax_media_slider() {
			echo $this->_ms_ajax_callback_function($_POST['slideId']);
			die;
		}
		
		public function _ms_save_settings($post_id) {
			if(isset($_POST['ms_save_nonce'])) {
				if ( !isset( $_POST['ms_save_nonce'] ) || !wp_verify_nonce( $_POST['ms_save_nonce'], 'ms_save_settings' ) ) {
				   print 'Sorry, your nonce did not verify.';
				   exit;
				} else {
				$image_ids = $_POST['media-slide-ids'];
				$image_titles = ($_POST['media-slide-title']);
				$image_types = ($_POST['media-slide-type']);
				$i = 0;
				foreach($image_ids as $image_id) {
					$single_image_update = array(
						'ID'           => $image_id,
						'post_title'   => $image_titles[$i],
					);
					wp_update_post( $single_image_update );
					$i++;
					}				
					$awl_media_slider_shortcode_setting = "awl_ms_settings_".$post_id;
					update_post_meta($post_id, $awl_media_slider_shortcode_setting, base64_encode(serialize($_POST)));
				}
			}
		}// end save setting
		
		public function _ms_doc_page() {
			require_once('docs.php');
		}
		public function _ms_featured_plugin_page() {
			require_once('featured-plugins/featured-plugins.php');
		}
	}// end of class
	
	$ms_gallery_object = new Awl_Media_Slider();
	require_once('shortcode.php');
}
?>