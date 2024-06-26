<?php

namespace App\Controllers;

use App\Core\Database;
use App\Models\Field;
use App\Models\Type;


class ProccessManageController extends BaseController
{
    public function addFields()
    {
        $input = file_get_contents('php://input');
        $params = json_decode($input, true);

        // Проверка на наличие необходимых параметров
        if (!isset($params['process_name']) || !isset($params['fields'])) {
            return $this->jsonResponse(['error' => 'Invalid input'], 400);
        }

        $processName = $params['process_name'];
        $fields = $params['fields'];
        $errors = []; // массив для хранения информации об ошибках

        // Подключение к базе данных
        $db = new Database();

        // Проверка существования процесса
        $process = $db->query("SELECT * FROM processes WHERE name = ?", [$processName]);

        if (empty($process)) {
            return $this->jsonResponse(['error' => 'Process not found'], 404);
        }

        $processId = $process[0]['id']; // Извлекаем ID процесса из результата

        $allowedTypes = ['text', 'number', 'date']; // Допустимые типы
        foreach ($fields as $field) {
            if (!in_array($field['type'], $allowedTypes)) {
                $errors[] = "Field type '{$field['type']}' is not allowed"; // добавление ошибки в массив
                continue; // пропуск текущей итерации
            }

            // Найти или создать тип
            $type = $db->query("SELECT * FROM types WHERE name = ? AND format = ?", [$field['type'], $field['format']]);

            if (empty($type)) {
                $typeId = $db->insert("INSERT INTO types (name, format, description) VALUES (?, ?, ?)", [$field['type'], $field['format'] ?? '', 'Automatically created type']);
            } else {
                $typeId = $type[0]['id'];
            }

            // Поиск существующего поля
            $existingField = $db->query("SELECT * FROM fields WHERE process_id = ? AND name = ?", [$processId, $field['name']]);

            if (!empty($existingField)) {
                // Обновление существующего поля
                $db->query("UPDATE fields SET value = ?, description = ? WHERE id = ?", [$field['value'], $field['description'] ?? $existingField[0]['description'], $existingField[0]['id']]);
            } else {
                // Создание нового поля
                $db->insert("INSERT INTO fields (process_id, type_id, name, value, description) VALUES (?, ?, ?, ?, ?)", [$processId, $typeId, $field['name'], $field['value'], $field['description'] ?? '']);
            }
        }

        if (!empty($errors)) {
            return $this->jsonResponse(['errors' => $errors], 422);
        }

        return $this->jsonResponse(['message' => 'Fields processed successfully'], 201);
    }

    public function getFields()
    {
        $input = file_get_contents('php://input');
        $params = json_decode($input, true);

        if (!isset($params['process_name'])) {
            return $this->jsonResponse(['error' => 'Invalid input'], 400);
        }

        $processName = $params['process_name'];

        // Подключение к базе данных
        $db = new Database();

        // Проверка существования процесса
        $process = $db->query("SELECT * FROM processes WHERE name = ?", [$processName]);

        if (empty($process)) {
            return $this->jsonResponse(['error' => 'Process not found', 'process_name' => $processName], 404);
        }

        $processId = $process[0]['id'];

        // Получение количества элементов на страницу из запроса или использование значения по умолчанию
        $pageSize = isset($params['page_size']) ? $params['page_size'] : $_ENV['RECORDS_PER_PAGE'];

        // Базовый запрос для получения полей
        $sql = "SELECT f.*, t.name as type_name, t.format as type_format FROM fields f JOIN types t ON f.type_id = t.id WHERE f.process_id = ?";
        $queryParams = [$processId];

        // Добавление фильтров
        if (isset($params['field_name'])) {
            $sql .= " AND f.name = ?";
            $queryParams[] = $params['field_name'];
        }

        if (isset($params['field_type'])) {
            $sql .= " AND t.name = ?";
            $queryParams[] = $params['field_type'];
        }

        // Получение полей с учетом пагинации
        $offset = $params['page'];
        $sql .= " LIMIT ? OFFSET ?";
        $queryParams[] = $pageSize;
        $queryParams[] = $offset;

        $fields = $db->query($sql, $queryParams);

        // Преобразование полей в нужный формат
        $formattedFields = array_map(function ($field) {
            switch ($field['type_name']) {
                case 'number':
                    $format = $field['type_format'] ?: '%.2f'; // значение по умолчанию
                    $formattedValue = sprintf($format, $field['value']);
                    break;
                case 'date':
                    $format = $field['type_format'] ?: 'Y-m-d'; // значение по умолчанию
                    $formattedValue = (new \DateTime($field['value']))->format($format);
                    break;
                case 'text':
                default:
                    $formattedValue = $field['value'];
                    break;
            }

            return [
                'name' => $field['name'],
                'value' => $formattedValue
            ];
        }, $fields);

        // Возвращение результата
        return $this->jsonResponse([
            'data' => $formattedFields,
            'pagination' => [
                'current_page' => 1, // статическое значение, так как постраничная навигация не реализована
                'last_page' => 1, // статическое значение
                'per_page' => $pageSize,
                'total' => count($fields),
                'next_page_url' => null,
                'prev_page_url' => null,
            ]
        ]);
    }
}