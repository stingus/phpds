### Queue usage
The queue is a strong-typed, FIFO structure. It is based on the doubly LinkedList data
type and PHPdt for setting the queue data type.

The queue is constructed with `new Queue(DataTypeInterface::class)`, where the
DataTypeInterface is a primitive or a user-defined data type. Check
[PHPdt](https://github.com/stingus/phpdt) for more information on data types.

The queue has 5 base methods:
 - `enqueue($data): void` insert new element at the end of the queue 
 - `dequeue(): queueType` get and remove the first element in-line
 - `peek(): queueType` get first element in-line
 - `has($data): bool` check if the data is in the queue
 - `count(): int` get the size of the queue
 
 ## Queue using primitive data type (eg. integer)

```php
use PHPds\Queue\Queue;
use PHPdt\DataType\IntDataType;

// Create an integer type queue
$queue = new Queue(IntDataType::class);

// Add 2 items to the queue
$queue->enqueue(1);
$queue->enqueue(2);

// Invalid data type
$queue->enqueue('1'); // throws PHPdt\DataType\Exceptions\InvalidDataTypeException

// Peek on the first element
echo $queue->peek(); // 1

// Dequeue (get and remove) the first element
echo $queue->dequeue(); // 1

// Count queue elements
echo $queue->count(); // 1

// Check if queue has data
var_dump($queue->has(1)); // false (was removed using dequeue())
var_dump($queue->has(2)); // true
```

## Queue using a user-defined type

```php
use PHPds\Queue\Queue;
use PHPdt\DataType\DataTypeInterface;
use PHPdt\DataType\ObjectValidationTrait;

// The user-defined type
// Could be also an interface or an abstract class
class FooDataType implements DataTypeInterface
{
    use ObjectValidationTrait;
}

// Create a FooDataType queue
$queue = new Queue(FooDataType::class);

// Add 2 items to the queue
$foo1 = new FooDataType();
$foo2 = new FooDataType();
$queue->enqueue($foo1);
$queue->enqueue($foo2);

// Invalid data type
$queue->enqueue(new stdClass()); // throws PHPdt\DataType\Exceptions\InvalidDataTypeException

// Peek on the first element
$queue->peek(); // $foo1

// Dequeue (get and remove) the first element
$queue->dequeue(); // $foo1

// Count queue elements
echo $queue->count(); // 1

// Check if queue has data
var_dump($queue->has($foo1)); // false (was removed using dequeue())
var_dump($queue->has($foo2)); // true
var_dump($queue->has(new FooDataType())); // false, search is strict
```
