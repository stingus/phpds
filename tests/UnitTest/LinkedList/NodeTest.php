<?php

namespace PHPds\UnitTest\LinkedList;

use PHPds\LinkedList\Node;
use PHPUnit_Framework_TestCase;

/**
 * Class NodeTest
 * @package UnitTest\LinkedList
 * @group Unit
 */
class NodeTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider nodeDataProvider
     * @param $data
     */
    public function testNodeCreateWithData($data)
    {
        $node = new Node($data);
        $this->assertSame($data, $node->getData());
    }

    public function nodeDataProvider()
    {
        return [
            [new \stdClass()],
            ['abc'],
            [''],
            [123],
            [-123],
            [.1],
            [true],
            [false],
            [[1,2,3]],
            [null]
        ];
    }
}
