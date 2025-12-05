<?php

namespace Giganteck\Opton\Sanitizers;

use Giganteck\Opton\Contracts\SanitizerInterface;

/**
 * URL sanitizer
 */
class Url implements SanitizerInterface
{
    public function sanitize($value)
    {
        return esc_url_raw($value);
    }
}
