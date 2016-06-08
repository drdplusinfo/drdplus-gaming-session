<?php
namespace DrdPlus\GamingSession\EnumTypes;

class GamingSessionEnumRegistrar
{
    public static function registerAll()
    {
        GamingSessionCategoryExperiencesType::registerSelf();
    }
}