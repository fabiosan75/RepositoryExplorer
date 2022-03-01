<?php

namespace GetTreeRepository;

/**
 * FileSystemInterface
 */

interface FileSystemReaderInterface
{
       
    /**
     * Method listDirectory
     *
     * @param string $dirPath [explicite description]
     *
     * @return array
     */

    public static function listDirectory( string $dirpath,string $pattern):array; 
 
    public static function canReadFile(string $filename):bool;

    public static function readFile( string $filename): string;


}
