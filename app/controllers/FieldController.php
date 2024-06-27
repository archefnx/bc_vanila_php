<?php
namespace App\Controllers;

use App\Models\Field;

class FieldController extends BaseController {
    protected $field;

    public function __construct(Field $field = null) {
        $this->field = $field ?: new Field();
    }

    public function setFieldModel($fieldModel) {
        $this->field = $fieldModel;
    }

    public function index() {
        $params = $this->getJsonInput();
        $page = isset($params['page']) ? intval($params['page']) : null;
        $perPage = isset($params['perPage']) ? intval($params['perPage']) : $_ENV['RECORDS_PER_PAGE'];
        $data = $this->field->getAll($page, $perPage);
        return $this->jsonResponse($data);
    }

    public function store() {
        $data = $this->getJsonInput();
        $result = $this->field->create($data);
        return $this->jsonResponse($result, 201);
    }

    public function destroy() {
        $data = $this->getJsonInput();
        if (isset($data['id'])) {
            $result = $this->field->destroy($data['id']);
            return $this->jsonResponse($result, 201);
        } else {
            return $this->jsonResponse(['error' => 'Missing ID'], 400);
        }
    }
}
