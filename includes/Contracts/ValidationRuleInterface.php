<?php

namespace Giganteck\Opton\Contracts;

/**
 * Interface for validation rules
 */
interface ValidationRuleInterface
{
    /**
     * Validate a value
     *
     * @param mixed $value Value to validate
     * @param array $params Rule parameters
     * @param string $fieldName Field name for error messages
     * @return array Array of error messages (empty if valid)
     */
    public function validate($value, array $params, string $fieldName): array;
}
