<?php
declare(strict_types = 1);

namespace DrdPlus\Tests\GamingSession\EnumTypes;

use Doctrine\DBAL\Types\Type;
use DrdPlus\GamingSession\EnumTypes\GamingSessionCategoryExperiencesType;
use DrdPlus\GamingSession\EnumTypes\GamingSessionEnumRegistrar;
use PHPUnit\Framework\TestCase;

class GamingSessionEnumRegistrarTest extends TestCase
{
    /**
     * @test
     * @throws \Doctrine\DBAL\DBALException
     */
    public function I_can_register_all_enums_at_once(): void
    {
        GamingSessionEnumRegistrar::registerAll();
        self::assertTrue(Type::hasType(GamingSessionCategoryExperiencesType::GAMING_SESSION_CATEGORY_EXPERIENCES));
    }
}