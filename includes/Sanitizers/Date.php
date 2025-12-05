<?php

namespace Giganteck\Opton\Sanitizers;

use Giganteck\Opton\Contracts\SanitizerInterface;

/**
 * Date sanitizer - ensures valid date format
 */
class Date implements SanitizerInterface
{
    public function sanitize($value)
    {
        // Try to create a DateTime object and return in Y-m-d format
        $date = \DateTime::createFromFormat('Y-m-d', $value);

        if ($date) {
            return $date->format('Y-m-d');
        }

        // Try other common formats
        $formats = ['m/d/Y', 'd/m/Y', 'Y/m/d', 'm-d-Y', 'd-m-Y'];
        foreach ($formats as $format) {
            $date = \DateTime::createFromFormat($format, $value);
            if ($date) {
                return $date->format('Y-m-d');
            }
        }

        return sanitize_text_field($value);
    }
}
