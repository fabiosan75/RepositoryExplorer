<?php

namespace GetTreeRepository;

/**
 * FileSystemInterface
 */

interface FileReaderInterface
{

    public static function canReadFile(string $filename):bool;

    public static function readFile( string $filename): string;

}
