<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Input;

use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Exception\LogicException;

/**
 * Represents a command line argument.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class InputArgument
{
    const REQUIRED = 1;
    const OPTIONAL = 2;
    const IS_ARRAY = 4;

    private $name;
    private $mode;
    private $default;
    private $description;

    /**
     * Constructor.
     *
     * @param string $name        The argument name
     * @param int    $mode        The argument mode: self::RE