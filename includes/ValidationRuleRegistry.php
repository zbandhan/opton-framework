<?php

namespace Giganteck\Opton;

use Giganteck\Opton\Contracts\ValidationRuleInterface;
use Giganteck\Opton\ValidationRules\Required;
use Giganteck\Opton\ValidationRules\Email;
use Giganteck\Opton\ValidationRules\Numeric;
use Giganteck\Opton\ValidationRules\Min;
use Giganteck\Opton\ValidationRules\Max;
use Giganteck\Opton\ValidationRules\Between;
use Giganteck\Opton\ValidationRules\Url;
use Giganteck\Opton\ValidationRules\Phone;
use Giganteck\Opton\ValidationRules\Date;
use Giganteck\Opton\ValidationRules\Regex;

/**
 * Factory for creating validation rules
 */
class ValidationRuleRegistry
{
    private static $rules = [];
    private static $customRules = [];

    /**
     * Get validation rule instance
     *
     * @param string $ruleName Rule name
     * @return ValidationRuleInterface|null
     */
    public static function getRule(string $ruleName): ?ValidationRuleInterface
    {
        // Check for custom rule first
        if (isset(self::$customRules[$ruleName])) {
            return self::$customRules[$ruleName];
        }

        // Return cached rule if exists
        if (isset(self::$rules[$ruleName])) {
            return self::$rules[$ruleName];
        }

        // Create and cache rule
        $rule = self::createRule($ruleName);
        if ($rule) {
            self::$rules[$ruleName] = $rule;
        }

        return $rule;
    }

    /**
     * Create rule instance
     *
     * @param string $ruleName Rule name
     * @return ValidationRuleInterface|null
     */
    private static function createRule(string $ruleName): ?ValidationRuleInterface
    {
        switch ($ruleName) {
            case 'required':
                return new Required();

            case 'email':
                return new Email();

            case 'numeric':
                return new Numeric();

            case 'min':
                return new Min();

            case 'max':
                return new Max();

            case 'between':
                return new Between();

            case 'url':
                return new Url();

            case 'phone':
                return new Phone();

            case 'date':
                return new Date();

            case 'regex':
                return new Regex();

            default:
                return null;
        }
    }

    /**
     * Register a custom validation rule
     *
     * @param string $ruleName Rule name
     * @param ValidationRuleInterface $rule Rule instance
     * @return void
     */
    public static function registerRule(string $ruleName, ValidationRuleInterface $rule): void
    {
        self::$customRules[$ruleName] = $rule;
    }

    /**
     * Clear all cached rules (useful for testing)
     *
     * @return void
     */
    public static function clearCache(): void
    {
        self::$rules = [];
    }
}
