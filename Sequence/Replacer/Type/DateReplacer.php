<?php
/**
 * User: Marek Kebza <marek@kebza.cz>
 * Date: 06/08/2017
 * Time: 19:38
 */

namespace Kebza\SequenceBundle\Sequence\Replacer\Type;


use Kebza\SequenceBundle\Sequence\Replacer\AbstractReplacer;
use Kebza\SequenceBundle\Sequence\Replacer\ReplacerToken;

class DateReplacer extends AbstractReplacer
{
    protected $map = [
        'YYYY' => 'Y',
        'YY' => 'y',
        'MM' => 'm',
        'WW' => 'W'];

    public function supports(ReplacerToken $token)
    {
        return array_key_exists($token->getToken(), $this->map);
    }

    public function getValue(ReplacerToken $token, $value)
    {
        return date($this->map[$token->getToken()]);
    }
}