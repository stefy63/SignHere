<?php

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Monolog\Handler;

use Monolog\Formatter\JsonFormatter;
use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;

class EloquentHandler extends AbstractProcessingHandler {
    
    public function __construct($level = Logger::DEBUG, $bubble = true)
    {
        parent::__construct($level, $bubble);
    }
    
    
    
    protected function write(array $record) {
        //var_dump($record);
        \App\Models\Log::create([
            'env'     => $record['channel'],
            'message' => substr($record['message'],0,475),
            'level'   => $record['level_name'],
            'context' => $record['context'],
            'extra'   => $record['extra']
        ]);
    }
}
