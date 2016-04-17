<?php
namespace DrdPlus\Tests\Person\GamingSession\EnumTypes;

use Doctrine\DBAL\Types\Type;
use DrdPlus\Person\GamingSession\EnumTypes\GamingSessionCategoryExperiencesType;
use DrdPlus\Person\GamingSession\EnumTypes\GamingSessionEnumRegistrar;

class GamingSessionEnumRegistrarTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_register_all_enums_at_once()
    {
        GamingSessionEnumRegistrar::registerAll();
        self::assertTrue(Type::hasType(GamingSessionCategoryExperiencesType::getTypeName()));
    }
}
