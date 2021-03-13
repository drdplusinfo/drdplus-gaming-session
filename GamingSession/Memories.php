<?php declare(strict_types=1);

namespace DrdPlus\GamingSession;

use DrdPlus\Tables\Measurements\Experiences\Experiences;
use DrdPlus\Tables\Measurements\Experiences\ExperiencesTable;
use Granam\Strict\Object\StrictObject;
use Granam\String\StringInterface;

class Memories extends StrictObject implements \IteratorAggregate, \Countable
{
    /**
     * @var Adventure[]
     */
    private $adventures = [];

    /**
     * @return Adventure[]|array
     */
    public function getAdventures(): array
    {
        return $this->adventures;
    }

    /**
     * @param string|StringInterface $name
     * @return Adventure
     */
    public function createAdventure($name): Adventure
    {
        $adventure = new Adventure($this, $name);
        $this->adventures[] = $adventure;

        return $adventure;
    }

    public function getExperiences(ExperiencesTable $experiencesTable): Experiences
    {
        $experiencesSum = 0;
        foreach ($this->getAdventures() as $adventure) {
            $experiencesSum += $adventure->getExperiences($experiencesTable)->getValue();
        }
        return new Experiences($experiencesSum, $experiencesTable);
    }

    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->getAdventures());
    }

    public function count(): int
    {
        return \count($this->getAdventures());
    }

}
