<?php
/**
 * Template for field label
 *
 * @var string $args['field_id'] Field ID
 * @var string $args['label'] Label text
 * @var bool $args['required'] Whether field is required
 */
defined('ABSPATH') || exit;

$optonFieldId = $args['field_id'] ?? '';
$optonLabel = $args['label'] ?? '';
$optonRequired = $args['required'] ?? false;

if (!empty($optonLabel)) : ?>
    <label for="<?php echo esc_attr($optonFieldId); ?>" class="opton-label block mb-1 text-sm font-medium text-heading">
        <?php echo esc_html($optonLabel); ?>
        <?php if ($optonRequired) : ?>
            <span class="required text-red-700">*</span>
        <?php endif; ?>
    </label>
<?php endif;
