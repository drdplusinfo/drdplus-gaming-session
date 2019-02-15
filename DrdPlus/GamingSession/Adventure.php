<?php
declare(strict_types=1);

namespace DrdPlus\GamingSession;

use DrdPlus\Tables\Measurements\Experiences\Experiences;
use DrdPlus\Tables\Measurements\Experiences\ExperiencesTable;
use Granam\Scalar\Tools\ToString;
use Granam\Strict\Object\StrictObject;
use Granam\String\StringInterface;

class Adventure extends StrictObject implements \IteratorAggregate, \Countable
{
    /**
     * @var Memories
     */
    private $memories;
    /**
     * @var string
     */
    private $name;
    /**
     * @var GamingSession[]
     */
    private $gamingSessions = [];

    /**
     * @param Memories $memories
     * @param string|StringInterface $name
     */
    public function __construct(Memories $memories, $name)
    {
        $this->memories = $memories;
        $this->name = ToString::toString($name);
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMemories(): Memories
    {
        return $this->memories;
    }

    public function createGamingSession(
        GamingSessionCategoryExperiences $rolePlayingExperiences,
        GamingSessionCategoryExperiences $difficultiesSolvingExperiences,
        GamingSessionCategoryExperiences $abilityUsageExperiences,
        GamingSessionCategoryExperiences $companionsHelpingExperiences,
        GamingSessionCategoryExperiences $gameContributingExperiences,
        string $sessionName
    ): GamingSession
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
        $this->gamingSessions[] = $gamingSession;

        return $gamingSession;
    }

    /**
     * @return GamingSession[]|array
     */
    public function getGamingSessions(): array
    {
        return $this->gamingSessions;
    }

    public function getExperiences(ExperiencesTable $experiencesTable): Experiences
    {
        $experiencesSum = 0;
        foreach ($this->getGamingSessions() as $gamingSession) {
            $experiencesSum += $gamingSession->getExperiences($experiencesTable)->getValue();
        }
        return new Experiences($experiencesSum, $experiencesTable);
    }

    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->getGamingSessions());
    }

    public function count(): int
    {
        return \count($this->getGamingSessions());
    }

}