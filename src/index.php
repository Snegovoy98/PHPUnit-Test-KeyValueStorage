<?php

require_once __DIR__.'/../vendor/autoload.php';

use Snegovoy\App\{InMemoryStorageData,JsonKeyValueStorage,YmlKeyValueStorage};

$storage = new InMemoryStorageData();

$storage->set('array', ['style'=>'css','script'=>'js']);

$storage->get('array');

$storageJson = new JsonKeyValueStorage(__DIR__.'/../data/storage.json');

$storageJson->clear();

$storageYml = new YmlKeyValueStorage(__DIR__.'/../data/storage.yaml');


$storageYml->clear();

