<?php
/**
 * User: Marek Kebza <marek@kebza.cz>
 * Date: 06/08/2017
 * Time: 15:45
 */

namespace Kebza\SequenceBundle\Sequence;


class SequenceRegistry
{
    protected $list;

    /**
     * SequenceRegistry constructor.
     */
    public function __construct($sequences)
    {
        foreach ($sequences as $k => $info) {
            $this->add(new Sequence($k, $info['pattern'], $info['step'], $info['initial']));
        }
    }


    public function add(Sequence $sequence)
    {
        $this->list[$sequence->getKey()] = $sequence;
    }

    /**
     * @param $key
     * @return Sequence
     */
    public function get($key)
    {
        return $this->list[$key];
    }

    /**
     * @return Sequence[]
     */
    public function all()
    {
        return $this->list;
    }
}