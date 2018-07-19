<?php
declare(strict_types = 1);

namespace DrdPlus\GamingSession;

use Doctrineum\Integer\IntegerEnum;

class GamingSessionCategoryExperiences extends IntegerEnum
{
    const MINIMUM_CATEGORY_EXPERIENCES = 0;
    const MAXIMUM_CATEGORY_EXPERIENCES = 3;

    /**
     * @param int $value
     * @return GamingSessionCategoryExperiences|IntegerEnum
     * @throws \Doctrineum\Integer\Exceptions\UnexpectedValueToConvert
     * @throws \DrdPlus\GamingSession\Exceptions\ExperiencesTooHigh
     * @throws \DrdPlus\GamingSession\Exceptions\ExperiencesTooLow
     */
    public static function getIt($value)
    {
        return self::getEnum($value);
    }

    /**
     * @param mixed $value
     * @return int
     * @throws \Doctrineum\Integer\Exceptions\UnexpectedValueToConvert
     * @throws \DrdPlus\GamingSession\Exceptions\ExperiencesTooHigh
     * @throws \DrdPlus\GamingSession\Exceptions\ExperiencesTooLow
     */
    protected static function convertToEnumFinalValue($value): int
    {
        $asInteger = parent::convertToEnumFinalValue($value);
        self::guardExperiencesBoundary($asInteger);

        return $asInteger;
    }

    /**
     * @param int $experiences
     * @throws \DrdPlus\GamingSession\Exceptions\ExperiencesTooHigh
     * @throws \DrdPlus\GamingSession\Exceptions\ExperiencesTooLow
     */
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