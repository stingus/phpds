<?php

namespace PHPds\UnitTest\Stack;

use PHPdt\DataType\IntDataType;
use PHPds\Stack\Stack;
use PHPds\UnitTest\DataProvider\DataProviderTrait;

class StackTest extends \PHPUnit_Framework_TestCase
{
    use DataProviderTrait;

    /**
     * @dataProvider typedDataProvider
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
     * @dataProvider typedDataProvider
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
     * @dataProvider typedDataProvider
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
}
