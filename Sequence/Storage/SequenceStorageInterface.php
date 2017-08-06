<?php
/**
 * User: Marek Kebza <marek@kebza.cz>
 * Date: 06/08/2017
 * Time: 15:39
 */

namespace Kebza\SequenceBundle\Sequence\Storage;

use Kebza\SequenceBundle\Sequence\Sequence;

interface SequenceStorageInterface
{
    /**
     * Return next number in sequence
     *
     * @param Sequence $sequence
     * @return int
     */
    public function getCurrent(Sequence $sequence);
    public function getNext(Sequence $sequence);
    public function increment(Sequence $sequence);
}