<?php

require __DIR__ . '/../vendor/autoload.php';

$options = \Abacaphiliac\PhpCouchbasePerformance\Options::fromFiles([
    __DIR__ . '/../config/config.php',
    __DIR__ . '/../config/config.dist.php'
]);

$adapter = new \Abacaphiliac\PhpCouchbasePerformance\Adapter\Memcache($options);

\Assert\Assertion::isArray($argv);
\Assert\Assertion::keyExists($argv, 1);
$options->setInsertCount($argv[1]);

(new \Abacaphiliac\PhpCouchbasePerformance\Runner($adapter, $options))->run();
