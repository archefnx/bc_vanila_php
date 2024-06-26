# Тестовое задание PHP Для реализации бизнес-процессов(чистый php)
Необходимо реализовать процессы (объекты), которые содержат поля данных и 
уникальное наименование. В тестовом задании других свойств процесса нет. 
Поля данных процесса могут быть трех типов (текстовое, числовое, дата), и быть в
произвольном порядке и количестве. Свойства полей: у всех полей есть имя, которое
должно быть уникальным ключом. у всех полей есть тип, который не может быть пустыми 
у всех полей есть значение по умолчанию, которое может быть пустым, 0 или текущая
дата. у поля типа "число" есть дополнительное свойство - формат числа 
(знаки после запятой, лидирующие нули и т.д., в формате sprintf). 
у поля типа "дата" есть дополнительное свойство - формат даты, в формате 
DateTime::format. Входные данные: Конфигурация поля определяется набором 
свойств в массиве. Например: 
```
$field = ['name' => 'Text', 'type' => 'text', 'value' => 'Text'];
```
Набор полей определяется в виде массива конфигурации полей. Например: 
```
$fields = [ 
    ['name' => 'Text', 'type' => 'text', 'value' => 'Text'], 
    ['name' => 'Number', 'type' => 'number', 'value' => 455, 'format' => '%+.2f'], 
    ['name' => 'Text2', 'type' => 'text', 'value' => 'Text 2'], 
    ['name' => 'Start', 'type' => 'date', 'value' => '12.03.2023'],
  ]; 
  ```
Необходимо спроектировать таблицы СУБД  (любой SQL-совместимой) для хранения структуры процессов, их данных и заполнить их тестовыми данными. Допустимо добавлять технические поля не описанные в ТЗ. Код должен реализовать следующий функционал: ·	получение данных из БД с учетом постраничной навигации ·	создание объекта процесса ·	передачу ему конфигурационного набора полей ·	добавление в процесс отдельного поля ·	вывод данных по всем полям процесса в нужном формате. Требования к коду: ·	использование ООП ·	Типизация ·	Возможность просто и безопасно: ·	добавлять новые типы полей в дальнейшем, ·	изменять логику работы существующих типов полей. ·	работа с namespace ·	тесты для кода. Плюсом является: •	реализация поиска при выборе данных из БД

