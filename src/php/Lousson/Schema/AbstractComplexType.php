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
 * Lousson\Schema\AbstractComplexType class definition
 *
 * @package     org.lousson.schema
 * @copyright   (c) 2013, The Lousson Project
 * @license     http://opensource.org/licenses/bsd-license.php New BSD License
 * @author      Mathias J. Hennig <mhennig at quirkies.org>
 * @filesource
 */
namespace Lousson\Schema;

/** Dependencies: */
use Lousson\Schema\AbstractType;

/**
 * An abstract complex type implementation
 *
 * @since       lousson/Lousson_Schema-0.1.0
 * @package     org.lousson.schema
 */
abstract class AbstractComplexType extends AbstractType
{
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
    abstract protected function importItem(array $input, $key, &$value);

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
    abstract protected function exportItem(array &$output, $key, $value);

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
        $this->normalizeRecord($input);

        $keyList = array();
        $value = $this->indexInput($input, $keyList);

        try {
            foreach ($keyList as $key) {
                $this->importItem($input, $key, $value);
            }
        }
        catch (\Lousson\Schema\AnySchemaException $error) {
            $this->importError($input, $error);
        }

        return $value;
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
        $keyList = array();
        $output = $this->indexValue($value, $keyList);

        try {
            foreach ($keyList as $key) {
                $this->exportItem($output, $key, $value);
            }
        }
        catch (\Lousson\Schema\AnySchemaException $error) {
            $this->exportError($value, $error);
        }

        return $output;
    }

    /**
     * Determine index keys using the canonical representation
     *
     * The indexInput() method is used internally to populate a sequence
     * of index $keys (strings), each of which is used in an invocation of
     * importItem() during the import() process. Additionally, it returns
     * a prototype of the internal representation for use as the $value
     * reference.
     *
     * @param   array               $input      The input record to map
     * @param   array               $keys       The index keys to populate
     *
     * @return  mixed
     *          An internal value prototype is returned on success
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
    protected function indexInput(array $input, array &$keys)
    {
        $keys = array_keys($input);
        return array();
    }

    /**
     * Determine index keys using the internal representation
     *
     * The indexValue() method is used internally to populate a sequence
     * of index $keys (strings), each of which is used in an invocation of
     * exportItem() during the export() process. Additionally, it returns
     * a prototype record for use as the $output reference.
     *
     * @param   mixed               $value      The internal value to map
     * @param   array               $keys       The index keys to populate
     *
     * @return  array
     *          A (possibly empty) record prototype is returned on success
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
    protected function indexValue($value, array &$keys)
    {
        if (is_array($value)) {
            $keys = array_keys($value);
        }
        else {
            $this->exportError($value);
        }

        return array();
    }
}

