<?php

namespace Giganteck\Opton\Sanitizers;

use Giganteck\Opton\Contracts\SanitizerInterface;

/**
 * HTML sanitizer - allows safe HTML tags
 */
class Html implements SanitizerInterface
{
    public function sanitize($value)
    {
        return wp_kses_post($value);
    }
}
