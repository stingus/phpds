<?php

namespace PHPds\Queue;

use PHPds\LinkedList\LinkedList;
use PHPds\LinkedList\LinkedListArray;

/**
 * Class Queue.
 * Queue data structure
 *
 * @package PHPds\Queue
 */
class Queue implements QueueInterface, \Countable
{
    /** @var LinkedList */
    private $list;

    /**
     * Queue constructor.
     * @param string $dataType Data type class, instance of PHPdt\DataType\DataTypeInterface
     */
    public function __construct($dataType)
    {
        $this->list = new LinkedList($dataType);
    }

    /**
     * @inheritdoc
     */
    public function enqueue($data)
    {
        return $this->list->insert($data)->getData();
    }

    /**
     * @inheritdoc
     */
    public function dequeue()
    {
        return $this->list->pop(LinkedList::LAST)->getData();
    }

    /**
     * @inheritdoc
     */
    public function peek()
    {
        return $this->list->peek(LinkedList::LAST)->getData();
    }

    /**
     * @inheritdoc
     */
    public function has($data)
    {
        $iterator = new LinkedListArray($this->list);
        while ($iterator->valid()) {
            if ($iterator->current()->getData() === $data) {
                return true;
            }
            $iterator->next();
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function count()
    {
        return $this->list->count();
    }
}
