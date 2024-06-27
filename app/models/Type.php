<?php
namespace App\Models;

use App\Core\Database;

class Type {
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
            $sql = "SELECT * FROM types LIMIT ? OFFSET ?";
            return $this->db->query($sql, [$perPage, $offset]) ?: [];
        } else {
            $sql = "SELECT * FROM types";
            return $this->db->query($sql) ?: [];
        }
    }

    public function create($data) {
        $sql = "INSERT INTO types (name, format, description) VALUES (?, ?, ?)";
        return $this->db->insert($sql, [$data['name'], $data['format'], $data['description']]);
    }

    public function destroy($id) {
        $sql = "DELETE FROM types WHERE id = ?";
        return $this->db->query($sql, [$id]);
    }
}
