<?php
/**
 * User: Marek Kebza <marek@kebza.cz>
 * Date: 06/08/2017
 * Time: 19:19
 */

namespace Kebza\SequenceBundle\Tests\Sequence\Replacer\Type;

use Kebza\SequenceBundle\Sequence\Replacer\ReplacerToken;
use Kebza\SequenceBundle\Sequence\Replacer\Type\ValueReplacer;
use Kebza\SequenceBundle\Sequence\Sequence;
use PHPUnit\Framework\TestCase;

class ValueReplacerTest extends TestCase
{
    public function testStorageKeyChangeYear()
    {
        $replacer = new ValueReplacer();
        $sequence = new Sequence('test', '{ID|4|YEAR}', 1, 1);
        $token = new ReplacerToken('ID', [4, 'YEAR'], '{ID|4|YEAR}');

        $replacer->preLoad($token, $sequence);

        $this->assertContains('year', $sequence->getStorageKey());
    }

    public function testStorageKeyChangeMonth()
    {
        $replacer = new ValueReplacer();
        $sequence = new Sequence('test', '{ID|4|MONTH}', 1, 1);
        $token = new ReplacerToken('ID', [4, 'MONTH'], '{ID|4|MONTH}');

        $replacer->preLoad($token, $sequence);

        $this->assertContains('month', $sequence->getStorageKey());
    }

    public function testStorageKeyChangeWeek()
    {
        $replacer = new ValueReplacer();
        $sequence = new Sequence('test', '{ID|4|WEEK}', 1, 1);
        $token = new ReplacerToken('ID', [4, 'WEEK'], '{ID|4|WEEK}');

        $replacer->preLoad($token, $sequence);

        $this->assertContains('week', $sequence->getStorageKey());
    }

    public function testStorageKeyChangeInvalid()
    {
        $replacer = new ValueReplacer();
        $sequence = new Sequence('test', '{ID|4|INVALID}', 1, 1);
        $token = new ReplacerToken('ID', [4, 'INVALID'], '{ID|4|INVALID}');

        $this->expectException(\InvalidArgumentException::class);
        $replacer->preLoad($token, $sequence);
    }


    public function testValueReplace()
    {
        $replacer = new ValueReplacer();
        $token = new ReplacerToken('ID', [4], '{ID|4}');

        $this->assertEquals('0012', $replacer->getValue($token, 12));
    }

    public function testValueReplaceOverflow()
    {
        $replacer = new ValueReplacer();
        $token = new ReplacerToken('ID', [4], '{ID|4}');

        $this->expectException(\OverflowException::class);
        $this->assertEquals('0012', $replacer->getValue($token, 12345));
    }

}
