<?php
/**
 * Template for file upload field
 *
 * @var string $args['attributes'] HTML attributes string
 * @var string $args['current_url'] Current file URL if exists
 */
defined('ABSPATH') || exit;

$optonAttributes = $args['attributes'] ?? '';
$optonCurrentUrl = $args['current_url'] ?? '';
?>

<div class="opton-file-upload-wrapper">
    <input <?php echo wp_kses_post($optonAttributes); ?>>

    <?php if (!empty($optonCurrentUrl)) : ?>
        <div class="opton-file-preview mt-2.5!">
            <a href="<?php echo esc_url($optonCurrentUrl); ?>" target="_blank">
                <?php echo esc_html('View Current File') ?>
            </a>
        </div>
    <?php endif; ?>
</div>
