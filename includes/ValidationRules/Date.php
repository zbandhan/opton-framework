<?php

namespace Giganteck\Opton\ValidationRules;

use Giganteck\Opton\Contracts\ValidationRuleInterface;

/**
 * Date format validation rule
 */
class Date implements ValidationRuleInterface
{
    public function validate($value, array $params, string $fieldName): array
    {
        if (!empty($value)) {
            $format = !empty($params[0]) ? $params[0] : 'Y-m-d';
            $date = \DateTime::createFromFormat($format, $value);

            if (!$date || $date->format($format) !== $value) {
                return [$fieldName . ' must be a valid date in format ' . $format];
            }
        }

        return [];
    }
}
