<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2017 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Test\CodeCleaner;

use Psy\CodeCleaner\StrictTypesPass;

class StrictTypesPassTest extends CodeCleanerTestCase
{
    public function setUp()
    {
        if (version_compare(PHP_VERSION, '7.0', '<')) {
            $this->markTestSkipped();
        }

        $this->setPass(new StrictTypesPass());
    }

    public function testProcess()
    {
        $this->assertProcessesAs('declare(strict_types=1)', '