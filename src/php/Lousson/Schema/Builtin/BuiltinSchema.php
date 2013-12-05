<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 textwidth=75: *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Copyright (c) 2013, The Lousson Project                               *
 *                                                                       *
 * All rights reserved.                                                  *
 *                                                                       *
 * Redistribution and use in source and binary forms, with or without    *
 * modification, are permitted provided that the following conditions    *
 * are met:                                                              *
 *                                                                       *
 * 1) Redistributions of source code must retain the above copyright     *
 *    notice, this list of conditions and the following disclaimer.      *
 * 2) Redistributions in binary form must reproduce the above copyright  *
 *    notice, this list of conditions and the following disclaimer in    *
 *    the documentation and/or other materials provided with the         *
 *    distribution.                                                      *
 *                                                                       *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS   *
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT     *
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS     *
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE        *
 * COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT,            *
 * INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES    *
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR    *
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)    *
 * HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT,   *
 * STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)         *
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED   *
 * OF THE POSSIBILITY OF SUCH DAMAGE.                                    *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

/**
 * Lousson\Schema\Builtin\BuiltinSchema class definition
 *
 * @package     org.lousson.schema
 * @copyright   (c) 2013, The Lousson Project
 * @license     http://opensource.org/licenses/bsd-license.php New BSD License
 * @author      Attila G. Levai <sgnl19 at quirkies.org>
 * @filesource
 */
namespace Lousson\Schema\Builtin;

/* Dependencies: */
use Lousson\Schema\AbstractSchema;

/**
 * The builtin implementation of the AnySchema interface
 *
 * @since       lousson/Lousson_Schema-0.1.0
 * @package     org.lousson.schema
 */
final class BuiltinSchema extends AbstractSchema
{
    /**
     *
     */
    public static function getInstance()
    {
        static $instance = null;
        isset($instance) || ($instance = new self());
        return $instance;
    }

    /**
     * Lookup a type implementation
     *
     * The getType() method returns the type object, an instance of the
     * Lousson\Schema\AnyType interface, that is associated with the given
     * $name and $namespaceURI.
     *
     * @param   string      $name           The name of the type to look up
     * @param   string      $namespaceURI   The type's namespace
     *
     * @return  \Lousson\Schema\AnyType
     *          An instance of the AnyType interface is returned on success
     *
     * @return  \Lousson\Schema\AnyType
     *          An instance of the AnyType interface is returned on success
     *
     * @throws  \Lousson\Schema\AnySchemaException
     *          All possible exceptions implement this interface
     *
     * @throws  \InvalidArgumentException
     *          Raised in case one of the input parameters is considered
     *          invalid
     *
     * @throws  \RuntimeException
     *          Raised in case of an internal error
     */
    public function getType($name, $namespaceURI = null)
    {
        $key = (string) $name;
        $uri = (string) $namespaceURI;

        if (self::NS_SCHEMA === $uri
                && isset($this->_map[$key])) {

            if (!isset($this->_types[$key])) {
                $class = $this->_map[$key];
                $this->_types[$key] = new $class;
            }

            $type = $this->_types[$key];
        }
        else {
            /* May raise a schema exception */
            $type = parent::getType($name, $namespaceURI);
        }

        return $type;
    }

    /**
     * A map ap XS type names to implementation class names
     *
     * @var array
     */
    private $_map = array(
        "anyType" =>
            "Lousson\\Schema\\Builtin\\BuiltinUrType",
        "anySimpleType" =>
            "Lousson\\Schema\\Builtin\\BuiltinSimpleType",
        "anyAtomicType" =>
            "Lousson\\Schema\\Builtin\\BuiltinAtomicType",
        "anyURI" =>
            "Lousson\\Schema\\Builtin\\BuiltinURIType",
        "string" =>
            "Lousson\\Schema\\Builtin\\BuiltinStringType",
    );

    /**
     * A register for type instances
     *
     * @var array
     */
    private $_types = array();
}
