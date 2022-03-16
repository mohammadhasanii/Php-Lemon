<?php

declare(strict_types=1);

namespace Lemon;

/**
 * Static layer over Lemon Config.
 *
 * @method static \Lemon\Support\Types\Array_ part(string $part) Returns part of config
 */
class Config extends Zest
{
    protected static function unit(): string
    {
        return 'config';
    }
}
