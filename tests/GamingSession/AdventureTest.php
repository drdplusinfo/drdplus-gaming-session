<?php declare(strict_types=1);

namespace DrdPlus\Tests\GamingSession;

use DrdPlus\GamingSession\Adventure;
use DrdPlus\GamingSession\GamingSessionCategoryExperiences;
use DrdPlus\GamingSession\Memories;
use DrdPlus\Tables\Measurements\Experiences\Experiences;
use DrdPlus\Tables\Tables;
use Granam\TestWithMockery\TestWithMockery;

class AdventureTest extends TestWithMockery
{
    /**
     * @test
     */
    public function I_can_use_it_as_new(): void
    {
        $adventure = new Adventure($memories = $this->createMemories(), $name = 'foo');
        self::assertSame($memories, $adventure->getMemories());
        self::assertSame($name, $adventure->getName());
        self::assertSame($name, (string)$adventure);
        self::assertCount(0, $adventure->getGamingSessions());
        $experiences = $adventure->getExperiences(Tables::getIt()->getExperiencesTable());
        self::assertSame(0, $experiences->getValue());
    }

    /**
     * @return \Mockery\MockInterface|Memories
     */
    private function createMemories(): Memories
    {
        return $this->mockery(Memories::class);
    }

    /**
     * @test
     */
    public function I_can_add_gaming_session(): void
    {
        $adventure = new Adventure($this->createMemories(), 'foo');
        $experienceValues = [];

        $firstGamingSession = $adventure->createGamingSession(
            $rolePlayingExperiences = $this->createGamingSessionCategoryExperiences($experienceValues[] = 1),
            $difficultiesSolvingExperiences = $this->createGamingSessionCategoryExperiences($experienceValues[] = 2),
            $abilityUsageExperiences = $this->createGamingSessionCategoryExperiences($experienceValues[] = 3),
            $companionsHelpingExperiences = $this->createGamingSessionCategoryExperiences($experienceValues[] = 4),
            $gameContributingExperiences = $this->createGamingSessionCategoryExperiences($experienceValues[] = 5),
            $firstGamingSessionName = 'bar'
        );
        $experiencesTable = Tables::getIt()->getExperiencesTable();
        self::assertInstanceOf(Experiences::class, $experiences = $adventure->getExperiences($experiencesTable));
        self::assertSame(\array_sum($experienceValues), $experiences->getValue());
        self::assertSame($firstGamingSessionName, $firstGamingSession->getSessionName());
        self::assertSame($rolePlayingExperiences, $firstGamingSession->getRolePlayingExperiences());
        self::assertSame($difficultiesSolvingExperiences, $firstGamingSession->getDifficultiesSolvingExperiences());
        self::assertSame($abilityUsageExperiences, $firstGamingSession->getAbilityUsageExperiences());
        self::assertSame($companionsHelpingExperiences, $firstGamingSession->getCompanionsHelpingExperiences());
        self::assertSame($gameContributingExperiences, $firstGamingSession->getGameContributingExperiences());

        $secondGamingSession = $adventure->createGamingSession(
            $rolePlayingExperiences = $this->createGamingSessionCategoryExperiences($experienceValues[] = 6),
            $difficultiesSolvingExperiences = $this->createGamingSessionCategoryExperiences($experienceValues[] = 7),
            $abilityUsageExperiences = $this->createGamingSessionCategoryExperiences($experienceValues[] = 8),
            $companionsHelpingExperiences = $this->createGamingSessionCategoryExperiences($experienceValues[] = 9),
            $gameContributingExperiences = $this->createGamingSessionCategoryExperiences($experienceValues[] = 10),
            $secondGamingSessionName = 'baz'
        );
        self::assertInstanceOf(Experiences::class, $newExperiences = $adventure->getExperiences($experiencesTable));
        self::assertNotEquals($experiences, $newExperiences);
        self::assertSame(
            \array_sum($experienceValues),
            $newExperiences->getValue(),
            'Experiences should be always recalculated to catch new gaming session anytime'
        );
        self::assertSame($secondGamingSessionName, $secondGamingSession->getSessionName());
        self::assertSame($rolePlayingExperiences, $secondGamingSession->getRolePlayingExperiences());
        self::assertSame($difficultiesSolvingExperiences, $secondGamingSession->getDifficultiesSolvingExperiences());
        self::assertSame($abilityUsageExperiences, $secondGamingSession->getAbilityUsageExperiences());
        self::assertSame($companionsHelpingExperiences, $secondGamingSession->getCompanionsHelpingExperiences());
        self::assertSame($gameContributingExperiences, $secondGamingSession->getGameContributingExperiences());
        self::assertCount(2, $adventure);
        $collectedGamingSessions = [];
        foreach ($adventure as $gamingSessionToCollect) {
            $collectedGamingSessions[] = $gamingSessionToCollect;
        }
        self::assertSame([$firstGamingSession, $secondGamingSession], $collectedGamingSessions);
    }

    /**
     * @param $experiencesValue
     * @return \Mockery\MockInterface|GamingSessionCategoryExperiences
     */
    private function createGamingSessionCategoryExperiences($experiencesValue)
    {
        $gamingSessionCategoryExperiences = $this->mockery(GamingSessionCategoryExperiences::class);
        $gamingSessionCategoryExperiences->shouldReceive('getValue')
            ->andReturn($experiencesValue);

        return $gamingSessionCategoryExperiences;
    }
}
