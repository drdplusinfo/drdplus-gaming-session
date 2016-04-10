<?php
namespace DrdPlus\Person\GamingSession;

use DrdPlus\Tables\Measurements\Experiences\Experiences;
use DrdPlus\Tables\Tables;
use Granam\Tests\Tools\TestWithMockery;

class MemoriesTest extends TestWithMockery
{

    /**
     * @test
     */
    public function I_can_use_it()
    {
        $memories = new Memories();

        $firstAdventureExperienceValues = [];
        $firstAdventure = $memories->createAdventure($adventureName = 'foo');
        self::assertInstanceOf(Adventure::class, $firstAdventure);
        self::assertSame($adventureName, $firstAdventure->getName());
        $firstAdventure->createGamingSession(
            $this->createGamingSessionCategoryExperiences($firstAdventureExperienceValues[] = 1),
            $this->createGamingSessionCategoryExperiences($firstAdventureExperienceValues[] = 2),
            $this->createGamingSessionCategoryExperiences($firstAdventureExperienceValues[] = 3),
            $this->createGamingSessionCategoryExperiences($firstAdventureExperienceValues[] = 4),
            $this->createGamingSessionCategoryExperiences($firstAdventureExperienceValues[] = 5),
            'foo bar'
        );

        $secondAdventureExperienceValue = [];
        $secondAdventure = $memories->createAdventure('bar');
        $secondAdventure->createGamingSession(
            $this->createGamingSessionCategoryExperiences($secondAdventureExperienceValue[] = 6),
            $this->createGamingSessionCategoryExperiences($secondAdventureExperienceValue[] = 7),
            $this->createGamingSessionCategoryExperiences($secondAdventureExperienceValue[] = 8),
            $this->createGamingSessionCategoryExperiences($secondAdventureExperienceValue[] = 9),
            $this->createGamingSessionCategoryExperiences($secondAdventureExperienceValue[] = 10),
            'foo baz'
        );

        $totalExperiences = $memories->getExperiences((new Tables())->getExperiencesTable());
        self::assertInstanceOf(Experiences::class, $totalExperiences);
        self::assertSame(
            array_sum($firstAdventureExperienceValues) + array_sum($secondAdventureExperienceValue),
            $totalExperiences->getValue()
        );
    }

    /**
     * @param $value
     * @return \Mockery\MockInterface|GamingSessionCategoryExperiences
     */
    private function createGamingSessionCategoryExperiences($value)
    {
        $experiences = $this->mockery(GamingSessionCategoryExperiences::class);
        $experiences->shouldReceive('getValue')
            ->andReturn($value);

        return $experiences;
    }
}
