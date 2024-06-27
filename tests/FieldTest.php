<?php
use PHPUnit\Framework\TestCase;
use App\Models\Field;
use App\Core\Database;

class FieldTest extends TestCase {
    protected $field;

    protected function setUp(): void {
        // Создаем мок PDOStatement
        $stmtMock = $this->createMock(\PDOStatement::class);
        $stmtMock->method('fetchAll')->willReturn([
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

        // Создаем мок PDO
        $pdoMock = $this->createMock(\PDO::class);
        $pdoMock->method('prepare')->willReturn($stmtMock);

        // Создаем мок Database
        $dbMock = $this->getMockBuilder(Database::class)
            ->setConstructorArgs([$pdoMock])
            ->onlyMethods(['query'])
            ->getMock();

        // Настраиваем метод query, чтобы он возвращал наш мок PDOStatement
        $dbMock->method('query')->willReturn([
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

        $this->field = new Field($dbMock);
    }

    public function testGetAll() {
        $result = $this->field->getAll();
        $this->assertCount(2, $result);
        $this->assertEquals('Field 1', $result[0]['name']);
        $this->assertEquals('Field 2', $result[1]['name']);
    }
}
