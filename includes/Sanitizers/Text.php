<?php

namespace Giganteck\Opton\Sanitizers;

use Giganteck\Opton\Contracts\SanitizerInterface;

/**
 * Text sanitizer - removes HTML tags and special characters
 */
class Text implements SanitizerInterface
{
    public function sanitize($value)
    {
        return sanitize_text_field($value);
    }
}
