<?php
declare(strict_types = 1);

namespace DrdPlus\GamingSession\EnumTypes;

class GamingSessionEnumRegistrar
{
    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    public static function registerAll(): void
    {
        GamingSessionCategoryExperiencesType::registerSelf();
    }
}