<?php
/**
 * User: Marek Kebza <marek@kebza.cz>
 * Date: 06/08/2017
 * Time: 17:20
 */

namespace Kebza\SequenceBundle\Sequence\Storage;


use Doctrine\ORM\EntityManagerInterface;
use Kebza\SequenceBundle\Entity\DoctrineSequence;
use Kebza\SequenceBundle\Sequence\Sequence;

class DoctrineStorage implements SequenceStorageInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * DoctrineStorage constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Return next number in sequence
     *
     * @param Sequence $sequence
     * @return int
     */
    public function getCurrent(Sequence $sequence)
    {
        $entity = $this->em->find(DoctrineSequence::class, $sequence->getStorageKey());
        if ($entity == null) {
            return null;
        }
        return $entity->getCurrent();
    }

    public function getNext(Sequence $sequence)
    {
        $current = $this->getCurrent($sequence);
        if ($current == null) {
            return $sequence->getInitial();
        }
        return $current + $sequence->getStep();
    }

    public function increment(Sequence $sequence)
    {
        $entity = $this->em->find(DoctrineSequence::class, $sequence->getStorageKey());
        if ($entity == null) {
            $entity = new DoctrineSequence();
            $entity->setKey($sequence->getStorageKey());
        }

        $entity->setCurrent($this->getNext($sequence));
        $this->em->persist($entity);
        $this->em->flush();
    }

}