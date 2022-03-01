<?php

namespace GetTreeRepository;

interface JsonReaderInterface
{

    public function getContent(string $filename): string;

}
