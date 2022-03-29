<?php

namespace GetTreeRepository;

use GetTreeRepository\Logger;

/**
 * ComposerException
 */
class CliException extends \Exception
{
    /**
     * Method jsonError
     *
     * @return void
     */
    public function cliError() 
    {
        
        $errorMsg = 'CLI Error '
                .' '.$this->getMessage().' in '
                .basename($this->getFile()).':'.$this->getLine().PHP_EOL;

        Logger::msgLogger($errorMsg);  

        echo $errorMsg;
    }
}
