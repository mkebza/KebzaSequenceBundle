<?php
/**
 * User: Marek Kebza <marek@kebza.cz>
 * Date: 06/08/2017
 * Time: 17:57
 */

namespace Kebza\SequenceBundle\Sequence\Replacer;


use Kebza\SequenceBundle\Sequence\Sequence;

interface ReplacerInterface
{
    public function supports(ReplacerToken $token);
    public function preLoad(ReplacerToken $token, Sequence $sequence);
    public function getValue(ReplacerToken $token, $value);
}