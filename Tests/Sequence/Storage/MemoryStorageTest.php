<?php
/**
 * User: Marek Kebza <marek@kebza.cz>
 * Date: 06/08/2017
 * Time: 16:42
 */

namespace Kebza\SequenceBundle\Tests\Sequence\Storage;


use Kebza\SequenceBundle\Sequence\Sequence;
use Kebza\SequenceBundle\Sequence\Storage\MemoryStorage;
use PHPUnit\Framework\TestCase;

class MemoryStorageTest extends TestCase
{
    public function testNotInitilizedSequence() {
        $storage = new MemoryStorage();
        $sequence = new Sequence('init', null, 1, 1);

        $this->assertEquals(null, $storage->getCurrent($sequence));
        $this->assertEquals(1, $storage->getNext($sequence));

        $storage->increment($sequence);
        $this->assertEquals(1, $storage->getCurrent($sequence));
        $this->assertEquals(2, $storage->getNext($sequence));

        $storage->increment($sequence);
        $this->assertEquals(2, $storage->getCurrent($sequence));
        $this->assertEquals(3, $storage->getNext($sequence));
    }


    public function testCustomInitialValue() {
        $storage = new MemoryStorage();
        $sequence = new Sequence('initial_value', null, 1, 5);

        $this->assertEquals(null, $storage->getCurrent($sequence));
        $this->assertEquals(5, $storage->getNext($sequence));

        $storage->increment($sequence);
        $this->assertEquals(5, $storage->getCurrent($sequence));
        $this->assertEquals(6, $storage->getNext($sequence));
    }

    public function testCustomStep()
    {
        $storage = new MemoryStorage();
        $sequence = new Sequence('costomStep', null, 3, 3);

        $this->assertEquals(null, $storage->getCurrent($sequence));
        $this->assertEquals(3, $storage->getNext($sequence));

        $storage->increment($sequence);
        $this->assertEquals(3, $storage->getCurrent($sequence));
        $this->assertEquals(6, $storage->getNext($sequence));
    }
}