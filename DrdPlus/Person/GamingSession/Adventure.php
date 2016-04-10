<?php
namespace DrdPlus\Person\GamingSession;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrineum\Entity\Entity;
use DrdPlus\Tables\Measurements\Experiences\Experiences;
use DrdPlus\Tables\Measurements\Experiences\ExperiencesTable;
use Granam\Scalar\Tools\ToString;
use Granam\Strict\Object\StrictObject;

/**
 * @ORM\Entity()
 */
class Adventure extends StrictObject implements Entity
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * Is filled by Doctrine on GaminSession database persistence,
     * @see \DrdPlus\Person\GamingSession\GamingSession::__construct for linking
     *
     * @var GamingSession[]
     * @ORM\OneToMany(targetEntity="GamingSession", mappedBy="adventure", cascade={"persist"})
     */
    private $gamingSessions;

    /**
     * @var string
     * @ORM\Column(type="string", unique=true)
     */
    private $name;

    public function __construct($name)
    {
        $this->name = ToString::toString($name);
        $this->gamingSessions = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @param GamingSessionCategoryExperiences $rolePlayingExperiences
     * @param GamingSessionCategoryExperiences $difficultiesSolvingExperiences
     * @param GamingSessionCategoryExperiences $abilityUsageExperiences
     * @param GamingSessionCategoryExperiences $companionsHelpingExperiences
     * @param GamingSessionCategoryExperiences $gameContributingExperiences
     * @param string $sessionName
     * @return GamingSession
     */
    public function createGamingSession(
        GamingSessionCategoryExperiences $rolePlayingExperiences,
        GamingSessionCategoryExperiences $difficultiesSolvingExperiences,
        GamingSessionCategoryExperiences $abilityUsageExperiences,
        GamingSessionCategoryExperiences $companionsHelpingExperiences,
        GamingSessionCategoryExperiences $gameContributingExperiences,
        $sessionName
    )
    {
        $gamingSession = new GamingSession(
            $this,
            $rolePlayingExperiences,
            $difficultiesSolvingExperiences,
            $abilityUsageExperiences,
            $companionsHelpingExperiences,
            $gameContributingExperiences,
            $sessionName
        );
        $this->getGamingSessions()->add($gamingSession);

        return $gamingSession;
    }

    /**
     * @return GamingSession[]|Collection
     */
    public function getGamingSessions()
    {
        return $this->gamingSessions;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function getExperiences(ExperiencesTable $experiencesTable)
    {
        $experiencesSum = 0;
        foreach ($this->getGamingSessions() as $gamingSession) {
            $experiencesSum += $gamingSession->getExperiences($experiencesTable)->getValue();
        }

        return new Experiences($experiencesSum, $experiencesTable);
    }

}