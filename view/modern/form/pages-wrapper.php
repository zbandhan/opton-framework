<?php
/**
 * Template for form pages wrapper
 *
 * @var string $args['content'] The pages content HTML
 */
defined('ABSPATH') || exit;

$optonContent = $args['content'] ?? '';
?>
<div class="opton-pages col-start-2 -col-end-1 bg-white shadow-sm border border-gray-200 overflow-hidden">
    <?php
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo $optonContent;
    ?>
</div>
