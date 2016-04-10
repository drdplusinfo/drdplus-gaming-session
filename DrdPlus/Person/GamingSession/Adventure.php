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
use Traversable;

/**
 * @ORM\Entity()
 */
class Adventure extends StrictObject implements Entity, \IteratorAggregate, \Countable
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;
    /**
     * @var Memories
     * @ORM\ManyToOne(targetEntity="Memories", inversedBy="adventures", cascade={"persist"})
     */
    private $memories;
    /**
     * @var string
     * @ORM\Column(type="string", unique=true)
     */
    private $name;
    /**
     * Can be also filled by Doctrine on GaminSession database persistence,
     * @see \DrdPlus\Person\GamingSession\GamingSession::__construct for linking
     *
     * @var GamingSession[]
     * @ORM\OneToMany(targetEntity="GamingSession", mappedBy="adventure", cascade={"persist"})
     */
    private $gamingSessions;

    public function __construct(Memories $memories, $name)
    {
        $this->memories = $memories;
        $this->name = ToString::toString($name);
        $this->gamingSessions = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
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

    /**
     * @return Memories
     */
    public function getMemories()
    {
        return $this->memories;
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
     * @param ExperiencesTable $experiencesTable
     * @return Experiences
     */
    public function getExperiences(ExperiencesTable $experiencesTable)
    {
        $experiencesSum = 0;
        foreach ($this->getGamingSessions() as $gamingSession) {
            $experiencesSum += $gamingSession->getExperiences($experiencesTable)->getValue();
        }

        return new Experiences($experiencesSum, $experiencesTable);
    }

    /**
     * @return Traversable
     */
    public function getIterator()
    {
        return $this->getGamingSessions()->getIterator();
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->getGamingSessions()->count();
    }

}