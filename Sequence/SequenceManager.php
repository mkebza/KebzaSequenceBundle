<?php
/**
 * User: Marek Kebza <marek@kebza.cz>
 * Date: 06/08/2017
 * Time: 15:39
 */

namespace Kebza\SequenceBundle\Sequence;

use Kebza\SequenceBundle\Sequence\Replacer\ReplacerRegistry;
use Kebza\SequenceBundle\Sequence\Replacer\ReplacerToken;
use Kebza\SequenceBundle\Sequence\Storage\SequenceStorageInterface;

class SequenceManager
{
    /**
     * @var SequenceRegistry
     */
    private $sequences;
    /**
     * @var ReplacerRegistry
     */
    private $replacers;
    /**
     * @var SequenceStorageInterface
     */
    private $storage;

    /**
     * SequenceManager constructor.
     * @param SequenceRegistry $sequences
     * @param ReplacerRegistry $replacers
     * @param SequenceStorageInterface $storage
     */
    public function __construct(SequenceRegistry $sequences, ReplacerRegistry $replacers, SequenceStorageInterface $storage)
    {
        $this->sequences = $sequences;
        $this->replacers = $replacers;
        $this->storage = $storage;
    }

    public function current($name)
    {
        $sequence = $this->sequences->get($name);
        $tokens = $this->getTokens($sequence->getPattern());

        $this->applyReplacerPreload($tokens, $sequence);

        $value = $this->storage->getCurrent($sequence);
        if ($value == null) {
            return null;
        }

        return $this->applyReplacers($tokens, $sequence, $value);
    }

    public function peek($name)
    {
        $sequence = $this->sequences->get($name);
        $tokens = $this->getTokens($sequence->getPattern());

        $this->applyReplacerPreload($tokens, $sequence);

        $value = $this->storage->getNext($sequence);
        if ($value == null) {
            return null;
        }

        return $this->applyReplacers($tokens, $sequence, $value);
    }

    public function next($name)
    {
        $sequence = $this->sequences->get($name);
        $tokens = $this->getTokens($sequence->getPattern());

        $this->applyReplacerPreload($tokens, $sequence);

        $this->storage->increment($sequence);
        return $this->applyReplacers($tokens, $sequence, $this->storage->getCurrent($sequence));
    }

    protected function applyReplacers($tokens, Sequence $sequence, $value)
    {
        $final = $sequence->getPattern();

        foreach ($tokens as $token) {
            foreach ($this->replacers->all() as $replacer) {
                if ($replacer->supports($token)) {
                    $final = str_replace($token->getReplace(), $replacer->getValue($token, $value), $final);
                }
            }
        }

        return $final;
    }

    protected function applyReplacerPreload($tokens, Sequence $sequence)
    {
        foreach ($tokens as $token) {
            foreach ($this->replacers->all() as $replacer) {
                if ($replacer->supports($token)) {
                    $replacer->preLoad($token, $sequence);
                }
            }
        }
    }

    /**
     * @param $pattern
     * @return ReplacerToken[]
     */
    protected function getTokens($pattern)
    {
        $tokens = [];

        if (preg_match_all('~{([^|}]*?\|?.*)}~U', $pattern, $matches)) {
            for ($i = 0; $i < count($matches[0]); $i++) {
                $info = explode('|', $matches[1][$i]);

                $tokens[] = new ReplacerToken(array_shift($info), $info, $matches[0][$i]);
            }
        }

        return $tokens;
    }
}