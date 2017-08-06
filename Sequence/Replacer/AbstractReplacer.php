<?php
/**
 * User: Marek Kebza <marek@kebza.cz>
 * Date: 06/08/2017
 * Time: 17:59
 */

namespace Kebza\SequenceBundle\Sequence\Replacer;


use Kebza\SequenceBundle\Sequence\Sequence;

abstract class AbstractReplacer implements ReplacerInterface
{
    public function preLoad(ReplacerToken $token, Sequence $sequence)
    {
        // Do nothing
    }

}