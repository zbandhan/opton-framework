<?php

namespace Giganteck\Opton;

use Giganteck\Opton\ValidationRuleRegistry;

/**
 * Validation class for field validation
 */
class Validator
{
    private $rules = [];

    public function __construct($rules = [])
    {
        $this->rules = is_string($rules) ? explode('|', $rules) : $rules;
    }

    public function validate($value, $fieldName = 'field')
    {
        $errors = [];

        foreach ($this->rules as $rule) {
            $ruleParts = explode(':', $rule);
            $ruleName = $ruleParts[0];
            $ruleParams = isset($ruleParts[1]) ? explode(',', $ruleParts[1]) : [];

            // Get validation rule from rule registry
            $ruleObject = ValidationRuleRegistry::getRule($ruleName);

            if ($ruleObject) {
                $ruleErrors = $ruleObject->validate($value, $ruleParams, $fieldName);
                $errors = array_merge($errors, $ruleErrors);
            }
        }

        return $errors;
    }

}
