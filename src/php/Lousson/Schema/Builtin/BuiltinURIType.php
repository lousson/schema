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
 * Lousson\Schema\Builtin\BuiltinURIType class definition
 *
 * @package     org.lousson.schema
 * @copyright   (c) 2013, The Lousson Project
 * @license     http://opensource.org/licenses/bsd-license.php New BSD License
 * @author      Attila G. Levai <sgnl19 at quirkies.org>
 * @filesource
 */
namespace Lousson\Schema\Builtin;

/* Dependencies: */
use Lousson\Schema\Builtin\BuiltinAtomicType;
use Lousson\URI\AnyURIFactory;
use Lousson\URI\Builtin\BuiltinURIFactory;

/**
 * A generic implementation of the AnySchema interface
 *
 * @since       lousson/Lousson_Schema-0.1.0
 * @package     org.lousson.schema
 */
class BuiltinURIType extends BuiltinAtomicType
{
    /**
     * The type name of the URIType
     *
     * @var string
     */
    const NAME = "anyURI";

    /**
     * Obtain an URI type instance
     *
     * The static getInstance() method is a shortcut used to obtain an
     * URIType instance.
     *
     * Note that this method is deprecated; it has been introduced only
     * to work as an intermediary solution for the dependency issue in
     * the AbstractEnty class anyway!
     *
     * @return  \Lousson\Schema\Type\URIType
     *          An URI type type instance is returned on success
     */
    public static function getInstance()
    {
        static $instance = null;
        isset($instance) || ($instance = new self());
        return $instance;
    }

    /**
     *
     */
    public function __construct(AnyURIFactory $factory = null)
    {
        if (!isset($factory)) {
            $factory = new BuiltinURIFactory();
        }

        $this->_factory = $factory;
    }

    /**
     * Obtain the type's name
     *
     * The getName() method is used to retrieve the name of the type; the
     * same as the value of the URIType::NAME constant.
     *
     * @return  string
     *          The type's name is returned on success.
     */
    public function getName()
    {
        return self::NAME;
    }

    /**
     * Import to value space
     *
     * The import() method converts the given $input representation,
     * which must conform to the "record item" definition, to it's internal
     * value, which might be anything - with the restriction that every
     * type should use only one internal representation.
     *
     * @param   string  $input      The value to import
     *
     * @return  mixed
     *          The internal representation is returned on success
     *
     * @throws  \Lousson\Schema\AnySchemaException
     *          All possible exceptions implement this interface
     *
     * @throws  \InvalidArgumentException
     *          Raised in case either the given $input representation is
     *          or the imported value would be considered invalid
     *
     * @throws  \RuntimeException
     *          Raised in case of an internal error
     */
    public function import($input)
    {
        try {
            $lexical = parent::import($input);
            $uri = $this->_factory->getURI($lexical);
        }
        catch (\Lousson\URI\AnyURIException $error) {
            $this->importError($input, $error);
        }

        return $uri;
    }

    /**
     * Export from value space
     *
     * The export() method is used to convert the given $value (which
     * must be a compatible, probably import()ed representation) to it's
     * canonical representation, which must comply to the "record item"
     * definition.
     *
     * @param   mixed   $value      The value to export
     *
     * @return  mixed
     *          The $value's canonical representation is returned on success
     *
     * @throws  \Lousson\Schema\AnySchemaException
     *          All possible exceptions implement this interface
     *
     * @throws  \InvalidArgumentException
     *          Raised in case the given $value is considered invalid
     *
     * @throws  \RuntimeException
     *          Raised in case of an internal error
     */
    public function export($value)
    {
        if (!$value instanceof \Lousson\URI\AnyURI) try {
            $lexical = parent::export($value);
            $uri = $this->_factory->getURI($lexical);
        }
        catch (\Lousson\URI\AnyURIException $error) {
            $this->exportError($value, $error);
        }
        else {
            $uri = $value;
        }

        $output = (string) $uri;
        return $output;
    }

    /**
     * @var \Lousson\URI\AnyURIFactory
     */
    private $_factory;
}

