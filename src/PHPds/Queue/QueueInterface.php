<?php

namespace PHPds\Queue;

use PHPdt\DataType\DataTypeInterface;
use PHPdt\DataType\Exceptions\InvalidDataTypeException;

/**
 * Interface QueueInterface
 * @package PHPds\Queue
 */
interface QueueInterface
{
    /**
     * Add an element at the end of the queue
     *
     * @param mixed $data
     * @return mixed $data
     * @throws InvalidDataTypeException
     */
    public function enqueue($data);

    /**
     * Get the first element in line and remove it from the queue
     *
     * @return DataTypeInterface
     */
    public function dequeue();

    /**
     * Get the first element in line
     *
     * @return DataTypeInterface
     */
    public function peek();

    /**
     * Check whether the data is present in the queue.
     * The comparison is strict!
     *
     * @param mixed $data
     * @return bool
     */
    public function has($data);
}
