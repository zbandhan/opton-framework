<?php

namespace Giganteck\Opton\Sanitizers;

use Giganteck\Opton\Contracts\SanitizerInterface;

/**
 * Strip tags sanitizer - removes all HTML tags
 */
class StripTags implements SanitizerInterface
{
    public function sanitize($value)
    {
        return wp_strip_all_tags($value);
    }
}
