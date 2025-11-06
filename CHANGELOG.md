# Changelog

All notable changes to the Under Construction plugin will be documented in this file.

## [1.0.0] - 2025-11-06

### Added
- Initial release of Under Construction plugin
- Two display modes: Custom HTML and Existing Page
- Custom HTML editor with CodeMirror syntax highlighting
- Page selector to choose any existing WordPress page
- Administrator bypass - logged-in admins can access the site normally
- Beautiful default under construction template with gradient background
- Responsive design that works on all devices
- 503 HTTP status code for proper SEO handling
- Clean uninstall that removes all plugin options
- Security features:
  - Direct access prevention
  - Output escaping for all user inputs
  - Nonce protection for settings
  - Capability checks for admin access

### Security
- All user inputs are properly escaped
- Settings forms include nonce protection
- Administrator capability checks implemented
- Direct file access prevention

## Future Enhancements (Roadmap)
- Countdown timer option
- Email subscription form integration
- Social media links
- Custom CSS editor
- Multiple template options
- Preview mode for administrators
- Scheduled activation/deactivation
