<?php
/**
 * Plugin Name: DevCollaborative Editor Handbook
 * Plugin URI: https://github.com/devcollaborative/editor-handbook
 * Description: Private content type for in-site documentation
 * Version: 1.2.0
 * Author: DevCollaborative
 * Author URI: https://devcollaborative.com/
 * GitHub Plugin URI: devcollaborative/editor-handbook
 * Primary Branch: main
 */

defined( 'ABSPATH' ) or exit;

define( 'EDITOR_HANDBOOK_VERSION', '1.2.0' );

/**
 * Run plugin update process on activation.
 */
function editor_handbook_activate() {
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
function devcollab_handbook_post_type() {
	$labels = array(
		'name'                  => _x( 'Handbook', 'Post Type General Name', 'devcollab' ),
		'singular_name'         => _x( 'Handbook page', 'Post Type Singular Name', 'devcollab' ),
		'menu_name'             => __( 'Handbook', 'devcollab' ),
		'name_admin_bar'        => __( 'Handbook', 'devcollab' ),
		'archives'              => __( 'Handbook Archives', 'devcollab' ),
		'attributes'            => __( 'Handbook Attributes', 'devcollab' ),
		'parent_item_colon'     => __( 'Parent Handbook page:', 'devcollab' ),
		'all_items'             => __( 'Edit Handbook', 'devcollab' ),
		'add_new_item'          => __( 'Add New Handbook page', 'devcollab' ),
		'add_new'               => __( 'Add New', 'devcollab' ),
		'new_item'              => __( 'New Handbook page', 'devcollab' ),
		'edit_item'             => __( 'Edit Handbook', 'devcollab' ),
		'update_item'           => __( 'Update Handbook', 'devcollab' ),
		'view_item'             => __( 'View Handbook page', 'devcollab' ),
		'view_items'            => __( 'View Handbook pages', 'devcollab' ),
		'search_items'          => __( 'Search Handbook', 'devcollab' ),
		'not_found'             => __( 'Not found', 'devcollab' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'devcollab' ),
		'featured_image'        => __( 'Featured Image', 'devcollab' ),
		'set_featured_image'    => __( 'Set featured image', 'devcollab' ),
		'remove_featured_image' => __( 'Remove featured image', 'devcollab' ),
		'use_featured_image'    => __( 'Use as featured image', 'devcollab' ),
		'insert_into_item'      => __( 'Insert into Handbook', 'devcollab' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Handbook page', 'devcollab' ),
		'items_list'            => __( 'Handbook pages list', 'devcollab' ),
		'items_list_navigation' => __( 'Handbook pages list navigation', 'devcollab' ),
		'filter_items_list'     => __( 'Filter Handbook pages list', 'devcollab' ),
	);
	$args = array(
		'label'                 => __( 'handbook', 'devcollab' ),
		'description'           => __( 'Private in-site documentation for editors', 'devcollab' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'revisions'),
		'taxonomies'            => array(),
		'hierarchical'          => false,
		'menu_position'         => 3,
		'menu_icon'   				  => 'dashicons-editor-help',
		'show_in_admin_bar'     => false,
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
add_action( 'init', 'devcollab_handbook_post_type', 5 );

/**
 * Force handbook post types to private. Overrides the "publish" post status to always
 * change to private.
 */
function handbook_force_private($post) {
	if ($post['post_type'] === 'handbook' && $post['post_status'] === 'publish') {
		$post['post_status'] = 'private';
	}

	return $post;
}
add_filter('wp_insert_post_data', 'handbook_force_private');

/**
 * Remove "Private: " from the beginning of private posts for the handbook CPT.
 *
 * @param string $prepend Text displayed before the post title.
 * @param WP_Post $post Current post object.
 */
function handbook_private_title_format($prepend, $post) {
	if ($post->post_type === 'handbook') {
		return '%s';
	}

	return $prepend;
}
add_filter('private_title_format', 'handbook_private_title_format', 10, 2);

/**
 * Add Handbook admin page to the CPT submenu.
 */
function handbook_admin_menu() {
	$handbook = get_post_type_object('handbook');

	add_submenu_page(
    'edit.php?post_type=handbook',
    $handbook->labels->menu_name,
    $handbook->labels->menu_name,
    'read_private_handbooks',
    'handbook',
    'handbook_admin_page',
		0
	);
}
add_action( 'admin_menu', 'handbook_admin_menu' );

/**
 * Create the Handbook admin page to list all of the articles.
 *
 * Using an admin page means we don't need to worry about there being a
 * suitable front-end template for displaying these posts.
 */
function handbook_admin_page() {
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
				<li><a href="<?php echo get_permalink($post) ?>"><?php echo get_the_title($post) ?></a></li>
			<?php endforeach; ?>
		</ul>

		<?php if ( current_user_can( 'edit_handbooks' ) ): ?>
			<h3>Still need help?</h3>
			<p>If you still need help, reach out by filing a helpdesk ticket.</p>
			<p><a href="https://devcollaborative.com/helpdesk" target="_blank">https://devcollaborative.com/helpdesk</a></p>
		<?php endif; ?>
	</div>

	<?php
}

/**
 * Redirect handbook archive page to our custom admin page.
 */
function handbook_archive_redirect($archive_template){
  if ( is_post_type_archive ( 'handbook' ) ) {
		wp_redirect(admin_url() . 'edit.php?post_type=handbook&page=handbook');
		exit();
  }
  return $archive_template;
}
add_filter( 'archive_template', 'handbook_archive_redirect' ) ;
