<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
//phpinfo();
require_once dirname(__DIR__).'/vendor/autoload.php';

try {
    $mongoDbUri = 'mongodb://mongo:27017/';
    $client = new \MongoDB\Client($mongoDbUri);
    $collection = $client->test;
    $collection->drop();

    $filename = 'https://media.mongodb.org/zips.json';
    $lines = file($filename, FILE_IGNORE_NEW_LINES);

    $bulk = new \MongoDB\Driver\BulkWrite();
    foreach ($lines as $line) {
        $bson = \MongoDB\BSON\fromJSON($line);
        $document = \MongoDB\BSON\toPHP($bson);
        $bulk->insert($document);
    }

    $manager = new \MongoDB\Driver\Manager($mongoDbUri);

    $result = $manager->executeBulkWrite('test.zips', $bulk);
    printf("Inserted %d documents\n", $result->getInsertedCount());
} catch (\Exception $exception) {
    echo 'An error occurred during data send to MongoDB: ', $exception->getMessage(), '\n';
}