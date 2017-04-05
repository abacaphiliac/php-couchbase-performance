<?php

namespace Abacaphiliac\PhpCouchbasePerformance\Adapter;

interface AdapterInterface
{
    /**
     * @param string $key
     * @return string
     */
    public function get($key);
    
    /**
     * @param string $key
     * @param int $ttl
     * @return void
     */
    public function set($key, $ttl = null);
}
