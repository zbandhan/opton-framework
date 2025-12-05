<?php
/**
 * Template for repeater wrapper
 *
 * @var string $args['repeater_id'] Unique repeater ID
 * @var string $args['rows_html'] HTML for repeater rows
 * @var string $args['template_html'] HTML template for new rows
 */
defined('ABSPATH') || exit;

$optonRepeaterId = $args['repeater_id'] ?? '';
$optonRowsHtml = $args['rows_html'] ?? '';
$optonTemplateHtml = $args['template_html'] ?? '';
?>

<div class="opton-repeater" data-repeater-id="<?php echo esc_attr($optonRepeaterId); ?>">
    <div class="opton-repeater-items">
        <?php
            // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            echo $optonRowsHtml;
        ?>
    </div>

    <button type="button" class="button opton-repeater-add mt-2.5" data-repeater-id="<?php echo esc_attr($optonRepeaterId); ?>">
        <?php echo esc_html('Add Row') ?>
    </button>

    <script type="text/html" id="<?php echo esc_attr($optonRepeaterId); ?>-template">
        <?php
            // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            echo $optonTemplateHtml;
        ?>
    </script>
</div>
