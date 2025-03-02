<?php
/**
 * WordPress Direct Post Editor
 * Use this script to modify post content directly from code
 * without using WordPress admin interface
 */

// Load WordPress
define('WP_USE_THEMES', false);
require_once('wp-load.php');

// Security check - remove for production use
if (!isset($_GET['key']) || $_GET['key'] !== 'secure123') {
    die('Security key required');
}

// Post to update (get from query string or hardcode)
$post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 1; // Default to first post

// Get post details
$post = get_post($post_id);
if (!$post) {
    die('Post not found');
}

// Display current post info
echo '<h1>Current Post Content (ID: ' . $post_id . ')</h1>';
echo '<p><strong>Title:</strong> ' . esc_html($post->post_title) . '</p>';
echo '<p><strong>Content:</strong></p>';
echo '<div style="border:1px solid #ccc; padding:10px; margin-bottom:20px;">';
echo wpautop($post->post_content);
echo '</div>';

// Update post if form submitted
if (isset($_POST['submit'])) {
    $updated_post = array(
        'ID'           => $post_id,
        'post_title'   => sanitize_text_field($_POST['post_title']),
        'post_content' => wp_kses_post($_POST['post_content']),
    );
    
    $result = wp_update_post($updated_post, true);
    
    if (is_wp_error($result)) {
        echo '<div style="color:red; padding:10px; border:1px solid red; margin:10px 0;">';
        echo 'Error updating post: ' . $result->get_error_message();
        echo '</div>';
    } else {
        echo '<div style="color:green; padding:10px; border:1px solid green; margin:10px 0;">';
        echo 'Post updated successfully! <a href="' . get_permalink($post_id) . '">View Post</a>';
        echo '</div>';
        
        // Refresh post data
        $post = get_post($post_id);
    }
}

// Available posts for reference
$available_posts = get_posts(array(
    'numberposts' => 10,
    'post_status' => 'publish'
));

echo '<h2>Available Posts</h2>';
echo '<ul>';
foreach ($available_posts as $available_post) {
    echo '<li><a href="?key=secure123&post_id=' . $available_post->ID . '">' . 
         esc_html($available_post->post_title) . 
         ' (ID: ' . $available_post->ID . ')</a></li>';
}
echo '</ul>';

// Edit form
echo '<h2>Edit Post</h2>';
echo '<form method="post">';
echo '<p><label for="post_title">Title:</label><br>';
echo '<input type="text" name="post_title" id="post_title" value="' . esc_attr($post->post_title) . '" style="width:100%;"></p>';

echo '<p><label for="post_content">Content:</label><br>';
echo '<textarea name="post_content" id="post_content" style="width:100%; height:300px;">' . esc_textarea($post->post_content) . '</textarea></p>';

echo '<p><input type="submit" name="submit" value="Update Post"></p>';
echo '</form>';
?>
