<?php
/**
 * Template for displaying metabox page title
 *
 * @var string $args['page_title'] The page title
 */
defined('ABSPATH') || exit;

$optonPageTitle = $args['page_title'] ?? '';
$optonFormHtml = $args['form_html'] ?? '';
?>

<div class="grid grid-cols-[repeat(12,1fr)]">
    <div class="col-start-2 -col-end-1 bg-gray-50 border border-gray-200 rounded-tr-lg px-6 py-4">
        <?php if (!empty($optonPageTitle)) : ?>
            <h2 class="text-xl font-semibold text-gray-900 leading-7 m-0!">
                <?php echo esc_html($optonPageTitle); ?>
            </h2>
        <?php endif ?>
    </div>

    <?php
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo $optonFormHtml;
    ?>
</div>
