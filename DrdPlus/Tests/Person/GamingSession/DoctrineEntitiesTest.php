<?php
namespace DrdPlus\Tests\Person\GamingSession;

use Doctrine\ORM\EntityManager;
use Doctrineum\Tests\Entity\AbstractDoctrineEntitiesTest;
use DrdPlus\Person\GamingSession\EnumTypes\GamingSessionCategoryExperiencesType;
use DrdPlus\Person\GamingSession\GamingSession;
use DrdPlus\Person\GamingSession\GamingSessionCategoryExperiences;

class DoctrineEntitiesTest extends AbstractDoctrineEntitiesTest
{
    protected function setUp()
    {
        GamingSessionCategoryExperiencesType::registerSelf();
        self::assertTrue(GamingSessionCategoryExperiencesType::isRegistered());

        parent::setUp();
    }

    protected function getDirsWithEntities()
    {
        return [
            str_replace(DIRECTORY_SEPARATOR . 'Tests', '', __DIR__),
        ];
    }

    protected function getExpectedEntityClasses()
    {
        return [
            GamingSession::class,
        ];
    }

    protected function createEntitiesToPersist()
    {
        return [
            new GamingSession(
                GamingSessionCategoryExperiences::getIt(0),
                GamingSessionCategoryExperiences::getIt(1),
                GamingSessionCategoryExperiences::getIt(2),
                GamingSessionCategoryExperiences::getIt(3),
                GamingSessionCategoryExperiences::getIt(2),
                'foo'
            )
        ];
    }

    protected function fetchEntitiesByOriginals(array $originalEntities, EntityManager $entityManager)
    {
        $fetched = [];
        foreach ($originalEntities as $originalEntity) {
            /** @var GamingSession $originalEntity */
            $fetched[] = $entityManager->getRepository(GamingSession::class)->find($originalEntity->getId());
        }

        return $fetched;
    }

}
