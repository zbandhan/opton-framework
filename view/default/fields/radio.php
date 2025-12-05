<?php
/**
 * Template for radio input fields
 *
 * @var array $args['options'] Radio options [value => label]
 * @var string $args['field_id'] Base field ID
 * @var array $args['base_attributes'] Base attributes array
 * @var string $args['current_value'] Current selected value
 */
defined('ABSPATH') || exit;

$optonOptions = $args['options'] ?? [];
$optonFieldId = $args['field_id'] ?? '';
$optonBaseAttributes = $args['base_attributes'] ?? [];
$optonCurrentValue = $args['current_value'] ?? '';

foreach ($optonOptions as $optonValue => $optonLabel) :
    $optonRadioAttrs = $optonBaseAttributes;
    $optonRadioAttrs['id'] = $optonFieldId . '_' . $optonValue;
    $optonRadioAttrs['value'] = $optonValue;

    if ($optonCurrentValue == $optonValue) {
        $optonRadioAttrs['checked'] = 'checked';
    }

    $optonAttrsString = '';
    foreach ($optonRadioAttrs as $optonAttr => $optonValue) {
        if (is_bool($optonValue)) {
            $optonAttrsString .= $optonValue ? ' ' . esc_attr($optonAttr) : '';
        } else {
            $optonAttrsString .= ' ' . esc_attr($optonAttr) . '="' . esc_attr($optonValue) . '"';
        }
    }
    ?>
    <div class="opton-field">
        <label>
            <input <?php echo wp_kses_post($optonAttrsString); ?>> <?php echo esc_html($optonLabel); ?>
        </label>
    </div>
<?php endforeach;
