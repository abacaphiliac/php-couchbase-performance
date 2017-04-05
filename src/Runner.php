<?php

namespace Abacaphiliac\PhpCouchbasePerformance;

use Abacaphiliac\PhpCouchbasePerformance\Adapter\AdapterInterface;
use Ramsey\Uuid\Uuid;

class Runner
{
    /** @var AdapterInterface */
    private $adapter;
    
    /** @var Options */
    private $options;
    
    /**
     * Runner constructor.
     * @param AdapterInterface $adapter
     * @param Options $options
     */
    public function __construct(AdapterInterface $adapter, Options $options)
    {
        $this->adapter = $adapter;
        $this->options = $options;
    }
    
    /**
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= $this->options->getInsertCount(); $i++) {
            $key = Uuid::uuid4()->toString();
        
            $this->adapter->set($key, $this->options->getTtl());
        
            for ($j = 1; $j <= $this->options->getFetchPerInsert(); $j++) {
                $this->adapter->get($key);
            }
        }
    }
}
