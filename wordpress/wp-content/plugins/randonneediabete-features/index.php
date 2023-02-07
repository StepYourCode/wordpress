<?php
/**
 * Plugin Name:       Randonnée & Diabète Features
 * Description:				This plugin allows access to the set of all features for "Randonnée et diabète" theme
 * Plugin URI:        http://www.remi-rubis.fr
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Rémi Rubis
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       rd-features
 *
 * @package           rd-features
 */

/**
 * Register all blocks
 */
function rd_blocks_block_init() {
	// register_block_type( __DIR__ . '/blocks/base-block' ); => For example
	register_block_type( __DIR__ . '/blocks/latest-hikes' );
}
add_action('init', 'rd_blocks_block_init');

/**
 * Configure custom post types for hikes
 */

 function rd_register_post_types() {
  // Hiking CPT
  $labels = array(
    'name' => 'Randonnées',
    'all_items' => 'Toutes les randonnées',
    'singular_name' => 'Randonnée',
    'add_new_item' => 'Programmer une randonnée',
    'edit_item' => 'Modifier une randonnée',
    'menu_name' => 'Randonnées'
  );

  $args = array(
    'labels' => $labels,
    'public' => true,
    'show_in_rest' => true, // Add Gutenbergerg editor
    'has_archive' => true,
    'supports' => array( 'title', 'editor', 'thumbnail', 'revisions', 'comments' ),
    'menu_position' => 5,
    'menu_icon' => 'dashicons-schedule',
    'rewrite' => true,
  );

  register_post_type( 'hikes', $args );

  // Taxonomy declaration
  $labels = array(
    'name' => 'Type de randonnée',
    'add_new_item' => 'Ajouter une nouvelle randonnée',
  );

  $args = array(
      'hierarchical' => true,
      'labels' => $labels,
      'public' => true,
      'show_ui' => true,
      'show_admin_column' => true,
      'show_in_rest' => true,
      'rewrite' => ['slug' => 'type']
  );

  register_taxonomy( 'hike-types', ['hikes'], $args );

  register_block_style( 'core/group', [
    'name'         => 'full-height',
    'label'        => __( 'Full Height' ),
    'inline_style' => '.wp-block-group.is-style-full-height { height: 100%; }'
  ] );
}

add_action('init', 'rd_register_post_types');

add_action( 'rest_api_init', function () {
  register_rest_route( 'rd', '/hikes', array(
    'methods' => 'GET',
    'callback' => 'get_hikes',
		'permission_callback' => '__return_true',
    ));
});

function get_hikes() {
	global $wpdb;

	$data = $wpdb->get_results("SELECT
			post.post_title,
			post.guid,
			meta1.meta_value AS start_date,
			meta2.meta_value AS town,
			result.guid as image,
			GROUP_CONCAT(t.name SEPARATOR ',') AS hike_types
		FROM $wpdb->posts AS post
			INNER JOIN $wpdb->postmeta AS meta1
				ON meta1.post_id = post.ID
				AND meta1.meta_key = 'start_date'
			INNER JOIN $wpdb->postmeta AS meta2
				ON meta2.post_id = post.ID
				AND meta2.meta_key = 'town'
			INNER JOIN $wpdb->postmeta AS pm
				ON post.ID = pm.post_id
				AND pm.meta_key = '_thumbnail_id'
			INNER JOIN $wpdb->posts AS result
				ON pm.meta_value = result.ID
			INNER JOIN $wpdb->term_relationships AS tr
				ON post.ID = tr.object_id
			INNER JOIN $wpdb->term_taxonomy AS tt
				ON tr.term_taxonomy_id = tt.term_taxonomy_id
			INNER JOIN $wpdb->terms AS t
				ON t.term_id = tt.term_id
		WHERE post.post_type = 'hikes'
			AND post.post_status = 'publish'
			AND meta1.meta_value >= CURDATE()
		GROUP BY post.ID
		ORDER BY meta1.meta_value ASC
		LIMIT 3;
	");

	return $data;
}

function render_frontend($attributes) {
  if( !is_admin() ) {
    wp_enqueue_script( 'rd_block', plugin_dir_url( __FILE__ ) . '/build/frontend.js');
  }

  ob_start(); ?>

	<div class="data">
		<pre>
			<?php echo wp_json_encode( $attributes ) ?>
		</pre>
	</div>
	<section class="hikes"></section>

  <?php return ob_get_clean();
}
