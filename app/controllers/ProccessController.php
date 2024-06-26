<?php
namespace App\Controllers;

use App\Models\Process;

class ProccessController extends BaseController {
    public function index() {
        $params = $this->getJsonInput();

        $page = isset($params['page']) ? intval($params['page']) : null;
        $perPage = isset($params['perPage']) ? intval($params['perPage']) : $_ENV['RECORDS_PER_PAGE'];

        $process = new Process();
        $data = $process->getAll($page, $perPage);

        return $this->jsonResponse($data);
    }

    public function store() {
        $data = $this->getJsonInput();

        $process = new Process();
        $result = $process.create($data);  // Пример, предполагается, что данные передаются методом POST
        return $this->jsonResponse($result, 201);
    }

    public function destroy() {
        $data = $this->getJsonInput();

        if (isset($data['id'])) {
            $process = new Process();
            $result = $process.destroy($data['id']);
            return $this->jsonResponse($result, 201);
        } else {
            return $this->jsonResponse(['error' => 'Missing ID'], 400);
        }
    }
}
