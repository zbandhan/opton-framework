<?php
/**
 * Template for text input field
 *
 * @var string $args['attributes'] HTML attributes string
 */
defined('ABSPATH') || exit;

$optonAttributes = $args['attributes'] ?? '';
?>
<input <?php echo wp_kses_post($optonAttributes); ?>>
