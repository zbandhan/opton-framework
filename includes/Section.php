<?php

namespace Giganteck\Opton;

use Giganteck\Opton\Utils\Template;

/**
 * Section class for grouping fields
 */
class Section
{
    private $sectionTitle = '';
    private $gridColumns = 1;
    private $fields = [];
    private $repeaterFields = [];
    private $isRepeater = false;
    private $theme = 'default';

    /**
     * Set the theme for this section
     *
     * @param string $theme Theme name
     * @return self
     */
    public function setTheme(string $theme): self
    {
        $this->theme = $theme;
        return $this;
    }

    /**
     * Get the current theme
     *
     * @return string
     */
    public function getTheme(): string
    {
        return $this->theme;
    }

    public function title(string $title)
    {
        $this->sectionTitle = $title;
        return $this;
    }

    public function grid(int $columns)
    {
        $this->gridColumns = $columns;
        return $this;
    }

    public function fields(Field ...$fields)
    {
        foreach ($fields as $field) {
            $field->setTheme($this->theme);
        }

        $this->fields = array_merge($this->fields, $fields);
        $this->isRepeater = false;

        return $this;
    }

    public function repeater(Field ...$fields)
    {
        foreach ($fields as $field) {
            $field->setTheme($this->theme);
        }

        $this->repeaterFields = $fields;
        $this->isRepeater = true;

        return $this;
    }

    public function getFields()
    {
        if ($this->isRepeater) {
            return $this->repeaterFields;
        }

        return $this->fields;
    }

    public function isRepeaterSection()
    {
        return $this->isRepeater;
    }

    public function render($postId = null, $options = [], $optionName = null)
    {
        // Get contents cached
        $content = '';

        if ($this->isRepeater) {
            $content = $this->renderRepeater($postId, $options, $optionName);
        } else {
            $fields_parts = [];
            foreach ($this->fields as $field) {
                $currentValue = '';
                if ($postId) {
                    $currentValue = get_post_meta($postId, $field->getName(), true);
                } elseif (!empty($options)) {
                    $currentValue = isset($options[$field->getName()]) ? $options[$field->getName()] : '';
                }

                $fields_parts[] = $this->renderField($field, $currentValue, $optionName);
            }

            $content = Template::get_view('section/fields-grid', [
                'grid_columns' => $this->gridColumns,
                'content' => implode('', $fields_parts)
            ], $this->theme);
        }

        return Template::get_view('section/section-wrapper', [
            'title' => $this->sectionTitle,
            'content' => $content
        ], $this->theme);
    }

    /**
     * Render a single field with proper configuration
     *
     * @param Field $field The field to render
     * @param mixed $currentValue The current value
     * @param string|null $optionName Option name for settings pages
     * @return string Rendered field HTML
     */
    private function renderField(Field $field, $currentValue, ?string $optionName = null): string
    {
        // Determine the field name to use
        $fieldName = $field->getName();
        if ($optionName) {
            $fieldName = "{$optionName}[{$fieldName}]";
        }

        // Render with custom name and value (no clone needed)
        $fieldHtml = $field->renderWithOverrides($fieldName, $currentValue);

        // Add wrapper div with grid-column span if full width
        if ($field->isFullWidth()) {
            return '<div style="grid-column: 1 / -1;">' . $fieldHtml . '</div>';
        }

        return $fieldHtml;
    }

    /**
     * Render repeater fields
     *
     * @param int $postId
     * @param array $options
     * @param mixed $optionName
     * @return string
     */
    private function renderRepeater($postId = null, $options = [], $optionName = null)
    {
        // Generate unique ID for this repeater
        $repeaterId = 'opton_repeater_' . uniqid();
        $repeaterData = [];

        if (!empty($this->repeaterFields)) {
            $firstFieldName = $this->repeaterFields[0]->getName();
            $allMetaData = [];

            if ($postId) {
                $allPostMeta = get_post_meta($postId);
                $savedData = isset($allPostMeta[$firstFieldName][0]) ? $allPostMeta[$firstFieldName][0] : null;

                if (is_string($savedData) && $this->isSerialized($savedData)) {
                    $savedData = maybe_unserialize($savedData);
                }
            } elseif (!empty($options)) {
                $savedData = isset($options[$firstFieldName]) ? $options[$firstFieldName] : null;
            } else {
                $savedData = null;
            }

            if (is_array($savedData)) {
                $repeaterCount = count($savedData);

                // Pre-fetch all field data for repeater
                if ($postId) {
                    foreach ($this->repeaterFields as $field) {
                        $fieldName = $field->getName();

                        // Get the meta value and unserialize if needed
                        if (isset($allPostMeta[$fieldName][0])) {
                            $fieldData = $allPostMeta[$fieldName][0];

                            if (is_string($fieldData) && $this->isSerialized($fieldData)) {
                                $fieldData = maybe_unserialize($fieldData);
                            }

                            $allMetaData[$fieldName] = $fieldData;
                        } else {
                            $allMetaData[$fieldName] = [];
                        }
                    }
                }

                // Build repeater rows
                for ($i = 0; $i < $repeaterCount; $i++) {
                    $row = [];
                    foreach ($this->repeaterFields as $field) {
                        $fieldName = $field->getName();

                        if ($postId) {
                            // Use pre-fetched data instead of querying database
                            $fieldData = isset($allMetaData[$fieldName]) ? $allMetaData[$fieldName] : [];
                        } else {
                            $fieldData = isset($options[$fieldName]) ? $options[$fieldName] : [];
                        }

                        // Ensure we have an array and the index exists
                        if (is_array($fieldData) && isset($fieldData[$i])) {
                            $row[$fieldName] = $fieldData[$i];
                        } else {
                            $row[$fieldName] = '';
                        }
                    }

                    $repeaterData[] = $row;
                }
            }
        }

        // If no data, create one empty row
        if (empty($repeaterData)) {
            $repeaterData[] = [];
        }

        // Render existing rows
        $rows_parts = [];
        foreach ($repeaterData as $index => $rowData) {
            $rows_parts[] = $this->renderRepeaterRow($index, $rowData, $optionName);
        }

        $rows_html = implode('', $rows_parts);
        $template_html = $this->renderRepeaterRow('{{INDEX}}', [], $optionName);

        return Template::get_view('section/repeater-wrapper', [
            'repeater_id' => $repeaterId,
            'rows_html' => $rows_html,
            'template_html' => $template_html
        ], $this->theme);
    }

    /**
     * Render Repeater row
     *
     * @param int $index
     * @param array $rowData
     * @param mixed $optionName
     * @return string
     */
    private function renderRepeaterRow($index, $rowData = [], $optionName = null)
    {
        // Add section wrapper
        $fields_parts = [];
        foreach ($this->repeaterFields as $field) {
            $fieldName = $field->getName();

            // For settings pages, wrap in option name array
            if ($optionName) {
                $indexedName = "{$optionName}[{$fieldName}][{$index}]";
            } else {
                $indexedName = "{$fieldName}[{$index}]";
            }

            $currentValue = isset($rowData[$fieldName]) ? $rowData[$fieldName] : '';
            $fieldHtml = $field->renderWithOverrides($indexedName, $currentValue);

            // Add full-width wrapper if needed
            if ($field->isFullWidth()) {
                $fields_parts[] = '<div style="grid-column: 1 / -1;">' . $fieldHtml . '</div>';
            } else {
                $fields_parts[] = $fieldHtml;
            }
        }

        return Template::get_view('section/repeater-row', [
            'index' => $index,
            'grid_columns' => $this->gridColumns,
            'fields_html' => implode('', $fields_parts)
        ], $this->theme);
    }

    /**
     * Check if data is serialized (helper function)
     *
     * @param string $data Data to check
     * @return bool
     */
    private function isSerialized($data)
    {
        if (!is_string($data)) {
            return false;
        }

        $data = trim($data);

        if ('N;' === $data) {
            return true;
        }

        if (strlen($data) < 4 || ':' !== $data[1]) {
            return false;
        }

        $lastComma = substr($data, -1);

        if (';' !== $lastComma && '}' !== $lastComma) {
            return false;
        }

        return true;
    }

}
