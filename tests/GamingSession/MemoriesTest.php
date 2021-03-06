<?php declare(strict_types=1);

namespace DrdPlus\Tests\GamingSession;

use DrdPlus\GamingSession\GamingSessionCategoryExperiences;
use DrdPlus\GamingSession\Memories;
use DrdPlus\Tables\Tables;
use Granam\TestWithMockery\TestWithMockery;

class MemoriesTest extends TestWithMockery
{

    /**
     * @test
     */
    public function I_can_use_it(): void
    {
        $memories = new Memories();

        $firstAdventureExperienceValues = [];
        $firstAdventure = $memories->createAdventure($firstAdventureName = 'foo');
        self::assertSame($firstAdventureName, $firstAdventure->getName());
        $firstAdventure->createGamingSession(
            $this->createGamingSessionCategoryExperiences($firstAdventureExperienceValues[] = 1),
            $this->createGamingSessionCategoryExperiences($firstAdventureExperienceValues[] = 2),
            $this->createGamingSessionCategoryExperiences($firstAdventureExperienceValues[] = 3),
            $this->createGamingSessionCategoryExperiences($firstAdventureExperienceValues[] = 4),
            $this->createGamingSessionCategoryExperiences($firstAdventureExperienceValues[] = 5),
            'foo bar'
        );

        $secondAdventureExperienceValue = [];
        $secondAdventure = $memories->createAdventure($secondAdventureName = 'bar');
        self::assertSame($secondAdventureName, $secondAdventure->getName());
        $secondAdventure->createGamingSession(
            $this->createGamingSessionCategoryExperiences($secondAdventureExperienceValue[] = 6),
            $this->createGamingSessionCategoryExperiences($secondAdventureExperienceValue[] = 7),
            $this->createGamingSessionCategoryExperiences($secondAdventureExperienceValue[] = 8),
            $this->createGamingSessionCategoryExperiences($secondAdventureExperienceValue[] = 9),
            $this->createGamingSessionCategoryExperiences($secondAdventureExperienceValue[] = 10),
            'foo baz'
        );

        $totalExperiences = $memories->getExperiences(Tables::getIt()->getExperiencesTable());
        self::assertSame(
            \array_sum($firstAdventureExperienceValues) + array_sum($secondAdventureExperienceValue),
            $totalExperiences->getValue()
        );
        self::assertCount(2, $memories);
        $collectedAdventures = [];
        foreach ($memories as $adventureToCollect) {
            $collectedAdventures[] = $adventureToCollect;
        }
        self::assertSame([$firstAdventure, $secondAdventure], $collectedAdventures);
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
