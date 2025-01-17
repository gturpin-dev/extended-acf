<?php

/**
 * Copyright (c) Vincent Klaiber.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @see https://github.com/vinkla/extended-acf
 */

declare(strict_types=1);

namespace Extended\ACF;

use InvalidArgumentException;

class Key
{
    public static array $keys = [];

    /** @throws \InvalidArgumentException */
    public static function generate(string $key, string $prefix): string
    {
        if (array_key_exists($key, self::$keys)) {
            throw new InvalidArgumentException("The key [$key] is not unique.");
        }

        $hashedKey = $prefix . '_' . static::hash($key);

        static::$keys[$key] = $hashedKey;

        return $hashedKey;
    }

    public static function hash(string $key): string
    {
        return hash('fnv1a32', $key);
    }

    public static function sanitize(string $key): string
    {
        return str_replace('-', '_', sanitize_title($key));
    }

    public static function resolveParentKey(string|null $parentKey, string $key): string
    {
        $parentKeyPieces = explode('_', $parentKey);

        while (count($parentKeyPieces) > 1) {
            array_pop($parentKeyPieces);

            $potentialParentKey = implode('_', $parentKeyPieces);
            $potentialKey = $potentialParentKey . '_' . $key;

            if (array_key_exists($potentialKey, self::$keys)) {
                return $potentialParentKey;
            }
        }

        return $parentKey;
    }
}
