<?php
/**
 * User: Marek Kebza <marek@kebza.cz>
 * Date: 06/08/2017
 * Time: 15:43
 */

namespace Kebza\SequenceBundle\Tests\Sequence\Storage;


use Kebza\SequenceBundle\Sequence\Sequence;
use Kebza\SequenceBundle\Sequence\Storage\FileStorage;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

class FileStorageTest extends TestCase
{
    private $testDir = null;

    protected function setUp()
    {
        $this->testDir = sys_get_temp_dir().'/sequenceTest/';

        $fs = new Filesystem($this->testDir);
        $fs->mkdir($this->testDir);
    }

    protected function tearDown()
    {
        $fs = new Filesystem($this->testDir);
        $fs->remove($this->testDir);

        $this->testDir = null;
    }


    public function testCurrentOnNotInitializedSequence()
    {
        $sequence = new Sequence('test', null, 1, 1);
        $storage = new FileStorage($this->testDir);

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
        $storage = new FileStorage($this->testDir);
        $sequence = new Sequence('initial_value', null, 1, 5);

        $this->assertEquals(null, $storage->getCurrent($sequence));
        $this->assertEquals(5, $storage->getNext($sequence));

        $storage->increment($sequence);
        $this->assertEquals(5, $storage->getCurrent($sequence));
        $this->assertEquals(6, $storage->getNext($sequence));
    }

    public function testCustomStep()
    {
        $storage = new FileStorage($this->testDir);
        $sequence = new Sequence('costomStep', null, 3, 3);

        $this->assertEquals(null, $storage->getCurrent($sequence));
        $this->assertEquals(3, $storage->getNext($sequence));

        $storage->increment($sequence);
        $this->assertEquals(3, $storage->getCurrent($sequence));
        $this->assertEquals(6, $storage->getNext($sequence));
    }


}