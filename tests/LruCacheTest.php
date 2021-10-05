<?php

namespace Tests;

use App\LruCache;
use PHPUnit\Framework\TestCase;

class LruCacheTest extends TestCase
{

    /**
     * @covers \App\LruCache::put
     */
    public function testPut()
    {
        $lru = new LruCache(3);
        $lru->put(1, 1);
        $this->assertEquals('1', $lru->getCsv());
        $lru->put(2, 2);
        $this->assertEquals('2,1', $lru->getCsv());
        $lru->put(3, 3);
        $this->assertEquals('3,2,1', $lru->getCsv());
        $lru->put(4, 4);
        $this->assertEquals('4,3,2', $lru->getCsv());
        $lru->put(3, 3);
        $this->assertEquals('3,4,2', $lru->getCsv());
        $lru->put(1, 1);
        $this->assertEquals('1,3,4', $lru->getCsv());
    }

    /**
     * @covers \App\LruCache::get
     */
    public function testGet()
    {
        $lru = new LruCache(3);
        $lru->put(1, 1);
        $this->assertEquals(1, $lru->get(1));
        $this->assertEquals(-1, $lru->get(2));
        $this->assertEquals('1', $lru->getCsv());
        $lru->put(2, 2);
        $this->assertEquals('2,1', $lru->getCsv());
        $this->assertEquals(1, $lru->get(1));
        $this->assertEquals('1,2', $lru->getCsv());
        $this->assertEquals(2, $lru->get(2));
        $this->assertEquals('2,1', $lru->getCsv());
        $this->assertEquals(1, $lru->get(1));
        $this->assertEquals('1,2', $lru->getCsv());

        $this->assertEquals(-1, $lru->get(4));
        $this->assertEquals('1,2', $lru->getCsv());

        $this->assertEquals(1, $lru->get(1));
        $this->assertEquals('1,2', $lru->getCsv());
        $this->assertEquals(1, $lru->get(1));
        $this->assertEquals('1,2', $lru->getCsv());
        $lru->put(3, 3);
        $this->assertEquals(3, $lru->get(3));
        $this->assertEquals('3,1,2', $lru->getCsv());

        $lru->put(4, 4);
        $this->assertEquals('4,3,1', $lru->getCsv());

        $this->assertEquals(4, $lru->get(4));
        $this->assertEquals('4,3,1', $lru->getCsv());

        $this->assertEquals(1, $lru->get(1));
        $this->assertEquals('1,4,3', $lru->getCsv());
    }
}
