<?php
namespace DrdPlus\Tests\Person\GamingSession;

use Doctrineum\Tests\Entity\AbstractDoctrineEntitiesTest;
use DrdPlus\Person\GamingSession\Adventure;
use DrdPlus\Person\GamingSession\EnumTypes\GamingSessionCategoryExperiencesType;
use DrdPlus\Person\GamingSession\GamingSession;
use DrdPlus\Person\GamingSession\GamingSessionCategoryExperiences;
use DrdPlus\Person\GamingSession\Memories;

class DoctrineEntitiesTest extends AbstractDoctrineEntitiesTest
{
    protected function setUp()
    {
        GamingSessionCategoryExperiencesType::registerSelf();

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
            Memories::class,
            Adventure::class,
            GamingSession::class
        ];
    }

    protected function createEntitiesToPersist()
    {
        $memories = new Memories();

        $memoriesWithAdventure = new Memories();
        $memoriesWithAdventure->createAdventure('foo');

        $adventure = new Adventure(new Memories(), 'bar');

        $adventureWithNewMemoriesAndGamingSession = new Adventure(new Memories(), 'baz');
        $adventureWithNewMemoriesAndGamingSession->createGamingSession(
            GamingSessionCategoryExperiences::getIt(1),
            GamingSessionCategoryExperiences::getIt(2),
            GamingSessionCategoryExperiences::getIt(1),
            GamingSessionCategoryExperiences::getIt(2),
            GamingSessionCategoryExperiences::getIt(0),
            'foobar'
        );

        $gamingSessionWithNewAdventure = new GamingSession(
            new Adventure(new Memories(), 'qux'),
            GamingSessionCategoryExperiences::getIt(0),
            GamingSessionCategoryExperiences::getIt(1),
            GamingSessionCategoryExperiences::getIt(2),
            GamingSessionCategoryExperiences::getIt(3),
            GamingSessionCategoryExperiences::getIt(2),
            'foobaz'
        );

        return [
            $memories,
            $memoriesWithAdventure,
            $adventure,
            $adventureWithNewMemoriesAndGamingSession,
            $gamingSessionWithNewAdventure,
        ];
    }

}
