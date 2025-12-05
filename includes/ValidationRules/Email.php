<?php

namespace Giganteck\Opton\ValidationRules;

use Giganteck\Opton\Contracts\ValidationRuleInterface;

/**
 * Email validation rule
 */
class Email implements ValidationRuleInterface
{
    public function validate($value, array $params, string $fieldName): array
    {
        if (!empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return [$fieldName . ' must be a valid email address'];
        }

        return [];
    }
}
