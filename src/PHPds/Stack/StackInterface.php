<?php

namespace PHPds\Stack;

use PHPdt\DataType\DataTypeInterface;

/**
 * Interface StackInterface
 * @package PHPds\Stack
 */
interface StackInterface
{
    /**
     * Push an element at the end of the stack
     *
     * @param mixed $data
     * @return mixed $data
     */
    public function push($data);

    /**
     * Get the last element and remove it from the stack
     *
     * @return DataTypeInterface
     */
    public function pop();

    /**
     * Get the last element of the stack
     *
     * @return DataTypeInterface
     */
    public function peek();

    /**
     * Check whether the data is present in the stack.
     * The comparison is strict!
     *
     * @param mixed $data
     * @return bool
     */
    public function has($data);
}
