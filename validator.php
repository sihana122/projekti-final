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
<?php

class Slider
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getActive(): array
    {
        return $this->db->query("
            SELECT s.*, u.full_name as created_by_name 
            FROM slider_items s 
            LEFT JOIN users u ON s.created_by = u.id 
            WHERE s.active = 1 ORDER BY s.sort_order ASC
        ")->fetchAll();
    }

    public function getAll(): array
    {
        return $this->db->query("
            SELECT s.*, 
                uc.full_name as created_by_name, 
                uu.full_name as updated_by_name 
            FROM slider_items s 
            LEFT JOIN users uc ON s.created_by = uc.id 
            LEFT JOIN users uu ON s.updated_by = uu.id 
            ORDER BY s.sort_order ASC
        ")->fetchAll();
    }

    public function create(array $data, ?int $userId = null): int
    {
        $stmt = $this->db->prepare("INSERT INTO slider_items (title, description, image_path, link, sort_order, created_by) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['title'],
            $data['description'] ?? '',
            $data['image_path'] ?? '',
            $data['link'] ?? '',
            $data['sort_order'] ?? 0,
            $userId
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data, ?int $userId = null): bool
    {
        $stmt = $this->db->prepare("
            UPDATE slider_items SET title=?, description=?, image_path=?, link=?, sort_order=?, updated_by=? WHERE id=?
        ");
        return $stmt->execute([
            $data['title'],
            $data['description'] ?? '',
            $data['image_path'] ?? '',
            $data['link'] ?? '',
            $data['sort_order'] ?? 0,
            $userId,
            $id
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM slider_items WHERE id = ?");
        return $stmt->execute([$id]);
    }
}