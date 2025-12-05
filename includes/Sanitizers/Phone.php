<?php

namespace Giganteck\Opton\Sanitizers;

use Giganteck\Opton\Contracts\SanitizerInterface;

/**
 * Phone number sanitizer - removes all non-numeric characters
 */
class Phone implements SanitizerInterface
{
    public function sanitize($value)
    {
        // Remove all non-numeric characters
        return preg_replace('/[^0-9]/', '', $value);
    }
}
