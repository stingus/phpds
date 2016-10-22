<?php

namespace PHPds\Queue;

use PHPds\DataList\DataList;
use PHPds\LinkedList\LinkedList;

/**
 * Class Queue.
 * Queue data structure
 *
 * @package PHPds\Queue
 */
class Queue extends DataList implements QueueInterface
{
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
}
