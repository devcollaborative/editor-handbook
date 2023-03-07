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

### Page Templates

This plugin doesn't provide any templates for the Handbook pages, so they will follow the [WordPress template hierarchy](https://developer.wordpress.org/themes/basics/template-hierarchy/#custom-post-types). You may have to make style adjustments or create a specific template (`single-handbook.php`) for Handbook pages.
