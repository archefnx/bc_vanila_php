<?php
use PHPUnit\Framework\TestCase;
use App\Controllers\ProccessController;
use App\Models\Process;

class ProccessControllerTest extends TestCase {
    protected $proccessController;
    protected $processMock;

    protected function setUp(): void {
        // Создаем мок модели Process
        $this->processMock = $this->createMock(Process::class);

        // Передаем мок модели в конструктор ProccessController
        $this->proccessController = new ProccessController($this->processMock);
    }

    public function testIndex() {
        $this->proccessController = $this->getMockBuilder(ProccessController::class)
            ->setConstructorArgs([$this->processMock])
            ->onlyMethods(['getJsonInput'])
            ->getMock();

        $this->proccessController->method('getJsonInput')
            ->willReturn(['page' => 1, 'perPage' => 2]);

        $this->processMock->method('getAll')
            ->willReturn([
                [
                    'id' => 1,
                    'name' => 'Process 1',
                    'description' => 'Description 1'
                ],
                [
                    'id' => 2,
                    'name' => 'Process 2',
                    'description' => 'Description 2'
                ]
            ]);

        $expected = json_encode([
            [
                'id' => 1,
                'name' => 'Process 1',
                'description' => 'Description 1'
            ],
            [
                'id' => 2,
                'name' => 'Process 2',
                'description' => 'Description 2'
            ]
        ]);

        $this->expectOutputString($expected);
        $this->proccessController->index();
    }

    public function testStore() {
        $this->proccessController = $this->getMockBuilder(ProccessController::class)
            ->setConstructorArgs([$this->processMock])
            ->onlyMethods(['getJsonInput'])
            ->getMock();

        $this->proccessController->method('getJsonInput')
            ->willReturn([
                'name' => 'Process 1',
                'description' => 'Description 1'
            ]);

        $this->processMock->method('create')
            ->willReturn([
                'id' => 1,
                'name' => 'Process 1',
                'description' => 'Description 1'
            ]);

        $expected = json_encode([
            'id' => 1,
            'name' => 'Process 1',
            'description' => 'Description 1'
        ]);

        $this->expectOutputString($expected);
        $this->proccessController->store();
    }
}
