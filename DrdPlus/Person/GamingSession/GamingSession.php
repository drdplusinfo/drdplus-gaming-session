<?php
namespace DrdPlus\Person\GamingSession;

use DrdPlus\Tables\Measurements\Experiences\Experiences;
use DrdPlus\Tables\Measurements\Experiences\ExperiencesTable;
use Granam\Scalar\Tools\ToString;
use Granam\Strict\Object\StrictObject;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class GamingSession extends StrictObject
{
    /**
     * @var int
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
     * @var Experiences
     */
    private $experiences;

    /**
     * @param GamingSessionCategoryExperiences $rolePlayingExperiences
     * @param GamingSessionCategoryExperiences $difficultiesSolvingExperiences
     * @param GamingSessionCategoryExperiences $abilityUsageExperiences
     * @param GamingSessionCategoryExperiences $companionsHelpingExperiences
     * @param GamingSessionCategoryExperiences $companionsHelpingExperiences
     * @param GamingSessionCategoryExperiences $gameContributingExperiences
     * @param string $sessionName
     */
    public function __construct(
        GamingSessionCategoryExperiences $rolePlayingExperiences,
        GamingSessionCategoryExperiences $difficultiesSolvingExperiences,
        GamingSessionCategoryExperiences $abilityUsageExperiences,
        GamingSessionCategoryExperiences $companionsHelpingExperiences,
        GamingSessionCategoryExperiences $gameContributingExperiences,
        $sessionName
    )
    {
        $this->rolePlayingExperiences = $rolePlayingExperiences;
        $this->difficultiesSolvingExperiences = $difficultiesSolvingExperiences;
        $this->abilityUsageExperiences = $abilityUsageExperiences;
        $this->companionsHelpingExperiences = $companionsHelpingExperiences;
        $this->companionsHelpingExperiences = $companionsHelpingExperiences;
        $this->gameContributingExperiences = $gameContributingExperiences;
        $this->sessionName = ToString::toString($sessionName);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return GamingSessionCategoryExperiences
     */
    public function getRolePlayingExperiences()
    {
        return $this->rolePlayingExperiences;
    }

    /**
     * @return GamingSessionCategoryExperiences
     */
    public function getDifficultiesSolvingExperiences()
    {
        return $this->difficultiesSolvingExperiences;
    }

    /**
     * @return GamingSessionCategoryExperiences
     */
    public function getAbilityUsageExperiences()
    {
        return $this->abilityUsageExperiences;
    }

    /**
     * @return GamingSessionCategoryExperiences
     */
    public function getCompanionsHelpingExperiences()
    {
        return $this->companionsHelpingExperiences;
    }

    /**
     * @return GamingSessionCategoryExperiences
     */
    public function getGameContributingExperiences()
    {
        return $this->gameContributingExperiences;
    }

    /**
     * @param ExperiencesTable $experiencesTable
     * @return Experiences
     */
    public function getExperiences(ExperiencesTable $experiencesTable)
    {
        if ($this->experiences === null) {
            $this->experiences = new Experiences(
                $this->sumExperiences(),
                $experiencesTable
            );
        }

        return $this->experiences;
    }

    /**
     * @return int
     */
    private function sumExperiences()
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
    public function getSessionName()
    {
        return $this->sessionName;
    }
}
