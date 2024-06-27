<?php
use PHPUnit\Framework\TestCase;
use App\Controllers\FieldController;
use App\Models\Field;

class FieldControllerTest extends TestCase {
    protected $fieldController;
    protected $fieldMock;

    protected function setUp(): void {
        // Создаем мок модели Field
        $this->fieldMock = $this->createMock(Field::class);

        // Передаем мок модели в конструктор FieldController
        $this->fieldController = new FieldController($this->fieldMock);
    }

    public function testIndex() {
        $this->fieldController = $this->getMockBuilder(FieldController::class)
            ->setConstructorArgs([$this->fieldMock])
            ->onlyMethods(['getJsonInput'])
            ->getMock();

        $this->fieldController->method('getJsonInput')
            ->willReturn(['page' => 1, 'perPage' => 2]);

        $this->fieldMock->method('getAll')
            ->willReturn([
                [
                    'id' => 1,
                    'process_id' => 1,
                    'type_id' => 1,
                    'name' => 'Field 1',
                    'value' => 'Value 1',
                    'description' => 'Description 1'
                ],
                [
                    'id' => 2,
                    'process_id' => 1,
                    'type_id' => 1,
                    'name' => 'Field 2',
                    'value' => 'Value 2',
                    'description' => 'Description 2'
                ]
            ]);

        $expected = json_encode([
            [
                'id' => 1,
                'process_id' => 1,
                'type_id' => 1,
                'name' => 'Field 1',
                'value' => 'Value 1',
                'description' => 'Description 1'
            ],
            [
                'id' => 2,
                'process_id' => 1,
                'type_id' => 1,
                'name' => 'Field 2',
                'value' => 'Value 2',
                'description' => 'Description 2'
            ]
        ]);

        $this->expectOutputString($expected);
        $this->fieldController->index();
    }

    public function testStore() {
        $this->fieldController = $this->getMockBuilder(FieldController::class)
            ->setConstructorArgs([$this->fieldMock])
            ->onlyMethods(['getJsonInput'])
            ->getMock();

        $this->fieldController->method('getJsonInput')
            ->willReturn([
                'process_id' => 1,
                'type_id' => 1,
                'name' => 'Field 1',
                'value' => 'Value 1',
                'description' => 'Description 1'
            ]);

        $this->fieldMock->method('create')
            ->willReturn([
                'id' => 1,
                'process_id' => 1,
                'type_id' => 1,
                'name' => 'Field 1',
                'value' => 'Value 1',
                'description' => 'Description 1'
            ]);

        $expected = json_encode([
            'id' => 1,
            'process_id' => 1,
            'type_id' => 1,
            'name' => 'Field 1',
            'value' => 'Value 1',
            'description' => 'Description 1'
        ]);

        $this->expectOutputString($expected);
        $this->fieldController->store();
    }
}
