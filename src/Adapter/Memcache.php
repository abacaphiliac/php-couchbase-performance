<?php

namespace Abacaphiliac\PhpCouchbasePerformance\Adapter;

use Abacaphiliac\PhpCouchbasePerformance\Options;
use Assert\Assertion;

class Memcache implements AdapterInterface
{
    /** @var \Memcache */
    private $driver;
    
    /**
     * Couchbase constructor.
     * @param Options $options
     */
    public function __construct(Options $options)
    {
        $this->driver = new \Memcache();
    
        $servers = $options->getMemcacheServers();
        Assertion::greaterOrEqualThan(count($servers), 1);
        
        foreach ($servers as $server) {
            $this->driver->addServer($server[0], $server[1]);
        }
    }
    
    /**
     * @param string $key
     * @return string
     * @throws \Assert\AssertionFailedException
     */
    public function get($key)
    {
        $result = $this->driver->get($key);
        Assertion::eq($result, $key);
        
        return $result;
    }
    
    /**
     * @param string $key
     * @param int $ttl
     * @return void
     * @throws \Assert\AssertionFailedException
     */
    public function set($key, $ttl = null)
    {
        $result = $this->driver->set($key, $key, null, $ttl);
        
        Assertion::true($result);
    }
}
