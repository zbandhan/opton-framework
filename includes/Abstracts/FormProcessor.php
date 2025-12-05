<?php

namespace Giganteck\Opton\Abstracts;

use Giganteck\Opton\Form;
use Giganteck\Opton\Section;

/**
 * Abstract FormProcessor class for handling form data processing
 * Extracts common logic from Metabox and Settings classes
 */
abstract class FormProcessor
{
    /**
     * Form instance
     *
     * @var Form
     */
    protected $form;

    /**
     * Get the theme for this form
     * Override this method to use a different theme
     *
     * @return string Theme name (default, modern, elegant, etc.)
     */
    abstract protected function theme(): string;

    /**
     * Define form structure
     * This method should be implemented to build the form
     *
     * @param Form $form Form instance to build
     * @return void
     */
    abstract protected function form(Form $form): void;

    /**
     * Initialize and build the form
     * Creates a new Form instance, sets the theme, and builds the form structure
     *
     * @return Form The initialized form instance
     */
    protected function initializeForm(): Form
    {
        $form = new Form();
        $form->setTheme($this->theme());
        $this->form($form);

        return $form;
    }

    /**
     * Process form data through validation and sanitization
     *
     * @param array $sections Array of Section objects
     * @param array $inputData Raw input data from form submission
     * @return array Processed results ['sanitized' => [], 'errors' => []]
     */
    protected function processFormData(array $sections, array $inputData): array
    {
        $sanitized = [];
        $errors = [];

        foreach ($sections as $section) {
            if ($section->isRepeaterSection()) {
                $result = $this->processRepeaterSection($section, $inputData);
                $sanitized = array_merge($sanitized, $result['sanitized']);
                $errors = array_merge($errors, $result['errors']);
            } else {
                $result = $this->processNormalSection($section, $inputData);
                $sanitized = array_merge($sanitized, $result['sanitized']);
                $errors = array_merge($errors, $result['errors']);
            }
        }

        return [
            'sanitized' => $sanitized,
            'errors' => $errors
        ];
    }

    /**
     * Process repeater section fields
     *
     * @param Section $section The repeater section
     * @param array $inputData Raw input data
     * @return array ['sanitized' => [], 'errors' => []]
     */
    private function processRepeaterSection(Section $section, array $inputData): array
    {
        $sanitized = [];
        $errors = [];
        $repeaterFields = $section->getFields();

        foreach ($repeaterFields as $field) {
            $fieldName = $field->getName();

            if (isset($inputData[$fieldName]) && is_array($inputData[$fieldName])) {
                $sanitizedArray = [];

                foreach ($inputData[$fieldName] as $index => $value) {
                    $validationErrors = $field->validateValue($value);
                    if (!empty($validationErrors)) {
                        $errors[$fieldName . '[' . $index . ']'] = $validationErrors;
                        continue;
                    }

                    $sanitizedArray[] = $field->sanitizeValue($value);
                }

                $sanitized[$fieldName] = $sanitizedArray;
            } else {
                $sanitized[$fieldName] = [];
            }
        }

        return [
            'sanitized' => $sanitized,
            'errors' => $errors
        ];
    }

    /**
     * Process normal section fields
     *
     * @param Section $section The normal section
     * @param array $inputData Raw input data
     * @return array ['sanitized' => [], 'errors' => []]
     */
    private function processNormalSection(Section $section, array $inputData): array
    {
        $sanitized = [];
        $errors = [];

        foreach ($section->getFields() as $field) {
            $fieldName = $field->getName();

            // Check if field data exists in input
            if (!isset($inputData[$fieldName])) {
                if ($field->getType() === 'checkbox') {
                    $sanitized[$fieldName] = '';
                }

                continue;
            }

            $rawValue = $inputData[$fieldName];

            // Validate field value
            $validationErrors = $field->validateValue($rawValue);
            if (!empty($validationErrors)) {
                $errors[$fieldName] = $validationErrors;
                continue;
            }

            $sanitized[$fieldName] = $field->sanitizeValue($rawValue);
        }

        return [
            'sanitized' => $sanitized,
            'errors' => $errors
        ];
    }

    /**
     * Save processed data to storage
     * Must be implemented by child classes (Metabox uses post_meta, Settings uses options)
     *
     * @param mixed $identifier Post ID for metabox, option name for settings
     * @param array $sanitizedData The sanitized data to save
     * @return void
     */
    abstract protected function saveData($identifier, array $sanitizedData): void;

    /**
     * Store validation errors
     * Must be implemented by child classes (different transient keys)
     *
     * @param mixed $identifier Post ID for metabox, user ID for settings
     * @param array $errors Validation errors
     * @return void
     */
    abstract protected function storeErrors($identifier, array $errors): void;
}
