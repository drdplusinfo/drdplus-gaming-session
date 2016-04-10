<?php
namespace DrdPlus\Person\GamingSession;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrineum\Entity\Entity;
use DrdPlus\Tables\Measurements\Experiences\Experiences;
use DrdPlus\Tables\Measurements\Experiences\ExperiencesTable;
use Granam\Strict\Object\StrictObject;

/**
 * @ORM\Entity()
 */
class Memories extends StrictObject implements Entity, \IteratorAggregate, \Countable
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * Can be also filled by Doctrine on Adventure database persistence,
     * @see \DrdPlus\Person\GamingSession\GamingSession::__construct for linking
     *
     * @var Adventure[]
     * @ORM\OneToMany(targetEntity="Adventure", mappedBy="memories", cascade={"persist"})
     */
    private $adventures;

    public function __construct()
    {
        $this->adventures = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Adventure[]|Collection
     */
    public function getAdventures()
    {
        return $this->adventures;
    }

    /**
     * @param string $name
     * @return Adventure
     */
    public function createAdventure($name)
    {
        $adventure = new Adventure($this, $name);
        $this->getAdventures()->add($adventure);

        return $adventure;
    }

    /**
     * @param ExperiencesTable $experiencesTable
     * @return Experiences
     */
    public function getExperiences(ExperiencesTable $experiencesTable)
    {
        $experiencesSum = 0;
        foreach ($this->getAdventures() as $adventure) {
            $experiencesSum += $adventure->getExperiences($experiencesTable)->getValue();
        }

        return new Experiences($experiencesSum, $experiencesTable);
    }

    public function getIterator()
    {
        return $this->getAdventures()->getIterator();
    }

    public function count()
    {
        return $this->getAdventures()->count();
    }

}