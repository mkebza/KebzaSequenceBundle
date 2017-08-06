<?php
/**
 * User: Marek Kebza <marek@kebza.cz>
 * Date: 06/08/2017
 * Time: 15:42
 */

namespace Kebza\SequenceBundle\Sequence\Storage;


use Kebza\SequenceBundle\Sequence\Sequence;
use Symfony\Component\Filesystem\Filesystem;

class FileStorage implements SequenceStorageInterface
{
    /**
     * @var
     */
    private $path;

    /**
     * FileStorage constructor.
     * @param $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    public function getCurrent(Sequence $sequence)
    {
        $fs = new Filesystem();
        $filename = $this->filename($sequence->getStorageKey());
        if ($fs->exists($filename)) {
            return (int)file_get_contents($filename);
        }
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
        $fs = new Filesystem();
        $fs->mkdir($this->path);

        file_put_contents($this->filename($sequence->getStorageKey()), $this->getNext($sequence));
    }

    protected function filename($key) {
        return sprintf("%s/%s", $this->path, $key);
    }


}