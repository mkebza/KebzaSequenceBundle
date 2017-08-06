<?php
/**
 * User: Marek Kebza <marek@kebza.cz>
 * Date: 06/08/2017
 * Time: 18:05
 */

namespace Kebza\SequenceBundle\Sequence\Replacer;


class ReplacerRegistry
{
    protected $replacers = [];

    public function add(ReplacerInterface $replacer)
    {
        $this->replacers[] = $replacer;
    }

    /**
     * @return ReplacerInterface[]
     */
    public function all()
    {
        return $this->replacers;
    }
}