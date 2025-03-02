<?php
/**
 * WordPress Core Patcher for Output Buffering Issues
 *
 * This script directly fixes the output buffering issue in WordPress core
 * that causes errors with WPForms and other plugins.
 * 
 * HOW TO USE:
 * 1. Place this file in your WordPress root directory
 * 2. Run it once via browser or command line
 * 3. Delete this file after successful execution
 */

// Basic security check
if (PHP_SAPI !== 'cli') {
    if (!isset($_GET['run']) || $_GET['run'] !== 'fix') {
        die("For security, add ?run=fix to the URL to execute this script.");
    }
}

// Path to the WordPress functions.php file
$functions_file = __DIR__ . '/wp-includes/functions.php';

// Check if the file exists
if (!file_exists($functions_file)) {
    die("WordPress core file not found. Make sure this script is in the WordPress root directory.");
}

// Backup the file first
$backup_file = $functions_file . '.bak-' . date('Y-m-d-H-i-s');
if (!copy($functions_file, $backup_file)) {
    die("Failed to create backup of functions.php. Aborting for safety.");
}
echo "Backup created at: " . basename($backup_file) . "\n";

// Read the file contents
$contents = file_get_contents($functions_file);
if ($contents === false) {
    die("Failed to read functions.php. Check file permissions.");
}

// The original problematic function
$original_function = <<<'EOD'
function wp_ob_end_flush_all() {
	/**
	 * Filters whether to flush the output buffer or not.
	 *
	 * @since 6.3.0
	 *
	 * @param bool $do_flush Whether to flush output buffer. Default true.
	 */
	$do_flush = apply_filters( 'wp_ob_end_flush_all', true );
	if ( ! $do_flush ) {
		return;
	}

	$levels = ob_get_level();
	for ( $i = 0; $i < $levels; $i++ ) {
		ob_end_flush();
	}
}
EOD;

// The fixed version of the function
$fixed_function = <<<'EOD'
function wp_ob_end_flush_all() {
	/**
	 * Filters whether to flush the output buffer or not.
	 *
	 * @since 6.3.0
	 *
	 * @param bool $do_flush Whether to flush output buffer. Default true.
	 */
	$do_flush = apply_filters( 'wp_ob_end_flush_all', true );
	if ( ! $do_flush ) {
		return;
	}

	$levels = ob_get_level();
	for ( $i = 0; $i < $levels; $i++ ) {
		@ob_end_flush();
	}
}
EOD;

// Replace the function in the file contents
$new_contents = str_replace($original_function, $fixed_function, $contents);

// Check if the replacement was successful
if ($new_contents === $contents) {
    echo "No changes were made. The function may already be patched or is in a different format than expected.\n";
} else {
    // Write the modified contents back to the file
    if (file_put_contents($functions_file, $new_contents) === false) {
        die("Failed to write to functions.php. Check file permissions.");
    }
    echo "Successfully patched WordPress core to fix output buffering issues.\n";
}

echo "Fix complete. Please delete this script for security.\n";
