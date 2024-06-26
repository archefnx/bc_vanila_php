<?php
namespace App\Controllers;

use App\Models\Field;

class FieldController extends BaseController {
    public function index() {
        $params = $this->getJsonInput();

        $page = isset($params['page']) ? intval($params['page']) : null;
        $perPage = isset($params['perPage']) ? intval($params['perPage']) : $_ENV['RECORDS_PER_PAGE'];

        $field = new Field();
        $data = $field->getAll($page, $perPage);

        return $this->jsonResponse($data);
    }

    public function store() {
        $data = $this->getJsonInput();

        $field = new Field();
        $result = $field->create($data);
        return $this->jsonResponse($result, 201);
    }

    public function destroy() {
        $data = $this->getJsonInput();

        if (isset($data['id'])) {
            $field = new Field();
            $result = $field->destroy($data['id']);
            return $this->jsonResponse($result, 201);
        } else {
            return $this->jsonResponse(['error' => 'Missing ID'], 400);
        }
    }
}
