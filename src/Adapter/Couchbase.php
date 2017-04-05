<?php

namespace Abacaphiliac\PhpCouchbasePerformance\Adapter;

use Abacaphiliac\PhpCouchbasePerformance\Options;
use Assert\Assertion;

class Couchbase implements AdapterInterface
{
    /** @var \CouchbaseBucket */
    private $driver;
    
    /**
     * Couchbase constructor.
     * @param Options $options
     */
    public function __construct(Options $options)
    {
        $cluster = new \CouchbaseCluster($options->getCouchbaseDsn());
        
        $this->driver = $cluster->openBucket($options->getCouchbaseBucket());
    }
    
    /**
     * @param string $key
     * @return string
     * @throws \Assert\AssertionFailedException
     */
    public function get($key)
    {
        $result = $this->driver->get($key);
        Assertion::isInstanceOf($result, '\Couchbase\Document');
        Assertion::propertyExists($result, 'error');
        Assertion::null($result->error);
    
        Assertion::propertyExists($result, 'value');
        Assertion::eq($result->value, $key);
        
        return $result->value;
    }
    
    /**
     * @param string $key
     * @param int $ttl
     * @return void
     * @throws \Assert\AssertionFailedException
     */
    public function set($key, $ttl = null)
    {
        $result = $this->driver->insert($key, $key);
        Assertion::isInstanceOf($result, '\Couchbase\Document');
        Assertion::propertyExists($result, 'error');
        Assertion::null($result->error);
    }
}
