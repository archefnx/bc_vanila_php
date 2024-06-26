<?php
namespace App\Controllers;

use App\Models\Field;

class FieldController extends BaseController {
    public function index() {
        $input = file_get_contents('php://input');
        $params = json_decode($input, true);

        $page = isset($params['page']) ? intval($params['page']) : null;
        $perPage = isset($params['perPage']) ? intval($params['perPage']) : $_ENV['RECORDS_PER_PAGE'];

        $field = new Field();
        $data = $field->getAll($page, $perPage);

        return $this->jsonResponse($data);
    }

    public function store() {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            $field = new Field();
            $result = $field->create($data);
            return $this->jsonResponse($result, 201);
        } else {
            return $this->jsonResponse(['error' => 'Invalid JSON input'], 400);
        }
    }

    public function destroy() {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        if (json_last_error() === JSON_ERROR_NONE and isset($data['id'])) {
            $field = new Field();
            $result = $field->destroy($data['id']);
            return $this->jsonResponse($result, 201);
        } else {
            return $this->jsonResponse(['error' => 'Invalid JSON input'], 400);
        }
    }
}
