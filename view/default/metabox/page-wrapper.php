<?php
/**
 * Template for displaying metabox page title
 *
 * @var string $args['page_title'] The page title
 */
defined('ABSPATH') || exit;

$optonPageTitle = $args['page_title'] ?? '';
$optonFormHtml = $args['form_html'] ?? '';

if (!empty($optonPageTitle)) : ?>
    <h2 class="mt-0"><?php echo esc_html($optonPageTitle); ?></h2>
<?php endif;

// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
echo $optonFormHtml;
