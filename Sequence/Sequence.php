<?php
/**
 * User: Marek Kebza <marek@kebza.cz>
 * Date: 06/08/2017
 * Time: 15:44
 */

namespace Kebza\SequenceBundle\Sequence;


class Sequence
{
    protected $key;
    protected $pattern;
    protected $step;
    protected $initial;
    protected $storageKey;

    /**
     * Sequence constructor.
     * @param $key
     * @param $pattern
     * @param $step
     * @param $initial
     */
    public function __construct($key, $pattern, $step, $initial)
    {
        $this->key = $key;
        $this->pattern = $pattern;
        $this->step = $step;
        $this->initial = $initial;
        $this->setStorageKey('default');
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return mixed
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * @return mixed
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * @return mixed
     */
    public function getInitial()
    {
        return $this->initial;
    }

    /**
     * @return mixed
     */
    public function getStorageKey()
    {
        return $this->storageKey;
    }

    /**
     * @param mixed $storageKey
     * @return Sequence
     */
    public function setStorageKey($storageKey)
    {
        $this->storageKey = sprintf("%s.%s", $this->getKey(), $storageKey);
        return $this;
    }
}