<?php
namespace App\Models;

use App\Core\Database;

//require '../app/core/Database.php';

class Field {
    public function index($page = null, $perPage) {
        $perPage = isset($params['perPage']) ? $perPage : $_ENV['RECORDS_PER_PAGE'];
        $db = new Database();
        if ($page !== null) {
            $offset = ($page - 1) * $perPage;
            $sql = "SELECT * FROM fields LIMIT ? OFFSET ?";
            return $db->query($sql, [$perPage, $offset]);
        } else {
            $sql = "SELECT * FROM fields";
            return $db->query($sql);
        }
    }

    public function create($data) {
        $db = new Database();
        $sql = "INSERT INTO fields (process_id, type_id, name, value, description) VALUES (?, ?, ?, ?, ?)";
        return $db->insert($sql, [$data['process_id'],$data['type_id'],$data['name'], $data['value'],$data['description'], ]);
    }

    public function destroy($id) {
        $db = new Database();
        $sql = "DELETE FROM fields WHERE id = ?";
        return $db->query($sql, [$id]);
    }
}
