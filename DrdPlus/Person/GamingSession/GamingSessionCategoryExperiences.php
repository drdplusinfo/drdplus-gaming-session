<?php
namespace DrdPlus\Person\GamingSession;

use Doctrineum\Integer\IntegerEnum;

class GamingSessionCategoryExperiences extends IntegerEnum
{
    const GAMING_SESSION_CATEGORY_EXPERIENCES = 'gaming_session_category_experiences';

    const MINIMUM_CATEGORY_EXPERIENCES = 0;
    const MAXIMUM_CATEGORY_EXPERIENCES = 3;

    /**
     * @param int $value
     * @return GamingSessionCategoryExperiences
     */
    public static function getIt($value)
    {
        return self::getEnum($value);
    }

    protected static function convertToEnumFinalValue($value)
    {
        $asInteger = parent::convertToEnumFinalValue($value);
        self::guardExperiencesBoundary($asInteger);

        return $asInteger;
    }

    private static function guardExperiencesBoundary($experiences)
    {
        if ($experiences < self::MINIMUM_CATEGORY_EXPERIENCES) {
            throw new Exceptions\ExperiencesTooLow(
                'Gaming sessions experiences of a single category can not be lesser than '
                . self::MINIMUM_CATEGORY_EXPERIENCES . ', got ' . $experiences
            );
        }
        if ($experiences > self::MAXIMUM_CATEGORY_EXPERIENCES) {
            throw new Exceptions\ExperiencesTooHigh(
                'Gaming sessions experiences of a single category can not be greater than '
                . self::MAXIMUM_CATEGORY_EXPERIENCES . ', got ' . $experiences
            );
        }
    }

}