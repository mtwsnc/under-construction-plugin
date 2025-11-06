# Security Policy

## Security Features

The Under Construction plugin implements several security measures to protect your WordPress installation:

### 1. Direct Access Prevention
All PHP files check for the `ABSPATH` constant to prevent direct file access.

### 2. Input Sanitization
All user inputs are sanitized before being saved to the database:
- **Enable/Disable Toggle**: Validated to be only '0' or '1'
- **Mode Selection**: Restricted to allowed values ('html' or 'page')
- **HTML Content**: Sanitized based on user capabilities
  - Users with `unfiltered_html` capability can save full HTML/CSS/JS (by design, for administrators)
  - Users without this capability have content filtered through `wp_kses_post()`
- **Page ID**: Sanitized using `absint()` to ensure only positive integers

### 3. Output Escaping
All output is properly escaped using WordPress functions:
- `esc_html()` for text content
- `esc_attr()` for HTML attributes
- `esc_textarea()` for textarea content

### 4. Capability Checks
- Only users with `manage_options` capability can access settings
- Administrator bypass allows only logged-in administrators to view the site

### 5. CSRF Protection
WordPress `settings_fields()` provides automatic nonce generation and verification for form submissions.

### 6. Clean Uninstall
The plugin properly cleans up all options when uninstalled, preventing data leakage.

## Design Decisions

### HTML Content Handling
The plugin allows administrators with the `unfiltered_html` capability to save unrestricted HTML, CSS, and JavaScript for the under construction page. This is intentional and follows WordPress best practices:

- Only administrators (those with `unfiltered_html` capability) can save unrestricted content
- The content is displayed only to non-authenticated users
- This allows full customization of the under construction page
- Users without `unfiltered_html` capability have their content filtered

This is the same approach used by WordPress core for post content and widgets.

## Reporting Security Issues

If you discover a security vulnerability, please email the maintainer rather than using the public issue tracker. This helps us address the issue before it can be exploited.

## Supported Versions

Only the latest version receives security updates. Please always use the most recent release.

## Security Best Practices

When using this plugin:
1. Only grant administrative access to trusted users
2. Keep WordPress and all plugins up to date
3. Use strong passwords for all user accounts
4. Implement proper file permissions on your server
5. Regularly backup your database and files
