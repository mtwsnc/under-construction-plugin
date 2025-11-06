<?php
/**
 * Plugin Name: Under Construction
 * Plugin URI: https://github.com/mtwsnc/under-construction-plugin
 * Description: An under construction plugin for WordPress which allows you to set your site to be under construction by using HTML or using a page on your website
 * Version: 1.0.0
 * Author: mtwsnc
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: under-construction
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('UC_VERSION', '1.0.0');
define('UC_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('UC_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Main plugin class
 */
class Under_Construction {
    
    /**
     * Constructor
     */
    public function __construct() {
        // Add admin menu
        add_action('admin_menu', array($this, 'add_admin_menu'));
        
        // Register settings
        add_action('admin_init', array($this, 'register_settings'));
        
        // Check if under construction mode is enabled
        add_action('template_redirect', array($this, 'show_under_construction'));
        
        // Add admin styles
        add_action('admin_enqueue_scripts', array($this, 'admin_styles'));
    }
    
    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_options_page(
            __('Under Construction Settings', 'under-construction'),
            __('Under Construction', 'under-construction'),
            'manage_options',
            'under-construction',
            array($this, 'settings_page')
        );
    }
    
    /**
     * Register plugin settings
     */
    public function register_settings() {
        register_setting('under_construction_settings', 'uc_enabled', array(
            'sanitize_callback' => array($this, 'sanitize_checkbox')
        ));
        register_setting('under_construction_settings', 'uc_mode', array(
            'sanitize_callback' => array($this, 'sanitize_mode')
        ));
        register_setting('under_construction_settings', 'uc_html_content', array(
            'sanitize_callback' => array($this, 'sanitize_html_content')
        ));
        register_setting('under_construction_settings', 'uc_page_id', array(
            'sanitize_callback' => 'absint'
        ));
    }
    
    /**
     * Sanitize checkbox value
     */
    public function sanitize_checkbox($value) {
        return ($value === '1') ? '1' : '0';
    }
    
    /**
     * Sanitize mode selection
     */
    public function sanitize_mode($value) {
        $allowed_modes = array('html', 'page');
        return in_array($value, $allowed_modes, true) ? $value : 'html';
    }
    
    /**
     * Sanitize HTML content
     */
    public function sanitize_html_content($value) {
        // Allow administrators to save HTML/CSS/JS for the under construction page
        // This is intentional as it's admin-only and for displaying to non-authenticated users
        if (!current_user_can('unfiltered_html')) {
            // For users without unfiltered_html capability, strip all tags
            return wp_kses_post($value);
        }
        return $value;
    }
    
    /**
     * Enqueue admin styles
     */
    public function admin_styles($hook) {
        if ($hook !== 'settings_page_under-construction') {
            return;
        }
        
        wp_enqueue_style('wp-codemirror');
        wp_enqueue_script('wp-codemirror');
        wp_enqueue_code_editor(array('type' => 'text/html'));
    }
    
    /**
     * Display settings page
     */
    public function settings_page() {
        if (!current_user_can('manage_options')) {
            return;
        }
        
        // Get current settings
        $enabled = get_option('uc_enabled', '0');
        $mode = get_option('uc_mode', 'html');
        $html_content = get_option('uc_html_content', $this->get_default_html());
        $page_id = get_option('uc_page_id', '');
        
        // Get all pages for dropdown
        $pages = get_pages();
        
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            
            <?php settings_errors(); ?>
            
            <form method="post" action="options.php">
                <?php settings_fields('under_construction_settings'); ?>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="uc_enabled"><?php _e('Enable Under Construction Mode', 'under-construction'); ?></label>
                        </th>
                        <td>
                            <input type="checkbox" id="uc_enabled" name="uc_enabled" value="1" <?php checked($enabled, '1'); ?>>
                            <p class="description"><?php _e('Enable this to activate the under construction page. Administrators will still be able to access the site.', 'under-construction'); ?></p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">
                            <label for="uc_mode"><?php _e('Display Mode', 'under-construction'); ?></label>
                        </th>
                        <td>
                            <select id="uc_mode" name="uc_mode">
                                <option value="html" <?php selected($mode, 'html'); ?>><?php _e('Custom HTML', 'under-construction'); ?></option>
                                <option value="page" <?php selected($mode, 'page'); ?>><?php _e('Existing Page', 'under-construction'); ?></option>
                            </select>
                            <p class="description"><?php _e('Choose whether to display custom HTML or an existing page.', 'under-construction'); ?></p>
                        </td>
                    </tr>
                    
                    <tr class="uc-html-mode">
                        <th scope="row">
                            <label for="uc_html_content"><?php _e('HTML Content', 'under-construction'); ?></label>
                        </th>
                        <td>
                            <textarea id="uc_html_content" name="uc_html_content" rows="15" class="large-text code"><?php echo esc_textarea($html_content); ?></textarea>
                            <p class="description"><?php _e('Enter your custom HTML for the under construction page.', 'under-construction'); ?></p>
                        </td>
                    </tr>
                    
                    <tr class="uc-page-mode">
                        <th scope="row">
                            <label for="uc_page_id"><?php _e('Select Page', 'under-construction'); ?></label>
                        </th>
                        <td>
                            <select id="uc_page_id" name="uc_page_id">
                                <option value=""><?php _e('-- Select a Page --', 'under-construction'); ?></option>
                                <?php foreach ($pages as $page) : ?>
                                    <option value="<?php echo esc_attr($page->ID); ?>" <?php selected($page_id, $page->ID); ?>>
                                        <?php echo esc_html($page->post_title); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <p class="description"><?php _e('Select an existing page to display as the under construction page.', 'under-construction'); ?></p>
                        </td>
                    </tr>
                </table>
                
                <?php submit_button(); ?>
            </form>
        </div>
        
        <style>
            .uc-html-mode,
            .uc-page-mode {
                display: none;
            }
        </style>
        
        <script>
            jQuery(document).ready(function($) {
                // Initialize CodeMirror
                if (typeof wp !== 'undefined' && wp.codeEditor) {
                    wp.codeEditor.initialize($('#uc_html_content'), {
                        codemirror: {
                            mode: 'htmlmixed',
                            lineNumbers: true,
                            lineWrapping: true
                        }
                    });
                }
                
                // Show/hide mode-specific fields
                function toggleModeFields() {
                    var mode = $('#uc_mode').val();
                    $('.uc-html-mode, .uc-page-mode').hide();
                    $('.uc-' + mode + '-mode').show();
                }
                
                $('#uc_mode').on('change', toggleModeFields);
                toggleModeFields();
            });
        </script>
        <?php
    }
    
    /**
     * Show under construction page
     */
    public function show_under_construction() {
        // Don't show for logged-in administrators
        if (current_user_can('manage_options')) {
            return;
        }
        
        // Check if under construction mode is enabled
        $enabled = get_option('uc_enabled', '0');
        if ($enabled !== '1') {
            return;
        }
        
        // Get mode and display appropriate content
        $mode = get_option('uc_mode', 'html');
        
        if ($mode === 'page') {
            $page_id = get_option('uc_page_id', '');
            if (!empty($page_id)) {
                // Redirect to the selected page
                $page_url = get_permalink($page_id);
                if ($page_url && get_queried_object_id() != $page_id) {
                    wp_redirect($page_url);
                    exit;
                }
            } else {
                // Fallback to HTML mode if no page selected
                $this->display_html_content();
            }
        } else {
            $this->display_html_content();
        }
    }
    
    /**
     * Display HTML content
     */
    private function display_html_content() {
        $html_content = get_option('uc_html_content', $this->get_default_html());
        
        // Set 503 header
        status_header(503);
        nocache_headers();
        
        // Output the HTML content
        // Note: This content is administrator-controlled and sanitized on save
        // Only users with 'unfiltered_html' capability can save unrestricted HTML
        echo $html_content;
        exit;
    }
    
    /**
     * Get default HTML template
     */
    private function get_default_html() {
        return '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Under Construction</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            text-align: center;
            padding: 20px;
        }
        
        .container {
            max-width: 600px;
        }
        
        h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }
        
        p {
            font-size: 1.25rem;
            line-height: 1.6;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        .icon {
            font-size: 5rem;
            margin-bottom: 2rem;
        }
        
        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }
            
            p {
                font-size: 1rem;
            }
            
            .icon {
                font-size: 3rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">🚧</div>
        <h1>Under Construction</h1>
        <p>We&rsquo;re working hard to bring you something amazing. Please check back soon!</p>
    </div>
</body>
</html>';
    }
}

// Initialize the plugin
new Under_Construction();
