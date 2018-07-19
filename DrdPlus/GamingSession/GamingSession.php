<?php
declare(strict_types=1);

namespace DrdPlus\GamingSession;

use Doctrineum\Entity\Entity;
use DrdPlus\Tables\Measurements\Experiences\Experiences;
use DrdPlus\Tables\Measurements\Experiences\ExperiencesTable;
use Granam\Scalar\Tools\ToString;
use Granam\Strict\Object\StrictObject;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class GamingSession extends StrictObject implements Entity, \IteratorAggregate
{
    /**
     * @var int|null
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;
    /**
     * @var GamingSessionCategoryExperiences
     * @ORM\Column(type="gaming_session_category_experiences")
     */
    private $rolePlayingExperiences;
    /**
     * @var GamingSessionCategoryExperiences
     * @ORM\Column(type="gaming_session_category_experiences")
     */
    private $difficultiesSolvingExperiences;
    /**
     * @var GamingSessionCategoryExperiences
     * @ORM\Column(type="gaming_session_category_experiences")
     */
    private $abilityUsageExperiences;
    /**
     * @var GamingSessionCategoryExperiences
     * @ORM\Column(type="gaming_session_category_experiences")
     */
    private $companionsHelpingExperiences;
    /**
     * @var GamingSessionCategoryExperiences
     * @ORM\Column(type="gaming_session_category_experiences")
     */
    private $gameContributingExperiences;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $sessionName;
    /**
     * @var Adventure
     * @ORM\ManyToOne(targetEntity="Adventure", inversedBy="gamingSessions", cascade={"persist"})
     */
    private $adventure;

    /**
     * @param Adventure $adventure
     * @param GamingSessionCategoryExperiences $rolePlayingExperiences
     * @param GamingSessionCategoryExperiences $difficultiesSolvingExperiences
     * @param GamingSessionCategoryExperiences $abilityUsageExperiences
     * @param GamingSessionCategoryExperiences $companionsHelpingExperiences
     * @param GamingSessionCategoryExperiences $gameContributingExperiences
     * @param string $sessionName
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function __construct(
        Adventure $adventure,
        GamingSessionCategoryExperiences $rolePlayingExperiences,
        GamingSessionCategoryExperiences $difficultiesSolvingExperiences,
        GamingSessionCategoryExperiences $abilityUsageExperiences,
        GamingSessionCategoryExperiences $companionsHelpingExperiences,
        GamingSessionCategoryExperiences $gameContributingExperiences,
        string $sessionName
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

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Adventure
     */
    public function getAdventure(): Adventure
    {
        return $this->adventure;
    }

    /**
     * @return GamingSessionCategoryExperiences
     */
    public function getRolePlayingExperiences(): GamingSessionCategoryExperiences
    {
        return $this->rolePlayingExperiences;
    }

    /**
     * @return GamingSessionCategoryExperiences
     */
    public function getDifficultiesSolvingExperiences(): GamingSessionCategoryExperiences
    {
        return $this->difficultiesSolvingExperiences;
    }

    /**
     * @return GamingSessionCategoryExperiences
     */
    public function getAbilityUsageExperiences(): GamingSessionCategoryExperiences
    {
        return $this->abilityUsageExperiences;
    }

    /**
     * @return GamingSessionCategoryExperiences
     */
    public function getCompanionsHelpingExperiences(): GamingSessionCategoryExperiences
    {
        return $this->companionsHelpingExperiences;
    }

    /**
     * @return GamingSessionCategoryExperiences
     */
    public function getGameContributingExperiences(): GamingSessionCategoryExperiences
    {
        return $this->gameContributingExperiences;
    }

    /**
     * @param ExperiencesTable $experiencesTable
     * @return Experiences
     */
    public function getExperiences(ExperiencesTable $experiencesTable): Experiences
    {
        return new Experiences($this->sumExperiences(), $experiencesTable);
    }

    /**
     * @return int
     */
    private function sumExperiences(): int
    {
        return
            $this->rolePlayingExperiences->getValue()
            + $this->difficultiesSolvingExperiences->getValue()
            + $this->abilityUsageExperiences->getValue()
            + $this->companionsHelpingExperiences->getValue()
            + $this->gameContributingExperiences->getValue();
    }

    /**
     * @return string
     */
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
            $this->getGameContributingExperiences()
        ]);
    }

}
