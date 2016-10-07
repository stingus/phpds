<?php

namespace PHPds\Stack;

use PHPdt\DataType\Exceptions\DataTypeImplementationException;
use PHPdt\DataType\ValidationTypeTrait;

/**
 * Class Stack.
 * Stack data structure
 *
 * @package PHPds\Stack
 */
class Stack implements StackInterface, \Countable
{
    use ValidationTypeTrait;

    /**
     * Data type of the stack elements
     *
     * @var string
     */
    private $dataType;

    /**
     * Stack data
     *
     * @var array
     */
    private $data;

    /**
     * StackInterface constructor.
     * Data type can be any DataTypeInterface object
     *
     * @param string $dataType
     * @throws DataTypeImplementationException
     */
    public function __construct($dataType)
    {
        $this->dataType = $dataType;
        $this->data = [];
    }

    /**
     * @inheritdoc
     */
    public function push($data)
    {
        $this->validateType($data, $this->dataType);
        return $this->data[] = $data;
    }

    /**
     * @inheritdoc
     */
    public function pop()
    {
        return array_pop($this->data);
    }

    /**
     * @inheritdoc
     */
    public function peek()
    {
        return end($this->data);
    }

    /**
     * @inheritdoc
     */
    public function has($data)
    {
        return in_array($data, $this->data, true);
    }

    /**
     * @inheritdoc
     */
    public function count()
    {
        return count($this->data);
    }
}
