<?php

namespace PHPds\LinkedList;

/**
 * Class Node
 * @package PHPds\LinkedList
 */
class Node implements NodeInterface
{
    /**
     * @var mixed Data held by Node
     */
    private $data;

    /**
     * @var NodeInterface
     */
    private $next;

    /**
     * @var NodeInterface
     */
    private $previous;

    /**
     * @inheritDoc
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @inheritdoc
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @inheritdoc
     */
    public function getNext()
    {
        return $this->next;
    }

    /**
     * @inheritdoc
     */
    public function setNext(NodeInterface $node = null)
    {
        $this->next = $node;
    }

    /**
     * @inheritdoc
     */
    public function getPrevious()
    {
        return $this->previous;
    }

    /**
     * @inheritdoc
     */
    public function setPrevious(NodeInterface $previous = null)
    {
        $this->previous = $previous;
    }
}
