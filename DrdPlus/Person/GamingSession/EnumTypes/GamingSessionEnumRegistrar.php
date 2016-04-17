<?php
namespace DrdPlus\Person\GamingSession\EnumTypes;

class GamingSessionEnumRegistrar
{
    public static function registerAll()
    {
        GamingSessionCategoryExperiencesType::registerSelf();
    }
}