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
 * Lousson\Schema\AbstractComponent class definition
 *
 * @package     org.lousson.schema
 * @copyright   (c) 2013, The Lousson Project
 * @license     http://opensource.org/licenses/bsd-license.php New BSD License
 * @author      Mathias J. Hennig <mhennig at quirkies.org>
 * @filesource
 */
namespace Lousson\Schema;

/* Dependencies: */
use Lousson\Schema\Builtin\BuiltinStringType;
use Lousson\Schema\Builtin\BuiltinURIType;
use Lousson\Schema\Error\SchemaArgumentError;

/**
 * An abstract schema implementation
 *
 * @since       lousson/Lousson_Schema-0.1.0
 * @package     org.lousson.schema
 */
abstract class AbstractComponent
{
	/**
     * The namespace URI of XML Schema
     *
     * @var string
     */
    const NS_SCHEMA = "http://www.w3.org/2001/XMLSchema";

    /**
     *
     */
    final protected function importURI($uri)
    {
        if (isset($uri)) {
            $type = BuiltinURIType::getInstance();
            $value = $type->import($uri);
        }
        else {
            $value = null;
        }

        return $value;
    }

    /**
     * Fetch an xs:string value
     *
     * The normalizeString() method is used internally to fetch and verify
     * the given $input value according to the xs:string type.
     *
     * @param   mixed               $input      The value to fetch
     *
     * @throws  \Lousson\Schema\Error\SchemaArgumentError
     *          Raised in case the given $input could not get used as or
     *          converted into a string value
     */
    final protected function normalizeString(&$input)
    {
        static $errorMessageProtos = array(
            "Could not use %1\$s as string value",
            "Could not use instance of %2\$s as string value",
        );

        if (is_scalar($input) || (is_object($input)
                && is_callable(array($input, "__toString")) )) {
            $string = (string) $input;
        }
        else {
            $this->raiseArgumentError($errorMessageProtos, $input);
        }
    }

    /**
     * Fetch an xs:name value
     *
     * The normalizeName() method is used internally to fetch and verify
     * the given $input value according to the xs:name type.
     *
     * @param   mixed               $input      The value to fetch
     *
     * @throws  \Lousson\Schema\Error\SchemaArgumentError
     *          Raised in case the given $input could not get used as or
     *          converted into a xs:name/string value
     */
    final protected function normalizeName(&$input)
    {
        $this->normalizeString($input);
        $valid = preg_match(json_decode(
            '"/^[:A-Z_a-z\\\\Xc0-\\\\Xd6\\\\Xd8-\\\\Xf6'.       // NameStartChar
            '\\\\Xf8-\\\\X2ff\\\\X370-\\\\X37d\\\\X37f-\\\\X1fff'.  // NameStartChar
            '\\\\X200c-\\\\X200d\\\\X2070-\\\\X218f'.           // NameStartChar
            '\\\\X2c00-\\\\X2fef\\\\X3001-\\\\Xd7ff'.           // NameStartChar
            '\\\\Xf900-\\\\Xfdcf\\\\Xfdf0-\\\\Xfffd'.           // NameStartChar
            '\\\\X10000-\\\\Xeffff]'.                       // NameStartChar
            '[:A-Z_a-z\\\\Xc0-\\\\Xd6\\\\Xd8-\\\\Xf6'.          // NameChar
            '\\\\Xf8-\\\\X2ff\\\\X370-\\\\X37d\\\\X37f-\\\\X1fff'.  // NameChar
            '\\\\X200c-\\\\X200d\\\\X2070-\\\\X218f'.           // NameChar
            '\\\\X2c00-\\\\X2fef\\\\X3001-\\\\Xd7ff'.           // NameChar
            '\\\\Xf900-\\\\Xfdcf\\\\Xfdf0-\\\\Xfffd'.           // NameChar
            '\\\\X10000-\\\\Xeffff\\\\-.0-9\\\\Xb7'.            // NameChar
            '\\\\X300-\\\\X36f\\\\X203f-\\\\X2040]*$/u"'),      // NameChar
            $input
        );

        if (!$valid) {
            $format = "Invalid {%s}name: \"%s\"";
            $message = sprintf($format, self::NS_SCHEMA, $input);
            throw new SchemaArgumentError($message);
        }
    }

    /**
     * Fetch an xs:NCName value
     *
     * The normalizeName() method is used internally to fetch and verify
     * the given $input value according to the xs:NCName type.
     *
     * @param   mixed               $input      The value to fetch
     *
     * @throws  \Lousson\Schema\Error\SchemaArgumentError
     *          Raised in case the given $input could not get used as or
     *          converted into a xs:NCName/string value
     */
    final protected function normalizeNCName(&$input)
    {
        $this->normalizeName($input);
        $valid = false === strpos($input, ":");

        if (!$valid) {
            $format = "Invalid {%s}NCName: \"%s\"";
            $message = sprintf($format, self::NS_SCHEMA, $input);
            throw new SchemaArgumentError($message);
        }
    }
}
