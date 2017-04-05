<?php

namespace Abacaphiliac\PhpCouchbasePerformance;

use Assert\Assertion;
use Zend\Stdlib\AbstractOptions;

class Options extends AbstractOptions
{
    /** @var string */
    private $couchbaseDsn = 'couchbase://localhost';
    
    /** @var string */
    private $couchbaseBucket = 'default';
    
    /** @var int */
    private $insertCount = 1;
    
    /** @var int */
    private $fetchPerInsert = 1;
    
    /** @var int|null */
    private $ttl = null;
    
    /** @var array[] */
    private $memcacheServers = [];
    
    /**
     * @param string[] $files
     * @return Options
     */
    public static function fromFiles(array $files)
    {
        $config = [];
        foreach ($files as $file) {
            if (is_file($file) && is_readable($file)) {
                $config = require $file ?: [];
                break;
            }
        }
        
        Assertion::isArray($config);
        
        return new self($config);
    }
    
    /**
     * @return string
     */
    public function getCouchbaseDsn()
    {
        return $this->couchbaseDsn;
    }
    
    /**
     * @param string $couchbaseDsn
     * @return void
     * @throws \Assert\AssertionFailedException
     */
    public function setCouchbaseDsn($couchbaseDsn)
    {
        Assertion::string($couchbaseDsn);
        
        $this->couchbaseDsn = $couchbaseDsn;
    }
    
    /**
     * @return string
     */
    public function getCouchbaseBucket()
    {
        return $this->couchbaseBucket;
    }
    
    /**
     * @param string $couchbaseBucket
     * @return void
     * @throws \Assert\AssertionFailedException
     */
    public function setCouchbaseBucket($couchbaseBucket)
    {
        Assertion::string($couchbaseBucket);
        
        $this->couchbaseBucket = $couchbaseBucket;
    }
    
    /**
     * @return int
     */
    public function getInsertCount()
    {
        return $this->insertCount;
    }
    
    /**
     * @param int $insertCount
     * @return void
     * @throws \Assert\AssertionFailedException
     */
    public function setInsertCount($insertCount)
    {
        Assertion::integerish($insertCount);
        Assertion::greaterOrEqualThan($insertCount, 1);
        
        $this->insertCount = $insertCount;
    }
    
    /**
     * @return int
     */
    public function getFetchPerInsert()
    {
        return $this->fetchPerInsert;
    }
    
    /**
     * @param int $fetchPerInsert
     * @return void
     * @throws \Assert\AssertionFailedException
     */
    public function setFetchPerInsert($fetchPerInsert)
    {
        Assertion::nullOrIntegerish($fetchPerInsert);
        Assertion::greaterOrEqualThan($fetchPerInsert, 1);
        
        $this->fetchPerInsert = $fetchPerInsert;
    }
    
    /**
     * @return int|null
     */
    public function getTtl()
    {
        return $this->ttl;
    }
    
    /**
     * @param int|null $ttl
     * @return void
     */
    public function setTtl($ttl)
    {
        Assertion::nullOrIntegerish($ttl);
        
        $this->ttl = $ttl;
    }
    
    /**
     * @return array[]
     */
    public function getMemcacheServers()
    {
        return $this->memcacheServers;
    }
    
    /**
     * @param string $memcacheServers
     * @return void
     * @throws \Assert\AssertionFailedException
     */
    public function setMemcacheServers($memcacheServers)
    {
        Assertion::string($memcacheServers);
    
        $hostPortPairs = array_map('trim', explode(',', $memcacheServers));
        Assertion::greaterOrEqualThan(count($hostPortPairs), 1);
        
        $servers = [];
        foreach ($hostPortPairs as $hostPortPair) {
            $server = array_map('trim', explode(':', $hostPortPair));
            
            Assertion::keyExists($server, 0);
            Assertion::string($server[0]);
            
            Assertion::keyExists($server, 1);
            Assertion::integerish($server[1]);
            
            $servers[] = $server;
        }
        
        $this->memcacheServers = $servers;
    }
}
