<?php

namespace Giganteck\Opton\FieldRenderers;

use Giganteck\Opton\Contracts\RendererInterface;
use Giganteck\Opton\Utils\Template;

/**
 * Renderer for checkbox fields
 */
class Checkbox implements RendererInterface
{
    public function render($currentValue, array $attributes, array $options = [], string $fieldId = ''): string
    {
        // Check if checkbox should be checked
        $checkboxValue = isset($attributes['value']) ? $attributes['value'] : '1';

        // Handle various truthy values and match against checkbox value
        $isChecked = false;
        if (!empty($currentValue)) {
            if ($currentValue === true || $currentValue === 'on' || $currentValue === 1 || $currentValue === '1') {
                $isChecked = true;
            } elseif ($currentValue == $checkboxValue) {
                $isChecked = true;
            }
        }

        // Add or remove checked attribute
        if ($isChecked) {
            $attributes['checked'] = 'checked';
        } else {
            unset($attributes['checked']);
        }

        return Template::get_view('fields/checkbox', [
            'attributes' => $this->attributesToString($attributes)
        ]);
    }

    private function attributesToString(array $attributes): string
    {
        $attrs = [];
        foreach ($attributes as $key => $value) {
            if (is_bool($value)) {
                if ($value) {
                    $attrs[] = esc_attr($key);
                }
            } else {
                $attrs[] = esc_attr($key) . '="' . esc_attr($value) . '"';
            }
        }

        return implode(' ', $attrs);
    }
}
