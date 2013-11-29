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
     * The fully qualified name of the AnyComplexType interface
     *
     * @var string
     */
    const I_COMPLEX_TYPE = "Lousson\\Schema\\AnyComplexType";

    /**
     * The fully qualified name of the AnySimpleType interface
     *
     * @var string
     */
    const I_SIMPLE_TYPE = "Lousson\\Schema\\AnySimpleType";

    /**
     * The namespace URI of XML Schema
     *
     * @var string
     */
    const NS_SCHEMA = "http://www.w3.org/2001/XMLSchema";

    /**
     * Obtain a schema instance
     *
     * The getSchema() method is used in the test cases to obtain an
     * instance of the schema implementation under test.
     *
     * @return  \Lousson\Schema\AnySchema
     *          An instance of the test schema is returned on success
     *
     * @throws  \Exception
     *          Raised in case of an internal error
     */
    abstract public function getSchema();

    /**
     * Obtain a type instance
     *
     * The getType() method is used instead of a direct invocation of the
     * schema's method of the same name. It decorates the testee, in order
     * to check on it's behavior.
     *
     * @param   string      $name           The name of the type to look up
     * @param   string      $namespaceURI   The type's namespace
     *
     * @return  \Lousson\Schema\AnyType
     *          A type object, either an instance of AnySimpleType or the
     *          AnyComplexType, interface is returned on success
     *
     * @throws  \PHPUnit_Framework_AssertionFailedError
     *          Raised in case the test discovered any issue
     *
     * @throws  \Lousson\Schema\AnySchemaException
     *          All allowed exceptions implement this interface
     *
     * @throws  \InvalidArgumentException
     *          Raised in case one of the input parameters is considered
     *          invalid
     *
     * @throws  \Exception
     *          Raised in case of an internal error
     */
    public function getType($name, $namespaceURI = null)
    {
        $schema = $this->getSchema();
        $this->assertInstanceOf(self::I_SCHEMA, $schema);

        $type = $schema->getType($name, $namespaceURI);
        $isSimpleType = $this->isInstanceOf(self::I_SIMPLE_TYPE);
        $isComplexType = $this->isInstanceOf(self::I_COMPLEX_TYPE);
        $isType = $this->logicalOr($isSimpleType, $isComplexType);

        $description = sprintf(
            "%s::getType() must return an instance of %s",
            get_class($schema), self::I_TYPE
        );

        $this->assertThat($type, $isType, $description);
        return $type;
    }

    /**
     * Obtain a sequence of getType() parameters
     *
     * The provideValidTypeIDs() method is a data provider that returns
     * a list of one or more sets, each of whose consists of one or two
     * items:
     *
     * - The name of a type that is expected to be recognized
     * - The type's namespace URI, or NULL
     *
     * This complies with the parameters expected by AnySchema::getType().
     *
     * @return  array
     *          An array of getType() parameters is returned on success
     *
     * @throws  \Exception
     *          Raised in case of an internal error
     */
    public function provideValidTypeIDs()
    {
        return array(
            array("anyURI", self::NS_SCHEMA),
            array("anyURI"),
        );
    }

    /**
     * Obtain a sequence of getType() parameters
     *
     * The provideInvalidTypeIDs() method is a data provider that returns
     * a list of one or more sets, each of whose consists of one or two
     * items:
     *
     * - A name that is expected to be unrecognized or considered invalid
     * - The type's namespace URI, or junk, or NULL
     *
     * This complies with the parameters expected by AnySchema::getType().
     *
     * @return  array
     *          An array of getType() parameters is returned on success
     *
     * @throws  \Exception
     *          Raised in case of an internal error
     */
    public function provideInvalidTypeIDs()
    {
        $foobar = md5("foobar");

        return array(
            array("", self::NS_SCHEMA),
            array("foobar", self::NS_SCHEMA),
            array(""),
            array($foobar),
            array("", null),
            array($foobar, null),
            array("--foobar"),
        );
    }

    /**
     * Obtain a simple type mock object
     *
     * The getSimpleTypeMock() method is used to obtain a mock object for
     * the AnySimpleType interface. This will be an unconfigured object,
     * where each invocation of any of the interface methods will raise an
     * BadMethodCallException - unless configured via ->expects()..
     * before.
     *
     * @return  \Lousson\Schema\AnySimpleType
     *          An unconfigured simple type mock is returned on success
     *
     * @throws  \Excpetion
     *          Raised in case of an internal error
     */
    public function getSimpleTypeMock(
        $name,
        $namespaceURI = self::NS_SCHEMA)
    {
        $methods = array(
            "getName", "getNamespaceURI",
            "import", "export", "importFrom", "exportTo"
        );

        $mock = $this->getMock(self::I_SIMPLE_TYPE, $methods);
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
            $message = sprintf($pattern, self::I_SIMPLE_TYPE, $methods[$i]);
            $error = new \BadMethodCallException($message);
            $mock
                ->expects($this->any())
                ->method($methods[$i])
                ->will($this->throwException($error));
        }

        return $mock;
    }
}

