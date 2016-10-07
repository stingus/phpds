<?php

namespace PHPds\LinkedList;

use PHPds\LinkedList\Exceptions\InvalidNodeIndexException;
use PHPds\LinkedList\Exceptions\InvalidNodePositionException;
use PHPds\LinkedList\Exceptions\OutOfBoundsIndexException;

/**
 * Interface LinkedListInterface
 * @package PHPds\LinkedList
 */
interface LinkedListInterface extends \Countable
{
    /** Node positioning */
    const FIRST = 1;
    const LAST  = 2;

    /**
     * Create a Node and add it in the LinkedList, either at the beginning or at the end
     *
     * @param mixed $data     Node data
     * @param int   $position First or Last position
     * @return Node
     * @throws InvalidNodePositionException
     */
    public function insert($data, $position = self::FIRST);

    /**
     * Insert a Node at a certain index.
     * Index is in the range [0..list_size - 1]. It is recommended to use the insert() method because it has O(1)
     * time complexity
     *
     * @param int   $index Node index
     * @param mixed $data  Node data
     * @return NodeInterface
     * @throws InvalidNodeIndexException
     * @throws OutOfBoundsIndexException
     */
    public function insertAt($index, $data);

    /**
     * Remove a Node, either the first one or the last one
     *
     * @param int $position First or Last position
     * @return bool True if Node was found and removed, False if not
     */
    public function remove($position = self::FIRST);

    /**
     * Remove a Node from the LinkedList
     *
     * @param NodeInterface $node
     * @return bool True if Node was found and removed, False if not
     */
    public function removeNode(NodeInterface $node);

    /**
     * Search if the given data is stored in one or more LinkedList Nodes
     *
     * @param $data
     * @return NodeInterface[] | null
     */
    public function search($data);

    /**
     * Check if a Node is found in the LinkedList
     *
     * @param NodeInterface $node
     * @return bool
     */
    public function has(NodeInterface $node);

    /**
     * Get Node found at index
     *
     * @param int $index Node index
     * @return NodeInterface | null
     */
    public function get($index);

    /**
     * Pop the first or the last Node.
     * Returns the Node and removes it from the LinkedList
     *
     * @param int $position First or Last position
     * @return NodeInterface | null
     */
    public function pop($position = self::FIRST);

    /**
     * Peek at the first or the last Node.
     * Returns the Node and but doesn't remove it from the LinkedList
     *
     * @param int $position First or Last position
     * @return NodeInterface | null
     */
    public function peek($position = self::FIRST);
}
