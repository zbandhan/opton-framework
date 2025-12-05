<?php
/**
 * Template for a form page
 *
 * @var string $args['page_id'] The page ID
 * @var bool $args['is_first'] Whether this is the first page
 * @var string $args['content'] The page content HTML
 */
defined('ABSPATH') || exit;

$optonPageId = $args['page_id'] ?? '';
$optonIsFirst = $args['is_first'] ?? false;
$optonContent = $args['content'] ?? '';
$optonDisplayStyle = $optonIsFirst ? 'block' : 'none';
?>

<div class="opton-page p-6 space-y-8"
     id="opton-page-<?php echo esc_attr($optonPageId); ?>"
     data-page="<?php echo esc_attr($optonPageId); ?>"
     style="display: <?php echo esc_attr($optonDisplayStyle); ?>;">
    <?php
        // phpcs:ignore	WordPress.Security.EscapeOutput.OutputNotEscaped
        echo $optonContent;
    ?>
</div>
