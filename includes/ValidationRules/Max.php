<?php

namespace Giganteck\Opton\ValidationRules;

use Giganteck\Opton\Contracts\ValidationRuleInterface;

/**
 * Maximum value validation rule
 */
class Max implements ValidationRuleInterface
{
    public function validate($value, array $params, string $fieldName): array
    {
        if (empty($params)) {
            return [];
        }

        $max = floatval($params[0]);

        if (!empty($value) && is_numeric($value) && floatval($value) > $max) {
            return [$fieldName . ' cannot exceed ' . $max];
        }

        return [];
    }
}
