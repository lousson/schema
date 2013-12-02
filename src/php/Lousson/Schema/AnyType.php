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
 * Lousson\Schema\AnyType interface definition
 *
 * @package     org.lousson.schema
 * @copyright   (c) 2013, The Lousson Project
 * @license     http://opensource.org/licenses/bsd-license.php New BSD License
 * @author      Mathias J. Hennig <mhennig at quirkies.org>
 * @filesource
 */
namespace Lousson\Schema;

/**
 * An interface for types
 *
 * @since       lousson/Lousson_Schema-0.1.0
 * @package     org.lousson.schema
 */
interface AnyType
{
	/**
     * The namespace URI of XML Schema
     *
     * @var string
     */
    const NS_SCHEMA = "http://www.w3.org/2001/XMLSchema";

    /**
     * Obtain the type's name
     *
     * The getName() method is used to retrieve the name of the type.
     *
     * @return  string
     *          The type's name, if any, is returned on success.
     *          NULL is returned in case the type is not associated with
     *          a name.
     */
    public function getName();

    /**
     * Obtain the type's namespace URI
     *
     * The getNamespaceURI() method is used to retrieve the URI of the
     * namespace the type is associated with. (This corresponds, for
     * example, to the "target namespace" of the type definition components
     * in XML Schema.)
     *
     * @return  string
     *          The type's namespace URI, if any, is returned on success.
     *          NULL is returned in case the type is not associated with
     *          any namespace.
     */
    public function getNamespaceURI();

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
    public function import($input);

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
    public function export($value);

    /**
     * Import a value from another type's representation
     *
     * The importFrom() method is used to import the given $input from
     * the $type's representation to the own value space.
     *
     * @param   AnyType         $type       The type to import from
     * @param   string          $input      The value to import
     *
     * @return  mixed
     *          The imported value is returned on success
     *
     * @throws  \Lousson\Schema\AnySchemaException
     *          All possible exceptions implement this interface
     *
     * @throws  \InvalidArgumentException
     *          Raised in case either the given $input representation is
     *          or the imported value would be considered invalid by either
     *          of the two types
     *
     * @throws  \RuntimeException
     *          Raised in case of an internal error
     */
    public function importFrom(AnyType $type, $input);

    /**
     * Export a value into another type's representation
     *
     * The exportTo() method is used to export the given $value from the
     * own value space into the $type's canonical representation.
     *
     * @param   AnyType         $type   The type to export to
     * @param   mixed           $value  The value to export
     *
     * @return  string
     *          The exported representation is returned on success
     *
     * @throws  \Lousson\Schema\AnyTypeException
     *          All possible exceptions implement this interface
     *
     * @throws  \InvalidArgumentException
     *          Raised in case the given $value is considered invalid by
     *          either of the two types
     *
     * @throws  \RuntimeException
     *          Raised in case of an internal error
     */
    public function exportTo(AnyType $type, $value);
}

