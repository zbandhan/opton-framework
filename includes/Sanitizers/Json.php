<?php

namespace Giganteck\Opton\Sanitizers;

use Giganteck\Opton\Contracts\SanitizerInterface;

/**
 * JSON sanitizer - validates and reformats JSON
 */
class Json implements SanitizerInterface
{
    public function sanitize($value)
    {
        $decoded = json_decode($value, true);

        if (json_last_error() === JSON_ERROR_NONE && $decoded !== null) {
            return json_encode($decoded);
        }

        return '{}';
    }
}
