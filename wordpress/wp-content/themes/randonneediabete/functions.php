<?php

setlocale(LC_TIME, "fr_FR");

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
if (!function_exists('rd_theme_support')):

	function rd_theme_support() {
		add_theme_support('wp-block-styles');
		add_editor_style('style.css');
	}

endif;
add_action('after_setup_theme', 'rd_theme_support');

/**
 * Enqueue Styles
 */

if (!function_exists('rd_styles')):

  function rd_styles() {
    // Register Stylesheet
    wp_enqueue_style('rd-style', get_stylesheet_uri(), [], wp_get_theme()->get( 'Version' ));
    // wp_enqueue_style('rd-style-blocks', get_template_directory_uri() . '/assets/css/blocks.css'); // TODO: remove or configure blocks styles
  }

endif;
add_action('wp_enqueue_scripts', 'rd_styles');

// Close ACF fields by default
function script_close_acf_fields() { ?>
 <script type="text/javascript">
   jQuery(function($){
     $('.acf-postbox').addClass('closed');
    });
  </script>
<?php }

add_action('acf/input/admin_head', 'script_close_acf_fields');

// Create ACF Shortcode for date format
function acf_date_shortcode($atts) {
	extract( shortcode_atts( array(
		'field'			=> '',
		'post_id'		=> false,
		'format_value'	=> true,
		'date_format' 	=> ''
	), $atts ) );
	
	$acf_date = get_field( $field, $post_id, $format_value );

  if (!$acf_date) return 'Non renseignée';

  return date_i18n( $date_format, $acf_date );

}

add_shortcode( 'acf_date', 'acf_date_shortcode' );


function check_featured_image_on_publish( $new_status, $old_status, $post ) {
  if ( $new_status === 'publish' && $old_status != 'publish' ) {
      if (!has_post_thumbnail($post->ID)) {
          error_log('test');
          add_action('admin_print_footer_scripts', function() {
            echo "<script>
                  wp.data.dispatch('core/notices').createErrorNotice('Merci de mettre une image de couverture avant de publier une ');
              </script>";
          });
          remove_action('transition_post_status', 'check_featured_image_on_publish', 10, 3);
          $post->post_status = 'draft';
          wp_update_post($post);
          add_action('transition_post_status', 'check_featured_image_on_publish', 10, 3);
      }
  }
}
add_action( 'transition_post_status', 'check_featured_image_on_publish', 10, 3 );


