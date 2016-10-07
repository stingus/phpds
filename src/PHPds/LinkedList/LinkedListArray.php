<?php

namespace PHPds\LinkedList;

/**
 * Class LinkedListArray
 * @package PHPds\LinkedList
 */
class LinkedListArray implements \ArrayAccess, \Iterator
{
    /**
     * @var LinkedList
     */
    private $list;

    /**
     * @var int
     */
    private $current;

    /**
     * LinkedListArray constructor.
     * @param LinkedList $list
     */
    final public function __construct(LinkedList $list)
    {
        $this->list = $list;
        $this->current = 0;
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        return $this->list->count() > $offset;
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return $this->list->get($offset);
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        return $this->list->insertAt($offset, $value);
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        $result = false;
        switch ($offset) {
            case 0:
                $result = $this->list->remove();
                break;
            case ($this->list->count() - 1):
                $result = $this->list->remove(LinkedListInterface::LAST);
                break;
            default:
                $node = $this->list->get($offset);
                if (null !== $node) {
                    $result = $this->list->removeNode($node);
                }
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function current()
    {
        return $this->list->get($this->current);
    }

    /**
     * @inheritDoc
     */
    public function next()
    {
        ++$this->current;
    }

    /**
     * @inheritDoc
     */
    public function key()
    {
        return $this->current;
    }

    /**
     * @inheritDoc
     */
    public function valid()
    {
        if (false === filter_var($this->current, FILTER_VALIDATE_INT)
            || $this->current < 0
            || $this->current >= $this->list->count()
        ) {
            return false;
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        $this->current = 0;
    }
}
