<?php

namespace PHPds\UnitTest\Stack;

use PHPds\UnitTest\Dummy\DummyClass;
use PHPdt\DataType\ArrayDataType;
use PHPdt\DataType\BoolDataType;
use PHPdt\DataType\DoubleDataType;
use PHPdt\DataType\IntDataType;
use PHPdt\DataType\StringDataType;
use PHPds\Stack\Stack;

class StackTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider stackItemProvider
     * @param $item
     */
    public function testStackPush($item)
    {
        $stack = new Stack($item['type']);
        foreach ($item['data'] as $data) {
            $stack->push($data);
        }
        $this->assertCount(count($item['data']), $stack);
    }

    /**
     * @dataProvider stackItemProvider
     * @param $item
     */
    public function testStackPeek($item)
    {
        $data = null;
        $stack = new Stack($item['type']);
        foreach ($item['data'] as $data) {
            $stack->push($data);
        }
        $this->assertSame($stack->peek(), $data);
        $this->assertCount(count($item['data']), $stack);
    }

    public function testStackPop()
    {
        $stack = new Stack(IntDataType::class);
        $stack->push(1);
        $item2 = $stack->push(2);
        $item3 = $stack->push(3);
        $pop = $stack->pop();
        $this->assertSame($item3, $pop);
        $this->assertSame($item2, $stack->peek());
        $this->assertCount(2, $stack);
    }

    /**
     * @dataProvider stackItemProvider
     * @param $item
     */
    public function testStackHas($item)
    {
        $stack = new Stack($item['type']);
        foreach ($item['data'] as $data) {
            $stack->push($data);
        }
        $element = $item['data'][count($item['data']) >> 1];
        $this->assertTrue($stack->has($element));
        $this->assertFalse($stack->has($item['miss']));
    }

    public function testStackCountEmpty()
    {
        $stack = new Stack(IntDataType::class);
        $this->assertCount(0, $stack);
    }

    public function testStackCountNonEmpty()
    {
        $stack = new Stack(IntDataType::class);
        $stack->push(1);
        $stack->push(2);
        $stack->push(3);
        $this->assertCount(3, $stack);
    }

    public function testStackDecreaseToEmpty()
    {
        $stack = new Stack(IntDataType::class);
        $stack->push(1);
        $stack->push(2);
        $stack->pop();
        $stack->pop();
        $this->assertCount(0, $stack);
    }

    public function stackItemProvider()
    {
        return [
            [
                [
                    'type' => IntDataType::class,
                    'data' => [-1, 0, 1],
                    'miss' => 2
                ]
            ],
            [
                [
                    'type' => DoubleDataType::class,
                    'data' => [-1.0, -.1, 0.0, 0.1, 1.0],
                    'miss' => 2.0
                ]
            ],
            [
                [
                    'type' => StringDataType::class,
                    'data' => ['a', 'A', '!', '#', '$', '.', '\'', '"', '/'],
                    'miss' => 'z'
                ]
            ],
            [
                [
                    'type' => BoolDataType::class,
                    'data' => [true, false],
                    'miss' => null
                ]
            ],
            [
                [
                    'type' => ArrayDataType::class,
                    'data' => [[1, 2, 3], ['a', 'b', 'c']],
                    'miss' => [1, 2]
                ]
            ],
            [
                [
                    'type' => DummyClass::class,
                    'data' => [new DummyClass(), new DummyClass()],
                    'miss' => new DummyClass()
                ]
            ]
        ];
    }
}
