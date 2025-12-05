<?php

namespace Giganteck\Opton\Sanitizers;

use Giganteck\Opton\Contracts\SanitizerInterface;

/**
 * Email sanitizer
 */
class Email implements SanitizerInterface
{
    public function sanitize($value)
    {
        return sanitize_email($value);
    }
}
