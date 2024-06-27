<?php
use PHPUnit\Framework\TestCase;
use App\Models\Type;
use App\Core\Database;

class TypeTest extends TestCase {
    protected $type;

    protected function setUp(): void {
        // Создаем мок PDOStatement
        $stmtMock = $this->createMock(\PDOStatement::class);
        $stmtMock->method('fetchAll')->willReturn([
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

        $this->type = new Type($dbMock);
    }

    public function testGetAll() {
        $result = $this->type->getAll();
        $this->assertCount(2, $result);
        $this->assertEquals('Type 1', $result[0]['name']);
        $this->assertEquals('Type 2', $result[1]['name']);
    }
}
