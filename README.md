# Editor Handbook

The Editor Handbook plugin provides a custom post type called "Handbook" that allows you to create in-site documentation for site editors.

Handbook pages are automatically set to "Private" to prevent non-logged-in users from accessing them. This ensures only editors with proper permissions can view the documentation.

## Installation

### Install Git Updater

Download and install [Git Updater](https://git-updater.com/). Git Updater will automatically check for updates, no configuration is required.

### Install Editor Handbook

1. Download the ZIP file from the most recent release on the [Releases page](https://github.com/devcollaborative/editor-handbook/releases).
1. Install the ZIP through the WordPress Dashboard, or extract it to `wp-content/plugins/editor-handbook`

## Usage

Create Handbook pages by going to WordPress Dashboard > Handbook > Add New.

To view all posts go to Dashboard > Handbook > Handbook. This is a simplified list of posts intended for site editors, and includes a link to the DevCollaborative helpdesk.

To view the default WP post list go to Dashboard > Handbook > Edit Handbook.

## Filters

### `editor_handbook_template`

Filters the template to use for displaying single handbook pages. Gets passed to `locate_template()`.

After setting a new template, you need to flush the rewrite rules by going to the Settings > Permalinks page in the admin dashboard.

#### Parameters

`$template_names` *string|array*

Filename of template(s) to use for displaying handbook posts.

Default: `page.php`

#### Example

```php
function my_handbook_template( $template_names ) {
    return 'my-custom-handbook-template.php';
}
add_filter( 'editor_handbook_template', 'my_handbook_template' );
```

## Capabilities

- **Administrators** and **Editors** have full access to read, update, and delete Handbook posts.
- **Authors** have access to view Handbook posts.
- **Subscribers** and **Contributors** don't have any access to Handbook posts.

### Customizing Capabilities
You can customize access to Handbook posts with a plugin like User Role Editor.

Available capabilities:
- edit_handbook
- read_handbook
- delete_handbook
- edit_handbooks
- edit_others_handbooks
- delete_handbooks
- publish_handbooks
- read_private_handbooks
- delete_private_handbooks
- delete_published_handbooks
- delete_others_handbooks
- edit_private_handbooks
- edit_published_handbooks
