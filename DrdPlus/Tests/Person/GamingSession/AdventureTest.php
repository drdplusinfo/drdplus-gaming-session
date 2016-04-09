<?php
namespace DrdPlus\Tests\Person\GamingSession;

use DrdPlus\Person\GamingSession\Adventure;

class AdventureTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_use_it()
    {
        $adventure = new Adventure($name = 'foo');
        self::assertSame($name, $adventure->getName());
        self::assertSame($name, (string)$adventure);
        self::assertNull($adventure->getId());
        self::assertCount(0, $adventure->getGamingSessions());
    }
}