<?php

namespace PHPds\LinkedList;

/**
 * Interface NodeInterface
 * @package PHPds\LinkedList
 */
interface NodeInterface
{
    /**
     * Get the Node data
     *
     * @return mixed
     */
    public function getData();

    /**
     * Get the next Node
     *
     * @return NodeInterface
     */
    public function getNext();

    /**
     * Set the link to the next Node
     *
     * @param NodeInterface $next
     */
    public function setNext(NodeInterface $next = null);

    /**
     * Get the previous Node
     *
     * @return NodeInterface
     */
    public function getPrevious();

    /**
     * Set the link to the previous Node
     *
     * @param NodeInterface $previous
     */
    public function setPrevious(NodeInterface $previous = null);
}
