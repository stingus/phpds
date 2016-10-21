<?php

namespace PHPds\LinkedList;

use PHPds\LinkedList\Exceptions\InvalidNodeIndexException;
use PHPds\LinkedList\Exceptions\InvalidNodePositionException;
use PHPds\LinkedList\Exceptions\OutOfBoundsIndexException;
use PHPdt\DataType\ValidationTypeTrait;

/**
 * Class LinkedList
 * @package PHPds\LinkedList
 */
class LinkedList implements LinkedListInterface
{
    use ValidationTypeTrait;

    /**
     * LinkedList first Node
     *
     * @var NodeInterface
     */
    private $first;

    /**
     * LinkedList last Node
     *
     * @var NodeInterface
     */
    private $last;

    /**
     * LinkedList data type
     *
     * @var string
     */
    private $dataType;

    /**
     * LinkedList size
     *
     * @var int
     */
    private $size = 0;

    public function __construct($dataType)
    {
        $this->dataType = $dataType;
    }

    /**
     * @inheritDoc
     */
    public function insert($data, $position = LinkedListInterface::FIRST)
    {
        switch ($position) {
            case static::FIRST:
                $current = $this->first;
                break;
            case static::LAST:
                $current = null;
                break;
            default:
                throw new InvalidNodePositionException(
                    sprintf('Position <%s> is invalid when creating the Node', $position)
                );
        }

        return $this->createNode($data, $current);
    }

    /**
     * @inheritdoc
     */
    public function insertAt($index, $data)
    {
        if (false === filter_var($index, FILTER_VALIDATE_INT) || $index < 0) {
            throw new InvalidNodeIndexException('Invalid LinkedList index when creating a Node');
        }
        if ($index > $this->size) {
            throw new OutOfBoundsIndexException('Trying to set an out of bounds index when creating a Node');
        }

        return $this->createNode($data, $this->get($index));
    }

    /**
     * @inheritDoc
     */
    public function remove($position = self::FIRST)
    {
        switch ($position) {
            case static::FIRST:
                $node = $this->first;
                break;
            case static::LAST:
                $node = $this->last;
                break;
            default:
                throw new InvalidNodePositionException(
                    sprintf('Position <%s> is invalid when removing', $position)
                );
        }
        if (null === $node) {
            return false;
        }

        return $this->unlinkNode($node);
    }

    /**
     * @inheritDoc
     */
    public function removeNode(NodeInterface $node)
    {
        if (!$this->has($node)) {
            return false;
        }

        return $this->unlinkNode($node);
    }

    /**
     * @inheritDoc
     */
    public function search($data)
    {
        $results = [];
        $current = $this->first;
        while (null !== $current) {
            if ($current->getData() === $data) {
                $results[] = $current;
            }
            $current = $current->getNext();
        }

        return $results;
    }

    /**
     * @inheritDoc
     */
    public function has(NodeInterface $node)
    {
        $result = false;
        $current = $this->first;
        while (null !== $current) {
            if ($current === $node) {
                $result = true;
                break;
            }
            $current = $current->getNext();
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function get($index)
    {
        if (false === filter_var($index, FILTER_VALIDATE_INT) || $index < 0) {
            throw new InvalidNodeIndexException('Invalid LinkedList index');
        }
        if ($index < ($this->size >> 1)) {
            $current = $this->first;
            for ($i = 0; $i < $index; $i++) {
                $current = $current->getNext();
            }
            return $current;
        } elseif ($index < $this->size) {
            $current = $this->last;
            for ($i = $this->size - 1; $i > $index; $i--) {
                $current = $current->getPrevious();
            }
            return $current;
        }
        return null;
    }

    /**
     * @inheritDoc
     */
    public function pop($position = self::FIRST)
    {
        switch ($position) {
            case static::FIRST:
                $node = $this->first;
                break;
            case static::LAST:
                $node = $this->last;
                break;
            default:
                throw new InvalidNodePositionException(
                    sprintf('Position <%s> is invalid when popping', $position)
                );
        }

        if (null !== $node) {
            $this->unlinkNode($node);
            $node->setNext(null);
            $node->setPrevious(null);
        }

        return $node;
    }

    /**
     * @inheritDoc
     */
    public function peek($position = self::FIRST)
    {
        switch ($position) {
            case static::FIRST:
                return $this->first;
            case static::LAST:
                return $this->last;
            default:
                throw new InvalidNodePositionException(
                    sprintf('Position <%s> is invalid when peeking', $position)
                );
        }
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        return $this->size;
    }

    /**
     * Unlink a node from the list
     *
     * @param NodeInterface $node
     * @return bool
     */
    private function unlinkNode(NodeInterface $node)
    {
        $next = $node->getNext();
        $previous = $node->getPrevious();

        if (null !== $previous) {
            $previous->setNext($next);
        }
        if (null === $previous) {
            $this->first = $next;
            if (null !== $next) {
                $next->setPrevious(null);
            }
        }

        if (null !== $next) {
            $next->setPrevious($previous);
        }
        if (null === $next) {
            $this->last = $previous;
            if (null !== $previous) {
                $previous->setNext(null);
            }
        }
        $this->size--;

        return true;
    }

    /**
     * Create a Node and link it to the list
     *
     * @param mixed              $data    Node data
     * @param NodeInterface|null $current Current Node to be moved (if null, either the list is empty or Node will be
     *                                    inserted on the last position)
     * @return Node
     */
    private function createNode($data, NodeInterface $current = null)
    {
        $this->validateType($data, $this->dataType);

        $node = new Node($data);

        if ($this->size === 0) {
            // List is empty
            $this->first = $this->last = $node;
        } elseif ($this->size > 0 && null === $current) {
            // Insert as last element
            $node->setPrevious($this->last);
            $this->last->setNext($node);
            $this->last = $node;
        } elseif ($this->size > 0) {
            // Positional insert (move current next)
            $previous = $current->getPrevious();
            $current->setPrevious($node);
            $node->setNext($current);
            $node->setPrevious($previous);
            if (null !== $previous) {
                $previous->setNext(($node));
            }
            if (null === $previous) {
                $this->first = $node;
            }
        }
        $this->size++;

        return $node;
    }
}
