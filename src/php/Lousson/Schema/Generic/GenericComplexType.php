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
 * Lousson\Schema\Generic\GenericComplexType class definition
 *
 * @package     org.lousson.schema
 * @copyright   (c) 2013, The Lousson Project
 * @license     http://opensource.org/licenses/bsd-license.php New BSD License
 * @author      Attila G. Levai <sgnl19 at quirkies.org>
 * @filesource
 */
namespace Lousson\Schema\Generic;

/* Dependencies: */
use Lousson\Schema\AbstractComplexType;
use Lousson\Schema\AnyType;
use Lousson\Schema\Error\SchemaArgumentError;

/**
 * A generic, complex type implementation
 *
 * @since       lousson/Lousson_Schema-0.1.0
 * @package     org.lousson.schema
 */
class GenericComplexType extends AbstractComplexType
{
    /**
     * Register a member type
     *
     * The setMemberType() method is used to register the given $type
     * with the $key (an xs::NCName) provided.
     *
     * @param   string              $key        The member's key
     * @param   string              $type       The member's type
     */
    public function setMemberType($key, AnyType $type)
    {
        $this->normalizeNCName($key);
        $this->_members[$key] = $type;
    }

    /**
     *
     */
    public function getMemberType($key)
    {
        $this->normalizeNCName($key);

        if (!isset($this->_members[$key])) {
            $name = $this->getName();
            $namespaceURI = $this->getNamespaceURI();
            $pattern = isset($name)
                ? "The {%2}%3s type has no \"%1s\" member item"
                : "The type has no \"%1s\" member item";
            $message = sprintf($pattern, $key, $namespaceURI, $name);
            $code = SchemaArgumentError::E_INVALID;
            throw new SchemaArgumentError($message, $code);
        }

        return $this->_members[$key];
    }

    /**
     * Import a record item
     *
     * The importItem() method is used internally by the import() method
     * when iterating over each $key in the sequence of keys returned by
     * indexInput() in order to import the $input record into it's $value
     * representation.
     *
     * @param   array               $input  The input record
     * @param   string              $key    The key to import
     * @param   mixed               $value  The internal value
     *
     * @throws  \Lousson\Schema\AnySchemaException
     *          All possible exceptions implement this interface
     *
     * @throws  \InvalidArgumentException
     *          Raised in case either the given $input is or the imported
     *          $value would be considered invalid
     *
     * @throws  \RuntimeException
     *          Raised in case of an internal error
     */
    protected function importItem(array $input, $key, &$value)
    {
        $this->normalizeString($key);
        $this->normalizeValue($value);

        $type = $this->getMemberType($key);
        $data = isset($input[$key])? $input[$key]: null;

        $value[$key] = $type->import($data);
    }

    /**
     * Export a record item
     *
     * The exportItem() method is used internally by the export() method
     * when iterating over each $key in the sequence of keys returned by
     * indexValue() in order to export the internal $value into the $output
     * record representation.
     *
     * @param   array               $output The output record
     * @param   string              $key    The key to import
     * @param   mixed               $value  The internal value
     *
     * @throws  \Lousson\Schema\AnySchemaException
     *          All possible exceptions implement this interface
     *
     * @throws  \InvalidArgumentException
     *          Raised in case either the given $value is or the exported
     *          $output would be considered invalid
     *
     * @throws  \RuntimeException
     *          Raised in case of an internal error
     */
    protected function exportItem(array &$output, $key, $value)
    {
        $this->normalizeString($key);
        $this->normalizeValue($value);

        $type = $this->getMemberType($key);
        $data = isset($value[$key])? $value[$key]: null;

        $output[$key] = $type->export($data);
    }

    /**
     * The normalizeValue() method is used internally to ensure that the
     * given $value reference is linked to an array.
     */
    final protected function normalizeValue(&$value)
    {
        is_array($value) || parent::normalizeValue($value);
    }

    /**
     * The list of member types, if any
     *
     * @var array
     */
    private $_members = array();
}

