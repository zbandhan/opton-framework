<?php
/**
 * Template for field wrapper
 *
 * @var string $args['wrapper_class'] Wrapper CSS class
 * @var string $args['conditional_attrs'] Conditional attributes HTML
 * @var string $args['label_html'] Label HTML
 * @var string $args['input_html'] Input HTML
 * @var string $args['description'] Field description
 */
defined('ABSPATH') || exit;

$optonWrapperClass = $args['wrapper_class'] ?? 'opton-field';
$optonConditionalAttrs = $args['conditional_attrs'] ?? '';
$optonInputType = $args['type'] ?? '';
$optonLabelHtml = $args['label_html'] ?? '';
$optonInputHtml = $args['input_html'] ?? '';
$optonDescription = $args['description'] ?? '';
?>

<?php if ($optonInputType !== 'radio') : ?>
    <div class="<?php echo esc_attr($optonWrapperClass); ?>"<?php echo $optonConditionalAttrs; ?>>
        <?php echo wp_kses_post($optonLabelHtml); ?>
        <?php
            // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            echo $optonInputHtml;
        ?>
        <?php if (!empty($optonDescription)) : ?>
            <p class="mt-2.5 text-sm text-fg-success-strong"><?php echo esc_html($optonDescription); ?></p>
        <?php endif; ?>
    </div>
<?php else: ?>
    <?php echo wp_kses_post($optonLabelHtml); ?>
    <?php
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo $optonInputHtml;
    ?>
    <?php if (!empty($optonDescription)) : ?>
        <p class="mt-2.5 text-sm text-fg-success-strong"><?php echo esc_html($optonDescription); ?></p>
    <?php endif; ?>
<?php endif ?>