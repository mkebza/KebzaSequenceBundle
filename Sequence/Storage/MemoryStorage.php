<?php
/**
 * User: Marek Kebza <marek@kebza.cz>
 * Date: 06/08/2017
 * Time: 16:38
 */

namespace Kebza\SequenceBundle\Sequence\Storage;


use Kebza\SequenceBundle\Sequence\Sequence;

class MemoryStorage implements SequenceStorageInterface
{
    protected $data = [];

    public function getCurrent(Sequence $sequence)
    {
        if (array_key_exists($sequence->getStorageKey(), $this->data)) {
            return $this->data[$sequence->getStorageKey()];
        }
        return null;
    }

    public function getNext(Sequence $sequence)
    {
        $current = $this->getCurrent($sequence);
        if ($current === null) {
            return $sequence->getInitial();
        }
        return $current + $sequence->getStep();
    }

    public function increment(Sequence $sequence)
    {
        if (!array_key_exists($sequence->getStorageKey(), $this->data)) {
            $this->data[$sequence->getStorageKey()] = $sequence->getInitial();
        } else {
            $this->data[$sequence->getStorageKey()] += $sequence->getStep();
        }

        return $this->data[$sequence->getStorageKey()];
    }
}