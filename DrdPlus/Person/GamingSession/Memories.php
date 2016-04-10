<?php
namespace DrdPlus\Person\GamingSession;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrineum\Entity\Entity;
use Granam\Strict\Object\StrictObject;

/**
 * @ORM\Entity()
 */
class Memories extends StrictObject implements Entity
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

    public function createAdventure($name)
    {
        $adventure = new Adventure($this, $name);
        $this->getAdventures()->add($adventure);

        return $adventure;
    }

}