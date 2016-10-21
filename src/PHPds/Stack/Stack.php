<?php

namespace PHPds\Stack;

use PHPds\LinkedList\LinkedList;
use PHPds\LinkedList\LinkedListArray;

/**
 * Class Stack.
 * Stack data structure
 *
 * @package PHPds\Stack
 */
class Stack implements StackInterface, \Countable
{
    /** @var LinkedList */
    private $list;

    /**
     * Stack constructor.
     * @param string $dataType Data type class, instance of PHPdt\DataType\DataTypeInterface
     */
    public function __construct($dataType)
    {
        $this->list = new LinkedList($dataType);
    }

    /**
     * @inheritdoc
     */
    public function push($data)
    {
        return $this->list->insert($data, LinkedList::LAST)->getData();
    }

    /**
     * @inheritdoc
     */
    public function pop()
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
