<?php

namespace PHPds\Stack;

use PHPds\DataList\DataListInterface;
use PHPdt\DataType\DataTypeInterface;

/**
 * Interface StackInterface
 * @package PHPds\Stack
 */
interface StackInterface extends DataListInterface
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
}
