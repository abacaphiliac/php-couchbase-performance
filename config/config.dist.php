<?php

return [
    'couchbase_dsn' => getenv('TEST_COUCHBASE_DSN') ?: 'couchbase://localhost',
    'couchbase_bucket' => getenv('TEST_COUCHBASE_BUCKET') ?: 'default',
    'fetch_per_insert' => getenv('TEST_FETCH_PER_INSERT') ?: 2,
    'ttl' => getenv('TEST_TTL') ?: 60,
    'memcache_servers' => getenv('TEST_MEMCACHE_SERVERS') ?: 'localhost:11211',
];
