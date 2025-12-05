<?php

namespace Giganteck\Opton\ValidationRules;

use Giganteck\Opton\Contracts\ValidationRuleInterface;

/**
 * Phone number validation rule (US format)
 */
class Phone implements ValidationRuleInterface
{
    public function validate($value, array $params, string $fieldName): array
    {
        if (!empty($value)) {
            // Remove common formatting characters
            $cleaned = preg_replace('/[^0-9]/', '', $value);

            if (strlen($cleaned) !== 10) {
                return [$fieldName . ' must be a valid 10-digit phone number'];
            }
        }

        return [];
    }
}
