<?php

/**
 * ComposerReaderInterface
 *
 * PHP version 7
 *
 * @category Class
 * @package  GetTreeRepository
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */

namespace GetTreeRepository\Interfaces;

/**
 * ComposerReaderInterface
 */
interface ComposerReaderInterface
{
    const URL_BASE_REPOSITORY = 'https://github.com/';
    const TYPE_REPOSITORY = 'vcs';

    /**
     * Method getPropertySchema
     *
     * @param string $propertyName [explicite description]
     *
     * @return void
     */
    public function getPropertySchema(string $propertyName);

    public function loadConfig(JsonDecoderInterface $jsonDecoder);

    public function hasAttribute($attrName):bool;

    public function getAttribute($attrName);

    public function getAttrArray(string $attrName): array;

    public function checkPkgName(string $pkgName): bool;


}
