<?php
namespace App\Models;

use App\Core\Database;

class Field {
    protected $db;

    public function __construct($db = null) {
        $this->db = $db ?: new Database();
    }

    public function setDatabase($db) {
        $this->db = $db;
    }

    public function getAll($page = null, $perPage = null) {
        $perPage = $perPage ?? $_ENV['RECORDS_PER_PAGE'];
        if ($page !== null) {
            $offset = ($page - 1) * $perPage;
            $sql = "SELECT * FROM fields LIMIT ? OFFSET ?";
            return $this->db->query($sql, [$perPage, $offset]) ?: [];
        } else {
            $sql = "SELECT * FROM fields";
            return $this->db->query($sql) ?: [];
        }
    }

    public function create($data) {
        $sql = "INSERT INTO fields (process_id, type_id, name, value, description) VALUES (?, ?, ?, ?, ?)";
        return $this->db->insert($sql, [$data['process_id'], $data['type_id'], $data['name'], $data['value'], $data['description']]);
    }

    public function destroy($id) {
        $sql = "DELETE FROM fields WHERE id = ?";
        return $this->db->query($sql, [$id]);
    }
}
