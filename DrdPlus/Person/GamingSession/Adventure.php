<?php
namespace DrdPlus\Person\GamingSession;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrineum\Entity\Entity;
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
     * @ORM\OneToMany(targetEntity="GamingSession", mappedBy="adventure")
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

}