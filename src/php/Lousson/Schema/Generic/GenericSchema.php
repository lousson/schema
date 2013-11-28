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
 * Lousson\Schema\Generic\GenericSchema class definition
 *
 * @package     org.lousson.schema
 * @copyright   (c) 2013, The Lousson Project
 * @license     http://opensource.org/licenses/bsd-license.php New BSD License
 * @author      Attila G. Levai <sgnl19 at quirkies.org>
 * @filesource
 */
namespace Lousson\Schema\Generic;

/* Interfaces: */
use Lousson\Schema\AnySchema;
use Lousson\Schema\AnyType;
use Lousson\Schema\Error\SchemaArgumentError;

/**
 * A generic implementation of the AnySchema interface
 *
 * @since       lousson/Lousson_Schema-0.1.0
 * @package     org.lousson.schema
 */
class GenericSchema implements AnySchema
{
    /* @see AnySchema::getType() */
    public function getType($name, $namespaceURI = null)
    {
		if (null === $namespaceURI) {
			$namespaceURI = AnyType::NS_SCHEMA;
		}

		if (!array_key_exists($namespaceURI, $this->_types)) {
			throw new SchemaArgumentError(
				"Invalid type namespace given ".var_export($namespaceURI, true)
			);
		}

    	if (empty($name) ||
    			!array_key_exists($name, $this->_types[$namespaceURI])
    	) {
    		throw new SchemaArgumentError(
				"Invalid type name given ".var_export($name, true)
       		);
    	}

		return $this->_types[$namespaceURI][$name];
    }

    /**
     * Set a type
     *
     * The setType() method is used to set an AnyType $type and associate
     * it with $name and $namespaceURI.
     *
     * @param	string	$name			The name to associate the type with
     * @param	string	$namespaceURI	The namespace the type is associated to
     * @param	AnyType	$type			The type to set
     *
     * @throws  SchemaArgumentError
     *          Raised in case one of the input parameters is considered
     *          invalid
     */
    public function setType($name, $namespaceURI, AnyType $type)
    {
    	if (empty($name)) {
    		throw new SchemaArgumentError(
				"Invalid type name given ".var_export($name, true)
    		);
    	}

		$namespaceURI = (string) $namespaceURI;
		$this->_types[$namespaceURI][$name] = $type;
    }

    /**
     * The list of types
     *
     * @var array
     */
    private $_types = array();
}

