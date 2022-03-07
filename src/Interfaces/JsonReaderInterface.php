<?php

namespace GetTreeRepository\Interfaces;

/**
 * JsonReaderInterface
 */
interface JsonReaderInterface
{
    public function getContent(string $filename): string;
}
