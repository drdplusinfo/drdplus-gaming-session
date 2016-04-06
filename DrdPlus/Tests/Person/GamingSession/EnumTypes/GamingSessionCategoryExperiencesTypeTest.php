<?php
namespace DrdPlus\Person\GamingSession\EnumTypes;

use Doctrine\DBAL\Types\Type;

class GamingSessionCategoryExperiencesTypeTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function I_can_register_it()
    {
        GamingSessionCategoryExperiencesType::registerSelf();

        self::assertTrue(Type::hasType(GamingSessionCategoryExperiencesType::getTypeName()));
        self::assertTrue(GamingSessionCategoryExperiencesType::isRegistered());
        self::assertInstanceOf(
            GamingSessionCategoryExperiencesType::class,
            Type::getType(GamingSessionCategoryExperiencesType::getTypeName())
        );
    }
}
