<?php

namespace GetTreeRepository;

use GetTreeRepository\Logger;

/**
 * ComposerException
 */
class ComposerException extends \Exception
{
    /**
     * Method jsonError
     *
     * @return void
     */
    public function jsonError() 
    {
        
        $errorMsg = 'json Error '
                .$this->getMessage()." in "
                .basename($this->getFile()).':'.$this->getLine().PHP_EOL;

        Logger::msgLogger($errorMsg);  

        echo $errorMsg;
    }
}
