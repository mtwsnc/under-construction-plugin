# Repository Guidelines

## Project Structure & Module Organization
The entry point is `under-construction.php`, defining the `Under_Construction` class, admin settings, and the front-end template. Group helpers in that class or split heavier features into `includes/` files required from the main file. Update `uninstall.php` whenever you register new options so cleanup stays idempotent. Root-level docs (`README.md`, `CHANGELOG.md`, `SECURITY.md`, `CONTRIBUTING.md`) should evolve with behavior and policy changes.

## Build, Test, and Development Commands
Work inside a local WordPress install or `wp-env`:
- `wp-env start` (after adding `.wp-env.json`) boots a disposable test site.
- `wp plugin activate under-construction` toggles the plugin for CLI QA.
- `php -l under-construction.php uninstall.php` performs a syntax check.
- `vendor/bin/phpcs --standard=WordPress under-construction.php` enforces coding standards; install `squizlabs/php_codesniffer` plus the WordPress ruleset via Composer.

## Coding Style & Naming Conventions
Follow WordPress PHP Coding Standards: four-space indentation, snake_case functions, and early returns. Escape output with `esc_*` helpers and sanitize input with Core utilities. Mark translatable strings with `__()`/`_e()` using the `under-construction` text domain. Name options and hooks with the `uc_` prefix. Add PHPDoc blocks for public methods and filters/actions.

## Testing Guidelines
Automated tests are not yet scaffolded; when adding behavior, include PHPUnit cases under `tests/phpunit/` generated via `wp scaffold plugin-tests`. Run them with `phpunit` once the WordPress test suite is bootstrapped. Meanwhile, cover regressions manually: verify Custom HTML and Existing Page modes, confirm administrators bypass the block, and test uninstall to ensure options purge. Capture browser-console output when debugging JavaScript on the settings page.

## Commit & Pull Request Guidelines
Use focused commits with imperative summaries (`Add redirect guard for page mode`). Reference GitHub issues in the body and describe both the problem and solution. Before opening a PR, rebase onto `main`, attach screenshots or recordings for UI changes, and list the tests you ran. Keep PR discussions in English, answer review feedback promptly, and append `Co-authored-by: MTWS Admin <tech@mtws.org>` to every commit.

## Security & Configuration Tips
Never commit secrets or `.env` files; rely on WordPress configuration constants. Sanitize every option via Core functions and recheck capability gates (`manage_options`, `unfiltered_html`) when extending forms. Audit dependencies periodically and document new external APIs in `SECURITY.md` so site owners understand the surface area.
