<?php

namespace Giganteck\Opton\ValidationRules;

use Giganteck\Opton\Contracts\ValidationRuleInterface;

/**
 * Custom regex validation rule
 */
class Regex implements ValidationRuleInterface
{
    public function validate($value, array $params, string $fieldName): array
    {
        if (empty($params[0])) {
            return [];
        }

        $pattern = $params[0];

        if (!empty($value) && !preg_match($pattern, $value)) {
            $message = !empty($params[1])
                ? $params[1]
                : $fieldName . ' does not match the required format';
            return [$message];
        }

        return [];
    }
}
