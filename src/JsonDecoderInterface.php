<?php

namespace GetTreeRepository;

interface JsonDecoderInterface
{

    public function decode(string $schema): array;

    public function getPropertySchema(string $propertyName):string;


    
}
