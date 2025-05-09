=== Editor Handbook ===
Contributors: devcollab, hbrokmeier, cparkinson
Tags: documentation
Requires at least: 6.0
Tested up to: 6.8
Stable tag: 2.0.5
Requires PHP: 8.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Create private, internal documentation for a site's editors.

== Description ==

The Editor Handbook plugin provides a Handbook menu item in the admin area and adds a Handbook custom post type for creating private, in-site documentation for site editors.

Handbook pages display using the default page template.

== Frequently Asked Questions ==

= Who has access to Handbook pages? =
- **Administrators** and **Editors** can view, update, and delete Handbook pages.
- **Authors** can view Handbook pages.
- **Subscribers** and **Contributors** don't have access to Handbook pages.

= How can I customize the template used to display Handbook posts? =
Handbook pages are displayed using the `page.php` template. Use the `editor_handbook_template` filter to customize which template is used.

`
function my_handbook_template( $template_names ) {
  return 'my-custom-handbook-template.php';
}
add_filter( 'editor_handbook_template', 'my_handbook_template' );
`

After setting a new template, flush the rewrite rules by going to **Settings > Permalinks** in the admin dashboard.

== Changelog ==

= 2.0.5 - 2025-04-16 =
* Bump tested up to 6.8

**Full Changelog**: https://github.com/devcollaborative/editor-handbook/compare/v2.0.4...v2.0.5

= 2.0.4 - 2025-01-30 =
* Added "Edit" link in Admin Toolbar

**Full Changelog**: https://github.com/devcollaborative/editor-handbook/compare/v2.0.3...v2.0.4

= 2.0.3 - 2024-12-18 =
* Bump tested up to 6.7.1

= 2.0.2 - 2024-03-20 =
* Fixed: Update text domain to match plugin slug
* Deleted: CHANGELOG.md in favor of using readme.txt

**Full Changelog**: https://github.com/devcollaborative/editor-handbook/compare/v2.0.1...v2.0.2

= 2.0.1 - 2024-02-16 =
* Security: Escape echo statements
* Fixed: Update stable & readme versions to match
* Fixed: Use the editor_handbook prefix for all functions
* Fixed: Whitescreen bug when template doesn't exist

**Full Changelog**: https://github.com/devcollaborative/editor-handbook/compare/v2.0.0...v2.0.1

= 2.0.0 - 2024-01-05 =
- Changed: Order handbook posts by title ASC
- Changed: Set page.php as default for displaying handbook pages
- Added: Add readme.txt & update plugin headers
- Removed: reference to DevCollab Helpdesk

**Full Changelog**: https://github.com/devcollaborative/editor-handbook/compare/v1.2.0...v2.0.0

= 1.2.0 - 2023-06-06 =
* Added: Custom capabilities for the Handbook post type
* Added: Plugin activation & update hooks for managing capabilities
* Changed: Handbook pages can now be viewed (but not edited) by Authors
* Changed: The default capability for viewing the Handbook admin page is now `read_private_handbooks`
