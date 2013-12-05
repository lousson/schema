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
 *  Lousson\Schema\AbstractTest class definition
 *
 * @package     org.lousson.schema
 * @copyright   (c) 2013, The Lousson Project
 * @license     http://opensource.org/licenses/bsd-license.php New BSD License
 * @author      Mathias J. Hennig <mhennig at quirkies.org>
 * @filesource
 */
namespace Lousson\Schema;

/** Dependencies: */
use Lousson\Schema\AnyType;
use PHPUnit_Framework_TestCase;

/**
 *  An abstract test case for schema classes
 *
 *  The Lousson\Schema\AbstractTest class serves as a base class for
 *  tests agains the interfaces in the Lousson\Schema namespace.
 *
 * @since       lousson/Lousson_Schema-0.1.0
 * @package     org.lousson.schema
 * @link        http://www.phpunit.de/manual/current/en/
 */
abstract class AbstractTest extends PHPUnit_Framework_TestCase
{
    /**
     * The fully qualified name of the AnySchema interface
     *
     * @var string
     */
    const I_SCHEMA = "Lousson\\Schema\\AnySchema";

    /**
     * The fully qualified name of the AnyType interface
     *
     * @var string
     */
    const I_TYPE = "Lousson\\Schema\\AnyType";

    /**
     * The fully qualified name of the AnyParticle interface
     *
     * @var string
     */
    const I_PARTICLE = "Lousson\\Schema\\AnyParticle";

    /**
     * The namespace URI of XML Schema
     *
     * @var string
     */
    const NS_SCHEMA = "http://www.w3.org/2001/XMLSchema";

    /**
     * Obtain a type mock object
     *
     * The getTypeMock() method is used to obtain a mock object for
     * the AnyType interface. This will be an unconfigured object,
     * where each invocation of any of the interface methods will raise an
     * BadMethodCallException - unless configured via ->expects()..
     * before.
     *
     * @return  \Lousson\Schema\AnyType
     *          An unconfigured simple type mock is returned on success
     *
     * @throws  \Excpetion
     *          Raised in case of an internal error
     */
    public function getTypeMock($name, $namespaceURI)
    {
        static $methods = array(
            "getName",
            "getNamespaceURI",
            "getBaseType",
            "import",
            "export",
            "importFrom",
            "exportTo"
        );

        $mock = $this->getMock(self::I_TYPE, $methods);
        $pattern = "Mocked method %s::%s() is not configured";

        $mock
            ->expects($this->any())
            ->method("getName")
            ->will($this->returnValue((string) $name));

        $mock
            ->expects($this->any())
            ->method("getNamespaceURI")
            ->will($this->returnValue((string) $namespaceURI));

        for ($i = 2; $i != count($methods); ++$i) {
            $message = sprintf($pattern, self::I_TYPE, $methods[$i]);
            $error = new \BadMethodCallException($message);
            $mock
                ->expects($this->any())
                ->method($methods[$i])
                ->will($this->throwException($error));
        }

        return $mock;
    }
}

