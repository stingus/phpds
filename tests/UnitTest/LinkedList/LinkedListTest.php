<?php

namespace PHPds\UnitTest\LinkedList;

use PHPds\LinkedList\LinkedList;
use PHPds\LinkedList\LinkedListInterface as LLI;
use PHPds\LinkedList\Node;
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
        $list = new LinkedList();
        $node = $list->insert(new \stdClass());
        $this->assertTrue($list->has($node));
        $this->assertCount(1, $list);
    }

    public function testInsertMultiple()
    {
        $list = new LinkedList();
        $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $this->assertCount(3, $list);
    }

    public function testInsertFirst()
    {
        $list = new LinkedList();
        $list->insert(new \stdClass(), LLI::FIRST);
        $list->insert(new \stdClass(), LLI::FIRST);
        $node = $list->insert(new \stdClass(), LLI::FIRST);
        $this->assertSame($node, $list->peek());
    }

    public function testInsertLast()
    {
        $list = new LinkedList();
        $list->insert(new \stdClass(), LLI::LAST);
        $list->insert(new \stdClass(), LLI::LAST);
        $node = $list->insert(new \stdClass(), LLI::LAST);
        $this->assertSame($node, $list->peek(LLI::LAST));
    }

    public function testInsertInEmptyListHasNoNextAndPreviousNodes()
    {
        $list = new LinkedList();
        $node = $list->insert(new \stdClass());
        $this->assertNull($node->getNext());
        $this->assertNull($node->getPrevious());
    }

    public function testInsertInEmptyListHasFirstAndLastSet()
    {
        $list = new LinkedList();
        $node = $list->insert(new \stdClass());
        $this->assertSame($node, $list->peek());
        $this->assertSame($node, $list->peek(LLI::LAST));
    }

    public function testInsertFirstLinksUpdated()
    {
        $list = new LinkedList();
        $node1 = $list->insert(new \stdClass());
        $node2 = $list->insert(new \stdClass());
        $this->assertNull($node2->getPrevious());
        $this->assertNull($node1->getNext());
        $this->assertSame($node1, $node2->getNext());
        $this->assertSame($node2, $node1->getPrevious());
    }

    public function testInsertLastLinksUpdated()
    {
        $list = new LinkedList();
        $node1 = $list->insert(new \stdClass(), LLI::LAST);
        $node2 = $list->insert(new \stdClass(), LLI::LAST);
        $this->assertNull($node1->getPrevious());
        $this->assertNull($node2->getNext());
        $this->assertSame($node2, $node1->getNext());
        $this->assertSame($node1, $node2->getPrevious());
    }

    public function testInsertWithInvalidPosition()
    {
        $this->expectException('PHPds\\LinkedList\\Exceptions\\InvalidNodePositionException');
        $list = new LinkedList();
        $list->insert(new \stdClass());
        $list->insert(new \stdClass(), 3);
    }

    public function testInsertAtFirst()
    {
        $list = new LinkedList();
        $node1 = $list->insert(new \stdClass());
        $node2 = $list->insert(new \stdClass());
        $node3 = $list->insertAt(0, new \stdClass());
        $this->assertNotNull($node3);
        $this->assertSame($node3, $list->peek());
        $this->assertSame($node1, $list->peek(LLI::LAST));
        $this->assertSame($node2, $node3->getNext());
        $this->assertSame($node3, $node2->getPrevious());
    }

    public function testInsertAtFirstOnEmptyList()
    {
        $list = new LinkedList();
        $node = $list->insertAt(0, new \stdClass());
        $this->assertNotNull($node);
        $this->assertSame($node, $list->peek());
        $this->assertSame($node, $list->peek(LLI::LAST));
    }

    public function testInsertAtMiddle()
    {
        $list = new LinkedList();
        $node1 = $list->insert(new \stdClass());
        $node2 = $list->insert(new \stdClass());
        $node3 = $list->insert(new \stdClass());
        $node4 = $list->insertAt(1, new \stdClass());
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
        $list = new LinkedList();
        $node1 = $list->insert(new \stdClass());
        $node2 = $list->insert(new \stdClass());
        $node3 = $list->insertAt(1, new \stdClass());
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
        $list = new LinkedList();
        $node1 = $list->insert(new \stdClass());
        $node2 = $list->insert(new \stdClass());
        $node3 = $list->insertAt(2, new \stdClass());
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
        $list = new LinkedList();
        $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $list->insertAt(3, new \stdClass());
    }

    /**
     * @dataProvider invalidKeyProvider
     * @param $data
     */
    public function testArraySetWithInvalidKey($data)
    {
        $this->expectException('PHPds\\LinkedList\\Exceptions\\InvalidNodeIndexException');
        $list = new LinkedList();
        $list->insertAt($data, new \stdClass());
    }

    public function testHasNodeTrue()
    {
        $list = new LinkedList();
        $list->insert(new \stdClass());
        $node = $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $this->assertTrue($list->has($node));
    }

    public function testHasNodeFalse()
    {
        $list = new LinkedList();
        $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $node = new Node(new \stdClass());
        $this->assertFalse($list->has($node));
    }

    public function testHasNodeFalseOnEmptyList()
    {
        $list = new LinkedList();
        $node = new Node(new \stdClass());
        $this->assertFalse($list->has($node));
    }

    public function testSearchEmptyList()
    {
        $list = new LinkedList();
        $this->assertEmpty($list->search(new \stdClass()));
    }

    public function testSearchSingleResult()
    {
        $list = new LinkedList();
        $data = new \stdClass();
        $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $node = $list->insert($data);
        $this->assertCount(1, $list->search($data));
        $this->assertSame($node, $list->search($data)[0]);
    }

    public function testSearchMultipleResults()
    {
        $list = new LinkedList();
        $data = new \stdClass();
        $list->insert($data);
        $list->insert(new \stdClass());
        $list->insert($data);
        $this->assertCount(2, $list->search($data));
    }

    public function testSearchNoResults()
    {
        $list = new LinkedList();
        $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $this->assertEmpty($list->search(new \stdClass()));
    }

    public function testPeekOnAnEmptyList()
    {
        $list = new LinkedList();
        $this->assertNull($list->peek());
    }

    public function testPeekFirst()
    {
        $list = new LinkedList();
        $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $node = $list->insert(new \stdClass());
        $this->assertSame($node, $list->peek());
        $this->assertCount(3, $list);
    }

    public function testPeekLast()
    {
        $list = new LinkedList();
        $node = $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $this->assertSame($node, $list->peek(LLI::LAST));
        $this->assertCount(3, $list);
    }

    public function testPeekInvalidPosition()
    {
        $this->expectException('PHPds\\LinkedList\\Exceptions\\InvalidNodePositionException');
        $list = new LinkedList();
        $list->peek(3);
    }

    public function testGetOnEmptyList()
    {
        $list = new LinkedList();
        $this->assertNull($list->get(0));
    }

    public function testGetWithValidIndex()
    {
        $list = new LinkedList();
        $node = $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $this->assertSame($node, $list->get(2));
    }

    public function testGetWithNegativeIndex()
    {
        $this->expectException('PHPds\\LinkedList\\Exceptions\\InvalidNodeIndexException');
        $list = new LinkedList();
        $list->get(-1);
    }

    public function testGetWithFloatIndex()
    {
        $this->expectException('PHPds\\LinkedList\\Exceptions\\InvalidNodeIndexException');
        $list = new LinkedList();
        $list->get(.1);
    }

    public function testGetWithFalseIndex()
    {
        $this->expectException('PHPds\\LinkedList\\Exceptions\\InvalidNodeIndexException');
        $list = new LinkedList();
        $list->get(false);
    }

    public function testGetWithObjectIndex()
    {
        $this->expectException('PHPds\\LinkedList\\Exceptions\\InvalidNodeIndexException');
        $list = new LinkedList();
        $list->get(new \stdClass());
    }

    public function testGetWithStringIndex()
    {
        $this->expectException('PHPds\\LinkedList\\Exceptions\\InvalidNodeIndexException');
        $list = new LinkedList();
        $list->get('index');
    }

    public function testGetWithOverflowIndex()
    {
        $list = new LinkedList();
        $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $this->assertNull($list->get(3));
    }

    public function testGetWithIndexInFirstHalf()
    {
        $list = new LinkedList();
        $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $node = $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $this->assertSame($node, $list->get(1));
    }

    public function testGetWithIndexInSecondHalf()
    {
        $list = new LinkedList();
        $list->insert(new \stdClass());
        $node = $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $this->assertSame($node, $list->get(3));
    }

    public function testGetWithIndexInTheMiddle()
    {
        $list = new LinkedList();
        $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $node = $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $this->assertSame($node, $list->get(2));
    }

    public function testRemoveNodeFromNonEmptyList()
    {
        $list = new LinkedList();
        $node1 = $list->insert(new \stdClass());
        $node2 = $list->insert(new \stdClass());
        $node3 = $list->insert(new \stdClass());
        $this->assertTrue($list->removeNode($node2));
        $this->assertCount(2, $list);
        $this->assertSame($node3, $list->peek());
        $this->assertSame($node1, $list->peek(LLI::LAST));
    }

    public function testRemoveNodeNotFound()
    {
        $list = new LinkedList();
        $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $node = new Node(new \stdClass());
        $this->assertFalse($list->removeNode($node));
    }

    public function testRemoveNodeFromMiddleLinksUpdated()
    {
        $list = new LinkedList();
        $node1 = $list->insert(new \stdClass());
        $node2 = $list->insert(new \stdClass());
        $node3 = $list->insert(new \stdClass());
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
        $list = new LinkedList();
        $node1 = $list->insert(new \stdClass());
        $node2 = $list->insert(new \stdClass());
        $node3 = $list->insert(new \stdClass());
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
        $list = new LinkedList();
        $node1 = $list->insert(new \stdClass());
        $node2 = $list->insert(new \stdClass());
        $node3 = $list->insert(new \stdClass());
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
        $list = new LinkedList();
        $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $node = new Node(new \stdClass());
        $node->setNext(new Node(new \stdClass()));
        $node->setPrevious(new Node(new \stdClass()));
        $this->assertFalse($list->removeNode($node));
        $this->assertCount(3, $list);
    }

    public function testRemoveNodeDecreaseSize()
    {
        $list = new LinkedList();
        $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $node = $list->insert(new \stdClass());
        $list->removeNode($node);
        $this->assertCount(2, $list);
    }

    public function testRemoveNodeDecreaseSizeToZero()
    {
        $list = new LinkedList();
        $node1 = $list->insert(new \stdClass());
        $node2 = $list->insert(new \stdClass());
        $list->removeNode($node1);
        $list->removeNode($node2);
        $this->assertCount(0, $list);
        $this->assertNull($list->peek());
        $this->assertNull($list->peek(LLI::LAST));
    }

    public function testRemoveOnEmptyList()
    {
        $list = new LinkedList();
        $this->assertFalse($list->remove());
    }

    public function testRemoveInvalidPosition()
    {
        $this->expectException('PHPds\\LinkedList\\Exceptions\\InvalidNodePositionException');
        $list = new LinkedList();
        $list->remove(3);
    }

    public function testRemoveFirst()
    {
        $list = new LinkedList();
        $node1 = $list->insert(new \stdClass());
        $node2 = $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $this->assertTrue($list->remove());
        $this->assertSame($node2, $node1->getPrevious());
        $this->assertSame($node1, $node2->getNext());
        $this->assertSame($node2, $list->peek());
        $this->assertSame($node1, $list->peek(LLI::LAST));
    }

    public function testRemoveLast()
    {
        $list = new LinkedList();
        $list->insert(new \stdClass());
        $node2 = $list->insert(new \stdClass());
        $node3 = $list->insert(new \stdClass());
        $this->assertTrue($list->remove(LLI::LAST));
        $this->assertSame($node3, $node2->getPrevious());
        $this->assertSame($node2, $node3->getNext());
        $this->assertSame($node3, $list->peek());
        $this->assertSame($node2, $list->peek(LLI::LAST));
    }

    public function testRemoveFirstFromTwoNodes()
    {
        $list = new LinkedList();
        $node = $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $this->assertTrue($list->remove());
        $this->assertNull($node->getPrevious());
        $this->assertNull($node->getNext());
        $this->assertSame($node, $list->peek());
        $this->assertSame($node, $list->peek(LLI::LAST));
    }

    public function testRemoveLastFromTwoNodes()
    {
        $list = new LinkedList();
        $list->insert(new \stdClass());
        $node = $list->insert(new \stdClass());
        $this->assertTrue($list->remove(LLI::LAST));
        $this->assertNull($node->getPrevious());
        $this->assertNull($node->getNext());
        $this->assertSame($node, $list->peek());
        $this->assertSame($node, $list->peek(LLI::LAST));
    }

    public function testRemoveOnlyNode()
    {
        $list = new LinkedList();
        $list->insert(new \stdClass());
        $this->assertTrue($list->remove());
        $this->assertNull($list->peek());
        $this->assertNull($list->peek(LLI::LAST));
    }

    public function testPopFirstRemovesNode()
    {
        $list = new LinkedList();
        $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $node = $list->insert(new \stdClass());
        $this->assertSame($node, $list->pop());
        $this->assertCount(2, $list);
    }

    public function testPopFirstHasCorrectHead()
    {
        $list = new LinkedList();
        $list->insert(new \stdClass());
        $node = $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $list->pop();
        $this->assertSame($node, $list->peek());
    }

    public function testPopFirstHasCorrectLinks()
    {
        $list = new LinkedList();
        $node1 = $list->insert(new \stdClass());
        $node2 = $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $list->pop();
        $this->assertSame($node1, $node2->getNext());
        $this->assertSame($node2, $node1->getPrevious());
        $this->assertNull($node2->getPrevious());
    }

    public function testPopLastRemovesNode()
    {
        $list = new LinkedList();
        $node = $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $this->assertEquals($node, $list->pop(LLI::LAST));
        $this->assertCount(2, $list);
    }

    public function testPopLastHasCorrectTail()
    {
        $list = new LinkedList();
        $list->insert(new \stdClass());
        $node = $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $list->pop(LLI::LAST);
        $this->assertSame($node, $list->peek(LLI::LAST));
    }

    public function testPopLastHasCorrectLinks()
    {
        $list = new LinkedList();
        $list->insert(new \stdClass());
        $node1 = $list->insert(new \stdClass());
        $node2 = $list->insert(new \stdClass());
        $list->pop(LLI::LAST);
        $this->assertSame($node1, $node2->getNext());
        $this->assertSame($node2, $node1->getPrevious());
        $this->assertNull($node1->getNext());
    }

    public function testPopOneNodeInList()
    {
        $list = new LinkedList();
        $list->insert(new \stdClass());
        $list->pop();
        $this->assertNull($list->peek());
        $this->assertNull($list->peek(LLI::LAST));
    }

    public function testPopFirstEmptyList()
    {
        $list = new LinkedList();
        $this->assertNull($list->pop());
    }

    public function testPopLastEmptyList()
    {
        $list = new LinkedList();
        $this->assertNull($list->pop(LLI::LAST));
    }

    public function testPopInvalidPosition()
    {
        $this->expectException('PHPds\\LinkedList\\Exceptions\\InvalidNodePositionException');
        $list = new LinkedList();
        $list->pop(3);
    }

    public function testPopFirstHasNullPointers()
    {
        $list = new LinkedList();
        $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $node = $list->pop();
        $this->assertNull($node->getNext());
        $this->assertNull($node->getPrevious());
    }

    public function testPopLastHasNullPointers()
    {
        $list = new LinkedList();
        $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $node = $list->pop(LLI::LAST);
        $this->assertNull($node->getNext());
        $this->assertNull($node->getPrevious());
    }

    public function testCountEmptyList()
    {
        $list = new LinkedList();
        $this->assertEquals(0, $list->count());
    }

    public function testCountIncrease()
    {
        $list = new LinkedList();
        $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $this->assertEquals(3, $list->count());
    }

    public function testCountDecrease()
    {
        $list = new LinkedList();
        $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $list->remove();
        $this->assertEquals(2, $list->count());
    }

    public function testCountDecreaseToZero()
    {
        $list = new LinkedList();
        $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $list->insert(new \stdClass());
        $list->remove();
        $list->remove();
        $list->remove();
        $this->assertEquals(0, $list->count());
    }

    public function invalidKeyProvider()
    {
        return [
            [new \stdClass()],
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
