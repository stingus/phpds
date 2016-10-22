<?php

namespace PHPds\Stack;

use PHPds\DataList\DataList;
use PHPds\LinkedList\LinkedList;

/**
 * Class Stack.
 * Stack data structure
 *
 * @package PHPds\Stack
 */
class Stack extends DataList implements StackInterface
{
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
}
