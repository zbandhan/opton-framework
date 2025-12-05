<?php

namespace Giganteck\Opton\Contracts;

/**
 * Interface for Field Builder
 *
 * This interface defines all configuration methods available for field chaining.
 */
interface BuilderInterface
{
    /**
     * Set the field ID
     *
     * @param string $id Field ID
     * @return BuilderInterface
     */
    public function id(string $id): BuilderInterface;

    /**
     * Set the field label
     *
     * @param string $label Field label
     * @return BuilderInterface
     */
    public function label(string $label): BuilderInterface;

    /**
     * Set the field value
     *
     * @param mixed $value Field value
     * @return BuilderInterface
     */
    public function value($value): BuilderInterface;

    /**
     * Set the default value
     *
     * @param mixed $value Default value
     * @return BuilderInterface
     */
    public function default($value): BuilderInterface;

    /**
     * Set the field placeholder
     *
     * @param string $placeholder Placeholder text
     * @return BuilderInterface
     */
    public function placeholder(string $placeholder): BuilderInterface;

    /**
     * Set the field description
     *
     * @param string $description Description text
     * @return BuilderInterface
     */
    public function description(string $description): BuilderInterface;

    /**
     * Set the field as required
     *
     * @param bool $required Whether field is required
     * @return BuilderInterface
     */
    public function required(bool $required = true): BuilderInterface;

    /**
     * Set the checked state (for checkboxes and radios)
     *
     * @param mixed $currentValue Current value to check against
     * @return BuilderInterface
     */
    public function checked($currentValue = true): BuilderInterface;

    /**
     * Set custom HTML attributes
     *
     * @param array $attributes Associative array of attributes
     * @return BuilderInterface
     */
    public function attributes(array $attributes): BuilderInterface;

    /**
     * Set minimum value (for number/date fields)
     *
     * @param float $min Minimum value
     * @return BuilderInterface
     */
    public function min(float $min): BuilderInterface;

    /**
     * Set maximum value (for number/date fields)
     *
     * @param float $max Maximum value
     * @return BuilderInterface
     */
    public function max(float $max): BuilderInterface;

    /**
     * Set options for select/radio/checkbox fields
     *
     * @param array $options Options array
     * @return BuilderInterface
     */
    public function options(array $options): BuilderInterface;

    /**
     * Set validation rules
     *
     * @param string|array $rules Validation rules
     * @return BuilderInterface
     */
    public function validate($rules): BuilderInterface;

    /**
     * Set custom sanitizer
     *
     * @param string|callable $sanitizer Sanitizer name or callable
     * @return BuilderInterface
     */
    public function sanitize($sanitizer): BuilderInterface;

    /**
     * Show field when condition is met
     *
     * @param string $fieldId Field ID to check
     * @param mixed $value Value to compare
     * @return BuilderInterface
     */
    public function showWhen(string $fieldId, $value): BuilderInterface;

    /**
     * Hide field when condition is met
     *
     * @param string $fieldId Field ID to check
     * @param mixed $value Value to compare
     * @return BuilderInterface
     */
    public function hideWhen(string $fieldId, $value): BuilderInterface;

    /**
     * Make field span full width in grid
     *
     * @return BuilderInterface
     */
    public function fullCol(): BuilderInterface;

    /**
     * Set the theme for this field
     *
     * @param string $theme Theme name
     * @return BuilderInterface
     */
    public function setTheme(string $theme): BuilderInterface;

    /**
     * Get the field name
     *
     * @return string
     */
    public function getName();

    /**
     * Get the field type
     *
     * @return string
     */
    public function getType();

    /**
     * Get field conditions
     *
     * @return array
     */
    public function getConditions();

    /**
     * Check if field should span full width
     *
     * @return bool
     */
    public function isFullWidth();

    /**
     * Get the current theme
     *
     * @return string
     */
    public function getTheme(): string;

    /**
     * Validate a value against field rules
     *
     * @param mixed $value Value to validate
     * @return array Validation errors
     */
    public function validateValue($value);

    /**
     * Sanitize a value
     *
     * @param mixed $value Value to sanitize
     * @return mixed Sanitized value
     */
    public function sanitizeValue($value);

    /**
     * Render the field
     *
     * @param mixed $currentValue Current field value
     * @return string Rendered HTML
     */
    public function render($currentValue = '');

    /**
     * Render field with custom name and value (for repeaters)
     *
     * @param string $customName Custom field name
     * @param mixed $customValue Custom field value
     * @return string Rendered HTML
     */
    public function renderWithOverrides(string $customName, $customValue = ''): string;
}
