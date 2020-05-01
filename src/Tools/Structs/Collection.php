<?php

namespace Sokil\Viber\Notifier\Tools\Structs;

abstract class Collection implements \Iterator, \Countable
{
    /**
     * @var array
     */
    private $collection = [];

    /**
     * @param array $collection
     */
    public function __construct(array $collection)
    {
        foreach ($collection as $element) {
            $this->assert($element);
        }

        $this->collection = array_values($collection);
    }

    /**
     * Validate element
     *
     * @param mixed $element
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    abstract protected function assert($element);

    /**
     * Return the current element
     *
     * @return mixed
     *
     * @throws \OutOfRangeException
     */
    public function current()
    {
        return $this->collection[$this->key()];
    }

    /**
     * Move forward to next element
     *
     * @return void
     */
    public function next()
    {
        next($this->collection);
    }

    /**
     * Return the key of the current element
     *
     * @return string|float|int|bool|null scalar on success, or null on failure.
     *
     * @throws \OutOfRangeException
     */
    public function key()
    {
        return key($this->collection);
    }

    /**
     * Checks if current position is valid
     *
     * @return bool
     */
    public function valid()
    {
        return $this->key() !== null;
    }

    /**
     * Rewind the Iterator to the first element
     *
     * @return void
     */
    public function rewind()
    {
        reset($this->collection);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->collection;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->collection);
    }

    /**
     * @param int $index
     *
     * @return mixed
     */
    public function get($index)
    {
        if (!is_integer($index)) {
            throw new \InvalidArgumentException('Index must be positive integer');
        }

        if ($index >= count($this) || $index < 0) {
            throw new \OutOfBoundsException(sprintf('Index %s out of bounds', $index));
        }

        return $this->collection[$index];
    }

    /**
     * @param callable $filter
     *
     * @return Collection
     */
    public function filter(callable $filter)
    {
        return new static(array_filter($this->collection, $filter));
    }

    /**
     * @param callable $mapper
     *
     * @return array
     */
    public function map(callable $mapper)
    {
        return array_map($mapper, $this->collection);
    }

    /**
     * @param callable $reducer
     * @param mixed $initialCarry
     *
     * @return mixed
     */
    public function reduce(callable $reducer, $initialCarry = [])
    {
        return array_reduce($this->collection, $reducer, $initialCarry);
    }

    /**
     * @param callable $sortingFunction
     *
     * @return Collection
     *
     */
    public function sort(callable $sortingFunction)
    {
        $elements = $this->collection;

        usort($elements, $sortingFunction);

        return new static($elements);
    }

    /**
     * Return a collection with elements in reverse order
     *
     * @return Collection
     */
    public function reverse()
    {
        $elements = array_reverse($this->collection);

        return new static($elements);
    }
}