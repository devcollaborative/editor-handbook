=== Editor Handbook ===
Contributors: devcollab, hbrokmeier, cparkinson
Tags: documentation
Tested up to: 6.3
Stable tag: 1.2.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Create private, internal documentation for a site's editors.

== Description ==

The Editor Handbook plugin provides a Handbook section for creating private, in-site documentation for site editors.

Handbook pages display using the default page template.

== Frequently Asked Questions ==

= Who has access to handbook pages? =
- **Administrators** and **Editors** can view, update, and delete handbook pages.
- **Authors** can view Handbook pages.
- **Subscribers** and **Contributors** don't have access to handbook pages.

= How can I customize the template used to display pages? =
Handbook pages are displayed using the `page.php` template. Use the `editor_handbook_template` filter to customize which template is used.

`
function my_handbook_template( $template_names ) {
  return 'my-custom-handbook-template.php';
}
add_filter( 'editor_handbook_template', 'my_handbook_template' );
`

After setting a new template, flush the rewrite rules by going to **Settings > Permalinks** in the admin dashboard.

== Changelog ==

= 1.2.0 - 2023-06-06 =
* Added: Custom capabilities for the Handbook post type
* Added: Plugin activation & update hooks for managing capabilities
* Changed: Handbook pages can now be viewed (but not edited) by Authors
* Changed: The default capability for viewing the handbook admin page is now `read_private_handbooks`
