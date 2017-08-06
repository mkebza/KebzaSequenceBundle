<?php
/**
 * User: Marek Kebza <marek@kebza.cz>
 * Date: 06/08/2017
 * Time: 15:43
 */

namespace Kebza\SequenceBundle\Tests\Sequence\Storage;


use Kebza\SequenceBundle\Sequence\Sequence;
use Kebza\SequenceBundle\Sequence\Storage\DoctrineStorage;
use Kebza\SequenceBundle\Sequence\Storage\FileStorage;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Filesystem\Filesystem;

class DoctrineStorageTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        $this->em->getConnection()->executeQuery('TRUNCATE TABLE kebza_sequence');

        parent::tearDown();

        $this->em->close();
        $this->em = null; // avoid memory leaks
    }


    public function testCurrentOnNotInitializedSequence()
    {
        $sequence = new Sequence('test', null, 1, 1);
        $storage = new DoctrineStorage($this->em);

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
        $storage = new DoctrineStorage($this->em);
        $sequence = new Sequence('initial_value', null, 1, 5);

        $this->assertEquals(null, $storage->getCurrent($sequence));
        $this->assertEquals(5, $storage->getNext($sequence));

        $storage->increment($sequence);
        $this->assertEquals(5, $storage->getCurrent($sequence));
        $this->assertEquals(6, $storage->getNext($sequence));
    }

    public function testCustomStep()
    {
        $storage = new DoctrineStorage($this->em);
        $sequence = new Sequence('costomStep', null, 3, 3);

        $this->assertEquals(null, $storage->getCurrent($sequence));
        $this->assertEquals(3, $storage->getNext($sequence));

        $storage->increment($sequence);
        $this->assertEquals(3, $storage->getCurrent($sequence));
        $this->assertEquals(6, $storage->getNext($sequence));
    }
}