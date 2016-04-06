<?php
// this file is for vendor/doctrine/bin/console and its testing purposes
use Doctrine\ORM\Tools\Console\ConsoleRunner;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$gamingSessionReflection = new \ReflectionClass(\DrdPlus\Person\GamingSession\GamingSession::class);
$projectRootDir = dirname($gamingSessionReflection->getFileName());
$paths = [$projectRootDir];
$config = Setup::createAnnotationMetadataConfiguration($paths, true /* dev mode */);
$cache = new \Doctrine\Common\Cache\ArrayCache();
$config->setMetadataCacheImpl($cache);
$config->setQueryCacheImpl($cache);
$driver = new \Doctrine\ORM\Mapping\Driver\AnnotationDriver(
    new \Doctrine\Common\Annotations\AnnotationReader(),
    $paths
);
$config->setMetadataDriverImpl($driver);

$gamingSessionTestReflection = new \ReflectionClass(\DrdPlus\Tests\Person\GamingSession\GamingSessionTest::class);
$testsRootDir = dirname($gamingSessionTestReflection->getFileName());
$entityManager = EntityManager::create(
    [
        'driver' => 'pdo_sqlite',
        'path' => ':memory:',
    ],
    $config
);


return ConsoleRunner::createHelperSet($entityManager);
