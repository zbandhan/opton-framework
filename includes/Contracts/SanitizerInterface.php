<?php

namespace Giganteck\Opton\Contracts;

/**
 * Interface for sanitizers
 */
interface SanitizerInterface
{
    /**
     * Sanitize a value
     *
     * @param mixed $value Value to sanitize
     * @return mixed Sanitized value
     */
    public function sanitize($value);
}
