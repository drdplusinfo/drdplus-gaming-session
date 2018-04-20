<?php
namespace DrdPlus\GamingSession\EnumTypes;

use Doctrineum\Integer\IntegerEnumType;

class GamingSessionCategoryExperiencesType extends IntegerEnumType
{
    public const GAMING_SESSION_CATEGORY_EXPERIENCES = 'gaming_session_category_experiences';

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::GAMING_SESSION_CATEGORY_EXPERIENCES;
    }
}