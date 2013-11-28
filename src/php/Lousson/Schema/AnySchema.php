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
 * Lousson\Schema\AnySchema interface definition
 *
 * @package     org.lousson.schema
 * @copyright   (c) 2013, The Lousson Project
 * @license     http://opensource.org/licenses/bsd-license.php New BSD License
 * @author      Mathias J. Hennig <mhennig at quirkies.org>
 * @filesource
 */
namespace Lousson\Schema;

/* Interfaces: */
use Lousson\Schema\AnyType;

/**
 * An interface for schemas
 *
 * @since       lousson/Lousson_Schema-0.1.0
 * @package     org.lousson.schema
 */
interface AnySchema
{
    /**
     * Lookup a type implementation
     *
     * The getType() method returns the type object, an instance of either
     * the Lousson\Schema\AnySimpleType or Lousson\Schema\AnyComplexType,
     * associated with the given $name and $namespaceURI.
     * Although the latter is optional, it's not defined whether omitting
     * the parmeter triggers the use some sort of search logic and, if so,
     * how such a search would operate.
     *
     * @param   string      $name           The name of the type to look up
     * @param   string      $namespaceURI   The type's namespace
     *
     * @return  \Lousson\Schema\AnyType
     *          A type object, either an instance of AnySimpleType or the
     *          AnyComplexType, interface is returned on success
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
    public function getType($name, $namespaceURI = null);
}

