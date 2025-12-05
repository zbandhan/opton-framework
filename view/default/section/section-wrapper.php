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

<div class="opton-section [&:has(.opton-repeater)]:border [&:has(.opton-repeater)]:border-[#ddd] [&:has(.opton-repeater)]:my-5 [&:has(.opton-repeater)]:p-5 [&:has(.opton-repeater)]:pt-2.5">
    <?php if (!empty($optonTitle)) : ?>
        <h3 class="opton-section-title"><?php echo esc_html($optonTitle); ?></h3>
    <?php endif; ?>
    <?php
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo $optonContent;
    ?>
</div>
