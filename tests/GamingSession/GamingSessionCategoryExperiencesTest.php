<?php declare(strict_types=1);

namespace DrdPlus\Tests\GamingSession;

use DrdPlus\GamingSession\GamingSessionCategoryExperiences;
use PHPUnit\Framework\TestCase;

class GamingSessionCategoryExperiencesTest extends TestCase
{
    /**
     * @test
     */
    public function I_can_use_it(): void
    {
        $experiences = GamingSessionCategoryExperiences::getEnum($value = 1);
        self::assertInstanceOf(GamingSessionCategoryExperiences::class, $experiences);
        self::assertSame($experiences, GamingSessionCategoryExperiences::getIt($value));
        self::assertSame($value, $experiences->getValue());
        self::assertSame((string)$value, (string)$experiences);
    }

    /**
     * @test
     */
    public function I_can_not_create_too_low_category_experiences(): void
    {
        $this->expectException(\DrdPlus\GamingSession\Exceptions\ExperiencesTooLow::class);
        GamingSessionCategoryExperiences::getIt(-1);
    }

    /**
     * @test
     */
    public function I_can_not_create_too_high_category_experiences(): void
    {
        $this->expectException(\DrdPlus\GamingSession\Exceptions\ExperiencesTooHigh::class);
        GamingSessionCategoryExperiences::getIt(4);
    }
}
