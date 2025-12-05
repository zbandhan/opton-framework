<?php

namespace Giganteck\Opton\FieldRenderers;

use Giganteck\Opton\Contracts\RendererInterface;
use Giganteck\Opton\Utils\Template;

/**
 * Renderer for select dropdown fields
 */
class Select implements RendererInterface
{
    public function render($currentValue, array $attributes, array $options = [], string $fieldId = ''): string
    {
        $attrs = $attributes;
        unset($attrs['value']);

        return Template::get_view('fields/select', [
            'attributes' => $this->attributesToString($attrs),
            'options' => $options,
            'current_value' => $currentValue
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
