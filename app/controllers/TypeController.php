<?php
namespace App\Controllers;

use App\Models\Type;

class TypeController extends BaseController {
    public function index() {
        $input = file_get_contents('php://input');
        $params = json_decode($input, true);

        $page = isset($params['page']) ? intval($params['page']) : null;
        $perPage = isset($params['perPage']) ? intval($params['perPage']) : $_ENV['RECORDS_PER_PAGE'];

        $type = new Type();
        $data = $type->getAll($page, $perPage);

        return $this->jsonResponse($data);
    }

    public function store() {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            $type = new Type();
            $result = $type->create($data);
            return $this->jsonResponse($result, 201);
        } else {
            return $this->jsonResponse(['error' => 'Invalid JSON input'], 400);
        }
    }

    public function destroy() {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        if (json_last_error() === JSON_ERROR_NONE and isset($data['id'])) {
            $type = new Type();
            $result = $type->destroy($data['id']);
            return $this->jsonResponse($result, 201);
        } else {
            return $this->jsonResponse(['error' => 'Invalid JSON input'], 400);
        }
    }
}