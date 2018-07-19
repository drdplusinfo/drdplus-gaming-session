<?php
declare(strict_types = 1);

namespace DrdPlus\Tests\GamingSession;

use Doctrine\DBAL\Types\Type;
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
     * @expectedException \DrdPlus\GamingSession\Exceptions\ExperiencesTooLow
     */
    public function I_can_not_create_too_low_category_experiences(): void
    {
        GamingSessionCategoryExperiences::getIt(-1);
    }

    /**
     * @test
     * @expectedException \DrdPlus\GamingSession\Exceptions\ExperiencesTooHigh
     */
    public function I_can_not_create_too_high_category_experiences(): void
    {
        GamingSessionCategoryExperiences::getIt(4);
    }

    /**
     * @test
     * @throws \ReflectionException
     */
    public function I_can_register_it_as_doctrine_type(): void
    {
        $typeClass = $this->getDoctrineTypeClass();
        self::assertTrue(class_exists($typeClass), "Doctrine type class not found: $typeClass");
        self::assertTrue(is_a($typeClass, Type::class, true), "Type class should be Doctrine type: $typeClass");
    }

    /**
     * @throws \ReflectionException
     */
    private function getDoctrineTypeClass(): string
    {
        $reflection = new \ReflectionClass(GamingSessionCategoryExperiences::class);
        $namespace = $reflection->getNamespaceName() . '\\EnumTypes';
        $baseName = $reflection->getShortName() . 'Type';

        return $namespace . '\\' . $baseName;
    }
}