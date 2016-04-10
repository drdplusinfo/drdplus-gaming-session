<?php
namespace DrdPlus\Tests\Person\GamingSession;

use Doctrineum\Tests\Entity\AbstractDoctrineEntitiesTest;
use DrdPlus\Person\GamingSession\Adventure;
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
            Adventure::class,
            GamingSession::class
        ];
    }

    protected function createEntitiesToPersist()
    {
        $adventureWithGamingSession = new Adventure('gux');
        $adventureWithGamingSession->createGamingSession(
            GamingSessionCategoryExperiences::getIt(1),
            GamingSessionCategoryExperiences::getIt(2),
            GamingSessionCategoryExperiences::getIt(1),
            GamingSessionCategoryExperiences::getIt(2),
            GamingSessionCategoryExperiences::getIt(0),
            'foobar'
        );

        return [
            new GamingSession(
                new Adventure('foo'),
                GamingSessionCategoryExperiences::getIt(0),
                GamingSessionCategoryExperiences::getIt(1),
                GamingSessionCategoryExperiences::getIt(2),
                GamingSessionCategoryExperiences::getIt(3),
                GamingSessionCategoryExperiences::getIt(2),
                'bar'
            ),
            new Adventure('baz'),
            $adventureWithGamingSession
        ];
    }

}
