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
     * @param string $file Ruta al archivo .json
     *
     * @return array
     */
    public function loadSchema(string $file): array;
    
    /**
     * Method validateJsonFormat
     *
     * @return bool
     */
    public function validateJsonFormat(): bool;
    
    /**
     * Method getFilePath
     *
     * @return string
     */
    public function getFilePath(): string;
    
}
