<?php

namespace PHPds\DataList;

use PHPds\LinkedList\LinkedList;
use PHPds\LinkedList\LinkedListArray;

/**
 * Class DataList.
 * Abstract class implementing DataListInterface
 *
 * @package PHPds\DataList
 */
abstract class DataList implements DataListInterface, \Countable
{
    /** @var LinkedList */
    protected $list;

    /** @var LinkedListArray */
    private $iterator;

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
    public function peek()
    {
        return $this->list->peek(LinkedList::LAST)->getData();
    }

    /**
     * @inheritdoc
     */
    public function has($data)
    {
        if (null === $this->iterator) {
            $this->iterator = new LinkedListArray($this->list);
        }
        while ($this->iterator->valid()) {
            if ($this->iterator->current()->getData() === $data) {
                return true;
            }
            $this->iterator->next();
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
