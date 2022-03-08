<?php

namespace GetTreeRepository\Interfaces;

/**
 * JsonDecoderInterface
 */
interface JsonDecoderInterface
{
    
    /**
     * Method getSchema
     *
     * @return string
     */
    public function getSchema(): string;
    
    /**
     * Method loadSchema
     *
     * @return void
     */
    public function loadSchema(): array;
    
    /**
     * Method validateJsonFormat
     *
     * @return bool
     */
    public function validateJsonFormat(): bool;
    
    /**
     * Method decodeSchema
     *
     * @return void
     */
   // public function decodeSchema();

   // public function getPropertySchema(string $propertyName);


    
}
