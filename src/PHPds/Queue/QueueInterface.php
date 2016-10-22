<?php

namespace PHPds\Queue;

use PHPds\DataList\DataListInterface;
use PHPdt\DataType\DataTypeInterface;

/**
 * Interface QueueInterface
 * @package PHPds\Queue
 */
interface QueueInterface extends DataListInterface
{
    /**
     * Add an element at the end of the queue
     *
     * @param mixed $data
     * @return mixed $data
     */
    public function enqueue($data);

    /**
     * Get the first element in line and remove it from the queue
     *
     * @return DataTypeInterface
     */
    public function dequeue();
}
