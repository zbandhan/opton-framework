<?php

namespace Giganteck\Opton\Abstracts;

/**
 * Abstract base class for creating fluent builders
 */
abstract class FormBuilder
{
    /**
     * Static factory method for creating instances
     * @return static
     */
    public static function create()
    {
        return new static();
    }

    /**
     * Convert attributes array to HTML attribute string
     * @param array $attributes
     * @return string
     */
    protected function attributesToString(array $attributes)
    {
        $parts = [];
        foreach ($attributes as $key => $value) {
            if ($value !== null && $value !== false) {
                if ($value === true) {
                    $parts[] = esc_attr($key);
                } else {
                    $parts[] = esc_attr($key) . '="' . esc_attr($value) . '"';
                }
            }
        }
        return implode(' ', $parts);
    }
}
