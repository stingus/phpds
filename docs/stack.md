### Stack usage
The stack is a strong-typed, LIFO structure. It is based on the PHP array data
type and PHPdt for setting the stack data type.

The stack is constructed with `new Stack(DataTypeInterface::class)`, where the
DataTypeInterface is a primitive or a user-defined data type. Check
[PHPdt](https://github.com/stingus/phpdt) for more information on data types.

The stack has 5 base methods:
 - `push($data): void` insert new element on top of stack
 - `pop(): stackType` get and remove last element
 - `peek(): stackType` get last element
 - `has($data): bool` check if the data is in the stack
 - `count(): int` get the size of the stack
 
 ## Stack using primitive data type (eg. integer)

```php
use PHPds\Stack\Stack;
use PHPdt\DataType\IntDataType;

// Create an integer type stack
$stack = new Stack(IntDataType::class);

// Add 2 items to the stack
$stack->push(1);
$stack->push(2);

// Invalid data type
$stack->push('1'); // throws PHPdt\DataType\Exceptions\InvalidDataTypeException

// Peek on the last element
echo $stack->peek(); // 2

// Pop (get and remove) the last element
echo $stack->pop(); // 2

// Count stack elements
echo $stack->count(); // 1

// Check if stack has data
var_dump($stack->has(2)); // false (was removed using pop())
var_dump($stack->has(1)); // true
```

## Stack using a user-defined type

```php
use PHPds\Stack\Stack;
use PHPdt\DataType\DataTypeInterface;
use PHPdt\DataType\ObjectValidationTrait;

// The user-defined type
// Could be also an interface or an abstract class
class FooDataType implements DataTypeInterface
{
    use ObjectValidationTrait;
}

// Create a FooDataType stack
$stack = new Stack(FooDataType::class);

// Add 2 items to the stack
$foo1 = new FooDataType();
$foo2 = new FooDataType();
$stack->push($foo1);
$stack->push($foo2);

// Invalid data type
$stack->push(new stdClass()); // throws PHPdt\DataType\Exceptions\InvalidDataTypeException

// Peek on the last element
$stack->peek(); // $foo2

// Pop (get and remove) the last element
$stack->pop(); // $foo2

// Count stack elements
echo $stack->count(); // 1

// Check if stack has data
var_dump($stack->has($foo2)); // false (was removed using pop())
var_dump($stack->has($foo1)); // true
var_dump($stack->has(new FooDataType())); // false, search is strict
```
