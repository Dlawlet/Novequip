<?php
// Disable WordPress auto-updates
define('AUTOMATIC_UPDATER_DISABLED', true);

// Disable post revisions
define('WP_POST_REVISIONS', false);

// Disable file editor
define('DISALLOW_FILE_EDIT', true);

// Disable debug
define('WP_DEBUG', false);

// Empty trash after 7 days
define('EMPTY_TRASH_DAYS', 7);

// Optimize database
define('OPTIMIZE_DATABASE', true);

// Disable WordPress cron (we'll use system cron instead)
define('DISABLE_WP_CRON', true);

// Block external HTTP requests
define('WP_HTTP_BLOCK_EXTERNAL', false);

// Increase memory limits
define('WP_MEMORY_LIMIT', '512M');
define('WP_MAX_MEMORY_LIMIT', '512M');

// Enable page caching
define('WP_CACHE', true);
