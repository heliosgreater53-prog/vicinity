<?php

declare(strict_types=1);

namespace Core;

/**
 * Validator – simple and extensible input validation engine.
 *
 * Usage:
 *   $errors = Validator::make($data, [
 *       'email'    => 'required|email|unique:users,email',
 *       'password' => 'required|min:8|confirmed',
 *   ]);
 *
 *   if (!empty($errors)) {
 *       // handle errors
 *   }
 */
class Validator
{
    /** @var array<string, mixed> */
    protected array $data = [];

    /** @var array<string, string|array> */
    protected array $rules = [];

    /** @var array<string, string[]> */
    protected array $errors = [];

    public function __construct(array $data, array $rules)
    {
        $this->data  = $data;
        $this->rules = $rules;
        $this->validate();
    }

    /**
     * Statically validate data and return error map.
     *
     * @param array<string, mixed> $data
     * @param array<string, string|array> $rules
     * @return array<string, string[]> field -> list of error messages
     */
    public static function make(array $data, array $rules): array
    {
        $validator = new self($data, $rules);
        return $validator->errors();
    }

    public function fails(): bool
    {
        return !empty($this->errors);
    }

    public function passes(): bool
    {
        return empty($this->errors);
    }

    /**
     * @return array<string, string[]>
     */
    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * Get first error message for a given field or null.
     */
    public function first(string $field): ?string
    {
        return $this->errors[$field][0] ?? null;
    }

    protected function validate(): void
    {
        foreach ($this->rules as $field => $rules) {
            $ruleList = is_string($rules) ? explode('|', $rules) : $rules;
            $value    = $this->data[$field] ?? null;

            foreach ($ruleList as $rule) {
                $rule = trim($rule);
                if ($rule === '') {
                    continue;
                }

                $param = null;
                if (str_contains($rule, ':')) {
                    [$ruleName, $param] = explode(':', $rule, 2);
                } else {
                    $ruleName = $rule;
                }

                $this->applyRule($field, $value, $ruleName, $param);
            }
        }
    }

    protected function applyRule(string $field, mixed $value, string $rule, ?string $param): void
    {
        $humanField = ucfirst(str_replace('_', ' ', $field));

        switch ($rule) {
            case 'required':
                if ($value === null || $value === '' || (is_array($value) && empty($value))) {
                    $this->addError($field, "The {$humanField} field is required.");
                }
                break;

            case 'email':
                if ($value !== null && $value !== '' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($field, "The {$humanField} must be a valid email address.");
                }
                break;

            case 'min':
                $min = (int) $param;
                if ($value !== null && $value !== '') {
                    if (is_numeric($value)) {
                        if ($value < $min) {
                            $this->addError($field, "The {$humanField} must be at least {$min}.");
                        }
                    } elseif (mb_strlen((string) $value) < $min) {
                        $this->addError($field, "The {$humanField} must be at least {$min} characters.");
                    }
                }
                break;

            case 'max':
                $max = (int) $param;
                if ($value !== null && $value !== '') {
                    if (is_numeric($value)) {
                        if ($value > $max) {
                            $this->addError($field, "The {$humanField} may not be greater than {$max}.");
                        }
                    } elseif (mb_strlen((string) $value) > $max) {
                        $this->addError($field, "The {$humanField} may not exceed {$max} characters.");
                    }
                }
                break;

            case 'numeric':
                if ($value !== null && $value !== '' && !is_numeric($value)) {
                    $this->addError($field, "The {$humanField} must be a number.");
                }
                break;

            case 'confirmed':
                $confirmationField = $field . '_confirmation';
                $confirmationValue = $this->data[$confirmationField] ?? null;
                if ($value !== $confirmationValue) {
                    $this->addError($field, "The {$humanField} confirmation does not match.");
                }
                break;

            case 'in':
                $allowed = explode(',', (string) $param);
                if ($value !== null && $value !== '' && !in_array((string) $value, $allowed, true)) {
                    $this->addError($field, "The selected {$humanField} is invalid.");
                }
                break;

            case 'unique':
                if ($value !== null && $value !== '' && $param !== null) {
                    [$table, $column] = explode(',', $param);
                    $exists = Database::getInstance()
                        ->table($table)
                        ->where($column, $value)
                        ->exists();

                    if ($exists) {
                        $this->addError($field, "The {$humanField} has already been taken.");
                    }
                }
                break;

            case 'url':
                if ($value !== null && $value !== '' && !filter_var($value, FILTER_VALIDATE_URL)) {
                    $this->addError($field, "The {$humanField} must be a valid URL.");
                }
                break;
        }
    }

    protected function addError(string $field, string $message): void
    {
        $this->errors[$field][] = $message;
    }
}
