<?php
/**
 * User: Marek Kebza <marek@kebza.cz>
 * Date: 06/08/2017
 * Time: 19:45
 */

namespace Kebza\SequenceBundle\Tests\Sequence\Replacer\Type;

use Kebza\SequenceBundle\Sequence\Replacer\ReplacerToken;
use Kebza\SequenceBundle\Sequence\Replacer\Type\DateReplacer;
use PHPUnit\Framework\TestCase;

class DateReplacerTest extends TestCase
{
    public function testValueReplaceYYYY()
    {
        $replacer = new DateReplacer();
        $token = new ReplacerToken('YYYY', [], '{YYYY}');

        $this->assertEquals(date('Y'), $replacer->getValue($token, 1));
    }

    public function testValueReplaceYY()
    {
        $replacer = new DateReplacer();
        $token = new ReplacerToken('YY', [], '{YY}');

        $this->assertEquals(date('y'), $replacer->getValue($token, 1));
    }

    public function testValueReplaceMM()
    {
        $replacer = new DateReplacer();
        $token = new ReplacerToken('MM', [], '{MM}');

        $this->assertEquals(date('m'), $replacer->getValue($token, 1));
    }

    public function testValueReplaceWW()
    {
        $replacer = new DateReplacer();
        $token = new ReplacerToken('WW', [], '{WW}');

        $this->assertEquals(date('W'), $replacer->getValue($token, 1));
    }

}
