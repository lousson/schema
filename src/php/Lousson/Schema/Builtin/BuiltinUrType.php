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
 * Lousson\Schema\Type\BuiltinUrType class definition
 *
 * @package     org.lousson.schema
 * @copyright   (c) 2013, The Lousson Project
 * @license     http://opensource.org/licenses/bsd-license.php New BSD License
 * @author      Attila G. Levai <sgnl19 at quirkies.org>
 * @filesource
 */
namespace Lousson\Schema\Builtin;

/* Dependencies: */
use Lousson\Schema\AbstractType;

/**
 * A baseclass for builtin types
 *
 * @since       lousson/Lousson_Schema-0.1.0
 * @package     org.lousson.schema
 */
class BuiltinUrType extends AbstractType
{
    /**
     * The type name of the UrType
     *
     * @var string
     */
    const NAME = "anyType";

    /**
     * The namespace URI of all builtin types
     *
     * @var string
     */
    const NAMESPACE_URI = self::NS_SCHEMA;

    /**
     * Obtain the type's name
     *
     * The getName() method is used to retrieve the name of the type; the
     * same as the value of the StringType::NAME constant.
     *
     * @return  string
     *          The type's name is returned on success.
     */
    public function getName()
    {
        return self::NAME;
    }

    /**
     * Obtain the type's namespace URI
     *
     * The getNamespaceURI() method is used to retrieve the URI of the
     * namespace the type is associated with. (This corresponds, for
     * example, to the "target namespace" of the type definition components
     * in XML Schema.)
     *
     * Note that the builtin implementation always returns NS_SCHEMA and
     * is NOT intended to be used in classes outside the builtin schema
     * (PHP) namespace!
     *
     * @return  string
     *          The type's namespace URI is returned on success.
     */
    public function getNamespaceURI()
    {
        return self::NAMESPACE_URI;
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
            $this->normalizeItem($value = $input);
            return $value;
        }
        catch (\Lousson\Record\AnyRecordException $error) {
            $this->importError($value, $error);
        }
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
        try {
            $this->normalizeItem($output = $value);
            return $output;
        }
        catch (\Lousson\Record\AnyRecordException $error) {
            $this->exportError($value, $error);
        }
    }
}

