<?php

namespace App;

class LruCacheNode
{
    /** @var mixed */
    protected $key;

    /** @var mixed */
    protected $value;

    protected ?LruCacheNode $prev = null;
    protected ?LruCacheNode $next = null;

    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setNext(?LruCacheNode $next): void
    {
        $this->next = $next;
    }

    public function setPrev(?LruCacheNode $prev): void
    {
        $this->prev = $prev;
    }

    public function getNext(): ?LruCacheNode
    {
        return $this->next;
    }

    public function getPrev(): ?LruCacheNode
    {
        return $this->prev;
    }

    public function __toString()
    {
        $nextVal = '';
        if (null !== $this->next && $this->next !== $this) {
            $nextVal = $this->next->__toString();
        }
        if ($nextVal !== '') {
            $nextVal = ',' . $nextVal;
        }
        return $this->value . $nextVal;
    }
}
