<?php

namespace App;

class LruCache
{
    protected int $size;
    protected array $hash = [];
    protected ?LruCacheNode $head = null;
    protected ?LruCacheNode $tail = null;

    public function __construct(int $size)
    {
        $this->size = $size;
    }

    protected function getTail(): ?LruCacheNode
    {
        $node = $this->head;
        while (null !== $node && null !== $node->getNext()) {
            $node = $node->getNext();
        }
        return $node;
    }

    protected function moveToHead(LruCacheNode $node)
    {
        if ($node === $this->head) {
            return;
        }

        if (null !== $node->getPrev()) {
            $node->getPrev()->setNext($node->getNext());
        }

        if (null !== $node->getNext()) {
            $node->getNext()->setPrev($node->getPrev());
        }

        $node->setNext($this->head);
        if (null !== $this->head) {
            $this->head->setPrev($node);
        }

        $this->head = $node;
        $this->tail = $this->getTail();
    }

    public function put($key, $value)
    {
        $node = $this->hash[$key] ?? new LruCacheNode($key, $value);

        // now move this node to the head
        $this->moveToHead($node);
        $this->tail = $this->getTail();

        $this->hash[$key] = $node;

        if (count($this->hash) > $this->size) {
            // need to delete tail's key from the hash
            unset($this->hash[$this->tail->getKey()]);
            // unlink the tail and set the tail to the new tail
            if (null !== $this->tail->getPrev()) {
                $this->tail->getPrev()->setNext(null);
                $this->tail = $this->tail->getPrev();
            }
        }
    }

    public function get($key): int
    {
        // if not found, just return -1
        if (!isset($this->hash[$key])) {
            return -1;
        }

        // otherwise grab the matching node and move it to the head
        $node = $this->hash[$key];

        // detach this node by relinking its next and prev
        $this->moveToHead($node);

        return $node->getValue();
    }

    public function getCsv(): string
    {
        return $this->__toString();
    }

    public function __toString()
    {
        return null !== $this->head ? $this->head->__toString() : 'nil';
    }
}
