<?php
/**
 * Template for select field
 *
 * @var string $args['attributes'] HTML attributes string
 * @var array $args['options'] Select options [value => label]
 * @var string $args['current_value'] Current selected value
 */
defined('ABSPATH') || exit;

$optonAttributes = $args['attributes'] ?? '';
$optonOptions = $args['options'] ?? [];
$optonCurrentValue = $args['current_value'] ?? '';
?>
<select <?php echo wp_kses_post($optonAttributes); ?>>
    <?php foreach ($optonOptions as $optonValue => $optonLabel) :
        $optonSelected = ($optonCurrentValue == $optonValue) ? 'selected="selected"' : '';
    ?>
        <option value="<?php echo esc_attr($optonValue); ?>" <?php echo esc_attr($optonSelected); ?>>
            <?php echo esc_html($optonLabel); ?>
        </option>
    <?php endforeach; ?>
</select>
