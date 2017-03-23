;

        $this->assertContains('PHP Parse error', $streamContents);
        $this->assertContains('message', $streamContents);
        $this->assertContains('line 13', $streamContents);
    }

    public function testHandlingErrors()
    {
        $shell  = new Shell($this->getConfig());
        $output = $this->getOutput();
        $stream = $output->getStream();
        $shell->setOutput($output);

        $oldLevel = error_reporting();
        error_reporting($oldLevel & ~E_USER_NOTICE);

        try {
            $shell->handleError(E_USER_NOTICE, 'wheee', null, 13);
        } catch (ErrorException $e) {
            error_reporting($oldLevel);
            $this->fail('Unexpected error exception');
        }
        error_reporting($oldLevel);

        rewind($stream);
        $streamContents = stream_get_contents($stream);

        $this->assertContains('PHP error:', $streamContents);
        $this->assertContains('wheee',      $streamContents);
        $this->assertContains('line 13',    $streamContents);
    }

    /**
     * @expectedException \Psy\Exception\ErrorException
     */
    public function testNotHandlingErrors()
    {
        $shell    = new Shell($this->getConfig());
        $oldLevel = error_reporting();
        error_reporting($oldLevel | E_USER_NOTICE);

        try {
            $shell->handleError(E_USER_NOTICE, 'wheee', null, 13);
        } catch (ErrorException $e) {
            error_reporting($oldLevel);
            throw $e;
        }
    }

    public function testVersion()
    {
        $shell = new Shell($this->getConfig());

        $this->assertInstanceOf('Symfony\Component\Console\Application', $shell);
        $this->assertContains(Shell::VERSION, $shell->getVersion());
        $this->assertContains(phpversion(), $shell->getVersion());
        $this->assertContains(php_sapi_name(), $shell->getVersion());
    }

    public function testCodeBuffer()
    {
        $shell = new Shell($this->getConfig());

        $shell->addCode('class');
        $this->assertNull($shell->flushCode());
        $this->assertTrue($shell->hasCode());

        $shell->addCode('a');
        $this->assertNull($shell->flushCode());
        $this->assertTrue($shell->hasCode());

        $shell->addCode('{}');
        $code = $shell->flushCode();
        $this->assertFalse($shell->hasCode());
        $code = preg_replace('/\s+/', ' ', $code);
        $this->assertNotNull($code);
        $this->assertEquals('class a { }', $code);
    }

    public function testKeepCodeBufferOpen()
    {
        $shell = new Shell($this->getConfig());

        $shell->addCode('1 \\');
        $this->assertNull($shell->flushCode());
        $this->assertTrue($shell->hasCode());

        $shell->addCode('+ 1 \\');
        $this->assertNull($shell->flushCode());
        $this->assertTrue($shell->hasCode());

        $shell->addCode('+ 1');
        $code = $shell->flushCode();
        $this->assertFalse($shell->hasCode());
        $code = preg_replace('/\s+/', ' ', $code);
        $this->assertNotNull($code);
        $this->assertEquals('return 1 + 1 + 1;', $code);
    }

    /**
     * @expectedException \Psy\Exception\ParseErrorException
     */
    public function testCodeBufferThrowsParseExceptions()
    {
        $shell = new Shell($this->getConfig());
        $shell->addCode('this is not valid');
        $shell->flushCode();
    }

    public function testClosuresSupport()
    {
        $shell = new Shell($this->getConfig());
        $code = '$test = function