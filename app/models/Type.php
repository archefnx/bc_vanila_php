<?php
namespace App\Models;

use App\Core\Database;

//require '../app/core/Database.php';

class Type {
    public function index($page = null, $perPage) {
        $perPage = isset($params['perPage']) ? $perPage : $_ENV['RECORDS_PER_PAGE'];
        $db = new Database();
        if ($page !== null) {
            $offset = ($page - 1) * $perPage;
            $sql = "SELECT * FROM types LIMIT ? OFFSET ?";
            return $db->query($sql, [$perPage, $offset]);
        } else {
            $sql = "SELECT * FROM types";
            return $db->query($sql);
        }
    }

    public function create($data) {
        $db = new Database();
        $sql = "INSERT INTO types (name, format, description) VALUES (?, ?, ?)";
        return $db->insert($sql, [$data['name'], $data['format'],$data['description'], ]);
    }

    public function destroy($id) {
        $db = new Database();
        $sql = "DELETE FROM types WHERE id = ?";
        return $db->query($sql, [$id]);
    }
}
