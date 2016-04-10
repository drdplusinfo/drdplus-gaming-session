<?php
namespace DrdPlus\Tests\Person\GamingSession;

use DrdPlus\Person\GamingSession\Adventure;
use DrdPlus\Person\GamingSession\GamingSession;
use DrdPlus\Person\GamingSession\GamingSessionCategoryExperiences;
use DrdPlus\Tables\Measurements\Experiences\Experiences;
use DrdPlus\Tables\Tables;
use Granam\Tests\Tools\TestWithMockery;

class AdventureTest extends TestWithMockery
{
    /**
     * @test
     */
    public function I_can_use_it_as_new()
    {
        $adventure = new Adventure($name = 'foo');
        self::assertSame($name, $adventure->getName());
        self::assertSame($name, (string)$adventure);
        self::assertNull($adventure->getId());
        self::assertCount(0, $adventure->getGamingSessions());
        $experiences = $adventure->getExperiences((new Tables())->getExperiencesTable());
        self::assertInstanceOf(Experiences::class, $experiences);
        self::assertSame(0, $experiences->getValue());
    }

    /**
     * @test
     */
    public function I_can_add_gaming_session()
    {
        $adventure = new Adventure($name = 'foo');
        $experienceValues = [];

        $gamingSession = $adventure->createGamingSession(
            $rolePlayingExperiences = $this->createGamingSessionCategoryExperiences($experienceValues[] = 1),
            $difficultiesSolvingExperiences = $this->createGamingSessionCategoryExperiences($experienceValues[] = 2),
            $abilityUsageExperiences = $this->createGamingSessionCategoryExperiences($experienceValues[] = 3),
            $companionsHelpingExperiences = $this->createGamingSessionCategoryExperiences($experienceValues[] = 4),
            $gameContributingExperiences = $this->createGamingSessionCategoryExperiences($experienceValues[] = 5),
            $gamingSessionName = 'bar'
        );
        self::assertInstanceOf(GamingSession::class, $gamingSession);
        $experiencesTable = (new Tables())->getExperiencesTable();
        self::assertInstanceOf(Experiences::class, $experiences = $adventure->getExperiences($experiencesTable));
        self::assertSame(array_sum($experienceValues), $experiences->getValue());
        self::assertSame($gamingSessionName, $gamingSession->getSessionName());
        self::assertSame($rolePlayingExperiences, $gamingSession->getRolePlayingExperiences());
        self::assertSame($difficultiesSolvingExperiences, $gamingSession->getDifficultiesSolvingExperiences());
        self::assertSame($abilityUsageExperiences, $gamingSession->getAbilityUsageExperiences());
        self::assertSame($companionsHelpingExperiences, $gamingSession->getCompanionsHelpingExperiences());
        self::assertSame($gameContributingExperiences, $gamingSession->getGameContributingExperiences());

        $anotherGamingSession = $adventure->createGamingSession(
            $rolePlayingExperiences = $this->createGamingSessionCategoryExperiences($experienceValues[] = 6),
            $difficultiesSolvingExperiences = $this->createGamingSessionCategoryExperiences($experienceValues[] = 7),
            $abilityUsageExperiences = $this->createGamingSessionCategoryExperiences($experienceValues[] = 8),
            $companionsHelpingExperiences = $this->createGamingSessionCategoryExperiences($experienceValues[] = 9),
            $gameContributingExperiences = $this->createGamingSessionCategoryExperiences($experienceValues[] = 10),
            $anotherGamingSessionName = 'baz'
        );
        self::assertInstanceOf(GamingSession::class, $anotherGamingSession);
        self::assertInstanceOf(Experiences::class, $newExperiences = $adventure->getExperiences($experiencesTable));
        self::assertNotEquals($experiences, $newExperiences);
        self::assertSame(
            array_sum($experienceValues),
            $newExperiences->getValue(),
            'Experiences should be always recalculated to catch new gaming session anytime'
        );
        self::assertSame($anotherGamingSessionName, $anotherGamingSession->getSessionName());
        self::assertSame($rolePlayingExperiences, $anotherGamingSession->getRolePlayingExperiences());
        self::assertSame($difficultiesSolvingExperiences, $anotherGamingSession->getDifficultiesSolvingExperiences());
        self::assertSame($abilityUsageExperiences, $anotherGamingSession->getAbilityUsageExperiences());
        self::assertSame($companionsHelpingExperiences, $anotherGamingSession->getCompanionsHelpingExperiences());
        self::assertSame($gameContributingExperiences, $anotherGamingSession->getGameContributingExperiences());
    }

    /**
     * @param $experiencesValue
     * @return GamingSessionCategoryExperiences
     */
    private function createGamingSessionCategoryExperiences($experiencesValue)
    {
        $gamingSessionCategoryExperiences = $this->mockery(GamingSessionCategoryExperiences::class);
        $gamingSessionCategoryExperiences->shouldReceive('getValue')
            ->andReturn($experiencesValue);

        return $gamingSessionCategoryExperiences;
    }
}