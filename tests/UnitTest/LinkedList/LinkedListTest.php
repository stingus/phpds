<?php

namespace PHPds\UnitTest\LinkedList;

use PHPds\LinkedList\LinkedList;
use PHPds\LinkedList\LinkedListInterface as LLI;
use PHPds\LinkedList\Node;
use PHPds\UnitTest\Dummy\DummyClass;
use PHPdt\DataType\IntDataType;
use PHPUnit_Framework_TestCase;

/**
 * Class LinkedListTest
 * @package UnitTest\LinkedList
 * @group Unit
 */
class LinkedListTest extends PHPUnit_Framework_TestCase
{
    public function testInsertInEmptyList()
    {
        $list = new LinkedList(DummyClass::class);
        $node = $list->insert(new DummyClass());
        $this->assertTrue($list->has($node));
        $this->assertCount(1, $list);
    }

    public function testInsertMultiple()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $this->assertCount(3, $list);
    }

    public function testInsertFirst()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass(), LLI::FIRST);
        $list->insert(new DummyClass(), LLI::FIRST);
        $node = $list->insert(new DummyClass(), LLI::FIRST);
        $this->assertSame($node, $list->peek());
    }

    public function testInsertLast()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass(), LLI::LAST);
        $list->insert(new DummyClass(), LLI::LAST);
        $node = $list->insert(new DummyClass(), LLI::LAST);
        $this->assertSame($node, $list->peek(LLI::LAST));
    }

    public function testInsertInEmptyListHasNoNextAndPreviousNodes()
    {
        $list = new LinkedList(DummyClass::class);
        $node = $list->insert(new DummyClass());
        $this->assertNull($node->getNext());
        $this->assertNull($node->getPrevious());
    }

    public function testInsertInEmptyListHasFirstAndLastSet()
    {
        $list = new LinkedList(DummyClass::class);
        $node = $list->insert(new DummyClass());
        $this->assertSame($node, $list->peek());
        $this->assertSame($node, $list->peek(LLI::LAST));
    }

    public function testInsertFirstLinksUpdated()
    {
        $list = new LinkedList(DummyClass::class);
        $node1 = $list->insert(new DummyClass());
        $node2 = $list->insert(new DummyClass());
        $this->assertNull($node2->getPrevious());
        $this->assertNull($node1->getNext());
        $this->assertSame($node1, $node2->getNext());
        $this->assertSame($node2, $node1->getPrevious());
    }

    public function testInsertLastLinksUpdated()
    {
        $list = new LinkedList(DummyClass::class);
        $node1 = $list->insert(new DummyClass(), LLI::LAST);
        $node2 = $list->insert(new DummyClass(), LLI::LAST);
        $this->assertNull($node1->getPrevious());
        $this->assertNull($node2->getNext());
        $this->assertSame($node2, $node1->getNext());
        $this->assertSame($node1, $node2->getPrevious());
    }

    public function testInsertWithInvalidPosition()
    {
        $this->expectException('PHPds\\LinkedList\\Exceptions\\InvalidNodePositionException');
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $list->insert(new DummyClass(), 3);
    }

    public function testInsertAtFirst()
    {
        $list = new LinkedList(DummyClass::class);
        $node1 = $list->insert(new DummyClass());
        $node2 = $list->insert(new DummyClass());
        $node3 = $list->insertAt(0, new DummyClass());
        $this->assertNotNull($node3);
        $this->assertSame($node3, $list->peek());
        $this->assertSame($node1, $list->peek(LLI::LAST));
        $this->assertSame($node2, $node3->getNext());
        $this->assertSame($node3, $node2->getPrevious());
    }

    public function testInsertAtFirstOnEmptyList()
    {
        $list = new LinkedList(DummyClass::class);
        $node = $list->insertAt(0, new DummyClass());
        $this->assertNotNull($node);
        $this->assertSame($node, $list->peek());
        $this->assertSame($node, $list->peek(LLI::LAST));
    }

    public function testInsertAtMiddle()
    {
        $list = new LinkedList(DummyClass::class);
        $node1 = $list->insert(new DummyClass());
        $node2 = $list->insert(new DummyClass());
        $node3 = $list->insert(new DummyClass());
        $node4 = $list->insertAt(1, new DummyClass());
        $this->assertNotNull($node4);
        $this->assertSame($node4, $list->get(1));
        $this->assertSame($node4, $node2->getPrevious());
        $this->assertSame($node4, $node3->getNext());
        $this->assertSame($node2, $node4->getNext());
        $this->assertSame($node3, $node4->getPrevious());
        $this->assertSame($node1, $list->peek(LLI::LAST));
        $this->assertSame($node3, $list->peek());

    }

    public function testInsertAtLast()
    {
        $list = new LinkedList(DummyClass::class);
        $node1 = $list->insert(new DummyClass());
        $node2 = $list->insert(new DummyClass());
        $node3 = $list->insertAt(1, new DummyClass());
        $this->assertNotNull($node3);
        $this->assertSame($node3, $list->get(1));
        $this->assertSame($node3, $node1->getPrevious());
        $this->assertSame($node3, $node2->getNext());
        $this->assertSame($node2, $node3->getPrevious());
        $this->assertSame($node1, $node3->getNext());
        $this->assertSame($node2, $list->peek());
        $this->assertSame($node1, $list->peek(LLI::LAST));
    }

    public function testInsertAfterLast()
    {
        $list = new LinkedList(DummyClass::class);
        $node1 = $list->insert(new DummyClass());
        $node2 = $list->insert(new DummyClass());
        $node3 = $list->insertAt(2, new DummyClass());
        $this->assertNotNull($node3);
        $this->assertSame($node1, $node3->getPrevious());
        $this->assertNull($node3->getNext());
        $this->assertSame($node3, $node1->getNext());
        $this->assertSame($node2, $list->peek());
        $this->assertSame($node3, $list->peek(LLI::LAST));
    }

    public function testArraySetOutOfBounds()
    {
        $this->expectException('PHPds\\LinkedList\\Exceptions\\OutOfBoundsIndexException');
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $list->insertAt(3, new DummyClass());
    }

    /**
     * @dataProvider invalidKeyProvider
     * @param $data
     */
    public function testArraySetWithInvalidKey($data)
    {
        $this->expectException('PHPds\\LinkedList\\Exceptions\\InvalidNodeIndexException');
        $list = new LinkedList(DummyClass::class);
        $list->insertAt($data, new DummyClass());
    }

    public function testHasNodeTrue()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $node = $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $this->assertTrue($list->has($node));
    }

    public function testHasNodeFalse()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $node = new Node(new DummyClass());
        $this->assertFalse($list->has($node));
    }

    public function testHasNodeFalseOnEmptyList()
    {
        $list = new LinkedList(DummyClass::class);
        $node = new Node(new DummyClass());
        $this->assertFalse($list->has($node));
    }

    public function testSearchEmptyList()
    {
        $list = new LinkedList(DummyClass::class);
        $this->assertEmpty($list->search(new DummyClass()));
    }

    public function testSearchSingleResult()
    {
        $list = new LinkedList(DummyClass::class);
        $data = new DummyClass();
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $node = $list->insert($data);
        $this->assertCount(1, $list->search($data));
        $this->assertSame($node, $list->search($data)[0]);
    }

    public function testSearchMultipleResults()
    {
        $list = new LinkedList(DummyClass::class);
        $data = new DummyClass();
        $list->insert($data);
        $list->insert(new DummyClass());
        $list->insert($data);
        $this->assertCount(2, $list->search($data));
    }

    public function testSearchNoResults()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $this->assertEmpty($list->search(new DummyClass()));
    }

    public function testPeekOnAnEmptyList()
    {
        $list = new LinkedList(DummyClass::class);
        $this->assertNull($list->peek());
    }

    public function testPeekFirst()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $node = $list->insert(new DummyClass());
        $this->assertSame($node, $list->peek());
        $this->assertCount(3, $list);
    }

    public function testPeekLast()
    {
        $list = new LinkedList(DummyClass::class);
        $node = $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $this->assertSame($node, $list->peek(LLI::LAST));
        $this->assertCount(3, $list);
    }

    public function testPeekInvalidPosition()
    {
        $this->expectException('PHPds\\LinkedList\\Exceptions\\InvalidNodePositionException');
        $list = new LinkedList(DummyClass::class);
        $list->peek(3);
    }

    public function testGetOnEmptyList()
    {
        $list = new LinkedList(DummyClass::class);
        $this->assertNull($list->get(0));
    }

    public function testGetWithValidIndex()
    {
        $list = new LinkedList(DummyClass::class);
        $node = $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $this->assertSame($node, $list->get(2));
    }

    public function testGetWithNegativeIndex()
    {
        $this->expectException('PHPds\\LinkedList\\Exceptions\\InvalidNodeIndexException');
        $list = new LinkedList(DummyClass::class);
        $list->get(-1);
    }

    public function testGetWithFloatIndex()
    {
        $this->expectException('PHPds\\LinkedList\\Exceptions\\InvalidNodeIndexException');
        $list = new LinkedList(DummyClass::class);
        $list->get(.1);
    }

    public function testGetWithFalseIndex()
    {
        $this->expectException('PHPds\\LinkedList\\Exceptions\\InvalidNodeIndexException');
        $list = new LinkedList(DummyClass::class);
        $list->get(false);
    }

    public function testGetWithObjectIndex()
    {
        $this->expectException('PHPds\\LinkedList\\Exceptions\\InvalidNodeIndexException');
        $list = new LinkedList(DummyClass::class);
        /** @noinspection PhpParamsInspection */
        $list->get(new DummyClass());
    }

    public function testGetWithStringIndex()
    {
        $this->expectException('PHPds\\LinkedList\\Exceptions\\InvalidNodeIndexException');
        $list = new LinkedList(DummyClass::class);
        $list->get('index');
    }

    public function testGetWithOverflowIndex()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $this->assertNull($list->get(3));
    }

    public function testGetWithIndexInFirstHalf()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $node = $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $this->assertSame($node, $list->get(1));
    }

    public function testGetWithIndexInSecondHalf()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $node = $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $this->assertSame($node, $list->get(3));
    }

    public function testGetWithIndexInTheMiddle()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $node = $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $this->assertSame($node, $list->get(2));
    }

    public function testRemoveNodeFromNonEmptyList()
    {
        $list = new LinkedList(DummyClass::class);
        $node1 = $list->insert(new DummyClass());
        $node2 = $list->insert(new DummyClass());
        $node3 = $list->insert(new DummyClass());
        $this->assertTrue($list->removeNode($node2));
        $this->assertCount(2, $list);
        $this->assertSame($node3, $list->peek());
        $this->assertSame($node1, $list->peek(LLI::LAST));
    }

    public function testRemoveNodeNotFound()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $node = new Node(new DummyClass());
        $this->assertFalse($list->removeNode($node));
    }

    public function testRemoveNodeFromMiddleLinksUpdated()
    {
        $list = new LinkedList(DummyClass::class);
        $node1 = $list->insert(new DummyClass());
        $node2 = $list->insert(new DummyClass());
        $node3 = $list->insert(new DummyClass());
        $list->removeNode($node2);
        $this->assertNull($node3->getPrevious());
        $this->assertNull($node1->getNext());
        $this->assertSame($node1, $node3->getNext());
        $this->assertSame($node3, $node1->getPrevious());
        $this->assertSame($node3, $list->peek());
        $this->assertSame($node1, $list->peek(LLI::LAST));
    }

    public function testRemoveNodeFromBeginningLinksUpdated()
    {
        $list = new LinkedList(DummyClass::class);
        $node1 = $list->insert(new DummyClass());
        $node2 = $list->insert(new DummyClass());
        $node3 = $list->insert(new DummyClass());
        $list->removeNode($node3);
        $this->assertNull($node2->getPrevious());
        $this->assertNull($node1->getNext());
        $this->assertSame($node1, $node2->getNext());
        $this->assertSame($node2, $node1->getPrevious());
        $this->assertSame($node2, $list->peek());
        $this->assertSame($node1, $list->peek(LLI::LAST));
    }

    public function testRemoveNodeFromEndLinksUpdated()
    {
        $list = new LinkedList(DummyClass::class);
        $node1 = $list->insert(new DummyClass());
        $node2 = $list->insert(new DummyClass());
        $node3 = $list->insert(new DummyClass());
        $list->removeNode($node1);
        $this->assertNull($node3->getPrevious());
        $this->assertNull($node2->getNext());
        $this->assertSame($node2, $node3->getNext());
        $this->assertSame($node3, $node2->getPrevious());
        $this->assertSame($node3, $list->peek());
        $this->assertSame($node2, $list->peek(LLI::LAST));
    }

    public function testRemoveNodeNotBelongingToTheList()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $node = new Node(new DummyClass());
        $node->setNext(new Node(new DummyClass()));
        $node->setPrevious(new Node(new DummyClass()));
        $this->assertFalse($list->removeNode($node));
        $this->assertCount(3, $list);
    }

    public function testRemoveNodeDecreaseSize()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $node = $list->insert(new DummyClass());
        $list->removeNode($node);
        $this->assertCount(2, $list);
    }

    public function testRemoveNodeDecreaseSizeToZero()
    {
        $list = new LinkedList(DummyClass::class);
        $node1 = $list->insert(new DummyClass());
        $node2 = $list->insert(new DummyClass());
        $list->removeNode($node1);
        $list->removeNode($node2);
        $this->assertCount(0, $list);
        $this->assertNull($list->peek());
        $this->assertNull($list->peek(LLI::LAST));
    }

    public function testRemoveOnEmptyList()
    {
        $list = new LinkedList(DummyClass::class);
        $this->assertFalse($list->remove());
    }

    public function testRemoveInvalidPosition()
    {
        $this->expectException('PHPds\\LinkedList\\Exceptions\\InvalidNodePositionException');
        $list = new LinkedList(DummyClass::class);
        $list->remove(3);
    }

    public function testRemoveFirst()
    {
        $list = new LinkedList(DummyClass::class);
        $node1 = $list->insert(new DummyClass());
        $node2 = $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $this->assertTrue($list->remove());
        $this->assertSame($node2, $node1->getPrevious());
        $this->assertSame($node1, $node2->getNext());
        $this->assertSame($node2, $list->peek());
        $this->assertSame($node1, $list->peek(LLI::LAST));
    }

    public function testRemoveLast()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $node2 = $list->insert(new DummyClass());
        $node3 = $list->insert(new DummyClass());
        $this->assertTrue($list->remove(LLI::LAST));
        $this->assertSame($node3, $node2->getPrevious());
        $this->assertSame($node2, $node3->getNext());
        $this->assertSame($node3, $list->peek());
        $this->assertSame($node2, $list->peek(LLI::LAST));
    }

    public function testRemoveFirstFromTwoNodes()
    {
        $list = new LinkedList(DummyClass::class);
        $node = $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $this->assertTrue($list->remove());
        $this->assertNull($node->getPrevious());
        $this->assertNull($node->getNext());
        $this->assertSame($node, $list->peek());
        $this->assertSame($node, $list->peek(LLI::LAST));
    }

    public function testRemoveLastFromTwoNodes()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $node = $list->insert(new DummyClass());
        $this->assertTrue($list->remove(LLI::LAST));
        $this->assertNull($node->getPrevious());
        $this->assertNull($node->getNext());
        $this->assertSame($node, $list->peek());
        $this->assertSame($node, $list->peek(LLI::LAST));
    }

    public function testRemoveOnlyNode()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $this->assertTrue($list->remove());
        $this->assertNull($list->peek());
        $this->assertNull($list->peek(LLI::LAST));
    }

    public function testPopFirstRemovesNode()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $node = $list->insert(new DummyClass());
        $this->assertSame($node, $list->pop());
        $this->assertCount(2, $list);
    }

    public function testPopFirstHasCorrectHead()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $node = $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $list->pop();
        $this->assertSame($node, $list->peek());
    }

    public function testPopFirstHasCorrectLinks()
    {
        $list = new LinkedList(DummyClass::class);
        $node1 = $list->insert(new DummyClass());
        $node2 = $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $list->pop();
        $this->assertSame($node1, $node2->getNext());
        $this->assertSame($node2, $node1->getPrevious());
        $this->assertNull($node2->getPrevious());
    }

    public function testPopLastRemovesNode()
    {
        $list = new LinkedList(DummyClass::class);
        $node = $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $this->assertEquals($node, $list->pop(LLI::LAST));
        $this->assertCount(2, $list);
    }

    public function testPopLastHasCorrectTail()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $node = $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $list->pop(LLI::LAST);
        $this->assertSame($node, $list->peek(LLI::LAST));
    }

    public function testPopLastHasCorrectLinks()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $node1 = $list->insert(new DummyClass());
        $node2 = $list->insert(new DummyClass());
        $list->pop(LLI::LAST);
        $this->assertSame($node1, $node2->getNext());
        $this->assertSame($node2, $node1->getPrevious());
        $this->assertNull($node1->getNext());
    }

    public function testPopOneNodeInList()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $list->pop();
        $this->assertNull($list->peek());
        $this->assertNull($list->peek(LLI::LAST));
    }

    public function testPopFirstEmptyList()
    {
        $list = new LinkedList(DummyClass::class);
        $this->assertNull($list->pop());
    }

    public function testPopLastEmptyList()
    {
        $list = new LinkedList(DummyClass::class);
        $this->assertNull($list->pop(LLI::LAST));
    }

    public function testPopInvalidPosition()
    {
        $this->expectException('PHPds\\LinkedList\\Exceptions\\InvalidNodePositionException');
        $list = new LinkedList(DummyClass::class);
        $list->pop(3);
    }

    public function testPopFirstHasNullPointers()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $node = $list->pop();
        $this->assertNull($node->getNext());
        $this->assertNull($node->getPrevious());
    }

    public function testPopLastHasNullPointers()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $node = $list->pop(LLI::LAST);
        $this->assertNull($node->getNext());
        $this->assertNull($node->getPrevious());
    }

    public function testCountEmptyList()
    {
        $list = new LinkedList(DummyClass::class);
        $this->assertEquals(0, $list->count());
    }

    public function testCountIncrease()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $this->assertEquals(3, $list->count());
    }

    public function testCountDecrease()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $list->remove();
        $this->assertEquals(2, $list->count());
    }

    public function testCountDecreaseToZero()
    {
        $list = new LinkedList(DummyClass::class);
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $list->insert(new DummyClass());
        $list->remove();
        $list->remove();
        $list->remove();
        $this->assertEquals(0, $list->count());
    }

    public function testDataTypeObjectGivenInteger()
    {
        $this->expectException('PHPdt\\DataType\\Exceptions\\InvalidDataTypeException');
        $list = new LinkedList(DummyClass::class);
        $list->insert(1);
    }

    public function testDataTypeIntegerGivenObject()
    {
        $this->expectException('PHPdt\\DataType\\Exceptions\\InvalidDataTypeException');
        $list = new LinkedList(IntDataType::class);
        $list->insert(new DummyClass());
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
