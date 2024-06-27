<?php
use PHPUnit\Framework\TestCase;
use App\Controllers\TypeController;
use App\Models\Type;
use App\Core\Database;

class TypeControllerTest extends TestCase {
    protected $typeController;
    protected $typeMock;
    protected $dbMock;

    protected function setUp(): void {
        // Создаем мок базы данных
        $this->dbMock = $this->createMock(Database::class);

        // Создаем мок модели Type с мок-объектом базы данных
        $this->typeMock = $this->getMockBuilder(Type::class)
            ->setConstructorArgs([$this->dbMock])
            ->onlyMethods(['getAll', 'create'])
            ->getMock();

        // Передаем мок модели в конструктор TypeController
        $this->typeController = new TypeController($this->typeMock);
    }

    public function testIndex() {
        $this->typeController = $this->getMockBuilder(TypeController::class)
            ->setConstructorArgs([$this->typeMock])
            ->onlyMethods(['getJsonInput'])
            ->getMock();

        $this->typeController->method('getJsonInput')
            ->willReturn(['page' => 1, 'perPage' => 2]);

        $this->typeMock->method('getAll')
            ->willReturn([
                [
                    'id' => 1,
                    'name' => 'Type 1',
                    'format' => 'Format 1',
                    'description' => 'Description 1'
                ],
                [
                    'id' => 2,
                    'name' => 'Type 2',
                    'format' => 'Format 2',
                    'description' => 'Description 2'
                ]
            ]);

        $expected = json_encode([
            [
                'id' => 1,
                'name' => 'Type 1',
                'format' => 'Format 1',
                'description' => 'Description 1'
            ],
            [
                'id' => 2,
                'name' => 'Type 2',
                'format' => 'Format 2',
                'description' => 'Description 2'
            ]
        ]);

        $this->expectOutputString($expected);
        $this->typeController->index();
    }

    public function testStore() {
        $this->typeController = $this->getMockBuilder(TypeController::class)
            ->setConstructorArgs([$this->typeMock])
            ->onlyMethods(['getJsonInput'])
            ->getMock();

        $this->typeController->method('getJsonInput')
            ->willReturn([
                'name' => 'Type 1',
                'format' => 'Format 1',
                'description' => 'Description 1'
            ]);

        $this->typeMock->method('create')
            ->willReturn([
                'id' => 1,
                'name' => 'Type 1',
                'format' => 'Format 1',
                'description' => 'Description 1'
            ]);

        $expected = json_encode([
            'id' => 1,
            'name' => 'Type 1',
            'format' => 'Format 1',
            'description' => 'Description 1'
        ]);

        $this->expectOutputString($expected);
        $this->typeController->store();
    }
}
