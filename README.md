# Editor Handbook

Create private, internal documentation for a site's editors.

## Description

The Editor Handbook plugin provides a Handbook section for creating private, in-site documentation for site editors.

Handbook pages display using the default page template.

## Frequently Asked Questions

### Who has access to handbook pages?
- **Administrators** and **Editors** can view, update, and delete handbook pages.
- **Authors** can view Handbook pages.
- **Subscribers** and **Contributors** don't have access to handbook pages.

### How can I customize the template used to display pages?
Handbook pages are displayed using the `page.php` template. Use the `editor_handbook_template` filter to customize which template is used.

```php
function my_handbook_template( $template_names ) {
  return 'my-custom-handbook-template.php';
}
add_filter( 'editor_handbook_template', 'my_handbook_template' );
```

After setting a new template, flush the rewrite rules by going to **Settings > Permalinks** in the admin dashboard.
