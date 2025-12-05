<?php

namespace Giganteck\Opton\ValidationRules;

use Giganteck\Opton\Contracts\ValidationRuleInterface;

/**
 * Between validation rule
 */
class Between implements ValidationRuleInterface
{
    public function validate($value, array $params, string $fieldName): array
    {
        if (count($params) < 2) {
            return [];
        }

        $min = floatval($params[0]);
        $max = floatval($params[1]);

        if (!empty($value) && is_numeric($value)) {
            $val = floatval($value);
            if ($val < $min || $val > $max) {
                return [$fieldName . ' must be between ' . $min . ' and ' . $max];
            }
        }

        return [];
    }
}
