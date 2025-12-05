<?php
/**
 * Template for fields grid layout
 *
 * @var int $args['grid_columns'] Number of grid columns
 * @var string $args['content'] Fields HTML content
 */
defined('ABSPATH') || exit;

$optonGridColumns = $args['grid_columns'] ?? 1;
$optonContent = $args['content'] ?? '';
?>

<div class="opton-fields-grid grid grid-cols-<?php echo absint($optonGridColumns); ?> gap-5">
    <?php
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo $optonContent;
    ?>
</div>
