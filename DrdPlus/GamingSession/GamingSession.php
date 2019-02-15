<?php
declare(strict_types=1);

namespace DrdPlus\GamingSession;

use DrdPlus\Tables\Measurements\Experiences\Experiences;
use DrdPlus\Tables\Measurements\Experiences\ExperiencesTable;
use Granam\Scalar\Tools\ToString;
use Granam\Strict\Object\StrictObject;
use Granam\String\StringInterface;

class GamingSession extends StrictObject implements \IteratorAggregate
{
    /**
     * @var GamingSessionCategoryExperiences
     */
    private $rolePlayingExperiences;
    /**
     * @var GamingSessionCategoryExperiences
     */
    private $difficultiesSolvingExperiences;
    /**
     * @var GamingSessionCategoryExperiences
     */
    private $abilityUsageExperiences;
    /**
     * @var GamingSessionCategoryExperiences
     */
    private $companionsHelpingExperiences;
    /**
     * @var GamingSessionCategoryExperiences
     */
    private $gameContributingExperiences;
    /**
     * @var string
     */
    private $sessionName;
    /**
     * @var Adventure
     */
    private $adventure;

    /**
     * @param Adventure $adventure
     * @param GamingSessionCategoryExperiences $rolePlayingExperiences
     * @param GamingSessionCategoryExperiences $difficultiesSolvingExperiences
     * @param GamingSessionCategoryExperiences $abilityUsageExperiences
     * @param GamingSessionCategoryExperiences $companionsHelpingExperiences
     * @param GamingSessionCategoryExperiences $gameContributingExperiences
     * @param string|StringInterface $sessionName
     */
    public function __construct(
        Adventure $adventure,
        GamingSessionCategoryExperiences $rolePlayingExperiences,
        GamingSessionCategoryExperiences $difficultiesSolvingExperiences,
        GamingSessionCategoryExperiences $abilityUsageExperiences,
        GamingSessionCategoryExperiences $companionsHelpingExperiences,
        GamingSessionCategoryExperiences $gameContributingExperiences,
        $sessionName
    )
    {
        $this->adventure = $adventure;
        $this->rolePlayingExperiences = $rolePlayingExperiences;
        $this->difficultiesSolvingExperiences = $difficultiesSolvingExperiences;
        $this->abilityUsageExperiences = $abilityUsageExperiences;
        $this->companionsHelpingExperiences = $companionsHelpingExperiences;
        $this->gameContributingExperiences = $gameContributingExperiences;
        $this->sessionName = ToString::toString($sessionName);
    }

    public function getAdventure(): Adventure
    {
        return $this->adventure;
    }

    public function getRolePlayingExperiences(): GamingSessionCategoryExperiences
    {
        return $this->rolePlayingExperiences;
    }

    public function getDifficultiesSolvingExperiences(): GamingSessionCategoryExperiences
    {
        return $this->difficultiesSolvingExperiences;
    }

    public function getAbilityUsageExperiences(): GamingSessionCategoryExperiences
    {
        return $this->abilityUsageExperiences;
    }

    public function getCompanionsHelpingExperiences(): GamingSessionCategoryExperiences
    {
        return $this->companionsHelpingExperiences;
    }

    public function getGameContributingExperiences(): GamingSessionCategoryExperiences
    {
        return $this->gameContributingExperiences;
    }

    public function getExperiences(ExperiencesTable $experiencesTable): Experiences
    {
        return new Experiences($this->sumExperiences(), $experiencesTable);
    }

    private function sumExperiences(): int
    {
        return
            $this->rolePlayingExperiences->getValue()
            + $this->difficultiesSolvingExperiences->getValue()
            + $this->abilityUsageExperiences->getValue()
            + $this->companionsHelpingExperiences->getValue()
            + $this->gameContributingExperiences->getValue();
    }

    public function getSessionName(): string
    {
        return $this->sessionName;
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator([
            $this->getRolePlayingExperiences(),
            $this->getDifficultiesSolvingExperiences(),
            $this->getAbilityUsageExperiences(),
            $this->getCompanionsHelpingExperiences(),
            $this->getGameContributingExperiences(),
        ]);
    }

}
