<?php

/**
 * Copyright (c) Vincent Klaiber.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @see https://github.com/wordplate/extended-acf
 */

declare(strict_types=1);

namespace WordPlate\Acf\Fields\Attributes;

trait Message
{
    /** @return static */
    public function message(string $message): self
    {
        $this->config->set('message', $message);

        return $this;
    }
}
