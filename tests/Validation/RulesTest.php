<?php

declare(strict_types=1);

namespace Lemon\Tests\Validation;

use Lemon\Tests\TestCase;
use Lemon\Validation\Rules;

/**
 * @internal
 *
 * @coversNothing
 */
class RulesTest extends TestCase
{
    public function testNumeric()
    {
        $r = new Rules();
        $this->assertTrue($r->numeric('37'));
        $this->assertFalse($r->numeric('parek'));

        $this->assertFalse($r->notNumeric('37'));
        $this->assertTrue($r->notNumeric('parek'));
    }

    public function testEmail()
    {
        $r = new Rules();
        $this->assertTrue($r->email('x@y.cz'));
        $this->assertFalse($r->email('x.cz'));
    }

    public function testUrl()
    {
        $r = new Rules();
        $this->assertTrue($r->url('https://foo.bar/parek'));
        $this->assertFalse($r->url('foo.bar/parek'));
    }

    public function testColor()
    {
        $r = new Rules();
        $this->assertTrue($r->color('#FfbB00'));
        $this->assertTrue($r->color('#ffb'));
        $this->assertFalse($r->color('ffbb00'));
        $this->assertFalse($r->color('#fbb00'));
        $this->assertFalse($r->color('#fbbG00'));
    }

    public function testMin()
    {
        $r = new Rules();
        $this->assertTrue($r->min('foo', 2));
        $this->assertTrue($r->min('foo', 3));
        $this->assertFalse($r->min('f', 2));
    }

    public function testMax()
    {
        $r = new Rules();
        $this->assertTrue($r->max('foo', 4));
        $this->assertTrue($r->max('foo', 3));
        $this->assertFalse($r->max('fooo', 2));
    }

    public function testRe()
    {
        $r = new Rules();
        $this->assertTrue($r->regex('foo', 'f(oo)?'));
        $this->assertFalse($r->regex('fo', 'f(oo)?'));

        $this->assertFalse($r->notRegex('foo', 'f(oo)?'));
        $this->assertTrue($r->notRegex('fo', 'f(oo)?'));
    }

    public function testContains()
    {
        $r = new Rules();
        $this->assertTrue($r->contains('ofooooo', 'f(oo)?'));
        $this->assertFalse($r->contains('ppprr', 'f(oo)?'));

        $this->assertFalse($r->doesntContain('pasdfooooooo', 'f(oo)?'));
        $this->assertTrue($r->doesntContain('asjpkhjasiop', 'f(oo)?'));
    }

    public function testCalling()
    {
        $r = new Rules();
        $this->assertTrue($r->call('parek', ['min', '1']));
        $this->assertTrue($r->call('p@a.rek', ['email']));
        $r->rule('name', fn ($name) => ucfirst($name) === $name);
        $this->assertTrue($r->call('Parek', ['name']));
    }
}
