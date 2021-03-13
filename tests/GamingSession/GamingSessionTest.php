<?php declare(strict_types=1);

namespace DrdPlus\Tests\GamingSession;

use DrdPlus\GamingSession\Adventure;
use DrdPlus\GamingSession\GamingSession;
use DrdPlus\GamingSession\GamingSessionCategoryExperiences;
use DrdPlus\Tables\Tables;
use Granam\TestWithMockery\TestWithMockery;

class GamingSessionTest extends TestWithMockery
{
    /**
     * @test
     */
    public function I_can_use_it(): void
    {
        $categorizedExperiences = [];
        $gamingSession = new GamingSession(
            $adventure = $this->createAdventure(),
            $categorizedExperiences[] = $rolePlayingExperiences = $this->createGamingSessionCategoryExperiences($experienceValues[] = 1),
            $categorizedExperiences[] = $difficultiesSolvingExperiences = $this->createGamingSessionCategoryExperiences($experienceValues[] = 2),
            $categorizedExperiences[] = $abilityUsageExperiences = $this->createGamingSessionCategoryExperiences($experienceValues[] = 3),
            $categorizedExperiences[] = $companionsHelpingExperiences = $this->createGamingSessionCategoryExperiences($experienceValues[] = 4),
            $categorizedExperiences[] = $gameContributingExperiences = $this->createGamingSessionCategoryExperiences($experienceValues[] = 5),
            $sessionName = 'foo'
        );
        self::assertSame($adventure, $gamingSession->getAdventure());
        self::assertSame($rolePlayingExperiences, $gamingSession->getRolePlayingExperiences());
        self::assertSame($difficultiesSolvingExperiences, $gamingSession->getDifficultiesSolvingExperiences());
        self::assertSame($abilityUsageExperiences, $gamingSession->getAbilityUsageExperiences());
        self::assertSame($companionsHelpingExperiences, $gamingSession->getCompanionsHelpingExperiences());
        self::assertSame($gameContributingExperiences, $gamingSession->getGameContributingExperiences());
        self::assertSame($sessionName, $gamingSession->getSessionName());

        $experiences = $gamingSession->getExperiences(Tables::getIt()->getExperiencesTable());
        $sameExperiencesNewInstance = $gamingSession->getExperiences(Tables::getIt()->getExperiencesTable());
        self::assertEquals($experiences, $sameExperiencesNewInstance);
        self::assertNotSame($experiences, $sameExperiencesNewInstance);

        self::assertSame($rolePlayingExperiences->getValue() + $difficultiesSolvingExperiences->getValue()
            + $abilityUsageExperiences->getValue() + $companionsHelpingExperiences->getValue()
            + $gameContributingExperiences->getValue(),
            $experiences->getValue()
        );
        $collectedCategorizedExperiences = [];
        foreach ($gamingSession as $categorizedExperienceToBeCollected) {
            $collectedCategorizedExperiences[] = $categorizedExperienceToBeCollected;
        }

        self::assertSame($categorizedExperiences, $collectedCategorizedExperiences);
    }

    /**
     * @return \Mockery\MockInterface|Adventure
     */
    private function createAdventure(): Adventure
    {
        return $this->mockery(Adventure::class);
    }

    /**
     * @param $value
     * @return \Mockery\MockInterface|GamingSessionCategoryExperiences
     */
    private function createGamingSessionCategoryExperiences($value): GamingSessionCategoryExperiences
    {
        $experiences = $this->mockery(GamingSessionCategoryExperiences::class);
        $experiences->shouldReceive('getValue')
            ->andReturn($value);

        return $experiences;
    }
}
