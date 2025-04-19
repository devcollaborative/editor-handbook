<?php
/**
 * Plugin Name: Editor Handbook
 * Plugin URI: https://github.com/devcollaborative/editor-handbook
 * Description: Adds internal documentation for site editors.
 * Version: 2.0.5
 * Requires at least: 6.7.1
 * Requires PHP: 8
 * Author: DevCollaborative
 * Author URI: https://devcollaborative.com/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

defined( 'ABSPATH' ) or exit;

define( 'EDITOR_HANDBOOK_VERSION', '2.0.5' );

/**
 * Run functions on plugin activation.
 */
function editor_handbook_activate() {
	// Flush permalinks so Handbook CPT rewrite rules are recognized.
	flush_rewrite_rules();

	// Run plugin update process.
	editor_handbook_update_check();
}
register_activation_hook( __FILE__, 'editor_handbook_activate' );

/**
 * Checks the current plugins version, and runs the update process if versions don't match.
 */
function editor_handbook_update_check() {
	if ( EDITOR_HANDBOOK_VERSION !== get_option( 'editor_handbook_version' ) ) {

		// Update with new plugin version.
		update_option( 'editor_handbook_version', EDITOR_HANDBOOK_VERSION );

		// Set capabilities again, in case there have been updates.
		editor_handbook_set_caps();
	}
}
add_action( 'plugins_loaded', 'editor_handbook_update_check' );

/**
 * Add handbook capabilities.
 */
function editor_handbook_set_caps() {
	$administrator = get_role('administrator');
	$editor        = get_role('editor');
	$author        = get_role('author');

	$all_caps = array(
		'edit_handbook',
		'read_handbook',
		'delete_handbook',
		'edit_handbooks',
		'edit_others_handbooks',
		'delete_handbooks',
		'publish_handbooks',
		'read_private_handbooks',
		'delete_private_handbooks',
		'delete_published_handbooks',
		'delete_others_handbooks',
		'edit_private_handbooks',
		'edit_published_handbooks',
	);

	// Give admins and editors full access.
	foreach ($all_caps as $cap) {
		$administrator->add_cap( $cap );
		$editor->add_cap( $cap );
	}

	// Give authors read-only access.
	$author->add_cap( 'read_handbooks' );
	$author->add_cap( 'read_private_handbooks' );
}

/**
 *  Register Custom Post Type for handbook
 */
function editor_handbook_post_type() {
	$labels = array(
		'name'                  => _x( 'Handbook', 'Post Type General Name', 'editor-handbook' ),
		'singular_name'         => _x( 'Handbook page', 'Post Type Singular Name', 'editor-handbook' ),
		'menu_name'             => __( 'Handbook', 'editor-handbook' ),
		'name_admin_bar'        => __( 'Handbook', 'editor-handbook' ),
		'archives'              => __( 'Handbook Archives', 'editor-handbook' ),
		'attributes'            => __( 'Handbook Attributes', 'editor-handbook' ),
		'parent_item_colon'     => __( 'Parent Handbook page:', 'editor-handbook' ),
		'all_items'             => __( 'Edit Handbook', 'editor-handbook' ),
		'add_new_item'          => __( 'Add New Handbook page', 'editor-handbook' ),
		'add_new'               => __( 'Add New', 'editor-handbook' ),
		'new_item'              => __( 'New Handbook page', 'editor-handbook' ),
		'edit_item'             => __( 'Edit Handbook', 'editor-handbook' ),
		'update_item'           => __( 'Update Handbook', 'editor-handbook' ),
		'view_item'             => __( 'View Handbook page', 'editor-handbook' ),
		'view_items'            => __( 'View Handbook pages', 'editor-handbook' ),
		'search_items'          => __( 'Search Handbook', 'editor-handbook' ),
		'not_found'             => __( 'Not found', 'editor-handbook' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'editor-handbook' ),
		'featured_image'        => __( 'Featured Image', 'editor-handbook' ),
		'set_featured_image'    => __( 'Set featured image', 'editor-handbook' ),
		'remove_featured_image' => __( 'Remove featured image', 'editor-handbook' ),
		'use_featured_image'    => __( 'Use as featured image', 'editor-handbook' ),
		'insert_into_item'      => __( 'Insert into Handbook', 'editor-handbook' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Handbook page', 'editor-handbook' ),
		'items_list'            => __( 'Handbook pages list', 'editor-handbook' ),
		'items_list_navigation' => __( 'Handbook pages list navigation', 'editor-handbook' ),
		'filter_items_list'     => __( 'Filter Handbook pages list', 'editor-handbook' ),
	);
	$args = array(
		'label'                 => __( 'handbook', 'editor-handbook' ),
		'description'           => __( 'Private in-site documentation for editors', 'editor-handbook' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'revisions'),
		'taxonomies'            => array(),
		'hierarchical'          => false,
		'menu_position'         => 3,
		'menu_icon'   				  => 'dashicons-editor-help',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'show_in_rest'				  => true,
		'can_export'            => true,
		'has_archive'           => true,
		'public' 								=> true,
		'capability_type'       => array( 'handbook', 'handbooks' ),
		'map_meta_cap' 					=> true,
	);
	register_post_type( 'handbook', $args );

}
add_action( 'init', 'editor_handbook_post_type', 5 );

/**
 * Force handbook post types to private. Overrides the "publish" post status to always
 * change to private.
 */
function editor_handbook_force_private($post) {
	if ($post['post_type'] === 'handbook' && $post['post_status'] === 'publish') {
		$post['post_status'] = 'private';
	}

	return $post;
}
add_filter('wp_insert_post_data', 'editor_handbook_force_private');

/**
 * Remove "Private: " from the beginning of private posts for the handbook CPT.
 *
 * @param string $prepend Text displayed before the post title.
 * @param WP_Post $post Current post object.
 */
function editor_handbook_private_title_format($prepend, $post) {
	if ($post->post_type === 'handbook') {
		return '%s';
	}

	return $prepend;
}
add_filter('private_title_format', 'editor_handbook_private_title_format', 10, 2);

/**
 * Add Handbook admin page to the CPT submenu.
 */
function editor_handbook_admin_menu() {
	$handbook = get_post_type_object('handbook');

	add_submenu_page(
    'edit.php?post_type=handbook',
    $handbook->labels->menu_name,
    $handbook->labels->menu_name,
    'read_private_handbooks',
    'handbook',
    'editor_handbook_admin_page',
		0
	);
}
add_action( 'admin_menu', 'editor_handbook_admin_menu' );

/**
 * Create the Handbook admin page to list all of the articles.
 *
 * Using an admin page means we don't need to worry about there being a
 * suitable front-end template for displaying these posts.
 */
function editor_handbook_admin_page() {
	$posts = get_posts(array(
		'post_type' 			=> 'handbook',
		'post_status' 	  => 'private',
		'posts_per_page' 	=> 999,
		'order' 					=> 'ASC',
		'orderby' 				=> 'title',
	));
	?>

	<div class="wrap">
		<h2>Handbook</h2>
		<h3>Help Articles</h3>
		<ul class="ul-disc">
			<?php foreach ($posts as $post) : ?>
				<li><a href="<?php echo esc_url( get_permalink($post) ); ?>"><?php echo esc_html( get_the_title($post) ); ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>

	<?php
}

/**
 * Redirect handbook archive page to our custom admin page.
 */
function editor_handbook_archive_redirect($archive_template){
  if ( is_post_type_archive ( 'handbook' ) ) {
		wp_redirect(admin_url() . 'edit.php?post_type=handbook&page=handbook');
		exit();
  }
  return $archive_template;
}
add_filter( 'archive_template', 'editor_handbook_archive_redirect' ) ;

/**
 * Retrieves a template file for displaying handbook posts.
 *
 */
function editor_handbook_template_include( $template ) {
	if ('handbook' === get_post_type()) {

		/**
		 * Customize template to use for displaying handbook posts.
		 *
		 * @param string|array $template_names Template filename(s) to search for, in order.
		 */
		$template_names = apply_filters( 'editor_handbook_template', 'page.php' );

		if ( $template_names ) {

			$template_found = locate_template( $template_names );

			if ( !empty( $template_found ) ){
				return $template_found;
			}
		}
	}

	return $template;
}
add_filter( 'template_include', 'editor_handbook_template_include' );
