<?php
namespace App\Models;

use App\Core\Database;

//require '../app/core/Database.php';

class Process {
    public function getAll($page = null, $perPage) {
        $perPage = isset($params['perPage']) ? $perPage : $_ENV['RECORDS_PER_PAGE'];
        $db = new Database();
        if ($page !== null) {
            $offset = ($page - 1) * $perPage;
            $sql = "SELECT * FROM processes LIMIT ? OFFSET ?";
            return $db->query($sql, [$perPage, $offset]);
        } else {
            $sql = "SELECT * FROM processes";
            return $db->query($sql);
        }
    }

    public function create($data) {
        $db = new Database();
        $sql = "INSERT INTO processes (name, description) VALUES (?, ?)";
        return $db->insert($sql, [$data['name'], $data['description']]);
    }

    public function destroy($id) {
        $db = new Database();
        $sql = "DELETE FROM processes WHERE id = ?";
        return $db->query($sql, [$id]);
    }
}
