<?php

namespace Giganteck\Opton\Contracts;

/**
 * Interface for field renderers
 */
interface RendererInterface
{
    /**
     * Render the field input
     *
     * @param mixed $currentValue Current field value
     * @param array $attributes Field attributes
     * @param array $options Field options (for select/radio)
     * @param string $fieldId Field ID
     * @return string Rendered HTML
     */
    public function render($currentValue, array $attributes, array $options = [], string $fieldId = ''): string;
}
