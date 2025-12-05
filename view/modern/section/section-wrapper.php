<?php
/**
 * Template for section wrapper
 *
 * @var string $args['title'] Section title
 * @var string $args['content'] Section content HTML
 */
defined('ABSPATH') || exit;

$optonTitle = $args['title'] ?? '';
$optonContent = $args['content'] ?? '';
?>

<div class="form-section">
    <?php if (!empty($optonTitle)) : ?>
        <h3 class="text-lg font-medium text-gray-900 mb-4"><?php echo esc_html($optonTitle); ?></h3>
    <?php endif; ?>
    <?php
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo $optonContent;
    ?>
</div>
