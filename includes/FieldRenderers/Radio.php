<?php

namespace Giganteck\Opton\FieldRenderers;

use Giganteck\Opton\Contracts\RendererInterface;
use Giganteck\Opton\Utils\Template;

/**
 * Renderer for radio button fields
 */
class Radio implements RendererInterface
{
    public function render($currentValue, array $attributes, array $options = [], string $fieldId = ''): string
    {
        return Template::get_view('fields/radio', [
            'options' => $options,
            'field_id' => $fieldId,
            'base_attributes' => $attributes,
            'current_value' => $currentValue
        ]);
    }
}
