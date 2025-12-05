<?php
/**
 * Template for textarea field
 *
 * @var string $args['attributes'] HTML attributes string
 * @var string $args['value'] Textarea value
 */
defined('ABSPATH') || exit;

$optonAttributes = $args['attributes'] ?? '';
$optonValue = $args['value'] ?? '';
?>
<textarea <?php echo wp_kses_post($optonAttributes); ?>><?php echo esc_textarea($optonValue); ?></textarea>
