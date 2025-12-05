<?php
/**
 * Template for a single repeater row
 *
 * @var int|string $args['index'] Row index
 * @var int $args['grid_columns'] Number of grid columns
 * @var string $args['fields_html'] HTML for fields in this row
 */
defined('ABSPATH') || exit;

$optonIndex = $args['index'] ?? 0;
$optonGridColumns = $args['grid_columns'] ?? 1;
$optonFieldsHtml = $args['fields_html'] ?? '';
$optonRowNumber = is_numeric($optonIndex) ? absint($optonIndex) + 1 : '{{INDEX_DISPLAY}}';
?>

<div class="opton-repeater-row bg-[#f9f9f9] border border-[#ddd] rounded-sm p-[15px]! mb-2.5!">
    <div class="opton-repeater-row-header flex justify-between items-center mb-2.5!">
        <?php printf('<span class="opton-repeater-row-number font-bold">Row #%s</span>', absint($optonRowNumber)); ?>
        <button type="button" class="button opton-repeater-remove color-[#a00] flex! justify-center items-center">
            <span class="dashicons dashicons-no-alt"></span>
        </button>
    </div>

    <div class="opton-fields-grid grid grid-cols-<?php echo absint($optonGridColumns); ?> gap-[15px]">
        <?php
            // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            echo $optonFieldsHtml;
        ?>
    </div>
</div>