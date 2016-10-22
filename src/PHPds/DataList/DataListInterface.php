<?php

namespace PHPds\DataList;

use PHPdt\DataType\DataTypeInterface;

/**
 * Interface DataListInterface
 * @package PHPds\DataList
 */
interface DataListInterface
{
    /**
     * Get the next element in line
     *
     * @return DataTypeInterface
     */
    public function peek();

    /**
     * Check whether the data is present in the DataList.
     * The comparison is strict!
     *
     * @param mixed $data
     * @return bool
     */
    public function has($data);
}
