<?php

namespace Giganteck\Opton\ValidationRules;

use Giganteck\Opton\Contracts\ValidationRuleInterface;

/**
 * Minimum value validation rule
 */
class Min implements ValidationRuleInterface
{
    public function validate($value, array $params, string $fieldName): array
    {
        if (empty($params)) {
            return [];
        }

        $min = floatval($params[0]);

        if (!empty($value) && is_numeric($value) && floatval($value) < $min) {
            return [$fieldName . ' must be at least ' . $min];
        }

        return [];
    }
}
