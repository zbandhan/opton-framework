<?php

namespace Giganteck\Opton\FieldRenderers;

use Giganteck\Opton\Contracts\RendererInterface;
use Giganteck\Opton\Utils\Template;

/**
 * Renderer for file upload fields
 */
class File implements RendererInterface
{
    public function render($currentValue, array $attributes, array $options = [], string $fieldId = ''): string
    {
        // Ensure type is file
        $attributes['type'] = 'file';

        // Remove value attribute (can't set value for file inputs)
        unset($attributes['value']);

        return Template::get_view('fields/file', [
            'attributes' => $this->attributesToString($attributes),
            'current_url' => $currentValue
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
