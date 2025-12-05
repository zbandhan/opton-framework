<?php

namespace Giganteck\Opton\ValidationRules;

use Giganteck\Opton\Contracts\ValidationRuleInterface;

/**
 * URL validation rule
 */
class Url implements ValidationRuleInterface
{
    public function validate($value, array $params, string $fieldName): array
    {
        if (!empty($value) && !filter_var($value, FILTER_VALIDATE_URL)) {
            return [$fieldName . ' must be a valid URL'];
        }

        return [];
    }
}
