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
                .$this->getLine()." ".$this->getMessage()." "
                .$this->getFile().PHP_EOL;

        Logger::msgLogger($errorMsg);  

        echo $errorMsg;
    }
}
