<?php

namespace Giganteck\Opton;

use Giganteck\Opton\Abstracts\FormBuilder;
use Giganteck\Opton\Contracts\BuilderInterface;
use Giganteck\Opton\Sanitizer;
use Giganteck\Opton\Renderer;
use Giganteck\Opton\Utils\Template;

/**
 * Field builder class
 */
class Field extends FormBuilder implements BuilderInterface
{
    private $type;
    private $name;
    private $fieldId;
    private $value;
    private $defaultValue;
    private $label = '';
    private $placeholder = '';
    private $description = '';
    private $required = false;
    private $options = [];
    private $conditions = [];
    private $attributes = [];
    private $validator;
    private $sanitizer;
    private $checked = false;
    private $fullWidth = false;
    private $theme = 'default';

    /**
     * Set the theme for this field
     *
     * @param string $theme Theme name
     * @return BuilderInterface
     */
    public function setTheme(string $theme): BuilderInterface
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

    /**
     * Create a text field
     *
     * @param string $name Field name
     * @return BuilderInterface
     */
    public static function text(string $name): BuilderInterface
    {
        return static::create()->textbox($name);
    }

    /**
     * Create an email field
     *
     * @param string $name Field name
     * @return BuilderInterface
     */
    public static function email(string $name): BuilderInterface
    {
        return static::create()->textbox($name)->attributes(['type' => 'email'])->validate('email');
    }

    /**
     * Create a number field
     *
     * @param string $name Field name
     * @return BuilderInterface
     */
    public static function number(string $name): BuilderInterface
    {
        return static::create()->textbox($name)->attributes(['type' => 'number'])->validate('numeric');
    }

    /**
     * Create a password field
     *
     * @param string $name Field name
     * @return BuilderInterface
     */
    public static function password(string $name): BuilderInterface
    {
        return static::create()->textbox($name)->attributes(['type' => 'password']);
    }

    /**
     * Create a select field
     *
     * @param string $name Field name
     * @return BuilderInterface
     */
    public static function select(string $name): BuilderInterface
    {
        return static::create()->selectField($name);
    }

    /**
     * Create a checkbox field
     *
     * @param string $name Field name
     * @return BuilderInterface
     */
    public static function checkbox(string $name): BuilderInterface
    {
        return static::create()->checkboxField($name);
    }

    /**
     * Create a radio field
     *
     * @param string $name Field name
     * @return BuilderInterface
     */
    public static function radio(string $name): BuilderInterface
    {
        return static::create()->radioField($name);
    }

    /**
     * Create a textarea field
     *
     * @param string $name Field name
     * @return BuilderInterface
     */
    public static function textarea(string $name): BuilderInterface
    {
        return static::create()->textareaField($name);
    }

    /**
     * Create a date field
     *
     * @param string $name Field name
     * @return BuilderInterface
     */
    public static function date(string $name): BuilderInterface
    {
        return static::create()->dateField($name);
    }

    /**
     * Create a color picker field
     *
     * @param string $name Field name
     * @return BuilderInterface
     */
    public static function color(string $name): BuilderInterface
    {
        return static::create()->colorField($name);
    }

    /**
     * Create a file upload field
     *
     * @param string $name Field name
     * @return BuilderInterface
     */
    public static function file(string $name): BuilderInterface
    {
        return static::create()->fileField($name);
    }

    /**
     * Add textbox attributes
     *
     * @param string $name
     * @return self
     */
    private function textbox(string $name): self
    {
        $this->type = 'text';
        $this->name = $name;
        $this->fieldId = $name;
        $this->attributes = array_merge([
            'type' => 'text',
            'class' => 'bg-neutral-secondary-medium! border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3! shadow-xs placeholder:text-body',
            'name' => $name,
            'id' => $name
        ], $this->attributes);

        return $this;
    }

    /**
     * Add attributes for select field
     *
     * @param string $name
     * @return self
     */
    private function selectField(string $name): self
    {
        $this->type = 'select';
        $this->name = $name;
        $this->fieldId = $name;
        $this->attributes = array_merge([
            'name' => $name,
            'id' => $name,
            'class' => 'bg-neutral-secondary-medium! border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3! shadow-xs',
        ], $this->attributes);

        return $this;
    }

    /**
     * Add attributes for checkbox
     *
     * @param string $name
     * @return self
     */
    private function checkboxField(string $name): self
    {
        $this->type = 'checkbox';
        $this->name = $name;
        $this->fieldId = $name;
        $this->value = '1';
        $this->attributes = array_merge([
            'type' => 'checkbox',
            'name' => $name,
            'id' => $name,
            'value' => '1'
        ], $this->attributes);

        return $this;
    }

    /**
     * Add attributes for radio fields
     *
     * @param string $name
     * @return self
     */
    private function radioField(string $name): self
    {
        $this->type = 'radio';
        $this->name = $name;
        $this->fieldId = $name;
        $this->attributes = array_merge([
            'type' => 'radio',
            'name' => $name,
            'id' => $name
        ], $this->attributes);

        return $this;
    }

    /**
     * Add attributes for textarea field
     *
     * @param string $name
     * @return self
     */
    private function textareaField(string $name): self
    {
        $this->type = 'textarea';
        $this->name = $name;
        $this->fieldId = $name;
        $this->attributes = array_merge([
            'name' => $name,
            'id' => $name,
            'rows' => 4,
            'cols' => 50,
            'class' => 'bg-neutral-secondary-medium! border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3! shadow-xs'
        ], $this->attributes);

        return $this;
    }

    /**
     * Add attribtes date field
     *
     * @param string $name
     * @return self
     */
    private function dateField(string $name): self
    {
        $this->type = 'date';
        $this->name = $name;
        $this->fieldId = $name;
        $this->attributes = array_merge([
            'type' => 'date',
            'class' => 'w-full',
            'name' => $name,
            'id' => $name
        ], $this->attributes);

        return $this;
    }

    /**
     * Add attributes for color field
     *
     * @param string $name
     * @return self
     */
    private function colorField(string $name): self
    {
        $this->type = 'color';
        $this->name = $name;
        $this->fieldId = $name;
        $this->attributes = array_merge([
            'type' => 'color',
            'name' => $name,
            'id' => $name
        ], $this->attributes);

        return $this;
    }

    /**
     * Add attributes for file field
     *
     * @param string $name
     * @return self
     */
    private function fileField(string $name): self
    {
        $this->type = 'file';
        $this->name = $name;
        $this->fieldId = $name;
        $this->attributes = array_merge([
            'type' => 'file',
            'class' => 'w-full',
            'name' => $name,
            'id' => $name
        ], $this->attributes);

        return $this;
    }

    /**
     * Set id for input field
     *
     * @param string $id
     * @return BuilderInterface
     */
    public function id(string $id): BuilderInterface
    {
        $this->fieldId = $id;
        $this->attributes['id'] = $id;
        return $this;
    }

    /**
     * Set label for input field
     *
     * @param string $label
     * @return BuilderInterface
     */
    public function label(string $label): BuilderInterface
    {
        $this->label = $label;
        return $this;
    }

    /**
     * Set value for input field
     *
     * @param mixed $value
     * @return BuilderInterface
     */
    public function value($value): BuilderInterface
    {
        $this->value = $value;
        if ($this->type === 'checkbox') {
            $this->attributes['value'] = $value;
        }
        return $this;
    }

    /**
     * Set default value for input field
     *
     * @param mixed $value
     * @return BuilderInterface
     */
    public function default($value): BuilderInterface
    {
        $this->defaultValue = $value;
        return $this;
    }

    /**
     * Set placeholder for input field
     *
     * @param string $placeholder
     * @return BuilderInterface
     */
    public function placeholder(string $placeholder): BuilderInterface
    {
        $this->placeholder = $placeholder;
        $this->attributes['placeholder'] = $placeholder;
        return $this;
    }

    /**
     * Set description for input field
     *
     * @param string $description
     * @return BuilderInterface
     */
    public function description(string $description): BuilderInterface
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Set input field to be required
     *
     * @param bool $required
     * @return BuilderInterface
     */
    public function required(bool $required = true): BuilderInterface
    {
        $this->required = $required;

        if ($required) {
            $this->attributes['required'] = true;
        } else {
            unset($this->attributes['required']);
        }

        return $this;
    }

    /**
     * Set radio and checkbox field checked
     *
     * @param mixed $currentValue
     * @return BuilderInterface
     */
    public function checked($currentValue = true): BuilderInterface
    {
        $this->checked = ($currentValue == $this->value) || ($currentValue === true);

        if ($this->checked) {
            $this->attributes['checked'] = 'checked';
        }

        return $this;
    }

    /**
     * Set custom attributes for input fields
     *
     * @param array $attributes
     * @return BuilderInterface
     */
    public function attributes(array $attributes): BuilderInterface
    {
        $this->attributes = array_merge($this->attributes, $attributes);
        return $this;
    }

    /**
     * Set minimum number value for number field
     *
     * @param float $min
     * @return BuilderInterface
     */
    public function min(float $min): BuilderInterface
    {
        $this->attributes['min'] = $min;
        return $this;
    }

    /**
     * Set maximum number value for number field
     *
     * @param float $max
     * @return BuilderInterface
     */
    public function max(float $max): BuilderInterface
    {
        $this->attributes['max'] = $max;
        return $this;
    }

    /**
     * Options for input field
     *
     * @param array $options
     * @return BuilderInterface
     */
    public function options(array $options): BuilderInterface
    {
        $this->options = $options;
        return $this;
    }

    /**
     * Validate input field's value
     *
     * @param string|array $rules
     * @return BuilderInterface
     */
    public function validate($rules): BuilderInterface
    {
        $this->validator = new Validator($rules);
        return $this;
    }

    /**
     * Sanitize input field's value
     *
     * @param string|callable $sanitizer
     * @return BuilderInterface
     */
    public function sanitize($sanitizer): BuilderInterface
    {
        $this->sanitizer = $sanitizer;
        return $this;
    }

    /**
     * Show an input field based on the other fields' value
     *
     * @param string $fieldId
     * @param mixed $value
     * @return BuilderInterface
     */
    public function showWhen(string $fieldId, $value): BuilderInterface
    {
        $this->conditions[] = [
            'type' => 'show',
            'operator' => '=',
            'field' => $fieldId,
            'value' => $value
        ];
        return $this;
    }

    /**
     * Hide an input field based on the other fields' value
     *
     * @param string $fieldId
     * @param mixed $value
     * @return BuilderInterface
     */
    public function hideWhen(string $fieldId, $value): BuilderInterface
    {
        $this->conditions[] = [
            'type' => 'hide',
            'operator' => '=',
            'field' => $fieldId,
            'value' => $value
        ];
        return $this;
    }

    /**
     * Make field span full width in grid
     *
     * @return BuilderInterface
     */
    public function fullCol(): BuilderInterface
    {
        $this->fullWidth = true;
        return $this;
    }

    /**
     * Check if field should span full width
     */
    public function isFullWidth()
    {
        return $this->fullWidth;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getConditions()
    {
        return $this->conditions;
    }

    public function validateValue($value)
    {
        if (!$this->validator) {
            return [];
        }

        return $this->validator->validate($value, $this->label ?: $this->name);
    }

    /**
     * Sanitize field's value
     *
     * @param mixed $value
     * @return mixed
     */
    public function sanitizeValue($value)
    {
        if (! $this->sanitizer) {
            $sanitizer = Sanitizer::getSanitizer('text');
            return $sanitizer->sanitize($value);
        }

        if (is_string($this->sanitizer)) {
            $sanitizer = Sanitizer::getSanitizer($this->sanitizer);
            return $sanitizer->sanitize($value);
        } elseif (is_callable($this->sanitizer)) {
            return call_user_func($this->sanitizer, $value);
        }

        // Fallback to text sanitizer
        $sanitizer = Sanitizer::getSanitizer('text');
        return $sanitizer->sanitize($value);
    }

    /**
     * Add rendering conditional attributes for input field
     *
     * @return string
     */
    private function renderConditionalAttributes()
    {
        if (empty($this->conditions)) {
            return '';
        }

        return ' data-conditions="' . esc_attr(json_encode($this->conditions)) . '"';
    }

    /**
     * Render input fields
     *
     * @param mixed $currentValue
     * @return string
     */
    public function render($currentValue = '')
    {
        $conditionalAttrs = $this->renderConditionalAttributes();
        $currentValue = $currentValue ?: ($this->value ?? $this->defaultValue ?? '');

        if ($this->type !== 'checkbox' && $this->type !== 'radio') {
            $this->attributes['value'] = $currentValue;
        }

        $wrapperClass = 'opton-field' . (!empty($this->conditions) ? ' conditional-field' : '');

        // Render label
        $label_html = Template::get_view('fields/label', [
            'field_id' => $this->fieldId,
            'label' => $this->label,
            'required' => $this->required
        ], $this->theme);

        // Render input based on type
        $input_html = $this->renderInput($currentValue);

        // Render complete field wrapper
        return Template::get_view('fields/wrapper', [
            'wrapper_class' => $wrapperClass,
            'conditional_attrs' => $conditionalAttrs,
            'type'  => $this->getType(),
            'label_html' => $label_html,
            'input_html' => $input_html,
            'description' => $this->description
        ], $this->theme);
    }

    /**
     * Render field with custom name and value (for repeaters)
     * This bypasses cloning issues by directly rendering with overrides
     *
     * @param string $customName Custom field name
     * @param mixed $customValue Custom field value
     * @return string Rendered HTML
     */
    public function renderWithOverrides(string $customName, $customValue = ''): string
    {
        // Save original values
        $originalName = $this->attributes['name'] ?? '';
        $originalValue = $this->attributes['value'] ?? '';

        // Temporarily override for rendering
        $this->attributes['name'] = $customName;

        if ($this->type !== 'checkbox' && $this->type !== 'radio') {
            $this->attributes['value'] = $customValue;
        }

        $conditionalAttrs = $this->renderConditionalAttributes();
        $wrapperClass = 'opton-field' . (!empty($this->conditions) ? ' conditional-field' : '');

        // Render label (use original field ID for label)
        $label_html = Template::get_view('fields/label', [
            'field_id' => $this->fieldId,
            'label' => $this->label,
            'required' => $this->required
        ], $this->theme);

        // Render input with custom value
        $input_html = $this->renderInput($customValue);

        // Restore original values
        $this->attributes['name'] = $originalName;
        if ($originalValue !== '') {
            $this->attributes['value'] = $originalValue;
        } else {
            unset($this->attributes['value']);
        }

        // Render complete field wrapper
        return Template::get_view('fields/wrapper', [
            'wrapper_class' => $wrapperClass,
            'conditional_attrs' => $conditionalAttrs,
            'type'  => $this->getType(),
            'label_html' => $label_html,
            'input_html' => $input_html,
            'description' => $this->description
        ], $this->theme);
    }

    /**
     * Render input field
     *
     * @param mixed $currentValue
     * @return string
     */
    private function renderInput($currentValue)
    {
        $renderer = Renderer::getRenderer($this->type);

        return $renderer->render(
            $currentValue,
            $this->attributes,
            $this->options,
            $this->fieldId
        );
    }
}
