<?php
/**
 * User: Marek Kebza <marek@kebza.cz>
 * Date: 06/08/2017
 * Time: 17:59
 */

namespace Kebza\SequenceBundle\Sequence\Replacer\Type;


use Kebza\SequenceBundle\Sequence\Replacer\AbstractReplacer;
use Kebza\SequenceBundle\Sequence\Replacer\ReplacerToken;
use Kebza\SequenceBundle\Sequence\Sequence;

class ValueReplacer extends AbstractReplacer
{
    protected $resetMap = [
        'YEAR' => 'Y',
        'MONTH' => 'm',
        'WEEK' => 'W'];

    public function supports(ReplacerToken $token)
    {
        return $token->getToken() == 'ID';
    }

    public function preLoad(ReplacerToken $token, Sequence $sequence)
    {
        parent::preLoad($token, $sequence);

        $reset = isset($token->getParams()[1]) ? $token->getParams()[1] : null;
        if ($reset != null) {
            if (array_key_exists($reset, $this->resetMap)) {
                $sequence->setStorageKey(strtolower($reset) . '.' . date($this->resetMap[$reset]));
            } else {
                throw new \InvalidArgumentException(sprintf("Sequence value resolver - Unknown reset period '%s'", $reset));
            }
        }
    }

    public function getValue(ReplacerToken $token, $value)
    {
        $params = $token->getParams();

        $padding = $params[0] > 0 && $params[0] < 20 ? $params[0] : 6;
        if ($padding < strlen((string)$value)) {
            throw new \OverflowException(
                sprintf("Sequence value resolver - Maximum value is number with %d digits, next value is %s", $padding, $value));
        }
        return sprintf("%0{$padding}d", $value);
    }
}