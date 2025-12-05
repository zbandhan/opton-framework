<?php

namespace Giganteck\Opton\ValidationRules;

use Giganteck\Opton\Contracts\ValidationRuleInterface;

/**
 * Required field validation rule
 */
class Required implements ValidationRuleInterface
{
    public function validate($value, array $params, string $fieldName): array
    {
        if (empty($value) && $value !== '0') {
            return [$fieldName . ' is required'];
        }

        return [];
    }
}
