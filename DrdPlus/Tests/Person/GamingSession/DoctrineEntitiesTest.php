<?php
namespace DrdPlus\Tests\Person\GamingSession;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Setup;
use DrdPlus\Person\GamingSession\EnumTypes\GamingSessionCategoryExperiencesType;
use DrdPlus\Person\GamingSession\GamingSession;
use DrdPlus\Person\GamingSession\GamingSessionCategoryExperiences;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Tests\Fixtures\DummyOutput;

class DoctrineEntitiesTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Symfony\Component\Console\Application */
    private $application;

    /** @var  EntityManager */
    private $entityManager;

    /** @var string */
    private $proxiesUniqueTempDir;

    protected function setUp()
    {
        if (!extension_loaded('pdo_sqlite')) {
            self::markTestSkipped('The pdo_sqlite extension is not available.');
        }

        GamingSessionCategoryExperiencesType::registerSelf();
        self::assertTrue(GamingSessionCategoryExperiencesType::isRegistered());

        $paths = [str_replace(DIRECTORY_SEPARATOR . 'Tests', '', __DIR__)];
        $config = Setup::createAnnotationMetadataConfiguration($paths, true /* dev mode */);
        $cache = new \Doctrine\Common\Cache\ArrayCache();
        $config->setMetadataCacheImpl($cache);
        $config->setQueryCacheImpl($cache);
        $driver = new \Doctrine\ORM\Mapping\Driver\AnnotationDriver(
            new \Doctrine\Common\Annotations\AnnotationReader(),
            $paths
        );
        $config->setMetadataDriverImpl($driver);
        $this->entityManager = EntityManager::create(
            [
                'driver' => 'pdo_sqlite',
                'path' => ':memory:',
            ],
            $config
        );

        $helperSet = ConsoleRunner::createHelperSet($this->entityManager);
        $this->application = \Doctrine\ORM\Tools\Console\ConsoleRunner::createApplication($helperSet);
        $this->application->setAutoExit(false);
    }

    protected function tearDown()
    {
        $this->entityManager->getConnection()->close();
        if ($this->proxiesUniqueTempDir !== null) {
            $this->removeDirectory($this->proxiesUniqueTempDir);
        }
    }

    private function removeDirectory($dir)
    {
        foreach (scandir($dir) as $folder) {
            if ($folder === '.' || $folder === '..') {
                continue;
            }
            $folderFullPath = $dir . DIRECTORY_SEPARATOR . $folder;
            if (is_dir($folderFullPath)) {
                $this->removeDirectory($folderFullPath);
            } else {
                unlink($folderFullPath);
            }
        }
        rmdir($dir);
    }

    /**
     * @test
     */
    public function I_can_persist_and_fetch_entities()
    {
        $this->I_can_create_schema();
        $this->I_can_generate_proxies();

        $gamingSession = new GamingSession(
            GamingSessionCategoryExperiences::getIt(0),
            GamingSessionCategoryExperiences::getIt(1),
            GamingSessionCategoryExperiences::getIt(2),
            GamingSessionCategoryExperiences::getIt(3),
            GamingSessionCategoryExperiences::getIt(2),
            'foo'
        );
        $this->entityManager->persist($gamingSession);
        $this->entityManager->flush();
        $gamingSessionId = $gamingSession->getId();
        $this->entityManager->clear();
        $fetchedGamingSession = $this->entityManager->getRepository(GamingSession::class)->find($gamingSessionId);
        self::assertEquals(
            $gamingSession,
            $fetchedGamingSession,
            'Persisted and fetched back entity should has same content'
        );
        self::assertNotSame(
            $gamingSession,
            $fetchedGamingSession,
            'After clearing entity manager the fetched back entity should not be the very same instance'
        );

        $this->I_can_drop_schema();
    }

    private function I_can_create_schema()
    {
        $exitCode = $this->application->run(new StringInput('orm:schema-tool:create'), $output = new DummyOutput());
        self::assertSame(0, $exitCode, $output->fetch());
    }

    private function I_can_generate_proxies()
    {
        $exitCode = $this->application->run(
            new StringInput('orm:generate:proxies ' . $this->getProxiesUniqueTempDir()),
            $output = new DummyOutput()
        );
        self::assertSame(0, $exitCode, $output->fetch());

        self::assertSame(
            [
                '__CG__' . str_replace('\\', '', GamingSession::class) . '.php'
            ],
            array_merge( // rebuilding array to reset keys
                array_filter(
                    scandir($this->getProxiesUniqueTempDir()),
                    function ($folderName) {
                        return $folderName !== '.' && $folderName !== '..';
                    }
                )
            )
        );
    }

    /**
     * @return string
     */
    private function getProxiesUniqueTempDir()
    {
        if ($this->proxiesUniqueTempDir === null) {
            $this->proxiesUniqueTempDir = sys_get_temp_dir() . '/' . uniqid('orm-proxies-test-', true);
        }

        return $this->proxiesUniqueTempDir;
    }

    private function I_can_drop_schema()
    {
        $exitCode = $this->application->run(new StringInput('orm:schema-tool:drop --force'), $output = new DummyOutput());
        self::assertSame(0, $exitCode, $output->fetch());
    }
}
