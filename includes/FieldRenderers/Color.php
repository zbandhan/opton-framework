<?php

namespace Giganteck\Opton\FieldRenderers;

use Giganteck\Opton\Contracts\RendererInterface;
use Giganteck\Opton\Utils\Template;

/**
 * Renderer for color picker fields (HTML5 color input)
 */
class Color implements RendererInterface
{
    public function render($currentValue, array $attributes, array $options = [], string $fieldId = ''): string
    {
        // Ensure type is color
        $attributes['type'] = 'color';

        // Set default value if not provided
        if (empty($attributes['value'])) {
            $attributes['value'] = '#000000';
        }

        return Template::get_view('fields/text', [
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
