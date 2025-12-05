<?php

namespace Giganteck\Opton\Sanitizers;

use Giganteck\Opton\Contracts\SanitizerInterface;

/**
 * Textarea sanitizer - allows line breaks
 */
class Textarea implements SanitizerInterface
{
    public function sanitize($value)
    {
        return sanitize_textarea_field($value);
    }
}
