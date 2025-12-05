<?php

namespace Giganteck\Opton\ValidationRules;

use Giganteck\Opton\Contracts\ValidationRuleInterface;

/**
 * Numeric validation rule
 */
class Numeric implements ValidationRuleInterface
{
    public function validate($value, array $params, string $fieldName): array
    {
        if (!empty($value) && !is_numeric($value)) {
            return [$fieldName . ' must be numeric'];
        }

        return [];
    }
}
