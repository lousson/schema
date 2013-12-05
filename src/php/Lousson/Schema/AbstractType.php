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
 * Lousson\Schema\AbstractType class definition
 *
 * @package     org.lousson.schema
 * @copyright   (c) 2013, The Lousson Project
 * @license     http://opensource.org/licenses/bsd-license.php New BSD License
 * @author      Mathias J. Hennig <mhennig at quirkies.org>
 * @filesource
 */
namespace Lousson\Schema;

/** Dependencies: */
use Lousson\Schema\AbstractComponent;
use Lousson\Schema\AnyType;
use Lousson\Schema\Error\SchemaArgumentError;
use Lousson\Record\Builtin\BuiltinRecordUtil;
use Exception;

/**
 * An abstract type implementation
 *
 * @since       lousson/Lousson_Schema-0.1.0
 * @package     org.lousson.schema
 */
abstract class AbstractType extends AbstractComponent implements AnyType
{
    /**
     * Obtain the type's name
     *
     * The getName() method is used to retrieve the name of the type.
     *
     * Note that the default implementation in Lousson\Schema\AbstractType
     * always returns NULL! Authors of derived classes must re-implement
     * the methods in order to allow for a more flexible approach.
     *
     * @return  string
     *          The type's name, if any, is returned on success.
     *          NULL is returned in case the type is not associated with
     *          a name.
     */
    public function getName()
    {
        return null;
    }

    /**
     * Obtain the type's namespace URI
     *
     * The getNamespaceURI() method is used to retrieve the URI of the
     * namespace the type is associated with. (This corresponds, for
     * example, to the "target namespace" of the type definition components
     * in XML Schema.)
     *
     * Note that the default implementation in Lousson\Schema\AbstractType
     * always returns NULL! Authors of derived classes must re-implement
     * the methods in order to allow for a more flexible approach.
     *
     * @return  string
     *          The type's namespace URI, if any, is returned on success.
     *          NULL is returned in case the type is not associated with
     *          any namespace.
     */
    public function getNamespaceURI()
    {
        return null;
    }

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
    public function importFrom(AnyType $type, $input)
    {
        $a = $type->import($input);
        $b = $type->export($a);
        $c = $this->import($b);

        return $c;
    }

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
    public function exportTo(AnyType $type, $value)
    {
        $a = $this->export($value);
        $b = $type->import($a);
        $c = $type->export($b);

        return $c;
    }

    /**
     *
     */
    protected function importError($input, Exception $previous = null)
    {
        $this->raiseArgumentError(self::$_importErrors, $input, $previous);
    }

    /**
     *
     */
    protected function exportError($value, Exception $previous = null)
    {
        $this->raiseArgumentError(self::$_exportErrors, $value, $previous);
    }

    /**
     *
     */
    protected function normalizeValue($input)
    {
        $this->raiseArgumentError(self::$_valueErrors, $input);
    }

    /**
     *
     */
    final protected function normalizeRecord(&$input)
    {
        if (is_array($input)) try {
            $input = BuiltinRecordUtil::normalizeItem($input);
        }
        catch (\Lousson\Record\AnyRecordException $error) {
            $this->raiseArgumentError(self::$_recordErrors, $input, $error);
        }
        else {
            $this->raiseArgumentError(self::$_typeErrors, $input);
        }

    }

    /**
     *
     */
    final protected function normalizeItem(&$input)
    {
        try {
            $input = BuiltinRecordUtil::normalizeItem($input);
        }
        catch (\Lousson\Record\AnyRecordException $error) {
            $this->raiseArgumentError(self::$_itemErrors, $input, $error);
        }
    }

    /**
     *
     */
    final protected function raiseArgumentError(
        array $pattern,
        $subject,
        Exception $previous = null)
    {
        $namespaceURI = $this->getNamespaceURI();
        $name = $this->getName();
        $type = gettype($subject);
        $class = is_object($subject)? get_class($subject): "primitive";
        $id = (is_object($subject) << 1) | isset($name);
        $format = (string) $pattern[$id % count($pattern)];
        $error = sprintf($format, $type, $class, $namespaceURI, $name);
        $code = SchemaArgumentError::E_INVALID;
        throw new SchemaArgumentError($error, $code, $previous);
    }

    /**
     * @var array
     */
    private static $_importErrors = array(
        "Could not import %1\$s as internal value",
        "Could not import %1\$s as {%3\$s}%4\$s",
        "Could not import instance of %2\$s as internal value",
        "Could not import instance of %2\$s as {%3\$s}%4\$s",
    );

    /**
     * @var array
     */
    private static $_exportErrors = array(
        "Could not export %1\$s as internal value",
        "Could not export %1\$s as {%3\$s}%4\$s",
        "Could not export instance of %2\$s as internal value",
        "Could not export instance of %2\$s as {%3\$s}%4\$s",
    );

    /**
     * @var array
     */
    private static $_typeErrors = array(
        "Could not use %1\$s as complex structure",
        "Could not use %1\$s as as {%3\$s}%4",
        "Could not use instance of %2\$s as complex structure",
        "Could not use instance of %2\$s as {%3\$s}%4\$s",
    );

    /**
     * @var array
     */
    private static $_recordErrors = array(
        "Could not use malformed record as complex structure",
        "Could not use malformed record as as {%3\$s}%4\$s",
    );

    /**
     * @var array
     */
    private static $_itemErrors = array(
        "Could not use %1\$s as complex structure item",
        "Could not use %1\$s as as {%3\$s}%4 item",
        "Could not use instance of %2\$s as complex structure item",
        "Could not use instance of %2\$s as {%3\$s}%4\$s item",
    );

    /**
     *
     */
    private static $_valueErrors = array(
        "Could not use %1\$s as internal value",
        "Could not use %1\$s as as {%3}%4",
        "Could not use instance of %2\$s as internal value",
        "Could not use instance of %2\$s as {%3}%4",
    );
}

