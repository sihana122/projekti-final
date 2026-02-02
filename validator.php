<?php

class Validator
{
    private array $errors = [];

    public function validate(array $rules, array $data): bool
    {
        $this->errors = [];
        
        foreach ($rules as $field => $ruleString) {
            $ruleList = explode('|', $ruleString);
            $value = $data[$field] ?? '';
            
            foreach ($ruleList as $rule) {
                $param = null;
                if (strpos($rule, ':') !== false) {
                    [$rule, $param] = explode(':', $rule, 2);
                }
                
                if (!$this->applyRule($rule, $field, $value, $param, $data)) {
                    break;
                }
            }
        }
        
        return empty($this->errors);
    }

    private function applyRule(string $rule, string $field, $value, $param, array $data): bool
    {
        switch ($rule) {
            case 'required':
                if (empty(trim((string)$value))) {
                    $this->errors[$field] = "Fusha $field është e detyrueshme.";
                    return false;
                }
                break;
            case 'email':
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->errors[$field] = "Email jo valid.";
                    return false;
                }
                break;
            case 'min':
                if (strlen($value) < (int)$param) {
                    $this->errors[$field] = "Fusha $field duhet të ketë minimum $param karaktere.";
                    return false;
                }
                break;
            case 'max':
                if (strlen($value) > (int)$param) {
                    $this->errors[$field] = "Fusha $field nuk duhet të kalojë $param karaktere.";
                    return false;
                }
                break;
            case 'confirmed':
                $confirmField = $field . '_confirmation';
                if (($data[$confirmField] ?? '') !== $value) {
                    $this->errors[$field] = "Fjalëkalimet nuk përputhen.";
                    return false;
                }
                break;
        }
        return true;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getFirstError(): ?string
    {
        return !empty($this->errors) ? reset($this->errors) : null;
    }
}
