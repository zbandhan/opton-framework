<?php
/**
 * Template for form pages wrapper
 *
 * @var string $args['content'] The pages content HTML
 */
defined('ABSPATH') || exit;

$optonContent = $args['content'] ?? '';
?>

<div class="opton-pages border border-solid border-[#ccc] border-t-0 p-5">
    <?php
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo $optonContent;
    ?>
</div>
