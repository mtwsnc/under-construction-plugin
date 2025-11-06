# Under Construction Plugin

A WordPress plugin that allows you to set your site to be under construction by using custom HTML or using an existing page on your website.

## Description

The Under Construction plugin provides a simple way to display a "coming soon" or "under construction" page to your site visitors while you work on your website. Administrators can still access the site normally.

## Features

- **Two Display Modes:**
  - **Custom HTML Mode**: Create a custom under construction page using HTML
  - **Existing Page Mode**: Use any existing WordPress page as your under construction page
  
- **Administrator Access**: Logged-in administrators can bypass the under construction page and access the site normally

- **Easy to Use**: Simple settings page in WordPress admin

- **Default Template**: Comes with a beautiful default under construction template

- **Code Editor**: Built-in HTML code editor with syntax highlighting for custom HTML mode

## Installation

1. Download the plugin files
2. Upload the `under-construction-plugin` folder to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Go to Settings > Under Construction to configure the plugin

## Usage

### Enabling Under Construction Mode

1. Navigate to **Settings > Under Construction** in your WordPress admin
2. Check the **Enable Under Construction Mode** checkbox
3. Choose your preferred display mode
4. Configure the mode-specific settings
5. Click **Save Changes**

### Custom HTML Mode

1. Select **Custom HTML** as the display mode
2. Edit the HTML in the code editor
3. The default template includes a responsive design with gradient background
4. You can customize the HTML, CSS, and content as needed

### Existing Page Mode

1. Select **Existing Page** as the display mode
2. Choose a page from the dropdown menu
3. The selected page will be displayed to non-admin visitors
4. The page will use your theme's styling

## FAQ

### Who can access the site when under construction mode is enabled?

Only logged-in users with administrator privileges can access the site normally. All other visitors will see the under construction page.

### Can I preview the under construction page?

Yes, simply log out of WordPress or view your site in a private/incognito browser window.

### What HTTP status code is sent?

When in Custom HTML mode, the plugin sends a 503 (Service Unavailable) status code, which is appropriate for temporary maintenance.

### Can I use my own HTML and CSS?

Yes! In Custom HTML mode, you have full control over the HTML and can include inline CSS and JavaScript.

## Screenshots

(Screenshots would be added here in a production environment)

## Changelog

### 1.0.0
* Initial release
* Custom HTML mode
* Existing page mode
* Administrator bypass
* Default template included

## License

This plugin is licensed under the GPL v2 or later.

## Support

For bug reports and feature requests, please use the [GitHub issue tracker](https://github.com/mtwsnc/under-construction-plugin/issues).