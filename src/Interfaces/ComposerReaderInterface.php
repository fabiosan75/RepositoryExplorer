<?php

/**
 * ComposerReaderInterface
 *
 * PHP version 7
 *
 * @category Interface
 * @package  RepositoryExplorer
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */

namespace RepositoryExplorer\Interfaces;

/**
 * Interface ComposerReaderInterface : Define los metodos para el acceso a las
 *                                     propiedades de un json SCHEMA
 *
 * @category Interface
 * @package  RepositoryExplorer
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */

interface ComposerReaderInterface
{
    /**
     * Method loadConfig
     *
     * @param JsonDecoderInterface $jsonDecoder [explicite description]
     *
     * @return void
     */
    public function loadConfig(JsonDecoderInterface $jsonDecoder);

    /**
     * getConfig
     *
     * @return array<string, array<string, string>|string>
     */
    public function getConfig(): array;

    /**
     * Method hasAttribute  Verifica si Atributo/propiedad existe
     *                      en el composer->config Ej : name/version/require
     *
     * @param string $attrName Nombre del Atributo/propiedad
     *
     * @return bool
     */
    public function hasAttribute(string $attrName): bool;

    /**
     * Method getAttribute
     *
     * @param string $attrName $attrName [explicite description]
     *
     * @return string
     */
    public function getAttribute(string $attrName): string;


    /**
     * Method getAttrArray
     *
     * @param string $attrName [explicite description]
     *
     * @return array<string, array<string, string>>
     */
    public function getAttrArray(string $attrName): array;

    //  public function checkPkgName(string $pkgName): bool;
}
