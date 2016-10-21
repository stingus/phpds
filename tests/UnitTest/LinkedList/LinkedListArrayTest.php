<?php

namespace PHPds\UnitTest\LinkedList;

use PHPds\LinkedList\LinkedList;
use PHPds\LinkedList\LinkedListArray;
use PHPds\LinkedList\LinkedListInterface as LLI;
use PHPds\UnitTest\Dummy\DummyClass;
use PHPUnit_Framework_TestCase;

/**
 * Class LinkedListArrayTest
 * @package UnitTest\LinkedList
 * @group Unit
 */
class LinkedListArrayTest extends PHPUnit_Framework_TestCase
{
    public function testArrayHasKey()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $array = new LinkedListArray($list);
        $this->assertArrayHasKey(0, $array);
        $this->assertArrayHasKey(1, $array);
        $this->assertArrayHasKey(2, $array);
    }

    public function testArrayNotHasKey()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $array = new LinkedListArray($list);
        $this->assertArrayNotHasKey(3, $array);
    }

    public function testArrayGetNode()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $node = $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $array = new LinkedListArray($list);
        $this->assertSame($node, $array[1]);
    }

    public function testArrayGetNonExistentNode()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $array = new LinkedListArray($list);
        $this->assertNull($array[1]);
    }

    /**
     * @dataProvider invalidKeyProvider
     * @param $data
     */
    public function testArrayGetWithInvalidKey($data)
    {
        $this->expectException('PHPds\\LinkedList\\Exceptions\\InvalidNodeIndexException');
        $array = new LinkedListArray(new LinkedList(DummyClass::class));
        $array->offsetGet($data);
    }

    public function testArraySetFirst()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $array = new LinkedListArray($list);
        $node = $array->offsetSet(0, new DummyClass());
        $this->assertSame($node, $array[0]);
    }

    public function testArraySetFirstOnEmptyList()
    {
        $list = new LinkedList(DummyClass::class);
        $array = new LinkedListArray($list);
        $node = $array->offsetSet(0, new DummyClass());
        $this->assertNotNull($node);
        $this->assertSame($node, $array[0]);
    }

    public function testArraySetMiddle()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $array = new LinkedListArray($list);
        $node = $array->offsetSet(1, new DummyClass());
        $this->assertSame($node, $array[1]);
    }

    public function testArraySetLast()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $array = new LinkedListArray($list);
        $node = $array->offsetSet(2, new DummyClass());
        $this->assertNotNull($node);
        $this->assertSame($node, $array[2]);
    }

    public function testArraySetOutOfBounds()
    {
        $this->expectException('PHPds\\LinkedList\\Exceptions\\OutOfBoundsIndexException');
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $array = new LinkedListArray($list);
        $array->offsetSet(3, new DummyClass());
    }

    public function testArrayUnsetFirst()
    {
        $list = new LinkedList(DummyClass::class);
        $node = $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $array = new LinkedListArray($list);
        $array->offsetUnset(0);
        $this->assertCount(1, $list);
        $this->assertSame($node, $array[0]);
        $this->assertSame($node, $list->peek());
        $this->assertSame($node, $list->peek(LLI::LAST));
    }

    public function testArrayUnsetMiddle()
    {
        $list = new LinkedList(DummyClass::class);
        $node1 = $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $node2 = $list->insert(new DummyClass());
        $array = new LinkedListArray($list);
        $array->offsetUnset(1);
        $this->assertCount(2, $list);
        $this->assertSame($node2, $array[0]);
        $this->assertSame($node1, $array[1]);
        $this->assertSame($node2, $node1->getPrevious());
        $this->assertSame($node1, $node2->getNext());
        $this->assertNull($node2->getPrevious());
        $this->assertNull($node1->getNext());
        $this->assertSame($node2, $list->peek());
        $this->assertSame($node1, $list->peek(LLI::LAST));
    }

    public function testArrayUnsetLast()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $node = $list->insert(new DummyClass());
        $array = new LinkedListArray($list);
        $array->offsetUnset(1);
        $this->assertCount(1, $list);
        $this->assertSame($node, $array[0]);
        $this->assertSame($node, $list->peek());
        $this->assertSame($node, $list->peek(LLI::LAST));
    }

    public function testArrayUnsetOutOfBounds()
    {
        $list = new LinkedList(DummyClass::class);
        $node1 = $list->insert(new DummyClass());
        $node2 = $list->insert(new DummyClass());
        $array = new LinkedListArray($list);
        $this->assertFalse($array->offsetUnset(2));
        $this->assertCount(2, $list);
        $this->assertSame($node1, $array[1]);
        $this->assertSame($node2, $array[0]);
        $this->assertSame($node1, $node2->getNext());
        $this->assertSame($node2, $node1->getPrevious());
        $this->assertNull($node2->getPrevious());
        $this->assertNull($node1->getNext());
        $this->assertSame($node2, $list->peek());
        $this->assertSame($node1, $list->peek(LLI::LAST));
    }

    public function testArrayIterate()
    {
        $list = new LinkedList(DummyClass::class);

        /** @noinspection PhpUnusedLocalVariableInspection */
        $node1 = $list->insert(new DummyClass());
        /** @noinspection PhpUnusedLocalVariableInspection */
        $node2 = $list->insert(new DummyClass());
        /** @noinspection PhpUnusedLocalVariableInspection */
        $node3 = $list->insert(new DummyClass());
        $array = new LinkedListArray($list);
        $i = 3;
        foreach ($array as $node) {
            $this->assertSame(${'node' . $i--}, $node);
        }
    }

    public function testArrayCurrentFirst()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $node = $list->insert(new DummyClass());
        $array = new LinkedListArray($list);
        $this->assertSame($node, $array->current());
    }

    public function testArrayCurrentMiddle()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $node = $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $array = new LinkedListArray($list);
        $array->next();
        $this->assertSame($node, $array->current());
    }

    public function testArrayCurrentLast()
    {
        $list = new LinkedList(DummyClass::class);
        $node = $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $array = new LinkedListArray($list);
        $array->next();
        $array->next();
        $this->assertSame($node, $array->current());
    }

    public function testArrayReset()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $node = $list->insert(new DummyClass());
        $array = new LinkedListArray($list);
        $array->next();
        $array->next();
        $array->next();
        $array->rewind();
        $this->assertSame($node, $array->current());
    }

    public function testArrayCurrentKey()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $array = new LinkedListArray($list);
        for ($j = 0; $j < $list->count(); $j++) {
            $this->assertSame($j, $array->key());
            $array->next();
        }
    }

    public function invalidKeyProvider()
    {
        return [
            [new DummyClass()],
            ['abc'],
            [''],
            [-123],
            [.1],
            [false],
            [[1,2,3]],
            [null]
        ];
    }
}
