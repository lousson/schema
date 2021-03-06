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
 *  Lousson\Schema\Generic\GenericSchemaTest class definition
 *
 * @package     org.lousson.schema
 * @copyright   (c) 2013, The Lousson Project
 * @license     http://opensource.org/licenses/bsd-license.php New BSD License
 * @author      Mathias J. Hennig <mhennig at quirkies.org>
 * @filesource
 */
namespace Lousson\Schema\Generic;

/** Dependencies: */
use Lousson\Schema\AnyType;
use Lousson\Schema\AbstractSchemaTest;

/**
 *  A test case for the GenericSchema class
 *
 * @since       lousson/Lousson_Schema-0.1.0
 * @package     org.lousson.schema
 * @link        http://www.phpunit.de/manual/current/en/
 */
class GenericSchemaTest extends AbstractSchemaTest
{
    /**
     * Obtain a schema instance
     *
     * The getSchema() method is used in the test cases to obtain an
     * instance of the schema implementation under test.
     * If the $type parameter is set, the caller expects the returned
     * schema to recognize the $type provided (when invoking getType()
     * with it's name and namespaceURI) - at least.
     *
     * @param   AnyType     $type       The required type object, if any
     *
     * @return  \Lousson\Schema\AnySchema
     *          An instance of the test schema is returned on success
     *
     * @throws  \Exception
     *          Raised in case of an internal error
     */
    public function getSchema(AnyType $type = null)
    {
        $this->assertNotNull($this->_schema);

        if (isset($type)) {
            $name = $type->getName();
            $namespaceURI = $type->getNamespaceURI();
            $this->_schema->setType($name, $namespaceURI, $type);
        }

        return $this->_schema;
    }

    /**
     * Prepare test suite
     *
     * The setUp() method is invoked to reset the test runtime and to
     * prepare for the next test invocation.
     */
    public function setUp()
    {
        $this->_schema = new GenericSchema();
    }

    /**
     * Test the getType() method
     *
     * The testGetType() method is a test for GenericSchema::getType().
     * For now, it is merely a stub with the intention to increase
     * code-coverage in some edge-cases (the AbstractSchemaTest class is
     * already utilizing this method implicitly).
     *
     * @expectedException   Lousson\Schema\AnySchemaException
     * @test
     *
     * @throws  \Lousson\Schema\AnySchemaException
     *          Raised in case the test is successful
     *
     * @throws  \Exception
     *          Raised in case of an internal error
     */
    public function testGetType()
    {
        $mock = $this->getSimpleTypeMock("foo", "urn:lousson:junk");
        $this->getSchema($mock)->getType("bar", "urn:lousson:junk");
    }

    /**
     * Test the setType() method
     *
     * The testSetType() method is a test for GenericSchema::setType().
     * For now, it is merely a stub with the intention to increase
     * code-coverage in some edge-cases (the AbstractSchemaTest class is
     * already utilizing this method implicitly).
     *
     * @expectedException   Lousson\Schema\AnySchemaException
     * @test
     *
     * @throws  \Lousson\Schema\AnySchemaException
     *          Raised in case the test is successful
     *
     * @throws  \Exception
     *          Raised in case of an internal error
     */
    public function testSetType()
    {
        $mock = $this->getSimpleTypeMock("foo", "urn:lousson:junk");
        $this->getSchema()->setType("--foobar", null, $mock);
    }

    /**
     * The schema under test
     *
     * @var \Lousson\Schema\Generic\GenericSchema
     */
    private $_schema;
}

