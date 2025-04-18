<?php

declare(strict_types=1);

namespace Lemon\Tests\Templating\Juice\Compilers\Directives;

use Lemon\Config\Config;
use Lemon\Kernel\Application;
use Lemon\Templating\Exceptions\CompilerException;
use Lemon\Templating\Factory;
use Lemon\Templating\Juice\Compiler;
use Lemon\Templating\Juice\Compilers\DirectiveCompiler;
use Lemon\Templating\Juice\Token;
use Lemon\Tests\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class ExtendsDirectiveTest extends TestCase
{
    public function testCompilation()
    {
        $application = new Application(__DIR__);
        $config = new Config($application);
        $compiler = new Compiler($config);
        new Factory($config, $compiler, $application);

        $this->assertSame(
            '<?php $_layout = new \Lemon\Templating\Juice\Compilers\Directives\Layout\Layout($_factory->make("foo.bar")->compiled_path) ?>',
            $compiler->directives->compileOpenning(new Token(Token::TAG, ['extends', '"foo.bar"'], 1), [])
        );

        $this->assertThrowable(function (DirectiveCompiler $d) {
            $d->compileOpenning(new Token(Token::TAG, ['extends', ''], 1), []);
        }, CompilerException::class, $compiler->directives);

        $this->assertThrowable(function (DirectiveCompiler $d) {
            $d->compileOpenning(new Token(Token::TAG, ['extends', 'echo'], 1), []);
        }, CompilerException::class, $compiler->directives);

        $this->assertThrowable(function (DirectiveCompiler $d) {
            $d->compileOpenning(new Token(Token::TAG, ['extends', '\'foo'], 1), []);
        }, CompilerException::class, $compiler->directives);

        $this->assertThrowable(function (DirectiveCompiler $d) {
            $d->compileOpenning(new Token(Token::TAG, ['extends', '\'foo\'"bar"'], 1), []);
        }, CompilerException::class, $compiler->directives);
    }
}
