<?php

namespace GetTreeRepository\Interfaces;

interface JsonDecoderInterface
{
    
    /**
     * Method getContent
     *
     * @return string
     */
    public function getSchema(): string;

    public function loadSchema(): void;

    public function validateJsonFormat(): bool;

    public function decodeSchema();

   // public function getPropertySchema(string $propertyName);


    
}
