<?php

declare(strict_types=1);

namespace Lemon\Templating\Juice\Compilers\Directives;

use Lemon\Templating\Exceptions\CompilerException;
use Lemon\Templating\Juice\Token;

final class UnlessDirective implements Directive
{
    public function compileOpenning(Token $token, array $stack): string
    {
        if ('' === $token->content[1]) {
            throw new CompilerException('Directive unless expects arguments', $token->line);
        }

        return 'if (!('.$token->content[1].')):';
    }

    public function compileClosing(): string
    {
        return 'endif';
    }
}
